<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";

use Miniature\Trivia;
use Miniature\Login;

Login::is_login($_SESSION['last_login']);
$user = Login::securityCheck();

/*
 * Only Sysop privileges are allowed.
 */
if ($user['security'] !== 'sysop') {
    header("Location: index.php");
    exit();
}
$delete = new Trivia();

$id = $_GET['id'] ?? null;

if (!empty($id)) {
    $data = Trivia::fetch_by_id($id);

    /*
     * Delete the record from the Database Table
     */
    $delete->delete($id);
    /*
     * Redirect to the Administrator's Home page
     */
    header("Location: index.php");
    exit();
}

header("Location: editQuiz.php");
exit();
