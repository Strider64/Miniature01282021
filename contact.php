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
