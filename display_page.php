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
    header("Location: indexbackup.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>Display Full Page</title>
    <link rel="stylesheet" media="all" href="\assets/css/stylesheet.css">
    <script src="\assets/js/menu.js" defer></script>
</head>
<body class="site">
<a class="skip-link screen-reader-text" href="#content">Skip to content</a>
<header class="masthead">
    <img class="masthead-logo" src="\assets/images/img-logo-004.png" alt="website logo">
    <h1 class="site-title">Miniature Photographer</h1>
</header>

<section class="main-nav">
    <button class="trigger" aria-expanded="false">Menu<span class="screen-reader-text">Reveal menu</span></button>

    <nav>
        <ul>
            <li><a href="\index.php">home</a></li>
            <li><a href="\admin/login.php">admin</a></li>
            <li><a href="\game.php">game</a></li>
            <li><a href="\contact.php">contact</a></li>
        </ul>
    </nav>
</section><!-- .main-nav -->

<main id="content" class="main-area">
    <div class="display_record">
        <img class="large_img" src="<?php echo "\\" . $cms->image_path; ?>" alt="<?= htmlspecialchars($cms->heading) ?>">
        <h3 class="record_heading"><?= $cms->heading ?></h3>
        <h6 class="record_author"><?php echo 'by ' . htmlspecialchars($cms->author); ?><span
                    class="date_created"> created on <?php echo htmlspecialchars(CMS::styleDate($cms->date_added)) ?></span></h6>
        <p class="record_content"><?php echo nl2br(htmlspecialchars($cms->content)); ?></p>
    </div>

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
</body>
</html>
