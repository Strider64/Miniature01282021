<?php

require_once 'assets/config/config.php';
require_once "vendor/autoload.php";

use Miniature\sendMail;

/*
 * The below must be used in order for the json to be decoded properly.
 */
$data = json_decode(file_get_contents('php://input'), true);

$token = $data['token'];

if (hash_equals($_SESSION['token'], $data['token'])) {
    /* The Following to get response back from Google recaptcha */
    $url = "https://www.google.com/recaptcha/api/siteverify";

    $remoteServer = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_URL);
    /*
     * g-response is from $data['response'] that was sent over using FETCH
     */
    $response = file_get_contents($url . "?secret=". PRIVATE_KEY . "&response=" . $data['response'] . "&remoteip=" . $remoteServer);
    $recaptcha_data = json_decode($response);
    /* The actual check of the recaptcha */
    if (isset($recaptcha_data->success) && $recaptcha_data->success === TRUE) {
        /*
         * If token matches and ReCaptcha is valid then send to an email
         * php script or php class. I personally use Swiftmailer, but you can use
         * another 3rd Party Mailer or write you own email script (I wouldn't
         * recommend it).
         */
        $send = new sendMail();

        $send->sendFrom([$data['email'] => $data['name']]);
        $send->sendTo(['jrpepp@pepster.com', 'pepster@pepster.com' => 'John Pepp']);
        $content = $data['phone'] . "\n" . $data['website'] . "\n" . $data['reason'] . "\n" . $data['comments'];
        $send->content($content);
        $send->subject('A email from The Miniature Photographer');
        $result = $send->sendEmail();

        /* Send Back Result (true or false) back to Fetch */
        if ($result) {
            output(true);
        } else {
            errorOutput(false);
        }
    } else {
        $success = "You're not a human!"; // Not on a production server:
    }
} else {
    output('Token Error');
}

function errorOutput($output, $code = 500) {
    http_response_code($code);
    echo json_encode($output);
}


/*
 * After converting data array to JSON send back to javascript using
 * this function.
 */
function output($output) {
    http_response_code(200);
    echo json_encode($output);
}