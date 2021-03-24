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
    <title>Photography Trivia</title>
    <link rel="stylesheet" media="all" href="assets/css/styles.css">
    <script type="text/javascript" src="assets/js/game.js" defer></script>
</head>
<body class="site">
<div id="skip"><a href="#content">Skip to Main Content</a></div>
<header class="masthead">

</header>

<?php include_once "assets/includes/inc.nav.php";?>

<main id="content" class="main">
    <div class="displayStatus">
        <span id="clock"></span>
        <h4 class="displayTitle">Welcome to Photography Trivia</h4>
        <p class="triviaInfo">Photography Trivia game is written in vanilla javascript and can be easily transported along with the
            HTML/CSS.
            Questions and answers are stored in a database table that is easily accessed through PHP, Ajax and
            Javascript.
            I obtained an Associates Degree in Computer Graphics: Game Design and Interactive Media that has helped me
            through
            the years to develop this game.</p>
        <div id="startBtn">
            <a class="logo" id="customBtn" title="Start Button" href="game.php">Start Button</a>
        </div>
    </div>

    <div id="quiz" class="displayMessage" data-username="Strider">
        <div class="triviaContainer" data-records=" ">
            <div id="mainGame">

                <div id="triviaSection" data-correct="">
                    <div id="questionBox">
                        <h2 id="question">What is the Question?</h2>
                    </div>
                    <div id="buttonContainer"></div>
                </div>
                <div id="nextStyle">
                    <button id="next" class="nextBtn">Next</button>
                </div>

                <div id="headerStyle" data-user="">
                    <h2><span id="currentQuestion"></span> out of <span id="totalQuestions"></span> questions</h2>
                </div>

                <div id="playerStats">
                    <h2 id="score">Score 0 Points</h2>
                    <h2 id="percent">100 percent</h2>
                </div>

            </div>
        </div>
    </div>
</main>

<div class="sidebar">
    <div class="info">
        <h2>Website Information</h2>
        <p>A responsive website that deals with photography and website development using the latest coding practices.</p>
        <p>I also have a GitHub repository on website at <a class="repository" href="https://github.com/Strider64/Miniature01282021" title="Github Repository">Miniature Repository</a> that you are free to check out.</p>
    </div>
    <a class="logo_style flickr" href="http://www.flickr.com/people/pepster/"><img
                src="assets/images/logo-flickr-256x256-001.jpg" alt="Flickr Profile"></a>
    <a class="logo_style facebook" href="https://www.facebook.com/Pepster64"><img
                src="assets/images/logo-facebook-400x400-002.png" alt="Miniature Photographer"></a>
    <a class="logo_style linkedin" href="http://www.linkedin.com/in/johnpepp"><img
                src="assets/images/logo-linkedin-640x640-001.png" alt="LinkedIn Profile"></a>

    <p class="css_validation">
        <a href="https://jigsaw.w3.org/css-validator/check/referer">
            <img style="border:0;width:88px;height:31px;margin: 0 auto"
                 src="https://jigsaw.w3.org/css-validator/images/vcss"
                 alt="Valid CSS!"/>
        </a>
    </p>
</div>

<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>

</body>
</html>
