<?php 
  include 'config/database.php'; 
  session_start();
  
  define('SALT', 'testsalt');

  function hasLoggedin(){
    if(isset($_SESSION['user'])) {
      header('Location: /registration/dashboard.php');
      exit;
    }
  }

  class LoginHelper {
    function __construct($email, $password)
    {
      $this->email = $email;
      $this->password = $password;
      $this->emailErr = $this->passwordErr = '';
    }

    function validate_fields() {
      if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        $this->emailErr = "Invalid email address";
      }

      if(strlen($this->password) < 8) {
        $this->passwordErr = "Password length must be greater than 8";
      }
    }

    function hasNoErrors() {
      if(empty($this->emailErr) && empty($this->passwordErr)) {
        return true;
      }
      return false;
    }

    function authenticate() {
      global $conn;
      $statement = $conn->prepare("SELECT * FROM users WHERE email = ?");
      $statement->bind_param('s', $this->email);
      $statement->execute();
      $result = $statement->get_result();
      $user = $result->fetch_assoc();

      $hashed_password = (!empty($user['password'])) ? $user['password'] : '';
      $user_pass = crypt($this->password, SALT);
      if($hashed_password == $user_pass) {
        return $user;
      }
      return null;
    }
  }

  class RegisterHelper {
    function __construct($name, $email, $password, $repeatPassword)
    {
      $this->name = $name;
      $this->email = $email;
      $this->password = $password;
      $this->repeatPassword = $repeatPassword;
      $this->nameErr = $this->emailErr = $this->passwordErr = $this->repeatPassErr = '';
    }

    function validate_fields() {
      //Email Validation
      global $conn;
      if(filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        $statement = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $statement->bind_param('s', $this->email);
        $statement->execute();
        $result = $statement->get_result();
        $email = $result->fetch_assoc();

        if(!empty($email)) {
          $this->emailErr = "Email address already exists";
        }
      }
      else {
        $this->emailErr = "Invalid email address";
      }
      // Name Validation
      if(strlen($this->name) < 3) {
        $this->nameErr = "Name length must be greater than 2";
      }
      // Password Validation
      if(strlen($this->password) < 8) {
        $this->passwordErr = "Password must be greater than 8";
      }

      if(empty($this->repeatPassword)) {
        $this->repeatPassErr = 'This field is required';
      }

      if($this->password != $this->repeatPassword) {
        $this->repeatPassErr = 'Passwords do not match';
      }
    }

    function hasNoErrors() {
      if(empty($this->nameErr) && empty($this->emailErr) && empty($this->passwordErr) && empty($this->repeatPassErr)) {
        return true;
      }
      return false;
    }

    function registerUser() {
      global $conn;
  
      $this->password = crypt($this->password, SALT);
      $statement = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
      $statement->bind_param('sss', $this->name, $this->email, $this->password);
      $status = $statement->execute();
      return $status;
    }
  }
?>
