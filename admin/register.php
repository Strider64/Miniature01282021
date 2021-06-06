<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";

use Miniature\Register;
use Miniature\sendMail;


if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['submit'])) {

    $send = new sendMail();
    $data = [];
    $data['name'] = $_POST['user']['first_name'] . ' ' . $_POST['user']['last_name'];
    $data['validation'] = $send->validationFCN(20);
    $_POST['user']['validation'] = $data['validation'];

    $data['email'] = $_POST['user']['email'];
    $data['phone'] = $_POST['user']['phone'];
    $data['birthday'] = $_POST['user']['birthday'];

    $data['message'] =
        '<html lang="en">' .
        '<body style=\'background: #eee;\'>' .
        '<p style="font-size: 1.8em; line-height: 1.5;">Full Name : ' . $data['name'] .
        '<br>Email Address : ' . $data['email'] .
        '<br>Phone : ' . $data['phone'] .
        '<br>Birthday : ' . $data['birthday'] . '</p>' .
        '<p style="font-size: 1.4em; line-height: 1.5;">Please click on link: https://www.miniaturephotographer.com/admin/activate.php?confirmation=' . $data['validation'] . ' in order to have access to the Miniature Photographer Website.</p>' .
        '<p style="font-size: 1.4em; line-height: 1.5;">In addition please answer the question "Meet Me Under the [blank] Clock" with the name of the clock in the image that was sent.</p>' .
        '</body>' .
        '</html>';

    $send->verificationEmail($data);

    $register = new Register($_POST['user']);
    $result = $register->create();
    if ($result) {
        header("Location: success.php");
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
        <a href="login.php">login</a>
    </div>
</div>

<div class="sidebar">
    <div class="info">
        <h2>New Registration System</h2>
        <p>I'm current implementing a registration system, so please don't try to register at this time as it's still in development. You can, but the account will probably end up being deleted. I will let everyone know with the registration system is complete.</p>
    </div>
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
            <input class="passwordBox1" id="passwordBox" type="password" name="user[hashed_password]" value=""
                   tabindex="6" required>
            <label for="passwordVisibility">Show Passwords</label>
            <input class="passwordBtn1" id="passwordVisibility" type="checkbox" tabindex="7">
        </div>

        <div class="password2">
            <label for="redoPassword">ReEnter Password</label>
            <input class="passwordBox2" id="redoPassword" type="password" name="user[redo]" value="" tabindex="8"
                   required>
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
        fields.forEach(x => {
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
