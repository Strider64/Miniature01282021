<?php
require_once '../assets/config/config.php';
require_once "../vendor/autoload.php";

use Miniature\Login;
use Miniature\Trivia;

if (isset($_POST['submit'])) {
    $quiz = $_POST['quiz'];
    //echo "<pre>" .print_r($quiz, 1) . "</pre>";
    //die();
    $trivia = new Trivia($quiz);
    $result = $trivia->create();
}

Login::is_login($_SESSION['last_login']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>Photography Quiz</title>
    <link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" media="all" href="../assets/css/stylesheet.css">
    <script src="../assets/js/menu.js" defer></script>
    <script type="text/javascript" src="../assets/js/game.js" defer></script>

</head>
<body class="site">
<a class="skip-link screen-reader-text" href="#content">Skip to content</a>
<header class="masthead">
    <a href="../indexbackup.php"><img class="masthead-logo" src="../assets/images/img-logo-004.png" alt="website logo"></a>
    <h1 class="site-title">The Miniature Photographer</h1>
</header>

<section class="main-nav">
    <button class="trigger" aria-expanded="false">Menu<span class="screen-reader-text">Reveal menu</span></button>

    <nav>
        <ul>

            <li><a href="index.php">home</a></li>
            <li><a href="create.php">create</a></li>
            <li><a href="addQuiz.php">add Q</a></li>
            <li><a href="editQuiz.php">edit Q</a></li>
            <li><a href="logout.php">logout</a></li>

        </ul>
    </nav>
</section><!-- .main-nav -->

<main id="content" class="main-area">
    <form id="addTriviaQA" class="trivia_form" action="addQuiz.php" method="post">
        <input type="hidden" name="quiz[user_id]" value="<?= $_SESSION['id'] ?>">
        <input type="hidden" name="quiz[hidden]" value="no">
        <input type="hidden" name="quiz[category]" value="photography">
        <label class="question_label" for="content">Content</label>
        <textarea class="question_input" id="content" name="quiz[question]" tabindex="2"
                  placeholder="Add question here..."
                  autofocus></textarea>
        <label class="answer_one_label" for="addAnswer1">Answer 1</label>
        <input class="answer_one_input"  id="addAnswer1" type="text" name="quiz[answer1]" value="" tabindex="3">
        <label class="answer_two_label" for="addAnswer2">Answer 2</label>
        <input class="answer_two_input"  id="addAnswer2" type="text" name="quiz[answer2]" value="" tabindex="4">
        <label class="answer_three_label" for="addAnswer3">Answer 3</label>
        <input class="answer_three_input"  id="addAnswer3" type="text" name="quiz[answer3]" value="" tabindex="5">
        <label class="answer_four_label" for="addAnswer4">Answer 4</label>
        <input class="answer_four_input"  id="addAnswer4" type="text" name="quiz[answer4]" value="" tabindex="6">
        <label class="correct_answer_label" for="addCorrect">Answer</label>
        <input class="correct_answer_input"  id="addCorrect" type="text" name="quiz[correct]" value="" tabindex="7">
        <button class="form_button" type="submit" name="submit" value="enter">submit</button>
    </form>
</main>
<section class="sidebar">
    <aside class="twin">

    </aside>
    <aside class="twin">

    </aside>
</section><!-- .twins -->
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>
</body>
</html>