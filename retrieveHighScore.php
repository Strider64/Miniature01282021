<?php

require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\Trivia;

$trivia = new Trivia();

Trivia::clearTable(); // Clear Data if New Day
try {
    $todays_data = new DateTime("now", new DateTimeZone("America/Detroit"));
} catch (Exception $e) {
}
$maximum = [];

/* Makes it so we don't have to decode the json coming from javascript */
header('Content-type: application/json');

/*
 * The below must be used in order for the json to be decoded properly.
 */
try {
    $maximum = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
}



$day_of_year = $todays_data->format('z');


$output = $trivia->readHighScores($maximum);
if (isset($output)) {
    try {
        output($output);
    } catch (JsonException $e) {
    }
}

/*
 * Throw error if something is wrong
 */

function errorOutput($output, $code = 500) {
    http_response_code($code);
    try {
        echo json_encode($output, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
    }
}

///*
// * If everything validates OK then send success message to Ajax / JavaScript
// */

/*
 * After converting data array to JSON send back to javascript using
 * this function.
 */
function output($output) {
    http_response_code(200);
    try {
        echo json_encode($output, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
    }
}
