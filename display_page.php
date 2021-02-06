<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\CMS;

$cms = new CMS();

$id = (int)htmlspecialchars($_GET['id'] ?? null);

/*
 * Set the class to of the record (data) to be display
 * to the class then fetch the data to the $record
 * ARRAY do be displayed on the website.
 */
if ($id && is_int($id)) {
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
    <link rel="stylesheet" href="assets/css/stylesheet.css">
    <title>Display Full Page</title>
    <link rel="stylesheet" href="assets/css/stylesheet.css">
    <script src="assets/js/menu.js" defer></script>
</head>
<body class="site">
<a class="skip-link screen-reader-text" href="#content">Skip to content</a>
<header class="masthead">
    <h1 class="site-title">The Miniature Photographer</h1>
</header>

<section class="main-nav">
    <button class="trigger" aria-expanded="false">Menu<span class="screen-reader-text">Reveal menu</span></button>

    <nav>
        <ul>
            <li><a href="index.php">home</a></li>
            <li><a href="admin/login.php">admin</a></li>
            <li><a href="game.php">game</a></li>
            <li><a href="contact.php">contact</a></li>
        </ul>
    </nav>
</section><!-- .main-nav -->

<main id="content" class="main-area">
    <div class="display_record">
        <img class="large_img" src="<?php echo $cms->image_path; ?>" alt="<?= $cms->heading ?>">
        <h3 class="record_heading"><?= $cms->heading ?></h3>
        <h6 class="record_author"><?php echo 'by ' . $cms->author; ?><span
                    class="date_created"> created on <?php echo CMS::styleDate($cms->date_added) ?></span></h6>
        <p class="record_content"><?php echo nl2br($cms->content); ?></p>
    </div>

</main>
<section class="sidebar">
    <aside class="twin">

    </aside>
    <aside class="twin">
        <img src="assets/images/img-logo-003.jpg" alt="Detroit Kern's Clock">
    </aside>
</section><!-- .twins -->
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>
</body>
</html>
