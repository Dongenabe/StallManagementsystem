<?php
    //session_start();
    if(!isset($_SESSION['usrId'])){
        header("Location: index.php");
        exit();
    }
    if(!isset($_SESSION['usrId'])){
        header("Location: login.php");
        exit();
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="bootstrap5/v5.0.2/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fontsicon/fontawesome-free-6.0.0-beta2-web/css/all.min.css">
    <link rel="stylesheet" href="fontsicon/fontawesome-free-6.4.0-web/css/all.min.css">

    
    <!--This is for pagination-->
    <link href="bootstrap5/v5.0.1/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap5/datatables/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="bootstrap5/datatables2/dataTables.bootstrap5.min.css">
    <!--End of pagination-->

    <link rel="stylesheet" href="css/alert.css">
    <script src="js/alert.js"></script>
    <link rel="stylesheet" href="css/hstyle.css">
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/css2.css" />
</head>
<body id="body-pd">
    <?php
        require 'includes/process.php';
    ?>

    <header class="header" id="header">
        <div class="header_toggle">
            <i class="fa fa-bars" id="header-toggle"></i>
        </div>
        <div class="header_img">
            <img src="img/binalbagan.png">
        </div>
        <span class="nav_logo" style="color: #0e1013; font-weight: bold; font-size: 1.5em;">MUNICIPALITY OF BINALBAGAN</span>
        <div class="dropdown">
            <button class="dropbtn">Welcome <?php echo $_SESSION['usernm'];?> </button>
            <div class="dropdown-content">
                <a href="cpass.php"><i class="fas fa-lock"></i> Change Password</a>
                <a href="includes/logout.inc.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
            </div>
        </div>
    </header>
    <div class="l-navbar border-end" id="nav-bar">
        <nav class="nav">
            <div> 

                <div class="nav_list">
                    <a href="manage.php" class="nav_link <?php if($_SESSION['actib'] == 'mngmnt'){echo 'active';}?>">
                        <i class="fa-solid fa-gauge"></i>
                            <span class="nav_name">Dashboard</span>
                    </a>
                    <?php
                        if($_SESSION['ustype'] == 'Admin'){
                            echo '<a href="users.php" class="nav_link '.$_SESSION['actib'].'"> 
                                    <i class="fas fa-user nav_icon"></i> 
                                        <span class="nav_name">Users</span> 
                                </a> ';
                        }
                    ?>
                    <a href="request.php" class="nav_link <?php if($_SESSION['actib'] == 'request'){echo 'active';}?>"> 
                        <?php 
                            $request = 0;
                            $sql = "SELECT COUNT(req_id) AS tot FROM request_tbl WHERE status='unread';";
                            $result = mysqli_query($conn, $sql);
                            $check = mysqli_num_rows($result);
                            if($check > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                    $request = $row['tot'];
                                }
                            }
                        ?>
                        <i class='fa-solid fa-comments <?php if($request > 0){echo 'position-relative';}?>'>
                            <?php
                                if($request > 0){
                                    echo  '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'.
                                    $request
                                            .'<span class="visually-hidden">unread messages</span>
                                        </span>';
                                }
                            ?>
                        </i> 
                        <span class="nav_name">Inquiries</span> 
                    </a>
                    <a href="market.php" class="nav_link <?php if($_SESSION['actib'] == 'market'){echo 'active';}?>">
                        <i class='fas fa-store-alt nav_icon'></i>
                        <span class="nav_name">Market</span> 
                    </a> 

                    <a href="rental.php" class="nav_link <?php if($_SESSION['actib'] == 'rental'){echo 'active';}?>">
                        <i class='fas fa-store-alt nav_icon'></i>
                        <span class="nav_name">Stalls</span> 
                    </a> 

                    <a href="tenants.php" class="nav_link <?php if($_SESSION['actib'] == 'tenants'){echo 'active';}?>"> 
                        <i class="fas fa-user-friends nav_icon"></i>
                        <span class="nav_name">Tenants</span> 
                    </a> 

                    <a href="tconcerns.php" class="nav_link <?php if ($_SESSION['actib'] == 'concerns') {echo 'active';} ?>">
                        <i class="fa-sharp fa-solid fa-circle-exclamation"></i>
                        <span class="nav_name">Tenants Concern</span>
                    </a>
                    <a href="messages.php" class="nav_link <?php if ($_SESSION['actib'] == 'messages') {echo 'active';} ?>">
                        <i class="fas fa-envelope nav_icon"></i>
                        <span class="nav_name">Message logs</span>
                    </a>
                    <a href="payments.php" class="nav_link <?php if ($_SESSION['actib'] == 'payments') {echo 'active';} ?>">
                        <i class="fa-solid fa-credit-card"></i>
                        <span class="nav_name">Payment Logs</span>
                    </a>
                    <a href="analytics.php" class="nav_link <?php if ($_SESSION['actib'] == 'Reports') {echo 'active';} ?>">
                        <i class="fa-solid fa-chart-simple"></i>
                        <span class="nav_name">Reports</span>
                    </a>

            </div> 
        </nav>
    </div>

