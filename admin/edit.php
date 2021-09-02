<?php
require_once '../assets/config/config.php';
require_once "../vendor/autoload.php";

use Miniature\CMS;
use Miniature\Login;

Login::is_login($_SESSION['last_login']);

$user = Login::securityCheck();

/*
 * Only Sysop privileges are allowed.
 */
if ($user['security'] !== 'sysop') {
    header("Location: index.php");
    exit();
}

$result = false;
$id = (int)htmlspecialchars($_GET['id'] ?? null);
try {
    $today = $todayDate = new DateTime('today', new DateTimeZone("America/Detroit"));
} catch (Exception $e) {
}
$date_updated = $today->format("Y-m-d H:i:s");
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

    $result = $cms->update();
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
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>Edit Page</title>
    <link rel="stylesheet" media="all" href="../assets/css/styles.css">
</head>
<body class="site">
<div id="skip"><a href="#content">Skip to Main Content</a></div>
<header class="masthead">

</header>

<div class="nav">
    <input type="checkbox" id="nav-check">

    <h3 class="nav-title">
        The Miniature Photographer
    </h3>

    <div class="nav-btn">
        <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>

    <div class="nav-links">
        <a href="index.php">home</a>
        <a href="create.php">create</a>
        <a href="addQuiz.php">add Q</a>
        <a href="editQuiz.php">edit Q</a>
        <a href="logout.php">logout</a>
    </div>
</div>

<div class="sidebar">

</div>
<main id="content" class="main">
    <form id="formData" class="form_classes" action="edit.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="cms[id]" value="<?= $id ?>">
        <input type="hidden" name="cms[user_id]" value="<?= $_SESSION['id'] ?>">
        <input type="hidden" name="cms[author]" value="<?= Login::full_name() ?>">
        <input type="hidden" name="cms[date_updated]" value="<?= $date_updated ?>">
        <input type="hidden" name="action" value="upload">
        <input class="form_image_upload_style" type="file" name="image">
        <br><br>
        <label class="heading_label_style" for="heading">Heading</label>
        <input class="enter_input_style" id="heading" type="text" name="cms[heading]" value="<?= $cms->heading ?>"
               tabindex="1" required autofocus>
        <label class="text_label_style" for="content">Content</label>
        <textarea class="text_input_style" id="content" name="cms[content]" tabindex="2"><?= $cms->content ?></textarea>
        <button class="form_button" formaction="delete.php?id=<?= $id ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
        <button class="form_button" type="submit" name="submit" value="enter">submit</button>
    </form>
</main>
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>

</body>
</html>
