<?php
    session_start();
    if (!isset($_SESSION['usernm']) || $_SESSION['ustype'] != 'Admin') {
        header('Location: manage.php');
        exit();
    }
    $_SESSION['actib'] = 'active';
    require 'headerr.php';
?>

    <!--Container Main start-->
    
    <!-- this is for alert -->
    <div id="dialogoverlay"></div>
        <div id="dialogbox">
            <div>
                <div id="dialogboxhead"></div>
                <div id="dialogboxbody"></div>
                <div id="dialogboxfoot"></div>
            </div>
        </div>
        <!-- end of alert -->
    <div class="height-100 bg-light-gray main-content">
        <style>
            .bord{
                border-top: 2px solid #aa8cfa;
            }
        </style>

    <div class="bg-light-gray mb-5 p-3 rounded">
        
            <h3 class="fw-bold">Users</h3><br>
        
                <?php
                    if(isset($_GET['action'])){
                        echo '<center><small><div class="text-start alert alert-'.$_GET['action'].' alert-dismissible fade show" role="alert">
                            <strong>';
                            if($_GET['action'] == 'danger')
                                echo '<i class="fa-solid fa-user-xmark"></i>&nbsp; '.$_GET['usertyp'].' '.$_GET['userlname'].' has been deleted !';
                            elseif($_GET['action'] == 'warning')
                                echo '<i class="fa-solid fa-user-pen"></i>&nbsp; User record has been updated !';
                        echo '</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div></small></center>';
                        
                    }
                ?>
        <?php
                $sql = "SELECT * FROM users ORDER BY lname ASC;";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
        ?>
        <div class="table-responsive p-3 bg-light-gray mb-3 border border-4 shadow-sm rounded">
            <form action="" method="post">
                <button formaction="signup.php" type="submit" class="btn btn-dark btn-sm"><i class="bi bi-people"></i><small> Add User</small></button>&nbsp;
                <button type="submit" formaction="users.php" class="btn btn-success btn-sm" ><i class="bi bi-arrow-clockwise"></i> <small>Refresh</small></button>
            </form><hr>
        <table id="myDataTable" class="table custom-table table-striped table-hover table-bordered table-sm">
            <thead>
                <tr>
                    <th>No.</th>

                    <th>Last name</th>
                    <th>First name</th>
                    <th>Username</th>
                    <th>User type</th>
                    <th>Email</th>
                    <th>Phone no.</th>
                    <th class="text-center">View</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 0;
                    if($resultCheck > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo '<tr>';
                                echo '<td class="fw-bold">'.++$no.'.</td>';
                                echo '<td>'.$row['lname'].'</td>';
                                echo '<td>'.$row['fname'].'</td>';
                                echo '<td>'.$row['username'].'</td>';
                                echo '<td>'.$row['usertype'].'</td>';
                                echo '<td>'.$row['email'].'</td>';
                                echo '<td>'.$row['phone'].'</td>';
                                echo '<td class="text-center"><a href="users.php?view='.$row['userid'].'" class="btn btn-primary btn-sm rounded"><i class="fa-solid fa-eye"></i></a></td>';
                                echo '<td class="text-center"><a href="signup.php?editUser='.$row['userid'].'" class="btn btn-warning btn-sm rounded"><i class="fa-solid fa-pen-to-square"></i></a></td>';
                                echo '<td class="text-center"><a href="includes/process.php?deleteUser='.$row['userid'].'&deletelname='.strtoupper($row['lname']).'&deleteusrtyp='.ucfirst($row['usertype']).'" class="btn btn-danger btn-sm rounded"><i class="fa-solid fa-trash"></i></a></td>';
                            echo '</tr>';
                        }

                    }
                ?>
            </tbody>
        </table>
        </div>
        <?php
            if(isset($_GET['view'])){
                $iddd = $_GET['view'];
                $sql = "SELECT * FROM users WHERE userid=$iddd;";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                if($resultCheck > 0){
                    while($row = mysqli_fetch_assoc($result)){

                        $k = $row['userid'];
                        $a = $row['lname'];
                        $b = $row['fname'];
                        $c = $row['username'];
                        $h = $row['usertype'];
                        $d = $row['email'];
                        $ph = $row['phone'];
                        
                    }
                }
            echo '<script>
                let str = `<div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><b>Last Name:</b></label>
                                <input type="text" class="form-control" value="${`' . $a . '`}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><b>First Name:</b></label>
                                <input type="text" class="form-control" value="${`' . $b . '`}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><b>Username:</b></label>
                                <input type="text" class="form-control" value="${`' . $c . '`}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><b>User Type:</b></label>
                                <input type="text" class="form-control" value="${`' . $h . '`}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><b>Email:</b></label>
                                <input type="text" class="form-control" value="${`' . $d . '`}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><b>Phone no.:</b></label>
                                <input type="text" class="form-control" value="${`' . $ph . '`}" readonly>
                            </div>
                        </div>
                    </div>
                </div>`;
                Alert.render(str)
            </script>';
            }
        ?>
        </div>
    </div>
    <!--Container Main end-->   
<?php
    require 'footer1.php';
?>