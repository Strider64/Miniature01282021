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
$per_page = 3; // Total number of records to be displayed:
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
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <link rel="stylesheet" href="../assets/css/stylesheet.css">
    <script src="../assets/js/menu.js" defer></script>
</head>
<body class="site">
<a class="skip-link screen-reader-text" href="#content">Skip to content</a>
<header class="masthead">
    <img class="masthead-logo" src="/assets/images/img-logo-004.png" alt="website logo">
    <h1 class="site-title">The Miniature Photographer</h1>
</header>

<section class="main-nav">
    <button class="trigger" aria-expanded="false">Menu<span class="screen-reader-text">Reveal menu</span></button>

    <nav>
        <ul>

            <li><a href="index.php">home</a></li>
            <li><a href="create.php">create</a></li>
            <li><a href="addQuiz.php">add Q</a></li>
            <li><a href="logout.php">logout</a></li>

        </ul>
    </nav>
</section><!-- .main-nav -->

<main id="content" class="main-area">
    <ul class="cards">
        <?php
        foreach ($cms as $record) {
            echo '<li class="card">';
            echo '<a href="edit.php?id=' . urldecode($record['id']) . '">';
            echo '<img class="thumb" src="../' . $record['thumb_path'] .  '" alt="thumbnail">';
            echo '<div class="cms_heading">';
            echo '<h2>' . $record['heading'] . '</h2>';
            echo '<p class="byline">by ' . $record['author'] . ' on ' . CMS::styleDate($record['date_added']) . '</p>';
            echo '</div>';
            echo '<p class="cms_content">' . nl2br(CMS::intro($record['content'], 200)) . '</p>';
            echo '</a>';
            echo '</li>';
        }
        ?>
    </ul>
    <?php
    $url = 'index.php';
    echo $pagination->new_page_links($url);
    echo '</div>';
    ?>
</main>
<section class="sidebar">
    <aside class="twin">

    </aside>
    <aside class="twin">
        <img src="../assets/images/img-logo-003.jpg" alt="Detroit Kern's Clock">
    </aside>
</section><!-- .twins -->
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>
</body>
</html>

