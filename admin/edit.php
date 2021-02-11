<?php
require_once '../assets/config/config.php';
require_once "../vendor/autoload.php";

use Miniature\CMS;
use Miniature\Login;

Login::is_login($_SESSION['last_login']);

$result = false;
$id = (int)htmlspecialchars($_GET['id'] ?? null);

/*
 * Set the class to of the record (data) to be display
 * to the class then fetch the data to the $record
 * ARRAY do be displayed on the website. If an
 * update has been done then update database
 * table otherwise just fetch the record
 * by id.
 */
if (isset($_POST['submit'])) {
    $cms = new CMS($_POST['cms']);
    $result = $cms->update();
    $id = $_POST['cms']['id'];
} elseif ($id && is_int($id)) {
    $record = CMS::fetch_by_id($id);
    $cms = new CMS($record);
} else {
    header("Location: index.php");
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Record</title>
    <link rel="stylesheet" href="../assets/css/stylesheet.css">
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
            <li><a href="logout.php">logout</a></li>
        </ul>
    </nav>
</section><!-- .main-nav -->

<main id="content" class="main-area">
    <form class="form_classes" action="edit.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="cms[id]" value="<?= $id ?>">
        <input type="hidden" name="cms[user_id]" value="<?= $_SESSION['id'] ?>">
        <input type="hidden" name="cms[author]" value="<?= Login::full_name() ?>">
        <input type="hidden" name="action" value="upload">
        <input class="form_image_upload_style" type="file" name="image">
        <label class="heading_label_style" for="heading">Heading</label>
        <input class="enter_input_style" id="heading" type="text" name="cms[heading]" value="<?= $cms->heading ?>"
               tabindex="1" required autofocus>
        <label class="text_label_style" for="content">Content</label>
        <textarea class="text_input_style" id="content" name="cms[content]" tabindex="2"><?= $cms->content ?></textarea>
        <?php echo '<a class="delete_button" href="delete.php?id=' . $id . '" onclick="return confirm(\'Are you sure you want to delete this item?\');">Delete</a>'; ?>
        <button class="form_button" type="submit" name="submit" value="enter">submit</button>
    </form>
</main>
<section class="sidebar">
    <aside class="twin">

    </aside>
    <aside class="twin">
        <img src="../assets/images/img-logo-003.jpg" alt="Detroit Kern's Clock">
    </aside>
</section><!-- .twins -->
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>
</body>
</html>
