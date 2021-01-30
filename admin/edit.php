<?php
require_once '../assets/config/config.php';
require_once "../vendor/autoload.php";

use Miniature\CMS;
use Miniature\Login;

Login::is_login($_SESSION['last_login']);


$id = (int) htmlspecialchars($_GET['id'] ?? null);

/*
 * Set the class to of the record (data) to be display
 * to the class then fetch the data to the $record
 * ARRAY do be displayed on the website. If an
 * update has been done then update database
 * table otherwise just fetch the record
 * by id.
 */
if (isset($_POST['submit'])) {
    $cms = new CMS($_POST['cms']);
    $cms->update();
    $id = $_POST['cms']['id'];
} elseif ($id && is_int($id)) {

    $record = CMS::fetch_by_id($id);
    $cms = new CMS($record);
} else {
    header("Location: index.php");
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/stylesheet.css">
    <title>Edit Record</title>
</head>
<body class="site">
<section class="mainArea">
    <header class="headerStyle">
        <img src="../assets/images/img-header-red-tailed-hawk-001.jpg" alt="Red-tailed Hawk">
    </header>
    <nav class="navigation">
        <ul class="topNav">
            <li><a href="index.php">home</a></li>
            <li><a href="create.php">add</a></li>
            <li><a href="logout.php">logout</a> </li>
        </ul>
    </nav>
    <aside class="sidebar">

    </aside>
    <main id="content" class="mainStyle">
        <form class="formGrid" action="edit.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="cms[id]" value="<?= $id ?>">
            <input type="hidden" name="cms[user_id]" value="<?= $_SESSION['id'] ?>">
            <input type="hidden" name="cms[author]" value="<?= Login::full_name() ?>">
            <input type="hidden" name="action" value="upload">
            <input class="image-upload" type="file" name="image">
            <label class="headingLabel" for="heading">Heading</label>
            <input class="enterHeading" id="heading" type="text" name="cms[heading]" value="<?= $cms->heading ?>" tabindex="1" required autofocus>
            <label class="textLabel" for="content">Content</label>
            <textarea class="contentTextarea" id="content" name="cms[content]" tabindex="2"><?= $cms->content ?></textarea>
            <button class="myButton" type="submit" name="submit" value="enter">submit</button>
        </form>
    </main>
    <div class="contentContainer">

    </div>

    <footer class="footerStyle">
        <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
    </footer>
</section>
</body>
</html>
