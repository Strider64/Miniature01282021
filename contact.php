<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Page</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/stylesheet.css">

    <script src="assets/js/menu.js" defer></script>
</head>
<body class="site">
<a class="skip-link screen-reader-text" href="#content">Skip to content</a>
<header class="masthead">
    <a href="index"><img class="masthead-logo" src="assets/images/img-logo-004.png" alt="website logo"></a>
    <h1 class="site-title">The Miniature Photographer</h1>
</header>

<section class="main-nav">
    <button class="trigger" aria-expanded="false">Menu<span class="screen-reader-text">Reveal menu</span></button>

    <nav>
        <ul>
            <li><a href="index">home</a></li>
            <li><a href="admin/login.php">admin</a></li>
            <li><a href="game">game</a></li>
            <li><a href="contact">contact</a></li>
        </ul>
    </nav>
</section><!-- .main-nav -->

<main id="content" class="main-area">
    <form id="contact" name="contact" action="contact.php" method="post" autocomplete="on">
        <div id="message">
            <h2 id="notice">Form Notification</h2>
            <a id="messageSuccess" href="index.php" title="Home Page">Home</a>
        </div>
        <fieldset>
            <legend>Contact Form</legend>
            <input id="token" type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            <label class="labelstyle" for="name" accesskey="U">Name</label>
            <input name="name" type="text" id="name" tabindex="1" autofocus required="required"/>

            <label class="labelstyle" for="email" accesskey="E">Email</label>
            <input name="email" type="email" id="email" tabindex="2" required="required"/>

            <label class="labelstyle" for="phone" accesskey="P">Phone <small>(optional)</small></label>
            <input name="phone" type="tel" id="phone" tabindex="3">

            <label class="labelstyle" for="web" accesskey="W">Website <small>(optional)</small></label>
            <input name="website" type="text" id="web" tabindex="4">

            <div id="radio-toolbar">
                <input type="radio" id="radioMessage" name="reason" value="message" checked>
                <label for="radioMessage">message</label>

                <input type="radio" id="radioOrder" name="reason" value="order">
                <label for="radioOrder">order</label>

                <input type="radio" id="radioStatus" name="reason" value="status">
                <label for="radioStatus">status</label>
            </div>
            <p>&nbsp;</p>
            <label class="textareaLabel" for="comments">Comments Length:<span id="length"></span></label>
            <textarea name="comments" id="comments" spellcheck="true" tabindex="6" required="required"></textarea>
            <?php if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) === "localhost") { ?>
                <div id="recaptcha" class="g-recaptcha" data-sitekey="6LdXNpAUAAAAAMwtslAEqbi9CU3sviuv2imYbQfe"
                     data-callback="correctCaptcha"></div>

            <?php } else { ?>
                <!-- Use a data callback function that Google provides -->
                <div id="recaptcha" class="g-recaptcha" data-sitekey="6LdXNpAUAAAAAMwtslAEqbi9CU3sviuv2imYbQfe"
                     data-callback="correctCaptcha"></div>
            <?php } ?>
            <input id="submitForm" type="submit" name="submit" value="submit" tabindex="7" data-response="">
        </fieldset>
    </form>
</main>
<section class="sidebar">
    <aside class="twin">

    </aside>
    <aside class="twin">
        <img src="assets/images/img-logo-003.jpg" alt="Detroit Kern's Clock">
    </aside>
</section><!-- .twins -->
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
<script src="assets/js/cookie.notice.js"></script>
</body>
</html>
