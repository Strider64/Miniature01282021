<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";

use Miniature\CalendarObject;
use Miniature\Login;

$monthly = new CalendarObject();

$monthly->phpDate();

$calendar = $monthly->generateCalendar('login.php');

$submit = $_POST['submit'] ?? null;

if ($submit) {
    //echo "<pre>" . print_r($_POST['user'], 1) . "</pre>";
    $login = new Login($_POST['user']);
    $login->login();
}

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
    <div class="topLeft">
        <nav class="navigation">
            <ul class="topNav">
                <li><a href="../index.php">home</a></li>
            </ul>
        </nav>
        <form class="login" method="post" action="login.php">
            <label class="username" for="username">Username</label>
            <input id="username" type="text" name="user[username]" value="">

            <label class="password" for="password">Password</label>
            <input id="password" type="password" name="user[hashed_password]">

            <button type="submit" name="submit" value="login">Login</button>
        </form>
    </div>
    <aside class="sidebar">

    </aside>
    <main id="content" class="mainStyle"><!-- Part of a grid -->
        <div class="twoBoxes"> <!-- flex boxes -->
            <div class="box">

            </div>
            <div class="box dkBlueGray">
                <?= $calendar ?>
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
