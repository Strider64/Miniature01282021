<?php


namespace Miniature;


class Register extends DatabaseObject
{
    protected static string $table = "admins"; // Table Name:
    static protected array $db_columns = ['first_name', 'last_name', 'email', 'username', 'phone', 'security', 'hashed_password', 'validation', 'new_date', 'update_date', 'birthday'];

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $username;
    public $phone;
    public $security;
    public $hashed_password;
    public $validation;
    public $new_date;
    public $update_date;
    public $birthday;

    public static function activate($username, $hashed_password, $validation, $answer): bool
    {

        static::$searchItem = 'username';
        static::$searchValue = htmlspecialchars($username);
        $sql = "SELECT id, security, hashed_password, validation FROM " . static::$table . " WHERE username =:username LIMIT 1";
        $result = static::fetch_by_column_name($sql);
        if (password_verify($hashed_password, $result['hashed_password'])) {

            unset($result['hashed_password']);
            /*
             * Update Security Level to next level
             * which is member status.
             */
            if ($result['validation'] === $validation && $answer === "Kern's") {
                $sql = 'UPDATE admins SET security=:security, validation=:validation WHERE id=:id';
                Database::pdo()->prepare($sql)->execute(['security' => 'member', 'validation' => 'validate', 'id' => $result['id']]);
                return true;
            }
        }

        return false;

    }

    public function __construct($args = [])
    {

        //echo "<pre>" . print_r($args, 1) . "</pre>";
        //die();

        $args['hashed_password'] = password_hash($args['hashed_password'], PASSWORD_DEFAULT);
        // Caution: allows private/protected properties to be set
        foreach ($args as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
                static::$params[$k] = $v;
                static::$objects[] = $v;
            }
        }
    } // End of construct method:


}