<?php
/*
 * Should have error reporting turned on and normally
 * goes into a configuration file (config.php for example)
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['submit'])) {
    $weight = (float) $_POST['weight'];
    $price = (float) $_POST['price'];

    /*
     * I would look into using the switch function if you
     * are going to have many ifs.
     */
    if ($weight <= 3500) {
        $price = 65.33;
    } elseif ($weight > 3500 && $weight <= 7500) {
        $price = 89.83;
    } elseif ($weight > 7500) {
        $price = 99.16;
    }
} // You forgot this bracket
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calculator</title>
    <style>
        .site {
            box-sizing: border-box;
            display: block;
            width: 18.50em;
            height: auto;
            padding: 1.250em;
            margin: 1.250em auto;
        }
        .calc {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-auto-rows: 3.125em;
            grid-gap: 0.313em;
            padding: 0.313em;
        }
        .calc label.weight {
            grid-column: 1/2;
            grid-row: 1/2;
            background-color: #86B3D1;
            color: #fff;
            text-align: center;
            line-height: 3.125em;
            box-shadow: 2px 2px 1px rgba(0, 0, 0, 0.5);
            padding: 0.313em;
        }
        .calc #weight, .calc #price {
            outline: none;
            border: none;
            background-color: #fef0db;
            box-shadow: 2px 2px 1px rgba(0, 0, 0, 0.5);
            font-size: 1.2em;
            padding: 0.313em;
        }
        .calc label.price {
            grid-column: 1/2;
            grid-row: 2/3;
            background-color: #86B3D1;
            color: #fff;
            text-align: center;
            line-height: 3.125em;
            box-shadow: 2px 2px 1px rgba(0, 0, 0, 0.5);
            padding: 0.313em;
        }
        .calc button {
            grid-column: 1/3;
            grid-row: 3/4;
            outline: none;
            color: #fff;
            border: none;
            background-color: #86B3D1;
            box-shadow: 2px 2px 1px rgba(0, 0, 0, 0.5);
            font-size: 1.2em;
            text-transform: capitalize;
        }
    </style>
</head>
<body class="site">

<form class="calc" action="calculator.php" method="post">
    <label class="weight" for="weight">Weight</label>
    <input type="number" id="weight" class="form-control" aria-label="Sizing example input" name="weight" aria-describedby="inputGroup-sizing-sm" value="<?=$weight ?? 3500 ?>" tabindex="1">
    <label class="price" for="price">Price</label>
    <input type="number" id="price" class="form-control" aria-label="Sizing example input" name="price" aria-describedby="inputGroup-sizing-sm" value="<?= $price ?? 65.13 ?>" tabindex="2">
    <!-- use ($price) ? $price : 65.13 if the above doesn't work -->
    <button type="submit" name="submit" value="enter">enter</button>
</form>

</body>
</html>
