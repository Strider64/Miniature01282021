<?php
/*
 * Website Development by John Pepp
 * Created on February 11, 2020
 * Updated on February 3, 2021
 * Version 1.0.2 Beta
 */
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\CalendarObject;
use Miniature\CMS;
use Miniature\Pagination;

/*
 * Using pagination in order to have a nice looking
 * website page.
 */

if (isset($_GET['page']) && !empty($_GET['page'])) {
    $current_page = urldecode($_GET['page']);
} else {
    $current_page = 1;
}

$per_page = 3; // Total number of records to be displayed:
$total_count = CMS::countAll(); // Total Records in the db table:

/* Send the 3 variables to the Pagination class to be processed */
$pagination = new Pagination($current_page, $per_page, $total_count);


/* Grab the offset (page) location from using the offset method */
$offset = $pagination->offset();
 //echo "<pre>" . print_r($offset, 1) . "</pre>";
 //die();
/*
 * Grab the data from the CMS class method *static*
 * and put the data into an array variable.
 */
$cms = CMS::page($per_page, $offset);

$monthly = new CalendarObject();

$monthly->phpDate();

$calendar = $monthly->generateCalendar('index.php');


//echo '<img class="thumb" src="' . $record['thumb_path'] . '" alt="thumbnail">' . "\n";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/stylesheet.css">
    <title><?php /** @noinspection PhpUndefinedVariableInspection */
        echo ($pageName === 'index') ? 'The Miniature Photographer' : $pageName; ?></title>
    <link rel="shortcut icon" href="favicon.ico">
    <script src="assets/js/cookie.notice.js"></script>
    <script src="assets/js/menu.js" defer></script>
</head>
<body class="site">
<a class="skip-link screen-reader-text" href="#content">Skip to content</a>
<header class="masthead">
    <img class="masthead-logo" src="assets/images/img-logo-004.png" alt="website logo">
    <h1 class="site-title">The Miniature Photographer</h1>
</header>

<div class="main-nav">
    <button class="trigger" aria-expanded="false">Menu<span class="screen-reader-text">Reveal menu</span></button>

    <nav>
        <ul>
            <li><a href="index">home</a></li>
            <li><a href="admin/login.php">admin</a></li>
            <li><a href="game">game</a></li>
            <li><a href="contact">contact</a></li>
        </ul>
    </nav>
</div><!-- .main-nav -->

<main id="content" class="main-area">

    <ul class="cards">
        <?php
        foreach ($cms as $record) {
            echo '<li class="card">' . "\n";
            echo "\t\t\t" . '<a href="/display/' . urldecode($record['id']) . '">' . "\n";
            echo "\t\t\t\t" . '<img class="thumb" src="' . htmlspecialchars($record['thumb_path']) . '" alt="thumbnail">' . "\n";
            echo "\t\t\t\t" . '<div class="cms_heading">' . "\n";
            echo "\t\t\t\t\t" . '<h2>' . htmlspecialchars($record['heading']) . '</h2>' . "\n";
            echo "\t\t\t\t\t" . '<p class="byline">by ' . htmlspecialchars($record['author']) . ' on ' . htmlspecialchars(CMS::styleDate($record['date_added'])) . '</p>' . "\n";
            echo "\t\t\t\t" . '</div>' . "\n";
            echo "\t\t\t\t" . '<p class="cms_content">' . nl2br(htmlspecialchars(CMS::intro($record['content'], 200))) . '</p>' . "\n";
            echo "\t\t\t\t" . '</a>' . "\n";
            echo '</li>' . "\n";
        }
        ?>
    </ul>

    <?php
    $url = 'index.php';
    echo $pagination->new_page_links($url);
    echo '</div>';
    ?>

</main>
<div class="sidebar">
    <aside class="twin">

    </aside>
    <aside class="twin">
        <img src="assets/images/img-logo-003.jpg" alt="Detroit Kern's Clock">
    </aside>
</div><!-- .twins -->
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>
</body>
</html>
