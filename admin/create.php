<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";
require_once "functions/resize_function.php";

use Miniature\Resize;
use Miniature\CMS;
use Miniature\Login;

Login::is_login($_SESSION['last_login']);

const IMAGE_WIDTH = 2048;
const IMAGE_HEIGHT = 1365;
$save_result = false;

if (isset($_POST['submit'], $_FILES['image'])) {
    $data = $_POST['cms'];

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
            $data['Model'] = $exif_data['Make'] . ' ' . $exif_data['Model'];
        }

        if (array_key_exists('ExposureTime', $exif_data)) {
            $data['ExposureTime'] = $exif_data['ExposureTime'] . "s";
        }

        if (array_key_exists('ApertureFNumber', $exif_data['COMPUTED'])) {
            $data['Aperture'] = $exif_data['COMPUTED']['ApertureFNumber'];
        }

        if (array_key_exists('ISOSpeedRatings', $exif_data)) {
            $data['ISO'] = "ISO " . $exif_data['ISOSpeedRatings'];
        }

        if (array_key_exists('FocalLengthIn35mmFilm', $exif_data)) {
            $data['FocalLength'] = $exif_data['FocalLengthIn35mmFilm'] . "mm";
        }

    } else {
        $data['Model'] = null;
        $data['ExposureTime'] = null;
        $data['Aperture'] = null;
        $data['ISO'] = null;
        $data['FocalLength'] = null;
    }

    $data['content'] = trim($data['content']);

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
    $new_file_name = $dir_path . 'img-gallery-' . time() . '-600x400.' . $file_ext;

    move_uploaded_file($file_tmp,"../" . $new_file_name);

    $resize = new Resize("../" . $new_file_name);
    $resize->resizeImage(600, 400, 'landscape');
    $resize->saveImage("../" . $new_file_name, 100);
    /*
     * Set path information for database table.
     */
    $data['image_path'] = $new_file_name;



    /*
     * If no errors save ALL the information to the
     * database table.
     */
    if (empty($errors) === true) {
        /* Save to Database Table CMS */
        try {
            $today = $todayDate = new DateTime('today', new DateTimeZone("America/Detroit"));
        } catch (Exception $e) {
        }
        $data['date_updated'] = $data['date_added'] = $today->format("Y-m-d H:i:s");

        $cms = new CMS($data);
        $result = $cms->create();
        if ($result) {
            header("Location: index.php");
            exit();
        }
    } else {
        return $errors;
    }
} // Submit to database table and images to the directories:

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" media="all" href="../assets/css/styles.css">
</head>
<body class="site">
<div id="skip"><a href="#content">Skip to Main Content</a></div>
<header class="masthead">

</header>

<div class="nav">
    <input type="checkbox" id="nav-check">

    <h3 class="nav-title">
        The Miniature Photographer
    </h3>

    <div class="nav-btn">
        <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="create.php">Create</a>
        <a href="addQuiz.php">Add Q</a>
        <a href="editQuiz.php">Edit Q</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="sidebar">


</div>
<main id="content" class="main">
    <form id="formData" class="form_classes" action="create.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="cms[user_id]" value="3">
        <input type="hidden" name="cms[author]" value="<?= Login::full_name() ?>">
        <input type="hidden" name="action" value="upload">
        <input class="form_image_upload_style" type="file" name="image">
        <br>
        <br>
        <label for="message-type">What Page?</label>
        <select id="message-type" name="cms[page]">
            <option value="index">Home</option>
            <option value="blog" selected>Blog</option>
            <option value="about">About</option>
        </select>
        <label class="heading_label_style" for="heading">Heading</label>
        <input class="enter_input_style" id="heading" type="text" name="cms[heading]" value="" tabindex="1" required
               autofocus>
        <label class="text_label_style" for="content">Content</label>
        <textarea class="text_input_style" id="content" name="cms[content]" tabindex="2"></textarea>
        <button class="form_button" type="submit" name="submit" value="enter">submit</button>
    </form>

</main>
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>
</body>