<?php
require_once 'assets/config/config.php';
require_once "vendor/autoload.php";
use Miniature\CalendarObject;

$monthly = new CalendarObject();

$monthly->phpDate();

$calendar = $monthly->generateCalendar('classes.php');
$classes = get_declared_classes();

echo "<pre>" . print_r($classes, 1) . "</pre>";

echo "John Pepp <br>";