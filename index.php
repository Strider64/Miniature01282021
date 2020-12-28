<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\CalendarDynamic;


$monthly = new CalendarDynamic();

$monthly->phpDate();

$calendar = $monthly->generateCalendar('index.php');


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/stylesheet.css">
    <title>The Miniature Photographer</title>
</head>
<body class="site">
<section class="mainArea">
    <header class="headerStyle">
        <img src="assets/images/img-header-red-tailed-hawk-001.jpg" alt="Red-tailed Hawk">
    </header>
    <nav class="navigation">
        <ul class="topNav">
            <li><a href="#">home</a></li>
            <li><a href="#">about</a></li>
            <li><a href="#">gallery</a></li>
            <li><a href="#">contact</a></li>
        </ul>
    </nav>
    <aside class="sidebar shadow">
        <form class="login" method="post" action="index.php">
            <label class="username" for="username" class="password">Username</label>
            <input id="username" type="text" name="username" value="">

            <label class="password" for="password" class="password">Password</label>
            <input id="password" type="password" name="password">

            <button type="submit" name="submit" value="Login">Login</button>
        </form>
    </aside>
    <main id="content" class="mainStyle">
        <div class="twoBoxes">
            <div class="box dkBlueGray"><?= $calendar ?></div>
            <div class="box">
                <h1>Lorem ipsum dolor sit amet.</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta est eum quidem vitae voluptatem.
                    Accusantium architecto autem corporis eius, eveniet incidunt ipsum maxime placeat quis quos ratione ut
                    vel voluptate voluptates voluptatum! Ab aperiam aspernatur atque autem, cupiditate delectus deserunt
                    doloribus esse expedita illo incidunt ipsa, labore nihil nisi numquam qui ratione repellendus, sed sequi
                    soluta. Ab accusamus aliquid cupiditate deleniti dignissimos dolore et, eveniet facilis hic nam neque
                    officia provident, quis totam ullam! A aperiam asperiores eum id iure quam quidem ratione sit?
                    Consequuntur inventore iste labore nostrum optio quasi repudiandae saepe velit! Assumenda fuga fugit nam
                    possimus quod sapiente, ullam vero! Amet, deleniti ducimus eius et eum facere hic incidunt ipsum
                    laboriosam laudantium libero maiores mollitia officia quam quibusdam quidem ratione repellat saepe sunt
                    velit voluptatem voluptates voluptatibus voluptatum? A aliquid asperiores commodi, consectetur culpa
                    dolore eius esse eum excepturi fuga, impedit iste magni modi molestias natus neque nisi obcaecati odit
                    officia perferendis porro possimus quaerat quos, rem sunt tempora vitae voluptate. Exercitationem fuga
                    nulla, quaerat ratione repellendus vero voluptas. Alias aliquid amet assumenda consectetur, ducimus et
                    ex facilis labore, minima nisi optio porro rem unde! Accusantium aliquam architecto deleniti
                    perspiciatis, provident quibusdam sint sit voluptates. Illo, rem!</p></div>
        </div>
    </main>
    <footer class="footerStyle">
        <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
    </footer>
</section>
</body>
</html>
