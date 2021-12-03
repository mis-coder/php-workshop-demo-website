<?php

//add file where connection was created
require_once "../config/connect.php";

//add file where we have created constants
require_once "../constants.php";

//initialize empty strings
$first_name = $email = $password = $confirm_password = "";
$first_name_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //check if first_name is empty
    if (empty(trim($_POST['first_name']))) {
        $first_name_err = $EMPTY_FIRSTNAME;
        echo $first_name_err;
    } else {
        $first_name = trim($_POST['first_name']);
    }

    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = $EMPTY_EMAIL;
        echo $email_err;
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set the value of param email
            $param_email = trim($_POST['email']);

            // Try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $email_err = $EMAIL_EXISTS;
                } else {
                    $email = trim($_POST['email']);
                }
            } else {
                echo $SOMETHING_WRONG;
            }
        }
    }

    mysqli_stmt_close($stmt);


    // Check for password
    if (empty(trim($_POST['password']))) {
        $password_err = $EMPTY_PASSWORD;
        echo $password_err;
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = $INVALID_PASSWORD;
        echo $password_err;
    } else {
        $password = trim($_POST['password']);
    }

    // Check for confirm password field
    if (trim($_POST['password']) !=  trim($_POST['cpassword'])) {
        $password_err = $PASSWORD_NOT_MATCHING;
        echo $password_err;
    }


    // If there were no errors, go ahead and insert into the database
    if (empty($first_name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (first_name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $param_first_name, $param_email, $param_password);

            // Set these parameters
            $param_first_name = $first_name;
            $param_email = $email;

            /**
             * password_hash() is in built function
             * it takes in two values - one is the password that you want to encrypt
             * second is the algorithm used to hash/encrypt your password
             */
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                header("location: ../template/login.html");
            } else {
                echo $SOMETHING_WRONG;
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
