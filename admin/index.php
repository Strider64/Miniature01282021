<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";
use Miniature\CMS;
use Miniature\Pagination;
use Miniature\Login;

Login::is_login($_SESSION['last_login']);


if (isset($_POST['submit'])) {
    $_SESSION['page'] = $_POST['page'];
} else {
    $_SESSION['page'] = 'blog';
}

/*
 * Using pagination in order to have a nice looking
 * website page.
 */
$current_page = $_GET['page'] ?? 1; // Current Page
$per_page = 1; // Total number of records to be displayed:
$total_count = CMS::countAllPage($_SESSION['page']); // Total Records in the db table:

/* Send the 3 variables to the Pagination class to be processed */
$pagination = new Pagination($current_page, $per_page, $total_count);

/* Grab the offset (page) location from using the offset method */
$offset = $pagination->offset();

/*
 * Grab the data from the CMS class method *static*
 * and put the data into an array variable.
 */
$cms = CMS::page($per_page, $offset, $_SESSION['page']);

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
    <div class="username">
        <h1><?= Login::full_name() ?></h1>
    </div>

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
    <form class="form_classes" action="index.php" method="post">
        <label for="select_page">Select Current Page</label>
        <select id="select_page" name="page">
            <option value="index" <?php echo ($_SESSION['page'] === 'index') ? 'selected' : null; ?>>Home</option>
            <option value="index" <?php echo ($_SESSION['page'] === 'blog') ? 'selected' : null; ?>>Blog</option>
            <option value="about"<?php echo ($_SESSION['page'] === 'about') ? 'selected' : null; ?>>About</option>
        </select>
        <button class="form_button" type="submit" name="submit" value="enter">submit</button>
    </form>
</div>
<main id="content" class="main">
    <section class="container">
        <h2 class="main_heading">The Miniature Journal</h2>
        <?php foreach ($cms as $record) { ?>
            <article class="cms" itemscope itemtype="http://schema.org/Article">
                <header itemprop="articleBody">
                    <div class="byline" itemprop="author publisher" itemscope itemtype="http://schema.org/Organization">
                        <img itemprop="image logo" class="logo" src="../assets/images/img-logo-004.png"
                             alt="website logo">
                        <h2 itemprop="headline" class="title"><?= $record['heading'] ?></h2>

                        <span itemprop="name" class="author_style">Created by <?= $record['author'] ?> on
                        <time itemprop="dateCreated datePublished"
                              datetime="<?= htmlspecialchars(CMS::styleTime($record['date_added'])) ?>" ><?= htmlspecialchars(CMS::styleDate($record['date_added'])) ?></time></span>

                    </div>


                    <img itemprop="image" class="article_image"
                         src="<?php echo "../" . htmlspecialchars($record['image_path']); ?>" alt="article image">
                </header>
                <p><?= nl2br($record['content']) ?></p>
                <a class="form_button" href="edit.php?id=<?= urldecode($record['id']) ?>">Record <?= urldecode($record['id']) ?></a>

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
