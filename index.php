<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";
require_once 'assets/functions/procedural_database_functions.php';


/*
 * Website Development by John Pepp
 * Created on February 11, 2020
 * Updated on June 28, 2021
 * Version 3.3.7 Beta - adding a gallery
 */

function codingTags($text): array|string
{
    $text = htmlspecialchars($text);
    return str_replace(array('[php]', '[/php]'), array("<pre><code>", "</code></pre>"), $text);
}
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
$total_count = totalRecords($pdo, 'cms');


/* calculate the offset */
$offset = $per_page * ($current_page - 1);

/* calculate total pages to be displayed */
$total_pages = ceil($total_count / $per_page);

//$previous = previous_link('index.php', $current_page);
//$next = next_link('index.php', $current_page, $total_pages);
$links = links_function('index.php', $current_page, $total_pages);

$cms = readData($pdo, 'cms', 'blog', $per_page, $offset);
//echo '<pre>' . print_r($cms,1) . "</pre>";
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>The Miniature Photographer</title>
    <link rel="stylesheet" media="all" href="assets/css/miniature.css">
    <link rel="stylesheet" href="assets/js/styles/a11y-light.min.css">
    <script src="assets/js/highlight.min.js"></script>

    <script>hljs.highlightAll();</script>
</head>
<body class="site">
<div id="skip"><a href="#content">Skip to Main Content</a></div>
<header class="masthead">

</header>

<div class="nav">
    <input type="checkbox" id="nav-check">
    <h3 class="nav-title">
        PHP Procedural Tutorials
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

        <?php
            if (isset($_SESSION['id'])) {
                echo '<a href="create.php">Create</a>';
                echo '<a href="logout.php">Logout</a>';
            } else {
                echo '<a href="https://www.phototechguru.com/">PhotoTech</a>';
                echo '<a href="login.php">Login</a>';
            }
        ?>


    </div>
</div>

<main id="content" class="checkStyle">
    <div class="container">
        <?php foreach ($cms as $record) { ?>
            <article class="cms">
                <img class="article_image"
                     src="<?php echo htmlspecialchars($record['image_path']); ?>" <?= getimagesize($record['image_path'])[3] ?>
                     alt="article image">
                <h2><?= $record['heading'] ?></h2>
                <span class="author_style">Created by <?= $record['author'] ?>
                    on <?= $record['date_added'] ?>
                </span>
                <?php
                //$content = str_replace("[code]", "<pre><code class=\"language-html\">", $record['content']);
                //$content2 = str_replace("[/code]", "</code></pre>", $content);
                $content = codingTags($record['content']);
                ?>


                <p><?= nl2br($content) ?></p>
                <?php echo (isset($_SESSION['id'])) ? '<a class="editButton" href="edit.php?id= ' . urldecode($record['id']) . '">Record ' . urldecode($record['id']) . '</a>' : null; ?>
            </article>
        <?php } ?>
    </div>
</main>
<div class="sidebar">
    <?= $links ?>
</div>
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>

</body>
</html>
