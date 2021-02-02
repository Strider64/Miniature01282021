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
    <title>Photography Quiz</title>
    <link rel="stylesheet" href="assets/css/stylesheet.css">
    <script type="text/javascript" src="assets/js/game.js" defer></script>

</head>
<body class="site">
<section class="mainArea">
    <header class="headerStyle">
        <img src="assets/images/img-header-red-tailed-hawk-001.jpg" alt="Red-tailed Hawk">
    </header>
    <nav class="navigation">
        <ul class="topNav">
            <li><a href="index.php">home</a></li>
            <li><a href="admin/login.php">admin</a></li>
            <li><a href="game.php">game</a> </li>
            <li><a href="#">contact</a></li>
        </ul>
    </nav>
    <aside class="sidebar">

    <div id="startBtn">
        <a class="logo" id="customBtn" title="Start Button" href="game.php"><span>Start Button</span></a>
    </div>
    </aside>
    <main id="content" class="mainStyle">
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
    </main>
    <div class="contentContainer">

    </div>

    <footer class="footerStyle">
        <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
    </footer>
</section>
</body>
</html>


