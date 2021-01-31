<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";

use Miniature\CalendarObject;
use Miniature\Login;

$monthly = new CalendarObject();

$monthly->phpDate();

$calendar = $monthly->generateCalendar('login.php');

$submit = $_POST['submit'] ?? null;

if ($submit) {
    $login = new Login($_POST['user']);
    $login->login();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Page</title>
    <link rel="stylesheet" href="../assets/css/stylesheet.css">
</head>
<body class="site">
<section class="mainArea">
    <header class="headerStyle">
        <img src="../assets/images/img-header-red-tailed-hawk-001.jpg" alt="Red-tailed Hawk">
    </header>
    <div class="topLeft">
        <nav class="navigation">
            <ul class="topNav">
                <li><a href="../index.php">home</a></li>
            </ul>
        </nav>
        <form class="login" method="post" action="login.php">
            <label class="username" for="username">Username</label>
            <input id="username" type="text" name="user[username]" value="">
            <label class="password" for="password">Password</label>
            <input id="password" type="password" name="user[hashed_password]">

            <button type="submit" name="submit" value="login">Login</button>
        </form>
    </div>
    <aside class="sidebar">
        <div class="subscribe_info">
            <h2>Please Subscribe</h2>
            <p>I'm not requiring a registration or a login to access this website, but I'm asking for subcriptions to help pay for some of the costs in developing this website. The costs is only $15.00 USD per year and would be very much appreciated. I will be adding new features to this website in the upcoming weeks and subscriptions will motivate me to continue developing.</p>
        </div>
        <div id="paypal-button-container"></div>
        <script src="https://www.paypal.com/sdk/js?client-id=AfNFD6Lrv6FGJvVGXIycY1HhaNNq22Vw21JAwv4zFSp1cTNGCMItNEKsqEUvgiB2jmN2glzRjzacmqUX&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
        <script>
            paypal.Buttons({
                style: {
                    shape: 'pill',
                    color: 'black',
                    layout: 'vertical',
                    label: 'subscribe'
                },
                createSubscription: function(data, actions) {
                    return actions.subscription.create({
                        'plan_id': 'P-5E965765G91370830MALBZOI'
                    });
                },
                onApprove: function(data, actions) {
                    alert(data.subscriptionID);
                }
            }).render('#paypal-button-container');
        </script>
    </aside>
    <main id="content" class="mainStyle"><!-- Part of a grid -->
        <div class="twoBoxes"> <!-- flex boxes -->
            <div class="box">

            </div>
            <div class="box dkBlueGray">
                <?= $calendar ?>
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
