<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";

use Miniature\Validation;

/*
 * The below must be used in order for the json to be decoded properly.
 */
$data = json_decode(file_get_contents('php://input'), true);

$result = Validation::usernameCheck($data['check']);

output($result);




function errorOutput($output, $code = 500) {
    http_response_code($code);
    echo json_encode($output);
}


/*
 * After converting data array to JSON send back to javascript using
 * this function.
 */
function output($output) {
    http_response_code(200);
    echo json_encode($output);
}
