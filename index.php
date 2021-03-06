<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\CMS;
use Miniature\Pagination;

/*
 * Using pagination in order to have a nice looking
 * website page.
 */

if (isset($_GET['page']) && !empty($_GET['page'])) {
    $current_page = urldecode($_GET['page']);
} else {
    $current_page = 1;
}

$per_page = 1; // Total number of records to be displayed:
$total_count = CMS::countAll(); // Total Records in the db table:

/* Send the 3 variables to the Pagination class to be processed */
$pagination = new Pagination($current_page, $per_page, $total_count);


/* Grab the offset (page) location from using the offset method */
$offset = $pagination->offset();
//echo "<pre>" . print_r($offset, 1) . "</pre>";
//die();
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
    <title>The Miniature Photographer</title>
    <link rel="stylesheet" media="all" href="assets/css/styles.css">
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
        <a href="index.php">Home</a>
        <a href="admin/login.php">Admin</a>
        <a href="game.php">Quiz</a>
        <a href="contact.php">Contact</a>
    </div>
</div>

<div class="sidebar">
    <figure class="nasa_perseverance_container">
        <img id="perseverance_image" src="" alt="Nasa Perseverance Image">
        <figcaption id="image_info">Latest NASA Perseverance Image</figcaption>
    </figure>
</div>
<main id="content" class="main">
    <?php foreach ($cms as $record) { ?>
        <article class="cms" itemscope itemtype="http://schema.org/Article">
            <header>
                <h1 itemprop="headline"><?= $record['heading'] ?></h1>
                <time itemprop="dateCreated datePublished"><?= htmlspecialchars(CMS::styleDate($record['date_added'])) ?></time>
                <div class="byline" itemprop="author publisher" itemscope itemtype="http://schema.org/Organization">
                    <p>
                        <img itemprop="image logo" src="assets/images/img-logo-004.png" alt="website logo">
                        Created by <span itemprop="name"><?= $record['author'] ?></span>
                    </p>
                </div>
            </header>
            <section class="container" itemprop="articleBody">
                <img itemprop="image" src="<?php echo htmlspecialchars($record['image_path']); ?>" alt="article image">
                <p><?= nl2br($record['content']) ?></p>
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

<script src="assets/js/nasa.js"></script>
</body>
</html>
