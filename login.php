<?php
    session_start();
    if(isset($_SESSION['usrId'])){
        header("Location: rental.php");
        exit();
    }if(isset($_SESSION['tenantId'])){
        header("Location: surveycontent.php");
        exit();
    }
?>


    <header>
        <?php include('indexheader.php');?>
    </header>
    <link rel="stylesheet" href="css/login1.css">    
    <main class="login">
        <div class="containerl">
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == "emptyinput"){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Please fill out all fields</strong></small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }elseif($_GET['error'] == "wronglogin1"){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Incorrect username</strong></small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }elseif($_GET['error'] == "wronglogin2"){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Incorrect password</strong></small>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                        }
                    }
                ?>

            <h2 class="text-center"><img src="img/binalbagan.png" alt="" width="96" height="96"></h2>

            <form action="includes/login.inc.php" method="post" class="login-email">
                <div class="input-group">
                    <input type="text" name="usname" class="form-control input"  aria-label="Username" aria-describedby="basic-addon1" required>
                    <label class="label">Username/Email</label>
                </div>
                <div class="input-group">
                    <input type="password" name="pword" class="form-control input"  aria-label="Password" aria-describedby="basic-addon1" required>
                    <label class="label">Password</label>
                </div>
                <div class="input-group">
                    <button type="submit" name="login-submit" class="btn">Login</button>
                </div>
                <p class="login-register-text">Are you a tenant? <a href="tenantlogin.php">Login Here</a>.</p>
                <p class="login-register-text"><a href="forgotPass.php">Forgot password?</a>.</p>
            </form>
        </div>
    </main>    
<?php
    //require 'indexFooter.php';
?>