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
    protected $security;
    static public $error = [];
    protected string $password;
    static public $last_login;

    public const MAX_LOGIN_AGE = 60*60*24*7; // 7 days:

    public function __construct($args = [])
    {
        static::$searchItem = 'username';
        static::$searchValue = htmlspecialchars($args['username']);
        $this->password = htmlspecialchars($args['hashed_password']);
    }

    public static function activate($username, $hashed_password, $validation, $answer) {

        static::$searchItem = 'username';
        static::$searchValue = htmlspecialchars($username);
        $sql = "SELECT id, security, hashed_password, validation FROM " . static::$table . " WHERE username =:username LIMIT 1";
        $result = static::fetch_by_column_name($sql);
        if ((password_verify($hashed_password, $result['hashed_password']) && ($result['validation'] === $validation)) && $answer == "Kern's") {
            unset($result['hashed_password']);
            $result['security'] = 'member';
            $result['validation'] = 'validated';

        }
        return $result;
    }

    public static function full_name(): string
    {
        static::$searchItem = 'id';
        static::$searchValue = $_SESSION['id'];
        $sql = "SELECT first_name, last_name FROM " . static::$table . " WHERE id =:id LIMIT 1";
        $user = static::fetch_by_column_name($sql);

        return $user['first_name'] . " " . $user['last_name'];
    }

    public static function securityCheck(): bool
    {
        static::$searchItem = "id";
        static::$searchValue = $_SESSION['id'];
        $sql = "SELECT security FROM " . static::$table . " WHERE id=:id LIMIT 1";
        $result = static::fetch_by_column_name($sql);
        return $result['security'] === 'sysop';
    }


    public function login(): void
    {
        $sql = "SELECT id, hashed_password FROM " . static::$table . " WHERE username =:username LIMIT 1";

        $user = static::fetch_by_column_name($sql);

        if ($user && password_verify($this->password, $user['hashed_password'])) {
            unset($this->password, $user['hashed_password']);
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
        header("Location: ../index.php");
        exit();
    }
}