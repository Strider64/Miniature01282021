<?php

require_once '../assets/config/config.php';
require_once "../vendor/autoload.php";

use Miniature\Trivia;

/*
 * Get Category from the FETCH statement from javascript
 */
$category = htmlspecialchars($_GET['category']);


if (isset($category)) { // Get rid of $api_key if not using:

    $data = Trivia::fetch_data($category);

    $mData = []; // Temporary Array Placeholder:
    $answers = []; // Answer Columns from Table Array:
    $finished = []; // Finished Results:
    $index = 0; // Index for answers array:
    $indexArray = 0; // Index for database table array:

    /*
     * Put database table in proper array format in order that
     * JSON will work properly.
     */
    foreach ($data as $qdata) {

        foreach ($qdata as $key => $value) {

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
        unset($qdata['answer1'], $qdata['answer2'], $qdata['answer3'], $qdata['answer4']);

        $finished = array_merge($qdata, $answers);
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