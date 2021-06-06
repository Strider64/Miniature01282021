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