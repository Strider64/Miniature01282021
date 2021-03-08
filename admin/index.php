<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";
use Miniature\CMS;
use Miniature\Pagination;
use Miniature\Login;

Login::is_login($_SESSION['last_login']);



/*
 * Using pagination in order to have a nice looking
 * website page.
 */
$current_page = $_GET['page'] ?? 1; // Current Page
$per_page = 1; // Total number of records to be displayed:
$total_count = CMS::countAll(); // Total Records in the db table:

/* Send the 3 variables to the Pagination class to be processed */
$pagination = new Pagination($current_page, $per_page, $total_count);

/* Grab the offset (page) location from using the offset method */
$offset = $pagination->offset();

/*
 * Grab the data from the CMS class method *static*
 * and put the data into an array variable.
 */
$cms = CMS::page($per_page, $offset);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>Admin Home Page</title>
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
    <?php foreach ($cms as $record) { ?>
        <article class="cms" itemscope itemtype="http://schema.org/Article">
            <header>
                <div class="byline" itemprop="author publisher" itemscope itemtype="http://schema.org/Organization">
                    <p>
                        <img itemprop="image logo" src="../assets/images/img-logo-004.png" alt="website logo">
                        <span itemprop="name"><?= $record['author'] ?> on <time itemprop="dateCreated datePublished"><?= htmlspecialchars(CMS::styleDate($record['date_added'])) ?></time></span>
                    </p>
                </div>
                <h1 itemprop="headline"><?= $record['heading'] ?></h1>


            </header>
            <section class="container" itemprop="articleBody">

                <img itemprop="image"
                     src="<?php echo "../" . htmlspecialchars($record['image_path']); ?>" <?= getimagesize("../" . $record['image_path'])[3] ?>
                     alt="article image">

                <p><?= nl2br($record['content']) ?></p>
                <a class="editBtn" href="edit.php?id=<?= urldecode($record['id']) ?>">Record <?= urldecode($record['id']) ?></a>
            </section>
        </article>
    <?php } ?>
    <?php
    $url = 'index.php';
    echo $pagination->new_page_links($url);
    ?>

</main>
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>

</body>
</html>
