<?php
    //session_start();
    if(!isset($_SESSION['tenantId'])){
        header("Location: index.php");
        exit();
    }
    if(!isset($_SESSION['tenantId'])){
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
            <button class="dropbtn">Welcome <?php echo $_SESSION['tlname'];?> </button>
            <div class="dropdown-content">
                <a href="includes/logout.inc.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
            </div>
        </div>
    </header>
    <div class="l-navbar border-end border-info" id="nav-bar">
        <nav class="nav">
            <div> 
                <a href="#" class="nav_logo <?php if($_SESSION['actib'] == 'cpass'){echo 'active';}?>">
                    <i class="fa-solid fa-id-badge" alt="" width="28" height="28" style="border-radius:50%"></i>
                    <span class="nav_logo-name"><?php echo $_SESSION['tlname']; ?></span> 
                </a>
                <div class="nav_list">
                    <a href="tdashboard.php" class="nav_link <?php if($_SESSION['actib'] == 'dboard'){echo 'active';}?>">
                        <i class='fa-sharp fa-solid fa-circle-exclamation'></i>
                            <span class="nav_name">Dashboard</span>
                    </a>
                </div>
                <div class="nav_list">
                    <a href="surveycontent.php" class="nav_link <?php if($_SESSION['actib'] == 'srvy'){echo 'active';}?>">
                        <i class='fa-sharp fa-solid fa-circle-exclamation'></i>
                            <span class="nav_name">Concerns</span>
                    </a>
                </div>
            </div> 
                <a href="includes/logout.inc.php" class="nav_link"> 
                    <i class='fas fa-sign-out-alt'></i> 
                    <span class="nav_name">SignOut</span> 
                </a>
        </nav>
    </div>