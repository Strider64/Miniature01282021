<?php

namespace Miniature;

use PDO;
use Miniature\Database as DB;
use PDOException;

class Users {

    private $password;
    protected $id;
    protected $query;
    protected $stmt = NULL;
    protected $result = NULL;
    protected $queryParams = NULL;
    protected $row = NULL;
    protected $loginStatus = false;
    protected $salt = NULL;
    public $user_id = NULL;
    public $fullName = NULL;
    public $user = NULL;
    public $userArray = [];
    public $username = NULL;
    public $duplicate = "duplicate";

    protected static function pdo(): PDO
    {
        $db = DB::getInstance();
        return $db->getConnection();
    }

    /* Create (Insert) new users information */

    public function __construct($args=[]) {

    }

    /* This method also takes an array of data and utilizes the constructor. */

    public function register($data): bool
    {

        $this->pwd = password_hash($data['password'], PASSWORD_DEFAULT);
        unset($data['password']);
        try {
            $this->query = 'INSERT INTO users (fullName, username, status, password, security, email, date_added) VALUES (:fullName, :username, :status, :password, :security, :email, Now())';
            $this->stmt = static::pdo()->prepare($this->query);
            $this->result = $this->stmt->execute([':fullName' => $data['fullName'], ':username' => $data['username'], ':status' => $data['status'], ':password' => $this->pwd, ':security' => 'newuser', ':email' => $data['email']]);
        } catch (PDOException $e) {

            /*
             * echo "unique index" . $e->errorInfo[1] . "<br>";
             *
             * An error has occurred if the error number is for something that
             * this code is designed to handle, i.e. a duplicate index, handle it
             * by telling the user what was wrong with the data they submitted
             * failure due to a specific error number that can be recovered
             * from by the visitor submitting a different value
             *
             * return false;
             *
             * else the error is for something else, either due to a
             * programming mistake or not validating input data properly,
             * that the visitor cannot do anything about or needs to know about
             *
             * throw $e;
             *
             * re-throw the exception and let the next higher exception
             * handler, php in this case, catch and handle it
             */

            if ($e->errorInfo[1] === 1062) {
                return false;
            }

            throw $e;
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n"; // Not for a production server:
        }

        return true;
    }



    public function read($username, $password): ?bool
    {

        /* Setup the Query for reading in login data from database table */
        $this->query = 'SELECT id, password FROM users WHERE username=:username';


        $this->stmt = static::pdo()->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':username' => $username]); // Execute the query with the supplied user's emaile:

        $this->result = $this->stmt->fetch(PDO::FETCH_OBJ); // Fetch the User
        //echo "<pre>" . print_r($this->result, 1) . "</pre>";
        if (isset($this->result->password) && password_verify($password, $this->result->password)) {

            unset($this->result->password);
            session_regenerate_id();
            $lifetime = 60 * 60 * 24 * 7;
            $arr_cookie_options = array(
                'expires' => time() + 60 * 60 * 24 * 30,
                'path' => '/',
                'domain' => '.miniaturephotographer.com', // leading dot for compatibility or use subdomain
                'secure' => true, // or false
                'httponly' => true, // or false
                'samesite' => 'None' // None || Lax  || Strict
            );
            //setcookie(session_name(''), session_id(), $arr_cookie_options);
            $_SESSION['id'] = $this->result->id;

            // Save these values in the session, even when checks aren't enabled
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['last_login'] = time();
            //echo sprintf("<pre>%s</pre>", print_r($this->result, 1));
            return true;
        }

        return false;
    }

    public function checkSecurity($id) {

        $this->query = 'SELECT id, security FROM users WHERE id=:id';
        $this->stmt = static::pdo()->prepare($this->query);
        $this->stmt->execute([':id' => $id]);

        $this->result = $this->stmt->fetch(PDO::FETCH_OBJ);

        return $this->result->security;
    }

    private function retrieveSalt($email) {
        $this->query = "SELECT salt FROM members WHERE email=:email";
        $this->stmt = static::pdo()->prepare($this->query);
        $this->stmt->execute([':email' => $email]);
        $this->stmt->setFetchMode(PDO::FETCH_OBJ);
        return $this->stmt->fetchColumn();
    }

    public function username($id = 0) {

        $this->query = "SELECT username FROM users WHERE id=:id";
        $this->stmt = static::pdo()->prepare($this->query);
        $this->stmt->execute([':id' => $id]);
        $this->user = $this->stmt->fetch(PDO::FETCH_OBJ);
        return $this->user->username; // Send back Real Name of User:
    }

    public function checkSecurityCode($confirmation_code) {

        $this->query = 'SELECT security_level FROM users WHERE confirmation_code=:confirmation_code';


        $this->stmt = static::pdo()->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':confirmation_code' => $confirmation_code]); // Execute the query with the supplied user's parameter(s):

        $this->stmt->setFetchMode(PDO::FETCH_OBJ);
        $this->user = $this->stmt->fetch();

        return $this->user->security_level === 'public';
    }

    public function update($confirmation_code) {

        $this->query = 'UPDATE users SET security_level=:security_level WHERE confirmation_code=:confirmation_code';


        $this->stmt = static::pdo()->prepare($this->query);
        $this->result = $this->stmt->execute([':security_level' => 'member', ':confirmation_code' => $confirmation_code]);

        if ($this->result) {
            return TRUE;
        }

        return FALSE;
    }

    /* Logoff Current User */

    public function delete($id = NULL) {
        unset($id, $this->user, $_SESSION['user']);
        $_SESSION['user'] = NULL;
        session_destroy();
        return TRUE;
    }

}
