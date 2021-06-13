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

<?php include_once "assets/includes/inc.nav.php"; ?>

<main id="content" class="main">
    <div class="displayStatus">
        <span id="clock"></span>
        <h4 class="displayTitle">Welcome to Photography Trivia</h4>
        <p class="triviaInfo">Photography Trivia game is written in vanilla javascript and can be easily transported
            along with the
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
                <div id="current">Question No. <span id="currentQuestion"></span></div>
                <div id="triviaSection" data-correct="">
                    <div id="questionBox">
                        <h2 id="question">What is the Question?</h2>
                    </div>
                    <div id="buttonContainer"></div>
                </div>


                <div id="headerStyle" data-user="">
                    <div class="gauge">
                        <div class="gauge__body">
                            <div class="gauge__fill"></div>
                            <div class="gauge__cover">Battery 100%</div>
                        </div>
                    </div>
                    <p id="score">0 Points</p>
                    <p id="percent">100% Correct</p>



                    <button id="next" class="nextBtn">Next</button>
                </div>

            </div>
        </div>
    </div>
    <div id="finalResult">
        <h2>Game Over!</h2>
        <p><span class="username"></span> ended up with <span class="totalScore"></span> points and answered <span
                    class="answeredRight"></span> right.</p>
    </div>
</main>

<div class="sidebar">
    <div class="info">
        <h2>Website Information</h2>
        <p>A responsive website that deals with photography and website development using the latest coding
            practices.</p>
        <p>I also have a GitHub repository on website at <a class="repository"
                                                            href="https://github.com/Strider64/Miniature01282021"
                                                            title="Github Repository">Miniature Repository</a> that you
            are free to check out.</p>
    </div>
    <article class="addTriviaInfo">
        <table id="scoreboard" class="styled-table">
            <thead>
            <tr class="tableTitle">
                <th colspan="2">High Scores</th>
            </tr>
            <tr class="subTitle">
                <th>Name</th>
                <th>Points</th>
            </tr>
            </thead>
            <tbody class="anchor">

            </tbody>
        </table>
    </article>
</div>

<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>
<script>
    const gaugeElement = document.querySelector(".gauge");

    function setGaugeValue(gauge, value) {
        if (value < 0 || value > 1) {
            return;
        }

        gauge.querySelector(".gauge__fill").style.transform = `rotate(${
            value / 2
        }turn)`;
        gauge.querySelector(".gauge__cover").textContent = `Battery ${Math.round(
            value * 100
        )}%`;
    }


</script>
</body>
</html>
