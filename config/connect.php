<?php

  //add constants
  require_once '../constants.php';
  
  //create connection
  $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

  //if there was any error in connection
  if ($conn == false){
    die('Error: Failed to connect to the database!');
  }
