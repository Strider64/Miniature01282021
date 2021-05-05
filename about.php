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
$total_count = CMS::countAllPage('about'); // Total Records in the db table:


/* Send the 3 variables to the Pagination class to be processed */
$pagination = new Pagination($current_page, $per_page, $total_count);


/* Grab the offset (page) location from using the offset method */
$offset = $pagination->offset();

/*
 * Grab the data from the CMS class method *static*
 * and put the data into an array variable.
 */
$cms = CMS::page($per_page, $offset, 'about');


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>About Page</title>
    <link rel="stylesheet" media="all" href="assets/css/styles.css">
</head>
<body class="site">
<div id="skip"><a href="#content">Skip to Main Content</a></div>
<header class="masthead">

</header>

<?php include_once "assets/includes/inc.nav.php";?>

<main id="content" class="main">
    <div class="container">
        <?php foreach ($cms as $record) { ?>
            <article class="cms" itemscope itemtype="http://schema.org/Article">
                <header itemprop="articleBody">
                    <div class="byline" itemprop="author publisher" itemscope itemtype="http://schema.org/Organization">
                        <img itemprop="image logo" class="logo" src="assets/images/img-logo-004.png"
                             alt="website logo">
                        <h2 itemprop="headline" class="title"><?= $record['heading'] ?></h2>

                        <span itemprop="name" class="author_style">Created by <?= $record['author'] ?> on
                        <time itemprop="dateCreated datePublished"
                              datetime="<?= htmlspecialchars(CMS::styleTime($record['date_added'])) ?>"><?= htmlspecialchars(CMS::styleDate($record['date_added'])) ?></time></span>

                    </div>


                    <img itemprop="image" class="article_image"
                         src="<?php echo htmlspecialchars($record['image_path']); ?>" <?= getimagesize($record['image_path'])[3] ?>
                         alt="article image">
                </header>
                <p><?= nl2br($record['content']) ?></p>


            </article>
        <?php } ?>
        <?php
        $url = 'about.php';
        //echo $pagination->new_page_links($url);
        ?>
    </div>
</main>

<div class="sidebar">
    <div class="info">
        <h2>Website Information</h2>
        <p>A responsive website that deals with photography and website development using the latest coding practices.</p>
        <p>I also have a GitHub repository on website at <a class="repository" href="https://github.com/Strider64/Miniature01282021" title="Github Repository">Miniature Repository</a> that you are free to check out.</p>
    </div>

</div>

<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>

</body>
</html>