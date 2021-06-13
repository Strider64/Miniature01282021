<?php


namespace Miniature;

use PDO;
trait General
{
    public function full_name() {

        $sql = "SELECT first_name, last_name FROM admin WHERE id =:id LIMIT 1";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute([ 'id' => $_SESSION['id'] ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $user['first_name'] . " " . $user['last_name'];
}
}