<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\CMS;
use Miniature\Pagination;

/*
 * If user/admin has update a particular comment
 * then send that record (data) to the CMS class
 * and update the data to the database table using
 * the update method.
 */
if (isset($_POST['submit'])) {
    $args = $_POST['cms'];
    $update = new CMS($args);
    $update->update();
}

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
    <title>CMS Threads</title>
    <link rel="stylesheet" href="assets/css/stylesheet.css">
</head>
<body class="site">
<div class="wrapper">
    <div class="centerForm">
        <form class="formGrid" action="index.php" method="post">
            <input type="hidden" name="cms[user_id]" value="3">
            <input type="hidden" name="cms[author]" value="John Pepp">
            <label class="headingLabel" for="heading">Heading</label>
            <input class="enterHeading" id="heading" type="text" name="cms[heading]" value="" tabindex="1" required autofocus>
            <label class="textLabel" for="content">Content</label>
            <textarea class="contentTextarea" id="content" name="cms[content]" tabindex="2"></textarea>
            <input class="myButton" type="submit" name="submit" value="enter">
        </form>
    </div>
</div>
<section class="mainArea">
    <header class="headerStyle">
        <img src="assets/images/img-header-red-tailed-hawk-001.jpg" alt="Red-tailed Hawk">
    </header>
    <nav class="navigation">
        <ul class="topNav">
            <li><a href="index.php">home</a></li>
            <li><a href="#">about</a></li>
            <li><a href="cms_forums.php">CMS threads</a></li>
            <li><a href="#">contact</a></li>
        </ul>
    </nav>
    <aside class="sidebar">

    </aside>
    <main id="content" class="mainStyle">
        <div class="cmsThreads">
            <?php
            $url = 'cms_forums.php';
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
