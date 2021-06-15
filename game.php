<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\Login;

try {
    $today = new DateTime("Now", new DateTimeZone("America/Detroit"));
} catch (Exception $e) {
}
if (isset($_SESSION['id'])) {
    $username = Login::username();
} else {
    $username = "Guest";
}

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
    <div class="username">
        <h1><?= $username ?></h1>
    </div>
</header>

<?php include_once "assets/includes/inc.nav.php"; ?>

<main id="content" class="main">
    <div class="displayStatus">
        <span id="clock"></span>
        <h4 class="displayTitle">Welcome to Photography Trivia</h4>
        <p class="triviaInfo">The Miniature Photographer Trivia game has been improved to include
        a high score table of the top 5 players for that day. Eventually the top winner that day will be
        allowed to add his/her own question with answers regarding <b>photography</b>. A player can
        play as long as he or she doesn't get more than 3 questions wrong. In order to win the daily
        competition you must be registered and login to be eligible; otherwise, a <i>Guest</i>username
        will be used and won't be factored into the high scores table. (Winning that is)</p>
        <p>I am still updating this trivia game and I hope to have it finished by the end the week. There might
        be modifications to the gameplay (rules) and I am always open to constructive critiques
        to the game.</p>
        <div id="startBtn">
            <a class="logo" id="customBtn" title="Start Button" href="game.php">Start Game</a>
        </div>
    </div>

    <div id="quiz" class="displayMessage" data-username="<?= $username ?>">
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
        <p><?= $username ?> ended up with <span class="totalScore"></span> points and answered <span
                    class="answeredRight"></span> right.</p>
        <a class="btn1" href="game.php" title="Quiz">Play Again?</a>
    </div>
</main>

<div class="sidebar">
    <article class="addTriviaInfo">
        <table id="scoreboard" class="styled-table">
            <thead>
            <tr class="tableTitle">
                <th colspan="2">High Scores - <?= $today->format("F j, Y") ?></th>
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
    <?php if (!isset($_SESSION['id'])) { ?>
    <div class="info">
        <form class="login" method="post" action="admin/login.php">
            <label class="text_username" for="username">Username</label>
            <input id="username" class="io_username" type="text" name="user[username]" value="" required>
            <label class="text_password" for="password">Password</label>
            <input id="password" class="io_password" type="password" name="user[hashed_password]" required>
            <button class="form_button" type="submit" name="submit" value="login">submit</button>
            <a href="admin/register.php" title="register">register</a>
        </form>
    </div>
    <?php } ?>

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
