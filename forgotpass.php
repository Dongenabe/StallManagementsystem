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

<body>
    <header>
        <?php include('indexheader.php');?>
    </header>

    <link rel="stylesheet" href="css/login1.css">    
    <main class="login">
        <div class="containerl">
                    <?php
                            if(isset($_GET['error'])){
                                if($_GET['error'] == "emptyfields"){
                                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Please fill out all fields.</strong><small>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                }elseif($_GET['error'] == "pwdnotmatched"){
                                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Password not matched.</strong></small>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                }elseif($_GET['error'] == "incorrectlastname"){
                                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Incorrect lastname.</strong></small>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                }elseif($_GET['error'] == "incorrectfirstname"){
                                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Incorrect firstname.</strong></small>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                }elseif($_GET['error'] == "incorrectusername"){
                                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Incorrect username.</strong></small>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                }elseif($_GET['error'] == "incorrectemail"){
                                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Incorrect email.</strong></small>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                }elseif($_GET['error'] == "nouser"){
                                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Incorrect username.</strong></small>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                }
                            }if(isset($_GET['resetpassword'])){
                                if($_GET['resetpassword'] == "success"){
                                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <small><strong> <i class="fa-solid fa-circle-check"></i>&nbsp; Password reset successfully.</strong></small>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                }
                            }
                        ?>

            <h2 class="text-center"><img src="img/binalbagan.png" alt="" width="96" height="96"></h2>

                <form action="includes/manageuseracc.php" method="post" class="login-email">
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-12">    
                            <div class="input-group">
                                <input type="text" name="usname" class="form-control input" required>
                                <label class="label">Username</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" name="lname" class="form-control input" required>
                                <label class="label">Lastname</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-12">    
                            <div class="input-group">
                                <input type="text" name="fname" class="form-control input" required>
                                <label class="label">Firstname</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="email" name="mel" class="form-control input"  required>
                                <label class="label">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-12">    
                            <div class="input-group">
                                <input type="password" name="pas1" class="form-control input" required>
                                <label class="label">New password</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-12">    
                            <div class="input-group">
                                <input type="Password" name="pas2" class="form-control input" required>
                                <label class="label">Confirm password</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-center">
                        <div class="col-6">
                            <div class="input-group">
                                <a href="login.php" class="btn btn-danger btn-sm btn-cancel">Cancel</a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group">
                                <button type="submit" name="forgot-submit" class="btn btn-save">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </main>
