<?php


namespace Miniature;

use PDO;


class Validation extends DatabaseObject
{
    public static string $table = "admins"; // Table Name:


    public static function usernameCheck($username): array
    {


        $query = "SELECT username FROM " . static::$table ." WHERE username = :username";
        $stmt = Database::pdo()->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $data['check'] = true;
            return $data;
        }

        $data['check'] = false;
        return $data;


    }

    public static function verifyPassword($password, $redo): bool
    {
        return $password === $redo;
    }
}