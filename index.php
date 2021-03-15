<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\CMS;
use Miniature\Pagination;

/*
 * Website Development by John Pepp
 * Created on February 11, 2020
 * Updated on March 14, 2021
 * Version 1.9.6 Beta
 */


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
    <a class="logo_style" href="http://www.flickr.com/people/pepster/"><img
                src="assets/images/logo-flickr-256x256-001.jpg" alt="Flickr Profile"></a>
    <a class="logo_style" href="https://www.facebook.com/Pepster64"><img
                src="assets/images/logo-facebook-400x400-002.png" alt="Miniature Photographer"></a>
    <a class="logo_style" href="http://www.linkedin.com/in/johnpepp"><img
                src="assets/images/logo-linkedin-640x640-001.png" alt="LinkedIn Profile"></a>
</div>
<main id="content" class="main">
    <section class="container">
        <h2 class="main_heading">The Miniature Journal</h2>
        <?php foreach ($cms as $record) { ?>
            <article class="cms" itemscope itemtype="http://schema.org/Article">
                <header itemprop="articleBody">
                    <div class="byline" itemprop="author publisher" itemscope itemtype="http://schema.org/Organization">
                        <img itemprop="image logo" class="logo" src="assets/images/img-logo-004.png"
                             alt="website logo">
                        <h2 itemprop="headline" class="title"><?= $record['heading'] ?></h2>

                        <span itemprop="name" class="author_style">Created by <?= $record['author'] ?> on
                        <time itemprop="dateCreated datePublished"
                              datetime="<?= htmlspecialchars(CMS::styleTime($record['date_added'])) ?>" ><?= htmlspecialchars(CMS::styleDate($record['date_added'])) ?></time></span>

                    </div>


                    <img itemprop="image" class="article_image"
                         src="<?php echo htmlspecialchars($record['image_path']); ?>" <?= getimagesize($record['image_path'])[3] ?>
                         alt="article image">
                </header>
                <p><?= nl2br($record['content']) ?></p>


            </article>
        <?php } ?>
        <?php
        $url = 'index.php';
        echo $pagination->new_page_links($url);
        ?>
    </section>
</main>
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>

</body>
</html>
