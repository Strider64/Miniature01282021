<?php

require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\Trivia;

/*
 * Get Category from the FETCH statement from javascript
 */
$category = htmlspecialchars($_GET['category']);


if (isset($category)) { // Get rid of $api_key if not using:

    $data = Trivia::fetch_data($category); // Fetch the data from the Database Table:

    $mData = []; // Temporary Array Placeholder:
    $answers = []; // Answer Columns from Table Array:
    $finished = []; // Finished Results:
    $index = 0; // Index for answers array:
    $indexArray = 0; // Index for database table array:

    /*
     * Put database table in proper array format in order that
     * JSON will work properly.
     */
    foreach ($data as $question_data) {

        foreach ($question_data as $key => $value) {

            /*
             * Use Switch Function to convert to the right array format
             * that is bases on the key (index) of that array.
             */
            switch ($key) {

                case 'answer1':
                    $answers['answers'][$index] = $value;
                    break;
                case 'answer2':
                    $answers['answers'][$index + 1] = $value;
                    break;
                case 'answer3':
                    $answers['answers'][$index + 2] = $value;
                    break;
                case 'answer4':
                    $answers['answers'][$index + 3] = $value;
                    break;
            }
        } // foreach inner

        /*
         * No Longer needed, but it wouldn't hurt if not unset
         */
        unset($question_data['answer1'], $question_data['answer2'], $question_data['answer3'], $question_data['answer4']);

        $finished = array_merge($question_data, $answers);
        $mData[$indexArray] = $finished;
        $indexArray++;
    }

    output($mData); // Send properly formatted array back to javascript:
}

/*
 * After converting data array to JSON send back to javascript using
 * this function.
 */
function output($output)
{
    http_response_code(200);
    try {
        echo json_encode($output, JSON_THROW_ON_ERROR);
    } catch (JsonException) {
    }

}