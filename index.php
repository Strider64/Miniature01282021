<?php
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

$calendar = $monthly->generateCalendar('login.php');

$enter = $_POST['submit'] ?? Null;

/*
 * If the user/admin has enter a comment then
 * set the data in the class and then save it
 * to the database.
 */
if ($enter) {
    $args = $_POST['cms'];
    $cms = new CMS($args);
    $cms->create();
}

//CMS::set_Objects();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/stylesheet.css">
    <title>The Miniature Photographer</title>
</head>
<body class="site">
<section class="mainArea">
    <header class="headerStyle">
        <img src="assets/images/img-header-red-tailed-hawk-001.jpg" alt="Red-tailed Hawk">
    </header>
    <div class="topLeft">
        <nav class="navigation">
            <ul class="topNav">
                <li><a href="index.php">home</a></li>
                <li><a href="admin/login.php">admin</a></li>
                <li><a href="cms_forums.php">CMS threads</a></li>
                <li><a href="#">contact</a></li>
            </ul>
        </nav>
        <img src="assets/images/img-logo-001.jpg" alt="Logo for Website">
    </div>
    <aside class="sidebar">

    </aside>
    <main id="content" class="mainStyle">
        <div class="cmsThreads">
            <?php
            $url = 'login.php';
            echo $pagination->page_links($url);
            foreach ($cms as $record) {
                echo '<article  class="display">' . "\n";
                if (!empty($record)) {
                    echo "<h3>" . $record['heading'] . "</h3>\n";
                }
                echo sprintf("<h4> Created by %s on %s updated on %s</h4>", $record['author'], CMS::styleDate($record['date_added']), CMS::styleDate($record['date_updated']));
                echo sprintf("<p>%s</p>\n", nl2br(CMS::intro($record['content'], 200, $record['id'])));
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
