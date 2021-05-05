<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";

use Miniature\CalendarObject;
use Miniature\Login;
if (isset($_SESSION['last_login'])) {
    header("Location: index.php");
    exit();
}

$monthly = new CalendarObject();

$monthly->phpDate();

$calendar = $monthly->generateCalendar('login.php');

if (isset($_POST['submit'])) {
    $login = new Login($_POST['user']);
    $login->login();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" media="all" href="../assets/css/styles.css">
</head>
<body class="site">
<div id="skip"><a href="#content">Skip to Main Content</a></div>
<header class="masthead">

</header>

<div class="nav">
    <input type="checkbox" id="nav-check">

    <h3 class="nav-title">
        The Miniature Photographer
    </h3>

    <div class="nav-btn">
        <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>

    <div class="nav-links">
        <a href="../index.php">Home</a>
        <a href="login.php">Admin</a>
        <a href="../game.php">Quiz</a>
        <a href="../contact.php">Contact</a>
    </div>
</div>

<div class="sidebar">

</div>
<main id="content" class="main">

    <form class="login" method="post" action="login.php">
        <label class="text_username" for="username">Username</label>
        <input id="username" class="io_username" type="text" name="user[username]" value="" required>
        <label class="text_password" for="password">Password</label>
        <input id="password" class="io_password" type="password" name="user[hashed_password]" required>
        <input class="login_button" type="submit" name="submit" value="login">
    </form>
</main>

<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>
</body>
</html>
