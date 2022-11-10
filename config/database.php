<?php
  define('DB_HOST', 'localhost');
  define('DB_USER', 'favas');
  define('DB_PASS', '123');
  define('DB_NAME', 'registration');

  // Create Connection
  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

  // Check Connection
  if($conn->connect_error) {
    die("Connection Error: $conn->connect_error");
  }
?>