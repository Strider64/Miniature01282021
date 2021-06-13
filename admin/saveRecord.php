<?php

require_once '../assets/config/config.php';
require_once "../vendor/autoload.php";

use Miniature\Login;
use Miniature\Trivia;

Login::is_login($_SESSION['last_login']);
$user = Login::securityCheck();

/*
 * Only Sysop privileges are allowed.
 */
if ($user['security'] === 'member') {
    header("Location: index.php");
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

//echo "<pre>" . print_r($data, 1) . "</pre>";
//die();
$trivia = new Trivia($data);
$result = $trivia->update();



if ($result) {
    output('Data Successfully Updated');
}

function errorOutput($output, $code = 500)
{
    http_response_code($code);
    echo json_encode($output);
}

function output($output)
{
    http_response_code(200);
    echo json_encode($output);
}
