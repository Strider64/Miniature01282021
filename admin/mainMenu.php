<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";


use Miniature\Login;

Login::is_login($_SESSION['last_login']);


//echo "<pre>" . print_r($calendar, 1) . "</pre>";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Post</title>
    <link rel="stylesheet" href="../assets/css/stylesheet.css">
</head>
<body class="site">
<section class="mainArea">
    <header class="headerStyle">
        <img src="../assets/images/img-header-red-tailed-hawk-001.jpg" alt="Red-tailed Hawk">
    </header>
    <nav class="navigation">
        <ul class="topNav">
            <li><a href="mainMenu.php">menu</a></li>
            <li><a href="#">edit</a></li>
            <li><a href="#">delete</a></li>
            <li><a href="logout.php">logout</a> </li>
        </ul>
    </nav>
    <aside class="sidebar">
    </aside>
    <main id="content" class="mainStyle">
        <div class="twoBoxes">
            <div class="box">
                <form class="formGrid" action="login.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="cms[user_id]" value="3">
                    <input type="hidden" name="cms[author]" value="John Pepp">
                    <label class="headingLabel" for="heading">Heading</label>
                    <input class="enterHeading" id="heading" type="text" name="cms[heading]" value="" tabindex="1" required autofocus>
                    <label class="textLabel" for="content">Content</label>
                    <textarea class="contentTextarea" id="content" name="cms[content]" tabindex="2"></textarea>
                    <input class="myButton" type="submit" name="submit" value="enter">
                </form>
            </div>
            <div class="box dkBlueGray"></div>
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
