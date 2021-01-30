<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\CMS;

$cms = new CMS();



$id = (int) htmlspecialchars($_GET['id'] ?? null);

/*
 * Set the class to of the record (data) to be display
 * to the class then fetch the data to the $record
 * ARRAY do be displayed on the website.
 */
if ($id && is_int($id)) {
    $record = CMS::fetch_by_id($id);
    $cms = new CMS($record);
    //echo "content " . $cmsRecord->content . "<br>";
    //echo "<pre>" . print_r($cmsRecord, 1) . "</pre>";
    //die();
} else {
    header("Location: cms_forums.php");
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
    <link rel="stylesheet" href="assets/css/stylesheet.css">
    <title>Edit Record</title>
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
            <li><a href="#">contact</a></li>
        </ul>
    </nav>
    <aside class="sidebar">

    </aside>
    <main id="content" class="mainStyle">
        <div class="display_record">
            <img class="large_img" src="<?php echo $cms->image_path; ?>" alt="<?= $cms->heading ?>">
            <h3 class="record_heading"><?= $cms->heading ?></h3>
            <h6 class="record_author"><?php echo $cms->author; ?><span class="date_created">created on <?php echo CMS::styleDate($cms->date_added) ?></span></h6>
            <p class="record_content"><?php echo nl2br($cms->content); ?></p>
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
