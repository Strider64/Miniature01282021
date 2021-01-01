<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\CalendarObject;
use Miniature\CMS;

$monthly = new CalendarObject();

$monthly->phpDate();

$calendar = $monthly->generateCalendar('index.php');
//$all = CMS::fetch_all();
//echo "<pre>" . print_r($all, 1) . "</pre>";
$enter = $_POST['submit'] ?? Null;

if ($enter) {
    $args = $_POST['cms'];
    $cms = new CMS($args);
    //echo "<pre>" . print_r($cms, 1) . "</pre>";
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
    <nav class="navigation">
        <ul class="topNav">
            <li><a href="index.php">home</a></li>
            <li><a href="#">about</a></li>
            <li><a href="cms_forums.php">CMS threads</a></li>
            <li><a href="#">contact</a></li>
        </ul>
    </nav>
    <aside class="sidebar">
        <form class="login" method="post" action="index.php">
            <label class="username" for="username">Username</label>
            <input id="username" type="text" name="username" value="">

            <label class="password" for="password">Password</label>
            <input id="password" type="password" name="password">

            <button type="submit" name="submit" value="login">Login</button>
        </form>
    </aside>
    <main id="content" class="mainStyle">
        <div class="twoBoxes">
            <div class="box dkBlueGray"><?= $calendar ?></div>
            <div class="box">
                <form class="cmsEditor" action="index.php" method="post">
                    <fieldset>
                        <legend>Content Management System</legend>
                        <input type="hidden" name="cms[user_id]" value="3">
                        <input type="hidden" name="cms[author]" value="John Pepp">
                        <label class="heading" for="heading">Heading</label>
                        <input class="headingInput" id="heading" type="text" name="cms[heading]" value="" tabindex="1" required autofocus>
                        <label class="content" for="content">Content</label>
                        <textarea class="contentTextarea" id="content" name="cms[content]" tabindex="2"></textarea>
                        <input class="submitBtn" type="submit" name="submit" value="enter">
                    </fieldset>
                </form>
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
