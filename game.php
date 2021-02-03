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
    <div class="topLeft">
        <nav class="navigation">
            <ul class="topNav">
                <li><a href="index.php">home</a></li>
                <li><a href="admin/login.php">admin</a></li>
                <li><a href="game.php">game</a></li>
                <li><a href="contact.php">contact</a></li>
            </ul>
        </nav>
        <img src="assets/images/img-logo-002.jpg" alt="Logo for Website">
    </div>

    <main id="content" class="mainStyle">
        <div class="displayStatus">
            <div id="startBtn">
                <a class="logo" id="customBtn" title="Start Button" href="game.php">Start Button</a>
            </div>
            <h4 class="displayTitle">Welcome to Photography Trivia</h4>
            <p>Photography Trivia game is written in vanilla javascript and can be easily transported along with the HTML/CSS.
             Questions and answers are stored in a database table that is easily accessed through PHP, Ajax and Javascript.
            I obtained an Associates Degree in Computer Graphics: Game Design and Interactive Media that has helped me through
            the years to develop this game. I have stripped some of the features away temporary as I have a better
            understanding of PHP Object-oriented Programming (OOP). Though I will be making improvements to the rest of
            this website before I comeback to put those features back.</p>

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
    </main>
    <aside class="sidebar">
        <div class="subscribe_info">
            <h2>Please Subscribe</h2>
            <p>I'm not requiring a registration or a login to access this website, but I'm asking for subscriptions to
                help
                pay for some of the costs in developing this website. The costs is only $15.00 USD per year and would be
                very much appreciated. I will be adding new features to this website in the upcoming weeks and
                subscriptions
                will motivate me to continue to develop.</p>
        </div>
        <div id="paypal-button-container"></div>
        <script src="https://www.paypal.com/sdk/js?client-id=AfNFD6Lrv6FGJvVGXIycY1HhaNNq22Vw21JAwv4zFSp1cTNGCMItNEKsqEUvgiB2jmN2glzRjzacmqUX&vault=true&intent=subscription"
                data-sdk-integration-source="button-factory"></script>
        <script>
            paypal.Buttons({
                style: {
                    shape: 'pill',
                    color: 'black',
                    layout: 'vertical',
                    label: 'subscribe'
                },
                createSubscription: function (data, actions) {
                    return actions.subscription.create({
                        'plan_id': 'P-5E965765G91370830MALBZOI'
                    });
                },
                onApprove: function (data, actions) {
                    alert(data.subscriptionID);
                }
            }).render('#paypal-button-container');
        </script>
    </aside>
    <div class="contentContainer">

    </div>

    <footer class="footerStyle">
        <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
    </footer>
</section>
</body>
</html>


