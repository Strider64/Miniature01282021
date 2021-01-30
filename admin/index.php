<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";
use Miniature\CMS;
use Miniature\Pagination;
use Miniature\Login;

Login::is_login($_SESSION['last_login']);

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

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
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
            <li><a href="logout.php">logout</a> </li>
        </ul>
    </nav>
    <aside class="sidebar">
        <?php
        $url = 'index.php';
        echo $pagination->page_links($url);
        ?>
    </aside>
    <main id="content" class="mainStyle">
        <div class="cmsThreads">
            <?php

            foreach ($cms as $record) {
                echo '<article  class="display">' . "\n";
                echo '<img class="thumb" src="' . '../' .  $record['thumb_path'] .  '">';
                echo '<div class="cms_heading">';
                echo "<h3>" . $record['heading'] . "</h3>\n";
                echo sprintf("<h6> Created by %s on %s updated on %s</h6>", $record['author'], CMS::styleDate($record['date_added']), CMS::styleDate($record['date_updated']));
                echo '</div>';
                echo sprintf("<p>%s</p>\n", nl2br(CMS::intro($record['content'], 200, $record['id'], 'edit.php')));
                echo '</article>';
            }
            ?>
        </div>
    </main>
    <div class="contentContainer">

    </div>

    <footer class="footerStyle">
        <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
    </footer>
</section>
</body>
</html>

