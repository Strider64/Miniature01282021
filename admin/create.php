<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";
require_once "functions/resize_function.php";

use Miniature\CMS;
use Miniature\Login;

Login::is_login($_SESSION['last_login']);

define('IMAGE_WIDTH', 2048);
define('IMAGE_HEIGHT', 1365);
$save_result = false;

if (isset($_POST['submit'], $_FILES['image'])) {
    $data = $_POST['cms'];
    $errors = array();
    $exif_data = [];
    $file_name = $_FILES['image']['name']; // Temporary file for thumbnails directory:
    $file_size = $_FILES['image']['size']; // Temporary file for uploads directory:
    $file_tmp = $_FILES['image']['tmp_name'];
    $thumb_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    /*
     * Set EXIF data info of image for database table that is
     * if it contains the info otherwise set to null.
     */
    if ($file_ext === 'jpeg' || $file_ext === 'jpg') {
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

    if ($file_size >= 29360128) {
        $errors[] = 'File size must be less than or equal to 28 MB';
    }

    /*
     * Set the paths to the correct folders
     */
    $dir_path = 'assets/uploads/';
    $thumb_path = 'assets/thumbnails/';

    /*
     * Create unique names for thumbnail and large image.
     */
    $new_thumb_name = $thumb_path . 'thumb-gallery-' . time() . '.' . $file_ext;
    $new_file_name = $dir_path . 'img-gallery-' . time() . '.' . $file_ext;

    /*
     * Set path information for database table.
     */
    $data['thumb_path'] = $new_thumb_name;
    $data['image_path'] = $new_file_name;

    /*
     * Call resize function to set the thumbnails and large images
     * to the correct size and save them to their corresponding
     * directories.
     */
    $thumb_result = resize($thumb_tmp, $new_thumb_name, true);
    $save_result = resize($file_tmp, $new_file_name);

    /*
     * If no errors save ALL the information to the
     * database table.
     */
    if (empty($errors) === true) {
        //move_uploaded_file($file_tmp, "../" . $new_file_name);
        /* Save to Database Table CMS */
        $cms = new CMS($data);
        $result = $cms->create();
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
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Post</title>
    <link rel="stylesheet" href="../assets/css/stylesheet.css">
</head>
<body class="site">
<section class="mainArea">
    <header class="headerStyle">
        <img src="../assets/images/img-header-red-tailed-hawk-001.jpg" alt="Red-tailed Hawk">
    </header>
    <nav class="navigation">
        <ul class="topNav">
            <li><a href="index.php">home</a></li>
            <li><a href="create.php">add</a></li>
            <li><a href="logout.php">logout</a></li>
        </ul>
    </nav>
    <aside class="sidebar">
    </aside>
    <main id="content" class="mainStyle">
        <form class="formGrid" action="create.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="cms[user_id]" value="3">
            <input type="hidden" name="cms[author]" value="John Pepp">
            <input type="hidden" name="action" value="upload">
            <input class="image-upload" type="file" name="image">
            <label class="headingLabel" for="heading">Heading</label>
            <input class="enterHeading" id="heading" type="text" name="cms[heading]" value="" tabindex="1" required
                   autofocus>
            <label class="textLabel" for="content">Content</label>
            <textarea class="contentTextarea" id="content" name="cms[content]" tabindex="2"></textarea>
            <button class="myButton" type="submit" name="submit" value="enter">submit</button>
        </form>
    </main>
    <div class="contentContainer">

    </div>

    <footer class="footerStyle">
        <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
    </footer>
</section>

</body>
</html>