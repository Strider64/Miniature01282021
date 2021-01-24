<?php
ob_start(); // turn on output buffering
/*if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}*/
// **PREVENTING SESSION HIJACKING**

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();
if (empty($_SESSION['token'])) {
    try {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    } catch (Exception $e) {
    }
}
$server_name = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL);
define('BASE_PATH', realpath(__DIR__));



define('DATABASE_HOST', 'localhost');
define('DATABASE_NAME', 'miniature');
define('DATABASE_USERNAME', 'admin');
define('DATABASE_PASSWORD', 'Dpsimfm1964!');
define('DATABASE_TABLE', 'cms');

/*define('PRIVATE_KEY', '6LdXNpAUAAAAAPkPQ5L1YqfrLcqkrwZXh8m33-Jg');
define('DATABASE_HOST', 'db2465.perfora.net');
define('DATABASE_NAME', 'db331312244');
define('DATABASE_USERNAME', 'dbo331312244');
define('DATABASE_PASSWORD', 'Gimfcs1964!Livonia');
define('DATABASE_TABLE', 'users');*/



header("Content-Type: text/html; charset=utf-8");
header('X-Frame-Options: SAMEORIGIN'); // Prevent Clickjacking:
header('X-Content-Type-Options: nosniff');
header('x-xss-protection: 1; mode=block');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
//header("content-security-policy: default-src 'self'; report-uri /csp_report_parser");
header('X-Permitted-Cross-Domain-Policies: master-only');

/* Get the current page */
$phpSelf = $_SERVER['PHP_SELF'];
$path_parts = pathinfo($phpSelf);
$basename = $path_parts['basename']; // Use this variable for action='':
$pageName = $path_parts['filename'];