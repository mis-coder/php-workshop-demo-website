<?php
//This script will handle login
session_start();

// check if the user is already logged in
if (isset($_SESSION['email'])) {
    header("location: ../index.php");
    exit;
}

//add file where connection was created
require_once "../config/connect.php";

//add file where we have created constants
require_once "../constants.php";

$email = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['email'])) || empty(trim($_POST['password']))) {
        $err = $EMPTY_EMAIL_PASSWORD;
        echo $err;
    } else {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
    }


    if (empty($err)) {
        $sql = "SELECT id, first_name, email, password FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;

        // Try to execute this statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $first_name, $email, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        // this means the password is corrct. Allow user to login
                        session_start();
                        $_SESSION["first_name"] = $first_name;
                        $_SESSION["email"] = $email;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;

                        //Redirect user to welcome page
                        header("location: ../index.php");
                    } else {
                        echo $INVALID_CREDS;
                    }
                }
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
