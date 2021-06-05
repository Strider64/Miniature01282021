<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";

use Miniature\Register;


if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['submit'])) {

  $register = new Register($_POST['user']);
  $result = $register->create();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>Registration</title>
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
    <form class="registerStyle" action="register.php" method="post">

        <div class="first">
            <label for="first_name">First Name</label>
            <input id="first_name" type="text" name="user[first_name]" value="" tabindex="2" required>
        </div>

        <div class="last">
            <label for="last_name">Last Name</label>
            <input id="last_name" type="text" name="user[last_name]" value="" tabindex="3" required>
        </div>

        <div class="screenName">
            <label class="text_username" for="username">Username</label>
            <input id="username" class="io_username" type="text" name="user[username]" value="" tabindex="4" required>
        </div>

        <div class="telephone">
            <label for="phone">Phone</label>
            <input id="phone" type="text" name="user[phone]" value="" tabindex="5">
        </div>

        <div class="emailStyle">
            <label for="email">Email</label>
            <input id="email" type="email" name="user[email]" value="" tabindex="1" autofocus required>
        </div>

        <div class="password1">
            <label for="passwordBox">Password</label>
            <input class="passwordBox1" id="passwordBox" type="password" name="user[hashed_password]" value="" tabindex="6" required>
            <label for="passwordVisibility">Show Passwords</label>
            <input class="passwordBtn1" id="passwordVisibility" type="checkbox" tabindex="7">
        </div>

        <div class="password2">
            <label for="redoPassword">ReEnter Password</label>
            <input class="passwordBox2" id="redoPassword" type="password" name="user[redo]" value="" tabindex="8" required>
        </div>

        <div class="birthday">
            <label for="birthday">Birthday</label>
            <input id="birthday" type="date" name="user[birthday]" value="1970-01-01" tabindex="9">
        </div>


        <div class="submitForm">
            <button id="submitForm" type="submit" name="submit" value="enter" tabindex="10">Submit</button>
        </div>


    </form>
</main>

<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>


<script>
    function passwordVisibility() {

        let passwordBox1 = document.querySelector(".passwordBox1");
        let passwordBox2 = document.querySelector(".passwordBox2");
        const fields = [passwordBox1, passwordBox2];
        fields.forEach( x => {
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }

        });
    }
    document.querySelector(".passwordBtn1").addEventListener('click', passwordVisibility, false);

</script>

</body>
</html>
