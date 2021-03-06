<?php
$ch = curl_init('https://coderbyte.com/api/challenges/json/json-cleaning');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch);

try {
    $new_data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
}
$new_array = [];
/** @noinspection PhpUndefinedVariableInspection */
echo "<pre>" . print_r($new_data, 1) . "</pre>";

foreach ($new_data as $key => $value) {

    //echo "<pre>" . print_r($key, 1) . "</pre>";
    if (!is_array($value)) {

        echo "Key: " . $key . " Value: " . $value . "<br>";
        if (!empty($value) && $value !== "-" && $value !== "N/A") {
            $new_array[$key] = $value;
        }

    } else {
        foreach ($value as $k => $v) {
            if (!empty($v) && $v !== "-" && $v !== "N/A") {
                $new_array[$key][$k] = $v;
            }
        }
    }

}

echo "<pre>" . print_r($new_array, 1) . "</pre>";

