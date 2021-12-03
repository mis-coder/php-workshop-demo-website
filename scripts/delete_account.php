<?php

//add file where connection was created
require_once '../config/connect.php';

session_start();

//check if there is an 'id' key stored in the sessio
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];

  //write a delete query to delete user that has id = $id
  $sql = "DELETE FROM users WHERE id = ?";

  //prepare the statement
  $stmt = mysqli_prepare($conn, $sql);

  if ($stmt) {

    //bind required parameters with the above statement
    mysqli_stmt_bind_param($stmt, "s", $param_id);
    $param_id = $id;

    //check if the statement was executed successfully
    if (mysqli_stmt_execute($stmt)) {
      session_destroy();
      header("location: ../template/register.html");
    }
  }
}
