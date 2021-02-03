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
    <link rel="stylesheet" href="assets/css/stylesheet.css">
</head>
<body class="site">
<section class="mainArea">
    <header class="headerStyle">
        <img src="assets/images/img-header-red-tailed-hawk-001.jpg" alt="Red-tailed Hawk">
    </header>
    <div class="topLeft">
        <nav class="navigation">
            <ul class="topNav">
                <li><a href="index.php">home</a></li>
                <li><a href="admin/login.php">admin</a></li>
                <li><a href="game.php">game</a></li>
                <li><a href="contact.php">contact</a></li>
            </ul>
        </nav>
        <img src="assets/images/img-logo-004.jpg" alt="Logo for Website">
    </div>
    <main id="content" class="mainStyle">
        <form id="contact" name="contact" action="contact.php" method="post"  autocomplete="on">
            <div id="message">
                <h2 id="notice">Form Notification</h2>
                <a  id="messageSuccess" href="index.php" title="Home Page">Home</a>
            </div>
            <fieldset>
                <legend>Contact Form</legend>
                <input id="token" type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                <label class="labelstyle" for="name" accesskey="U">Name</label>
                <input name="name" type="text" id="name" tabindex="1" autofocus required="required" />

                <label class="labelstyle" for="email" accesskey="E">Email</label>
                <input name="email" type="email" id="email" tabindex="2" required="required" />

                <label class="labelstyle" for="phone" accesskey="P" >Phone <small>(optional)</small></label>
                <input name="phone" type="tel" id="phone" tabindex="3">

                <label class="labelstyle" for="web" accesskey="W">Website <small>(optional)</small></label>
                <input name="website" type="text"  id="web" tabindex="4">

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
                <?php if (filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL) == "localhost") { ?>
                    <div id="recaptcha" class="g-recaptcha" data-sitekey="6LdXNpAUAAAAAMwtslAEqbi9CU3sviuv2imYbQfe" data-callback="correctCaptcha"></div>

                <?php } else { ?>
                    <!-- Use a data callback function that Google provides -->
                    <div id="recaptcha" class="g-recaptcha" data-sitekey="6LdXNpAUAAAAAMwtslAEqbi9CU3sviuv2imYbQfe" data-callback="correctCaptcha"></div>
                <?php } ?>
                <input id="submitForm" type="submit" name="submit" value="submit" tabindex="7" data-response="">
            </fieldset>
        </form>
    </main>
    <aside class="sidebar">
        <?php include "shared/includes/inc.sidebar.php"; ?>
    </aside>
    <div class="contentContainer">

    </div>

    <footer class="footerStyle">
        <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
    </footer>
</section>
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
