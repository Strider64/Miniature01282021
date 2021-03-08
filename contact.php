<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" media="all" href="assets/css/styles.css">
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
        <a href="index.php">Home</a>
        <a href="admin/login.php">Admin</a>
        <a href="game.php">Quiz</a>
        <a href="contact.php">Contact</a>
    </div>
</div>

<div class="sidebar">
    <a class="logo_style" href="http://www.flickr.com/people/pepster/"><img src="assets/images/logo-flickr-256x256-001.jpg"
                                                                            alt="Flickr Profile"></a>
    <a class="logo_style" href="https://www.facebook.com/Pepster64"><img src="assets/images/logo-facebook-400x400-002.png" alt="Miniature Photographer" ></a>
</div>
<main id="content" class="main">
    <div id="message">
        <h2 id="notice">Form Notification</h2>
        <a id="messageSuccess" href="index.php" title="Home Page">Home</a>
    </div>
    <form id="contact" name="contact" action="contact.php" method="post" autocomplete="on">


        <input id="token" type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
        <label class="labelstyle" for="name" accesskey="U">Name</label>
        <input name="name" type="text" id="name" tabindex="1" autofocus required="required"/>

        <label class="labelstyle" for="email" accesskey="E">Email</label>
        <input name="email" type="email" id="email" tabindex="2" required="required"/>

        <label class="labelstyle" for="phone" accesskey="P">Phone <small>(optional)</small></label>
        <input name="phone" type="tel" id="phone" tabindex="3">

        <label class="labelstyle" for="web" accesskey="W">Website <small>(optional)</small></label>
        <input name="website" type="text" id="web" tabindex="4">

        <label for="message-type">Reason for Writing?</label>
        <select id="message-type" name="reason">
            <option value="message">Message</option>
            <option value="inquiry">Inquiry</option>
            <option value="order">Order</option>
        </select>

        <label class="textareaLabel" for="comments">Comments Length:<span id="length"></span></label>
        <textarea name="comments" id="comments" spellcheck="true" placeholder="Enter Message Here..." tabindex="6"
                  required="required"></textarea>
        <?php if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) === "localhost") { ?>
            <div id="recaptcha" class="g-recaptcha" data-sitekey="6LdXNpAUAAAAAMwtslAEqbi9CU3sviuv2imYbQfe"
                 data-callback="correctCaptcha"></div>

        <?php } else { ?>
            <!-- Use a data callback function that Google provides -->
            <div id="recaptcha" class="g-recaptcha" data-sitekey="6LdXNpAUAAAAAMwtslAEqbi9CU3sviuv2imYbQfe"
                 data-callback="correctCaptcha"></div>
        <?php } ?>
        <input id="submitForm" type="submit" name="submit" value="submit" tabindex="7" data-response="">

    </form>
</main>
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>
<script src="assets/js/contact.js" async defer></script>
<!-- Fetch the g-response using a callback function -->
<script>
    var correctCaptcha = function (response) {
        document.querySelector('#submitForm').setAttribute('data-response', response);
    };
</script>

<script src='https://www.google.com/recaptcha/api.js' async defer></script>
</body>
</html>
