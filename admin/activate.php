<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";


use Miniature\Register;

if (($_SERVER['REQUEST_METHOD'] === 'GET') && isset($_GET['confirmation'])) {
    $data['validation']  = htmlspecialchars($_GET['confirmation']);
}

if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['submit'])) {

    $username = $_POST['user']['username'];
    $hashed_password = $_POST['user']['hashed_password'];
    $validation = $_POST['user']['validation'];
    $answer = $_POST['user']['answer'];

    $result = Register::activate($username, $hashed_password, $validation, $answer);

    if ($result) {
        header('Location: login.php');
        exit();
    }


}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Activate Account</title>
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
    </div>
</div>

<div class="sidebar">
    <div class="info">
        <h2>New Registration System</h2>
        <p>I'm current implementing a registration system, so please don't try to register at this time as it's still in development. You can, but the account will probably end up being deleted. I will let everyone know with the registration system is complete.</p>
    </div>
</div>
<main id="content" class="main">
    <form class="verify" method="post" action="activate.php">
        <input type="hidden" name="user[validation]" value="<?= $data['validation'] ?>">
        <label class="text_username" for="username">Username</label>
        <input id="username" class="io_username" type="text" name="user[username]" value="" required>
        <label class="text_password" for="password">Password</label>
        <input id="password" class="io_password" type="password" name="user[hashed_password]" required>
        <label for="question">What is the name of the Clock?</label>
        <input id="question" type="text" name="user[answer]" value="">
        <button id="submitForm" type="submit" name="submit" value="enter" tabindex="10">Submit</button>
    </form>
</main>

<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>

</body>
</html>

