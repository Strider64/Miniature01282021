<?php
require_once "assets/config/config.php";
require_once "vendor/autoload.php";
require_once 'assets/functions/procedural_database_functions.php';
require_once "assets/functions/login_functions.php";

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}


$id = $_GET['id'] ?? null;

if (!empty($id)) {
    $data = fetch_by_id($pdo, 'cms', $id);

    /*
     * Delete the images from the directory
     */
    unlink($data['image_path']);

    /*
     * Delete the record from the Database Table
     */
    $result = delete($id, 'cms', $pdo);
    if ($result) {
        /*
         * Redirect to the Administrator's Home page
         */
        header("Location: index.php");
        exit();
    }
}

header("Location: index.php");
exit();