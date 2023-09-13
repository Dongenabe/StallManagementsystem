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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/login1.css">    
    <main class="login">
        <div class="containerl">
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == "emptyinput"){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Please fill out all fields.</strong></small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }elseif($_GET['error'] == "wronglogin1"){
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Incorrect username.</strong></small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }elseif($_GET['error'] == "wronglogin2"){
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <small><strong> <i class="fa-solid fa-circle-exclamation"></i>&nbsp; Incorrect password.</strong></small>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                        }
                    }
                ?>

            <h2 class="text-center"><img src="img/binalbagan.png" alt="" width="96" height="96"></h2>

            <form action="includes/login.inc.php" method="post" class="login-email">
                <div class="input-group">
                    <input type="text" name="usname1" class="form-control" placeholder="Stall number.." aria-label="Username" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group">
                    <input type="password" name="pword1" class="form-control" placeholder="Contact no..." aria-label="Password" aria-describedby="basic-addon1" required>
                </div>
                <div class="input-group">
                    <button type="submit" name="login-tenant-submit" class="btn">Login</button>
                </div>
                <p class="login-register-text">Are you a staff? <a href="login.php">Login Here</a>.</p>
            </form>
        </div>
    </main>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/indexheader.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/cferdinandi/smooth-scroll@15.0.0/dist/smooth-scroll.polyfills.min.js"></script>
    <script>
        // All animations will take exactly 500ms
            var scroll = new SmoothScroll('a[href*="#"]', {
                    speed: 500,
                    speedAsDuration: true
            });

    </script>
    
<?php
    //require 'indexFooter.php';
?>