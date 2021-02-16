<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

?>
<div class="content">
    <main class="main-area">
        <section class="">
            <div id="remote">
                <a id="ePrev" class="btn" title="Previous Button" href="#">Prev</a>
                <h2 id="status">Record No. <span id="position"></span></h2>
                <a id="eNext" class="btn" title="Next Button" href="#">Next</a>
            </div>
            <form id="editTrivia" action="editTrivia.php" method="post" data-key="<?= $_SESSION['api_key']; ?>">
                <fieldset>
                    <legend id="legend">Edit Trivia</legend>
                    <input id="id" type="hidden" name="id" value="0">
                    <input id="user_id" type="hidden" name="user_id" value="">
                    <select id="hiddenQ" class="select-css" name="hidden" tabindex="1">
                        <option id="setOption" value="" selected></option>
                        <option value="yes">Question is Hidden!</option>
                        <option value="no">Question is NOT Hidden!</option>
                    </select>
                    <textarea id="addQuestion" name="question" tabindex="2" placeholder="Add question here..." autofocus></textarea>
                    <label for="addAnswer1">Answer 1</label>
                    <input id="addAnswer1" type="text" name="answer1" value="" tabindex="3">
                    <label for="addAnswer2">Answer 2</label>
                    <input id="addAnswer2" type="text" name="answer2" value="" tabindex="4">
                    <label for="addAnswer3">Answer 3</label>
                    <input id="addAnswer3" type="text" name="answer3" value="" tabindex="5">
                    <label for="addAnswer4">Answer 4</label>
                    <input id="addAnswer4" type="text" name="answer4" value="" tabindex="6">   
                    <label for="addCorrect">Correct</label>
                    <input id="addCorrect" type="text" name="correct" value="" tabindex="7">
                    <input id="submitBtn" type="submit" name="submit" value="save" tabindex="8">
                </fieldset>
            </form>
        </section>
    </main>

    <div class="sidebar">
        <div class="squish-container">
            <h3>Social Media</h3>
            <nav class="social-media">
                <ul>
                    <li><a href="https://www.facebook.com/Pepster64/"><i class="fab fa-facebook-square"></i>Facebook</a></li>
                    <li><a href="https://twitter.com/Strider64"><i class="fab fa-twitter"></i>Twitter</a></li>
                    <li><a href="https://www.linkedin.com/in/johnpepp/"><i class="fab fa-linkedin-in"></i>LinkedIn</a></li>
                    <li><a href="https://www.flickr.com/photos/pepster/sets/72157704634851262/"><i class="fab fa-flickr"></i>Flickr</a></li>
                </ul>
            </nav>
        </div>
    </div><!-- .sidebar -->
</div><!-- .content -->    

<?php
require_once 'assets/includes/footer.inc.php';
