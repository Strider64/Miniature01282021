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
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <title>Add Quiz</title>
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
<footer class="colophon">
    <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
</footer>
</body>
</html>