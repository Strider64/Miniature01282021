<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\CMS;

$cms = CMS::fetch_all();
//echo "<pre>" . print_r($cms, 1) . "</pre>";

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
            foreach ($cms as $record) {
                echo '<article  class="display">' . "\n";
                try {
                    $dateAdded = new DateTime($record->date_added, new DateTimeZone("America/Detroit"));
                } catch (Exception $e) {
                    error_log("Caught $e");
                }

                echo "<h3>" . $record->heading . " on " . $dateAdded->format("F j, Y") . "</h3>\n";
                echo "<h4> Created by" . $record->author . "</h4>";
                echo "<p>" . $record->content . "</p>\n";
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
