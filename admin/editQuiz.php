<?php
require_once '../assets/config/config.php';
require_once "../vendor/autoload.php";

use Miniature\Login;

Login::is_login($_SESSION['last_login']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Photography Quiz</title>
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" href="../assets/css/stylesheet.css">
    <script src="../assets/js/cookie.notice.js"></script>
    <script src="../assets/js/menu.js" defer></script>
    <script type="text/javascript" src="../assets/js/edit.js" defer></script>

</head>
<body class="site">
<a class="skip-link screen-reader-text" href="#content">Skip to content</a>
<header class="masthead">
    <a href="../index.php"><img class="masthead-logo" src="../assets/images/img-logo-004.png" alt="website logo"></a>
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
    <div id="remote">
        <a id="ePrev" class="btn" title="Previous Button" href="#">Prev</a>
        <h2 id="status">Record No.<span id="position"></span></h2>
        <a id="eNext" class="btn" title="Next Button" href="#">Next</a>
    </div>
    <form id="editTrivia" class="trivia_form" action="editTrivia.php" method="post" data-key="">

        <input id="id" type="hidden" name="id" value="0">
        <input id="user_id" type="hidden" name="user_id" value="">
        <select id="hiddenQ" class="select-css" name="hidden" tabindex="1">
            <option id="setOption" value="" selected></option>
            <option value="yes">Question is Hidden!</option>
            <option value="no">Question is NOT Hidden!</option>
        </select>
        <label class="question_label" for="addQuestion">Content</label>
        <textarea id="addQuestion" class="question_input" name="question" tabindex="2" placeholder="Add question here..."
                  autofocus></textarea>
        <label class="answer_one_label" for="addAnswer1">Answer 1</label>
        <input id="addAnswer1" class="answer_one_input" type="text" name="answer1" value="" tabindex="3">
        <label class="answer_two_label" for="addAnswer2">Answer 2</label>
        <input id="addAnswer2" class="answer_two_input" type="text" name="answer2" value="" tabindex="4">
        <label class="answer_three_label" for="addAnswer3">Answer 3</label>
        <input id="addAnswer3" class="answer_three_input" type="text" name="answer3" value="" tabindex="5">
        <label class="answer_four_label" for="addAnswer4">Answer 4</label>
        <input id="addAnswer4" class="answer_four_input" type="text" name="answer4" value="" tabindex="6">
        <label class="correct_answer_label" for="addCorrect">Correct</label>
        <input class="correct_answer_input" id="addCorrect" type="text" name="correct" value="" tabindex="7">
        <input class="form_button" id="submitBtn" type="submit" name="submit" value="save" tabindex="8">

    </form>
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