<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\CMS;

$cms = new CMS();

$delete_id = (int) ($_GET['delete_id'] ?? null);

/*
 * If user/admin deletes a post then send the
 * request off to the delete method in order for
 * that particular record (data) to be delete.
 */
if ($delete_id && is_int($delete_id)) {
    $result = $cms->delete($delete_id);
    if ($result) {
        header("Location: cms_forums.php");
        exit();
    }
}

$id = (int) htmlspecialchars($_GET['id'] ?? null);

/*
 * Set the class to of the record (data) to be display
 * to the class then fetch the data to the $record
 * ARRAY do be displayed on the website.
 */
if ($id && is_int($id)) {
    $record = CMS::fetch_by_id($id);
    $cmsRecord = new CMS($record);
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
            <li><a href="#">about</a></li>
            <li><a href="cms_forums.php">CMS threads</a></li>
            <li><a href="#">contact</a></li>
        </ul>
    </nav>
    <aside class="sidebar">

    </aside>
    <main id="content" class="mainStyle">
        <form class="formGrid" action="cms_forums.php" method="post">
            <input type="hidden" name="cms[id]" value="<?= $cmsRecord->id ?>">
            <label class="headingLabel" for="heading">Heading</label>
            <input class="enterHeading" id="heading" type="text" name="cms[heading]" value="<?= $cmsRecord->heading ?>" tabindex="1" required autofocus>
            <label class="textLabel" for="content">Content</label>
            <textarea class="contentTextarea" id="content" name="cms[content]" tabindex="2"><?=$cmsRecord->content ?></textarea>
            <input class="myButton" type="submit" name="submit" value="enter" tabindex="3">
            <a class="deleteBtn" href="edit.php?delete_id=<?= $cmsRecord->id ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
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
