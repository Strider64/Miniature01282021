<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\CMS;
use Miniature\Pagination;
if (isset($_POST['submit'])) {
    $args = $_POST['cms'];
    $update = new CMS($args);
    $update->update();
    //echo "<pre>" .  print_r($args, 1) . "</pre>";
}

$current_page = $_GET['page'] ?? 1;
$per_page = 3;
$total_count = CMS::countAll();

$pagination = new Pagination($current_page, $per_page, $total_count);
$offset = $pagination->offset();

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
                echo "<h3>" . $record['heading'] .  "</h3>\n";
                echo "<h4> Created by " . $record['author'] . " on " . CMS::styleDate($record['date_added']) . " updated on " . CMS::styleDate($record['date_updated']) . "</h4>";
                echo "<p>" . nl2br(CMS::intro($record['content'], 200, $record['id'])) . "</p>\n";
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
