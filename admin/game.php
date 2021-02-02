<?php
require_once '../assets/config/config.php';
require_once "../vendor/autoload.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Photography Quiz</title>

    <script type="text/javascript" src="../assets/js/game.js" defer></script>

</head>
<body>
    <div id="startBtn">
        <a class="logo" id="customBtn" title="Start Button" href="game.php"><span>Start Button</span></a>
    </div>
    <div id="quiz" class="displayMessage" data-username="Strider">
        <div class="triviaContainer" data-records=" ">
            <div id="mainGame">
                <div id="headerStyle" data-user="">
                    <h2>Time Left: <span id="clock"></span><span id="currentQuestion"></span><span
                                id="totalQuestions"></span></h2>
                </div>
                <div id="triviaSection" data-correct="">
                    <div id="questionBox">
                        <h2 id="question">What is the Question?</h2>
                    </div>
                    <div id="buttonContainer"></div>
                </div>

                <div id="playerStats">
                    <h2 id="score">Score 0 Points</h2>
                    <h2 id="percent">100 percent</h2>
                </div>
                <div id="nextStyle">
                    <button id="next" class="nextBtn">Next</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


