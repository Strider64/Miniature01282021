<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";
require_once "assets/functions/procedural_database_functions.php";
require_once "assets/functions/login_functions.php";

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

use Miniature\Resize;

$result = false;
$id = (int)htmlspecialchars($_GET['id'] ?? null);
try {
    $today = $todayDate = new DateTime('today', new DateTimeZone("America/Detroit"));
} catch (Exception $e) {
}
$date_updated = $today->format("Y-m-d H:i:s");
/*
 * Set the class to of the record (data) to be display
 * to the class then fetch the data to the $record
 * ARRAY do be displayed on the website. If an
 * update has been done then update database
 * table otherwise just fetch the record
 * by id.
 */
if (isset($_POST['submit'])) {

    $cms = $_POST['cms'];


    /*
     * If there are no errors then update the image,
     * otherwise just update the information.
     */
    if ($_FILES['image']['error'] === 0) {

        unlink($_SESSION['old_image']); // Remove old image path from db table:

        $errors = array();
        $exif_data = [];
        $file_name = $_FILES['image']['name']; // Temporary file for thumbnails directory:
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        /*
         * Set EXIF data info of image for database table that is
         * if it contains the info otherwise set to null.
         */
        if ($file_ext === 'jpeg' || $file_ext === 'jpg') {
            /*
             * I don't like suppressing errors, but this
             * is the only way that I can so
             * until find out how to do it this will
             * have to do.
             */
            $exif_data = @exif_read_data($file_tmp);

            if (array_key_exists('Make', $exif_data) && array_key_exists('Model', $exif_data)) {
                $cms['Model'] = $exif_data['Make'] . ' ' . $exif_data['Model'];
            }

            if (array_key_exists('ExposureTime', $exif_data)) {
                $cms['ExposureTime'] = $exif_data['ExposureTime'] . "s";
            }

            if (array_key_exists('ApertureFNumber', $exif_data['COMPUTED'])) {
                $cms['Aperture'] = $exif_data['COMPUTED']['ApertureFNumber'];
            }

            if (array_key_exists('ISOSpeedRatings', $exif_data)) {
                $cms['ISO'] = "ISO " . $exif_data['ISOSpeedRatings'];
            }

            if (array_key_exists('FocalLengthIn35mmFilm', $exif_data)) {
                $cms['FocalLength'] = $exif_data['FocalLengthIn35mmFilm'] . "mm";
            }

        } else {
            $cms['Model'] = null;
            $cms['ExposureTime'] = null;
            $cms['Aperture'] = null;
            $cms['ISO'] = null;
            $cms['FocalLength'] = null;
        }


        $extensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $extensions, true) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }

        if ($file_size >= 44040192) {
            $errors[] = 'File size must be less than or equal to 42 MB';
        }

        /*
         * Set the paths to the correct folders
         */
        $dir_path = 'assets/uploads/';

        /*
         * Create unique name for image.
         */
        $new_file_name = $dir_path . 'img-gallery-' . time() . '-' . IMAGE_WIDTH . 'x' . IMAGE_HEIGHT . '.' . $file_ext;

        move_uploaded_file($file_tmp, $new_file_name);

        $resize = new Resize($new_file_name);
        $resize->resizeImage(IMAGE_WIDTH, IMAGE_HEIGHT, 'auto');
        $resize->saveImage($new_file_name, 100);
        /*
         * Set path information for database table.
         */
        $cms['image_path'] = $new_file_name;

        $result = updateData($cms, $pdo, 'cms');
    } else {
        $result = updateData($cms, $pdo, 'cms');
    }

    if ($result) {
        header("Location: index.php");
        exit();
    }
} elseif ($id && is_int($id)) {
    $record = fetch_by_id($pdo, 'cms', $id);
    $_SESSION['old_image'] = $record['image_path'];
} else {
    header("Location: photogallery.php");
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>Edit Page</title>
    <link rel="stylesheet" media="all" href="assets/css/miniature.css">
</head>
<body class="site">

<div class="nav">
    <input type="checkbox" id="nav-check">

    <h3 class="nav-title">
        PHP Procedural Edit
    </h3>

    <div class="nav-btn">
        <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>

    <div class="nav-links">
        <a href="index.php">home</a>
        <a href="create.php">create</a>
        <a href="logout.php">logout</a>
    </div>
</div>

<main id="content" class="checkStyle">
    <form id="formData" class="form_classes" action="edit.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="cms[id]" value="<?= $id ?>">
        <input type="hidden" name="cms[user_id]" value="<?= $_SESSION['id'] ?>">
        <input type="hidden" name="cms[author]" value="John Pepp">
        <input type="hidden" name="cms[date_updated]" value="<?= $date_updated ?>">
        <input type="hidden" name="action" value="upload">
        <input type="hidden" name="cms[image_path]" value="<?= $record['image_path'] ?>">
        <img src="<?= $_SESSION['old_image'] ?>" alt="current image">
        <br>
        <div class="file-style">
            <input id="file" class="file-input-style" type="file" name="image" value="<?= $record['image_path'] ?>">
            <label for="file">Select file</label>
        </div>
        <div class="heading-style">
            <label class="heading_label_style" for="heading">Heading</label>
            <input class="enter_input_style" id="heading" type="text" name="cms[heading]" value="<?= $record['heading'] ?>"
                   tabindex="1" required autofocus>
        </div>
        <div class="content-style">
            <label class="text_label_style" for="content">Content</label>
            <textarea class="text_input_style" id="content" name="cms[content]"
                      tabindex="2"><?= $record['content'] ?></textarea>
        </div>
        <div class="submit-button">
            <button class="form-button" formaction="delete.php?id=<?= $id ?>"
                    onclick="return confirm('Are you sure you want to delete this item?');">Delete
            </button>
            <button class="form-button" type="submit" name="submit" value="enter">submit</button>
        </div>
    </form>
</main>
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Photo Tech Guru</p>
</footer>
</body>
</html>
