<?php

//add file where connection was created
require_once "../config/connect.php";

//add file where we have created constants
require_once "../constants.php";

// check if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['email'])) || empty(trim($_POST['new_password']))) {
        $err = $EMPTY_EMAIL;
        echo $err;
    } else {
        $email = trim($_POST['email']);
        $password = trim($_POST['new_password']);
    }

    //check if user with this email exists already
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
                $sql = "UPDATE users set password = ? WHERE email = ?";
                $stmt2 = mysqli_prepare($conn, $sql);
                if ($stmt2) {
                    mysqli_stmt_bind_param($stmt2, "ss", $param_password, $param_email);

                    // Set these parameters
                    $param_password = password_hash($password, PASSWORD_DEFAULT);
                    $param_email = $email;

                    // Try to execute the query
                    if (mysqli_stmt_execute($stmt2)) {
                        header("location: ../template/login.html");
                    }
                }
                mysqli_stmt_close($stmt2);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo $SOMETHING_WRONG;
        }
    }
    mysqli_close($conn);
}
