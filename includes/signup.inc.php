<?php

    if(isset($_POST['signup-submit'])){
        
        require 'dbh.inc.php';
        require 'functions.inc.php';

        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
        $username = $_POST['username'];
        $usrtype = $_POST['usrtype'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $pwd1 = $_POST['pwd1'];
        $pwd2 = $_POST['pwd2'];

        if(emptyInput($lname, $fname, $username, $usrtype, $email, $pwd1, $pwd2, $phone) !== false){
            header("Location: ../signup.php?error=emptyinput");
            exit();
        }if(invalidUid($username) !== false){
            header("Location: ../signup.php?error=invalidusername");
            exit();
        }if(invalidEmail($email) !== false){
            header("Location: ../signup.php?error=invalidemail");
            exit();
        }if(pwdMatch($pwd1, $pwd2) !== false){
            header("Location: ../signup.php?error=pwdnotmatched");
            exit();
        }if(usernameExists($conn, $username, $email) !== false){
            header("Location: ../signup.php?error=usernametaken");
            exit();
        }else{
            $sql = "SELECT username FROM users WHERE username=?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../signup.php?error=sqlerror");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if($resultCheck > 0){
                    header("Location: ../signup.php?error=usernametaken");
                    exit();
                }else{
                    $sql = "INSERT INTO users (lname, fname, username, usertype, email, phone, pwd) VALUES (?, ?, ?, ?, ?, ?, ?);";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: ../signup.php?error=sqlerror");
                        exit();
                    }else{
                        //this is for encrypting the password...
                        $hashedPass = password_hash($pwd1, PASSWORD_DEFAULT);
    
                        mysqli_stmt_bind_param($stmt, "sssssss", $lname, $fname, $username, $usrtype, $email, $phone, $hashedPass);
                        //this is for execution of the sql statement
                        mysqli_stmt_execute($stmt);
                        header("Location: ../signup.php?error=none");
                        exit();
                    }
                }
            }
        }

    }else{
        header("Location: ../signup.php?error=clkbtn");
        exit();
    }
