<?php

    if(isset($_POST['login-submit'])){

        require 'dbh.inc.php';
        require 'functions.inc.php';

        $username = $_POST['usname'];
        $pass = $_POST['pword'];

        if(emptyInputLogin($username, $pass) !== false){
            header("Location: ../login.php?error=emptyinput");
            exit();
        }
        else{
            $sql = "SELECT * FROM users WHERE username=? OR email=?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../login.php?error=sqlerrore");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "ss", $username, $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)){
                    //password verifier...
                    $passCheck = password_verify($pass, $row['pwd']);
                    if($passCheck == false){
                        header("Location: ../login.php?error=wronglogin2");
                        exit();
                    }elseif($passCheck == true){
                        session_start();
                        $_SESSION['usrId'] = $row['userid'];
                        $_SESSION['usernm'] = $row['username'];
                        $_SESSION['ustype'] = $row['usertype'];
                        $_SESSION['image'] = $row['img_url'];
                
                        header("Location: ../manage.php?login=success");
                        exit();
                    }else{
                        header("Location: ../login.php?error=wronglogin2");
                        exit();
                    }
                }else{
                    header("Location: ../login.php?error=wronglogin1");
                    exit();
                }
            }
        }

    }if(isset($_POST['login-tenant-submit'])){

        require 'dbh.inc.php';
        require 'functions.inc.php';

        $username = $_POST['usname1'];
        $pass = $_POST['pword1'];

        if(emptyInputLogin($username, $pass) !== false){
            header("Location: ../tenantlogin.php?error=emptyinput");
            exit();
        }
        else{
            $sql = "SELECT * FROM tenants WHERE tenantid=?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../tenantlogin.php?error=sqlerrore");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)){
                    //password verifier...
                    
                    $passCheck = false;
                    
                    if($pass == $row['phoneno']){
                        $passCheck = true;
                    }

                    if($passCheck == false){
                        header("Location: ../tenantlogin.php?error=wronglogin2");
                        exit();
                    }elseif($passCheck == true){
                        session_start();
                        $_SESSION['tenantId'] = $row['tenantid'];
                        $_SESSION['tlname'] = $row['tenant_lname'];
                        //$_SESSION['ustype'] = $row['usertype'];
                        //$_SESSION['image'] = $row['img_url'];
                
                        header("Location: ../tdashboard.php?login=success");
                        exit();
                    }else{
                        header("Location: ../tenantlogin.php?error=wronglogin2");
                        exit();
                    }
                }else{
                    header("Location: ../tenantlogin.php?error=wronglogin1");
                    exit();
                }
            }
        }

    }