<?php

function style_date($style_date) {
    try {
        $dateStylized = new DateTime($style_date, new DateTimeZone("America/Detroit"));
    } catch (Exception $e) {
        echo $e . " invalid date";
    }

    return $dateStylized->format("F j, Y");
}
