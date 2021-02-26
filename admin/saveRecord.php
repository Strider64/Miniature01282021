<?php

require_once 'assets/config/config.php';
require_once "vendor/autoload.php";





$data = json_decode(file_get_contents('php://input'), true);

function updateQuiz($data, $pdo) {
    $query = "UPDATE trivia_questions "
            . "SET "
            . "user_id = :user_id, "
            . "question = :question, "
            . "answer1 = :answer1, "
            . "answer2 = :answer2, "
            . "answer3 = :answer3, "
            . "answer4 = :answer4, "
            . "correct = :correct, "
            . 'hidden = :hidden '
            . "WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':user_id' => $data['user_id'],
        ':question' => $data['question'],
        ':answer1' => $data['answer1'],
        ':answer2' => $data['answer2'],
        ':answer3' => $data['answer3'],
        ':answer4' => $data['answer4'],
        ':correct' => $data['correct'],
        ':hidden' => $data['hidden'],
        ':id' => $data['id']
    ]);
    return \TRUE;
}

$result = updateQuiz($data, $pdo);

if ($result) {
    output('Data Successfully Updated');
}

function errorOutput($output, $code = 500) {
    http_response_code($code);
    echo json_encode($output);
}

function output($output) {
    http_response_code(200);
    echo json_encode($output);
}
