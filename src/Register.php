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
        $args['validation'] = $this->validation(20);
        // Caution: allows private/protected properties to be set
        foreach ($args as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
                static::$params[$k] = $v;
                static::$objects[] = $v;
            }
        }
    } // End of construct method:

    protected function validation($length = 15, $characters = true, $numbers = true, $case_sensitive = true, $hash = false ): string
    {

        $password = '';

        if($characters)
        {
            $charLength = $length;
            if($numbers) {
                $charLength -= 2;
            }
            if($case_sensitive) {
                $charLength -= 2;
            }
            if($hash) {
                $charLength -= 2;
            }
            $chars = "abcdefghijklmnopqrstuvwxyz";
            $password.= substr( str_shuffle( $chars ), 0, $charLength );
        }

        if($numbers)
        {
            $numbersLength = $length;
            if($characters) {
                $numbersLength -= 2;
            }
            if($case_sensitive) {
                $numbersLength -= 2;
            }
            if($hash) {
                $numbersLength -= 2;
            }
            $chars = "0123456789";
            $password.= substr( str_shuffle( $chars ), 0, $numbersLength );
        }

        if($case_sensitive)
        {
            $UpperCaseLength = $length;
            if($characters) {
                $UpperCaseLength -= 2;
            }
            if($numbers) {
                $UpperCaseLength -= 2;
            }
            if($hash) {
                $UpperCaseLength -= 2;
            }
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $password.= substr( str_shuffle( $chars ), 0, $UpperCaseLength );
        }

        if($hash)
        {
            $hashLength = $length;
            if($characters) {
                $hashLength -= 2;
            }
            if($numbers) {
                $hashLength -= 2;
            }
            if($case_sensitive) {
                $hashLength -= 2;
            }
            $chars = "!@#$%^&*()_-=+;:,.?";
            $password.= substr( str_shuffle( $chars ), 0, $hashLength );
        }

        return str_shuffle( $password );
    }
}