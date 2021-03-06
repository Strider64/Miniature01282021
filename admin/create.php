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
        /*
         * I don't like suppressing errors, but this
         * is the only way that I have  found out how to do it.
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
        /* Save to Database Table CMS */
        $cms = new CMS($data);
        $result = $cms->create();
        if ($result) {
            header("Location: indexbackup.php");
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
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>Add Post</title>
    <link rel="stylesheet" media="all" href="../assets/css/stylesheet.css">
    <script src="../assets/js/menu.js" defer></script>
</head>
<body class="site">
<a class="skip-link screen-reader-text" href="#content">Skip to content</a>
<header class="masthead">
    <img class="masthead-logo" src="/assets/images/img-logo-004.png" alt="website logo">
    <h1 class="site-title">The Miniature Photographer</h1>
</header>

<section class="main-nav">
    <button class="trigger" aria-expanded="false">Menu<span class="screen-reader-text">Reveal menu</span></button>

    <nav>
        <ul>
            <li><a href="index.php">home</a></li>
            <li><a href="create.php">create</a></li>
            <li><a href="addQuiz.php">add Q</a></li>
            <li><a href="editQuiz.php">edit Q</a></li>
            <li><a href="logout.php">logout</a></li>
        </ul>
    </nav>
</section><!-- .main-nav -->

<main id="content" class="main-area">
    <form id="formData" class="form_classes" action="create.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="cms[user_id]" value="3">
        <input type="hidden" name="cms[author]" value="<?= Login::full_name() ?>">
        <input type="hidden" name="action" value="upload">
        <input class="form_image_upload_style" type="file" name="image">
        <label class="heading_label_style" for="heading">Heading</label>
        <input class="enter_input_style" id="heading" type="text" name="cms[heading]" value="" tabindex="1" required
               autofocus>
        <label class="text_label_style" for="content">Content</label>
        <textarea class="text_input_style" id="content" name="cms[content]" tabindex="2"></textarea>
        <button class="form_button" type="submit" name="submit" value="enter">submit</button>
    </form>
</main>
<section class="sidebar">
    <aside class="twin">

    </aside>
    <aside class="twin">

    </aside>
</section><!-- .twins -->
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>
<!--<script src="../assets/js/save_to_cms.js"></script>-->
</body>
</html>
