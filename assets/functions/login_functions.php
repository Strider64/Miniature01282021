<?php

function login($username, $password, $pdo, $table) {
    /*
     * Create the PDO Query for the login
     */
    $sql = "SELECT id, hashed_password FROM " . $table . " WHERE username =:username LIMIT 1";
    /* Prepare the PDO for execution */
    $stmt = $pdo->prepare($sql);
    /* Execute PDO */
    $stmt->execute([ 'username'=> $username ]);
    /* Fetch the Password into an associate array */
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    /* Verify User's Password */
    if ($user && password_verify($password, $user['hashed_password'])) {
        unset($user['hashed_password']);
        session_regenerate_id(); // prevent session fixation attacks
        $last_login = $_SESSION['last_login'] = time();
        return $_SESSION['id'] = $user['id'];
    }
    return false;
}
