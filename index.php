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
$current_page = $_GET['page'] ?? 1; // Current Page
$per_page = 3; // Total number of records to be displayed:
$total_count = CMS::countAll(); // Total Records in the db table:

/* Send the 3 variables to the Pagination class to be processed */
$pagination = new Pagination($current_page, $per_page, $total_count);

/* Grab the offset (page) location from using the offset method */
$offset = $pagination->offset();

/*
 * Grab the data from the CMS class method *static*
 * and put the data into an array variable.
 */
$cms = CMS::page($per_page, $offset);

$monthly = new CalendarObject();

$monthly->phpDate();

$calendar = $monthly->generateCalendar('index.php');
include "shared/includes/inc.header.php";
?>
<section class="mainArea">
    <header class="headerStyle">
        <img src="assets/images/img-header-red-tailed-hawk-001.jpg" alt="Red-tailed Hawk">
    </header>
    <div class="topLeft">
        <nav class="navigation">
            <ul class="topNav">
                <li><a href="index.php">home</a></li>
                <li><a href="admin/login.php">admin</a></li>
                <li><a href="game.php">game</a></li>
                <li><a href="contact.php">contact</a></li>
            </ul>
        </nav>
        <img src="assets/images/img-logo-003.jpg" alt="Logo for Website">
    </div>
    <main id="content" class="mainStyle">
        <div class="cmsThreads">
            <?php

            foreach ($cms as $record) {
                echo '<article  class="display">' . "\n\n";
                echo '<a class="moreBtn" href="display_page.php?id=' . urldecode($record['id']) . '"><img class="thumb" src="' . $record['thumb_path'] . '" alt="thumbnail"></a>' . "\n";
                echo '<div class="cms_heading">' . "\n";
                echo "<h3>" . $record['heading'] . "</h3>\n";
                echo sprintf("<h6> by %s on %s updated on %s</h6>", $record['author'], CMS::styleDate($record['date_added']), CMS::styleDate($record['date_updated']));
                echo '</div>' . "\n";
                echo sprintf("<p>%s</p>\n", nl2br(CMS::intro($record['content'], 100)));
                echo '<a class="button" href="display_page.php?id=' . urldecode($record['id']) . '">Full Page</a>' . "\n\n";
                echo '</article>' . "\n\n";
            }
            ?>
        </div>
    </main>
    <aside class="sidebar">
        <?php
        $url = 'index.php';
        echo $pagination->page_links($url);
        ?>
        <?php include 'shared/includes/inc.sidebar.php'; ?>
    </aside>
    <div class="contentContainer">

    </div>

    <footer class="footerStyle">
        <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
    </footer>
</section>
</body>
</html>
