<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";
require_once 'assets/functions/procedural_database_functions.php';
require_once 'assets/functions/login_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = login($_POST['user']['username'], $_POST['user']['hashed_password'], $pdo, 'admins');
    if ($result) {
        header("Location: index.php");
        exit();
    }
    echo "failed!";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" media="all" href="assets/css/miniature.css">
</head>
<body class="site">


<div class="nav">
    <input type="checkbox" id="nav-check">

    <h3 class="nav-title">
        The Photo Tech Guru
    </h3>

    <div class="nav-btn">
        <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>

    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="#">Register</a>
    </div>
</div>


<form class="checkStyle" method="post" action="login.php">
    <div class="screenName">
        <label class="text_username" for="username">Username</label>
        <input id="username" class="io_username" type="text" name="user[username]" value="" required>
    </div>

    <label class="text_password" for="password">Password</label>
    <input id="password" class="io_password" type="password" name="user[hashed_password]" required>

    <div class="submitForm">
        <button class="submitBtn" id="submitForm" type="submit" name="submit" value="login">Login</button>
    </div>
</form>


</body>
</html>

