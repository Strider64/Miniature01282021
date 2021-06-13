<?php

require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\Trivia;

$trivia = new Trivia();

try {
    $todays_data = new DateTime("now", new DateTimeZone("America/Detroit"));
} catch (Exception $e) {
}


/* Makes it so we don't have to decode the json coming from javascript */
header('Content-type: application/json');

/*
 * The below must be used in order for the json to be decoded properly.
 */
$data = json_decode(file_get_contents('php://input'), true);
$todays_data = new DateTime('now', new DateTimeZone("America/Detroit"));
$data['day_of_year'] = $todays_data->format('z');
$trivia::clearTable();
$result = $trivia::insertHighScores($data);


if ($result) {

    output(true);
}

/*
 * Throw error if something is wrong
 */

function errorOutput($output, $code = 500) {
    http_response_code($code);
    echo json_encode($output);
}

/*
 * If everything validates OK then send success message to Ajax / JavaScript
 */

/*
 * After converting data array to JSON send back to javascript using
 * this function.
 */
function output($output) {
    http_response_code(200);
    echo json_encode($output);
}