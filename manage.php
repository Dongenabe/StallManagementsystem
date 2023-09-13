<?php
    session_start();
    $_SESSION['actib'] = 'mngmnt';
    require 'headerr.php';
    $collection=0;
    $tenants=0;
    $inquiry=0;
    $user=0;
    $concerns = 0;
    $curr_month = date("F");
    $curr_year = date("Y");

    $sql = "SELECT COUNT(rentalid) AS tot FROM rental_tbl;";
    $result = mysqli_query($conn, $sql);
    $check = mysqli_num_rows($result);
    if($check > 0){
        while($row = mysqli_fetch_assoc($result)){
            $stalls = $row['tot'];
        }
    }
    $sql = "SELECT COUNT(userid) AS tot FROM users;";
    $result = mysqli_query($conn, $sql);
    $check = mysqli_num_rows($result);
    if($check > 0){
        while($row = mysqli_fetch_assoc($result)){
            $user = $row['tot'];
        }
    }
    $sql = "SELECT SUM(amount) AS totalCollection FROM payments_tbl WHERE MONTHNAME(paymentdate) = '$curr_month' AND YEAR(paymentdate) = '$curr_year';";
    $result = mysqli_query($conn, $sql);
    $check = mysqli_num_rows($result);
    if($check > 0){
        while($row = mysqli_fetch_assoc($result)){
            $collection = $row['totalCollection'];
        }
    }

    $sql = "SELECT COUNT(req_id) AS tot FROM request_tbl WHERE status='unread';";
    $result = mysqli_query($conn, $sql);
    $check = mysqli_num_rows($result);
    if($check > 0){
        while($row = mysqli_fetch_assoc($result)){
            $inquiry = $row['tot'];
        }
    }
    $sql = "SELECT COUNT(concernid) AS tot FROM tconcerns WHERE status='pending';";
    $result = mysqli_query($conn, $sql);
    $check = mysqli_num_rows($result);
    if($check > 0){
        while($row = mysqli_fetch_assoc($result)){
            $concern = $row['tot'];
        }
    }

?>
<!-- Main content -->
<div class="height-100 bg-light-gray main-content">
    <div class="bg-light-gray mb-5 p-3 rounded">
        <h3 class="fw-bold mb-2"><i class='fas fa-tachometer-alt nav_icon'></i> Dashboard</h3><br>
        <div class="p-2 mb-2 bg-light-gray border-4 shadow-sm rounded">
            <div class="row g-3 my-2 justify-content-center bg-light-gray rounded">
                <div class="col-md-2">
                    <a href="rental.php">
                        <div class="p-3 bg-primary shadow-sm p-2 mb-3 d-flex align-items-center rounded">
                            <i class="fa-solid fa-store fs-4 text-white rounded mr-2"></i>
                            <div class="text-center">
                                <p class="fs-5 text-white">Stalls</p>
                                <h3 class="fs-3 text-white"><?php echo $stalls; ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2">
                    <a href="payments.php">
                        <div class="p-3 bg-primary shadow-sm p-2 mb-3 d-flex align-items-center rounded">
                            <i class="fa-solid fa-hand-holding-dollar fs-4 text-white rounded mr-2"></i>
                            <div class="text-center">
                                <p class="fs-5 text-white">Collection</p>
                                <h3 class="fs-3 text-white"><i class="fa-solid fa-peso-sign"></i> <?php echo number_format($collection, 2); ?></h3>
                                <p class="fs-6 text-white"><?php echo date("F Y") ?></p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2">
                    <a href="request.php">
                        <div class="p-3 bg-success shadow-sm p-2 mb-3 d-flex align-items-center rounded">
                            <i class="fa-solid fa-circle-info fs-4 text-white rounded mr-2"></i>
                            <div class="text-center">
                                <p class="fs-5 text-white">Inquiries</p>
                                <h3 class="fs-3 text-white"><?php echo $inquiry; ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2">
                    <a href="tconcerns.php">
                        <div class="p-3 bg-success shadow-sm p-2 mb-3 d-flex align-items-center rounded">
                            <i class="fa-solid fa-circle-info fs-4 text-white rounded mr-2"></i>
                            <div class="text-center">
                                <p class="fs-5 text-white">Pending Concerns</p>
                                <h3 class="fs-3 text-white"><?php echo $concern; ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2">
                    <a href="users.php">
                        <div class="p-3 bg-dark shadow-sm p-2 mb-3 d-flex align-items-center rounded">
                            <i class="fa-sharp fa-solid fa-users fs-4 text-white rounded mr-2"></i>
                            <div class="text-center">
                                <p class="fs-5 text-white">Users</p>
                                <h3 class="fs-3 text-white"><?php echo $user; ?></h3>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<div class="px-4 p-2 bg-light rounded">
                <div class="row justify-content-around rounded">
                    <div class="col-md-7 g-5 my-2 bg-light bordd border-4 shadow-sm rounded">
                    <h4 class="my-3 fw-bold"><i class='fa-solid fa-store'></i> Available Stalls</h4>
                    <hr class="dropdown-divider"></li>
                        <div class="card px-5 my-2">
                            <div class="class-card">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 g-5 my-2 rounded">
                        <div class="table-responsive px-3 my-3 bg-light borddd border-4 shadow-sm rounded">
                        <h4 class="my-3 fw-bold"><i class='fa-solid fa-store'></i> Cluster/Section</h4>
                        <hr class="dropdown-divider"></li>
                            <table id="myDataTable" class="table table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Cluster/Section</th>
                                        <th>Available Stalls</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $no = 0;
                                        $sikwel = "SELECT DISTINCT(stallname) AS cluster_distinct FROM rental_tbl ORDER BY stallname ASC;";
                                        $results = mysqli_query($conn, $sikwel);
                                        $resultsCheck = mysqli_num_rows($results);

                                        if($resultsCheck > 0){
                                            while($rows = mysqli_fetch_assoc($results)){
                                                
                                                $distinctCluster = $rows['cluster_distinct'];
                                                
                                                $sikwel1 = "SELECT COUNT(stallname) AS countCluster FROM rental_tbl WHERE stallname='$distinctCluster' AND status='Available';";
                                                $results1 = mysqli_query($conn, $sikwel1);
                                                $resultsCheck1 = mysqli_num_rows($results1);

                                                if($resultsCheck1 > 0){
                                                    while($rows1 = mysqli_fetch_assoc($results1)){
                                                        echo '<tr>';
                                                            echo '<td class="fw-bold">'.++$no.'.</td>';
                                                            echo '<td>'.$distinctCluster.'</td>';
                                                            echo '<td>'.$rows1['countCluster'].'</td>';
                                                        echo '</tr>';                    
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

        </div><br><br>
    </div>
    </div>
<?php
    require 'footer1.php';
?>
    <!--Container Main end-->   
