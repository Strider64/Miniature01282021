<?php

$myArray = '{
    "CONTACT_ID": "500",
    "INV_SERIAL_NO": "345",
    "NAME": "Rumi",
    "INV_DATE": "2018-06-27",
    "DUE_DATE": "2018-06-27",
    "CURRENCY": "KD",
    "SUBTOTAL": "100",
    "TAX_TOTAL": "12",
     "shipment_data": [
        {
            "SHIP_SERIAL_NO": "33",
            "MASTER_NO": "33",
            "HOUSE_NO": "2"
       
        },
          {
              "SHIP_SERIAL_NO": "55",
            "MASTER_NO": "345",
            "HOUSE_NO": "26"
       
        }
    ]

}';


try {
$data = json_decode($myArray, false, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
}

echo "<pre>" . print_r($data, 1) . "</pre>";

//echo "Contact " . $data->CONTACT_ID . "<br>";

//echo "Shipment Serial No: " . $data->shipment_data[0]->SHIP_SERIAL_NO;

foreach ($data as $key => $value) {
    echo "key : " . $key . " value : " . $value . "<br>";
    if (is_array($value)) {

    } else {
        $myStoredData[$key] = $value;
    }
}

echo "<pre>" . print_r($myStoredData, 1) . "</pre>";
