<?php


namespace Miniature;


class SessionObject
{
    private $admin_id;
    public $username;
    private $last_login;

    public const MAX_LOGIN_AGE = 60*60*24; // 1 day

    public function __construct() {
        session_start();
        $this->check_stored_login();
    }

    public function login($admin): bool
    {
        if($admin) {
            // prevent session fixation attacks
            session_regenerate_id();
            $this->admin_id = $_SESSION['admin_id'] = $admin->id;
            $this->username = $_SESSION['username'] = $admin->username;
            $this->last_login = $_SESSION['last_login'] = time();
        }
        return true;
    }

    public function is_logged_in(): bool
    {
        // return isset($this->admin_id);
        return isset($this->admin_id) && $this->last_login_is_recent();
    }

    public function logout(): bool
    {
        unset($_SESSION['admin_id'], $_SESSION['username'], $_SESSION['last_login'], $this->admin_id, $this->username, $this->last_login);
        return true;
    }

    private function check_stored_login(): void
    {
        if(isset($_SESSION['admin_id'])) {
            $this->admin_id = $_SESSION['admin_id'];
            $this->username = $_SESSION['username'];
            $this->last_login = $_SESSION['last_login'];
        }
    }

    private function last_login_is_recent(): bool
    {
        if (!isset($this->last_login)) {
            return false;
        }

        return !(($this->last_login + self::MAX_LOGIN_AGE) < time());
    }

    public function message($msg="") {
        if(!empty($msg)) {
            // Then this is a "set" message
            $_SESSION['message'] = $msg;
            return true;
        }

// Then this is a "get" message
        return $_SESSION['message'] ?? '';
    }

    public function clear_message(): void
    {
        unset($_SESSION['message']);
    }
}