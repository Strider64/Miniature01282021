<?php


namespace Miniature;


use JetBrains\PhpStorm\NoReturn;

class Login extends DatabaseObject
{
    protected static string $table = "admins";

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $username = [];
    static public $error = [];
    protected $hashed_password;
    static public $last_login;

    public const MAX_LOGIN_AGE = 60*60*24*7; // 7 days:

    public function __construct($args = [])
    {
        static::$params[] = $args['username'];
        static::$searchItem = 'username';
        $this->hashed_password = $args['hashed_password'];
    }

    public function login(): void
    {
        $sql = "SELECT id, hashed_password FROM " . static::$table . " WHERE username =:username LIMIT 1";

        $user = static::fetch_by_column_name($sql);

        if ($user && password_verify($this->hashed_password, $user['hashed_password'])) {
            unset($this->hashed_password, $user['hashed_password']);
            session_regenerate_id(); // prevent session fixation attacks
            static::$last_login = $_SESSION['last_login'] = time();
            $this->id = $_SESSION['id'] = $user['id'];
            header("Location: index.php");
            exit();
        }

        static::$error[] = 'Unable to login in!';

    }

    public static function is_login($last_login): void
    {
        if(!isset($last_login) || ($last_login + self::MAX_LOGIN_AGE) < time()) {
            header("Location: login.php");
            exit();
        }
    }

    #[NoReturn] public static function logout(): void
    {
        unset($_SESSION['last_login'], $_SESSION['id']);
        header("Location: login.php");
        exit();
    }
}