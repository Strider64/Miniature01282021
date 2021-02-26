<?php

require_once '../assets/config/config.php';
require_once "../vendor/autoload.php";

use Miniature\Login;
use Miniature\Trivia;

Login::is_login($_SESSION['last_login']);




$data = Trivia::fetch_all_data('photography');

/* Makes it so we don't have to decode the json coming from javascript */
header('Content-type: application/json');


output($data);

function errorOutput($output, $code = 500)
{
    http_response_code($code);
    echo json_encode($output);
}

///*
// * If everything validates OK then send success message to Ajax / JavaScript
// */

/*
 * After converting data array to JSON send back to javascript using
 * this function.
 */
function output($output)
{
    http_response_code(200);
    echo json_encode($output);
}
