<?php


namespace Miniature;


class Register extends DatabaseObject
{
    protected static string $table = "admins"; // Table Name:
    static protected array $db_columns = ['first_name', 'last_name', 'email', 'username', 'phone', 'security', 'hashed_password', 'validation', 'new_date', 'update_date', 'birthday'];

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



    public function activate($username, $hashed_password, $validation) {
        static::$searchItem = 'username';
        static::$searchValue = htmlspecialchars($username);
        $sql = "SELECT id, security, hashed_password, validation FROM " . static::$table . " WHERE username =:username LIMIT 1";
        $result = static::fetch_by_column_name($sql);
        if ($result && (password_verify($hashed_password, $result['hashed_password']) && $result['validation'] === $validation)) {
            $result['security'] = 'member';
            $result['validation'] = 'validated';
            return $result;

        }
    }


}