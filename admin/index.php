<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";

use Miniature\CalendarObject;

$monthly = new CalendarObject();

$monthly->phpDate();

$calendar = $monthly->generateCalendar('index.php');
//echo "<pre>" . print_r($calendar, 1) . "</pre>";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../assets/css/stylesheet.css">
</head>
<body class="site">
<section class="mainArea">
    <header class="headerStyle">
        <img src="../assets/images/img-header-red-tailed-hawk-001.jpg" alt="Red-tailed Hawk">
    </header>
    <nav class="navigation">
        <ul class="topNav">
            <li><a href="../index.php">home</a></li>
            <li><a href="#">add</a></li>
            <li><a href="#">edit</a></li>
            <li><a href="#">delete</a></li>
        </ul>
    </nav>
    <aside class="sidebar">
    </aside>
    <main id="content" class="mainStyle">
        <div class="twoBoxes">
            <div class="box dkBlueGray"><?= $calendar ?></div>
            <div class="box">

            </div>
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
