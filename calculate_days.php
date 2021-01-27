<?php


$date = "January 14, 2021";


    $calc = new DateTime($date, new DateTimeZone("America/Detroit"));
    $calc->modify("+45 days");
    echo "Testing";
    echo "Days from January 14, 2021 is " .  $calc->format("F j, Y") . "<br>";




