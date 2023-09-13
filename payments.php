<?php
    session_start();
    $_SESSION['actib'] = 'payment';
    require 'headerr.php';
    $curr_month = date("m");
    $curr_year = date("Y");
    $dateYear = $curr_year.'-'.date("m");
    $_SESSION['taon'] = $curr_year;

    $curr_days = cal_days_in_month(CAL_GREGORIAN, date("m"), $curr_year);
    $expectedCollection = 0;
    $receivedCollection = 0;
    $remaining = 0;



    $_SESSION['taonbuwan'] = $dateYear;
if (isset($_POST['searchDate'])) {
    if (!empty($_POST['dateYear'])) {
        $yearDate = explode('-', $_POST['dateYear']);

        $curr_month = $yearDate[1];
        $curr_year = $yearDate[0];
        $dateYear = $_POST['dateYear'];

        $curr_days = cal_days_in_month(CAL_GREGORIAN, $yearDate[1], $yearDate[0]);
        $expectedCollection = 0;
        $receivedCollection = 0;
        $remaining = 0;
    }
}
if (isset($_POST['searchYear'])) {
    $taon = $_POST['Year'];
    $_SESSION['taon'] = $taon;
}


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
    <div class="height-100 bg-light main-content">
    <style>
            .bord{
                border-top: 2px solid #ff00ff;
            }
        </style>

    <div class="bg-light mb-5 p-3 rounded">

        <h3 class="fw-bold"><i class='fa-solid fa-cash-register'></i> Payments</h3><br>
                <?php
                    if(isset($_GET['action'])){
                        echo '<center><small><div class="text-start alert alert-'.$_GET['action'].' alert-dismissible fade show" role="alert">
                            <strong>';
                            if($_GET['action'] == 'danger')
                                echo '<i class="fa-solid fa-user-xmark"></i>&nbsp; '.$_GET['lname'].'\'s payment has been deleted !';
                            elseif($_GET['action'] == 'warning')
                                echo '<i class="fa-solid fa-user-pen"></i>&nbsp; Payment record of '.$_GET['lname'].' has been updated !';
                            elseif($_GET['action'] == 'success')
                                echo '<i class="bi bi-check-circle-fill"></i>&nbsp; Payment for '.$_GET['lname'].' has been added !';
                        echo '</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div></small></center>';
                        
                    }
                ?>        
        <?php
        $sql = "SELECT payments_tbl.paymentid, payments_tbl.ornumber, payments_tbl.paymentdate, payments_tbl.paymenttime, 
                rental_tbl.stallname, rental_tbl.stallno, rental_tbl.renterid, payments_tbl.amount, tenants.tenant_lname
                FROM payments_tbl
                INNER JOIN rental_tbl ON payments_tbl.stall_id = rental_tbl.rentalid
                INNER JOIN tenants ON rental_tbl.renterid = tenants.tenantid
                ORDER BY payments_tbl.timestamp DESC;";

        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        ?>

        <div class="table-responsive p-3 bg-light mb-3 bord border-4 shadow-sm rounded">
            <form action="" method="post">
                <button formaction="tenants.php" type="submit" class="btn btn-dark btn-sm"><i class='fa-solid fa-cash-register'></i>&nbsp;Add payment</button>&nbsp;
                <button type="submit" formaction="payment.php" class="btn btn-success btn-sm" ><i class="fa-solid fa-arrow-rotate-right"></i><small> Refresh</small></button>
            </form><hr>
            <table id="myDataTable" class="table custom-table table-hover table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>O.R. number</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Tenant Name</th>
                        <th>Stallname</th>
                        <th>Stall no.</th>
                        <th>Amount paid</th>
                        <th><small>View</small></th>
                        <th><small>Edit</small></th>
                        <th><small>Delete</small></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    if ($resultCheck > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td class="fw-bold">' . ++$no . '.</td>';
                            echo '<td>' . $row['ornumber'] . '</td>';
                            echo '<td>' . $row['paymentdate'] . '</td>';
                            echo '<td>' . $row['paymenttime'] . '</td>';
                            echo '<td>' . $row['tenant_lname'] . '</td>';
                            echo '<td>' . $row['stallname'] . '</td>';
                            echo '<td>' . $row['stallno'] . '</td>';
                            echo '<td>₱ ' . number_format($row['amount']) . '</td>';

                            echo '<td class="text-center"><a href="payment.php?view=' . $row['paymentid'] . '" class="btn btn-primary btn-sm rounded"><i class="fa-solid fa-eye"></i></a></td>';
                            echo '<td class="text-center"><a href="paymentForm.php?editPayment=' . $row['paymentid'] . '" class="btn btn-warning btn-sm rounded"><i class="fa-solid fa-pen-to-square"></i></a></td>';
                            echo '<td class="text-center"><a href="includes/process.php?deletePayment=' . $row['paymentid'] . '" class="btn btn-danger btn-sm rounded"><i class="fa-solid fa-trash"></i></a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
                <div class="row g-3 my-2 justify-content-around" id="unpaid">
                    <div class="col-md-12 g-5 my-2 py-3 bg-light bordddd border-4 shadow-sm rounded"><br>
                        <?php
                            $currentmonth1 = date("m");
                            $currentyear1 = date("Y");
                            $curr_dayss1 = cal_days_in_month(CAL_GREGORIAN,date("m"),$currentyear1);
                            $dateYearStatus = $currentyear1.'-'.date("m");

                            $expectedCollection2 = 0;
                            $paidAmount = 0;

                        
                            if(isset($_POST['searchDateStatus'])){
                                if(empty($_POST['dateYearStatus'])){
                                    
                                }else{
                                    $yearDate = explode('-',$_POST['dateYearStatus']);
                        
                                    $currentmonth1 = $yearDate[1];
                                    $currentyear1 = $yearDate[0];
                                    $dateYearStatus = $_POST['dateYearStatus'];
                        
                                    $curr_dayss1 = cal_days_in_month(CAL_GREGORIAN,$yearDate[1],$yearDate[0]);
                                    $expectedCollection2 = 0;
                                    $paidAmount = 0;
                                }
                            }elseif(isset($_GET['yeardate'])){
                                $yearDate = explode('-',$_GET['yeardate']);
                    
                                $currentmonth1 = $yearDate[1];
                                $currentyear1 = $yearDate[0];
                                $dateYearStatus = $_GET['yeardate'];

                                $curr_dayss1 = cal_days_in_month(CAL_GREGORIAN,$yearDate[1],$yearDate[0]);
                                $expectedCollection2 = 0;
                                $paidAmount = 0;
                            }
                        ?>
                    <h4 class="text-start"><i class='fa-solid fa-cash-register'></i> Payment Status <span class="fs-6">(<?php $dateObj = DateTime::createFromFormat('!m', $currentmonth1);
                        $monthName = $dateObj->format('F');
                        echo $monthName . ', ' . $currentyear1; ?>)</span></h4>
                    <hr>

                    <div id="calendar"></div>
                    <hr>
            <div id="calendar"></div>
        <div class="table-responsive">
            <table id="myDataTable" class="table custom-table table-hover table-bordered table-striped table-sm">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Tenant name</th>
                        <th>Market fee</th>
                        <th>Unpaid Amount</th> <!-- Corrected column order -->
                        <th>Paid Amount</th> <!-- Corrected column order -->
                        <th>Status</th>
                        <th>Add payment</th>
                        <th><small>View</small></th>
                        <th><small>Edit</small></th>
                        <th><small>Delete</small></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    $currentMonth = date("m"); 
                    $curr_dayss1 = cal_days_in_month(CAL_GREGORIAN, date("m"), $currentyear1);
// Calculate the current year and month
$currentmonth1 = date("m");
$currentyear1 = date("Y");

// Retrieve the rent_started date for each tenant
$query = "SELECT
    tenants.tenantid,
    tenants.tenant_lname,
    rental_tbl.marketfee,
    rental_tbl.rent_started,
    COALESCE(SUM(payments_tbl.amount), 0) AS totalPaidAmount
FROM tenants
INNER JOIN rental_tbl ON tenants.tenantid = rental_tbl.renterid
LEFT JOIN payments_tbl ON rental_tbl.rentalid = payments_tbl.stall_id
GROUP BY tenants.tenantid, tenants.tenant_lname, rental_tbl.marketfee, rental_tbl.rent_started
ORDER BY tenants.tenant_lname ASC;";

$resquery = mysqli_query($conn, $query);
$resqueryCheck = mysqli_num_rows($resquery);
echo mysqli_error($conn);

if ($resqueryCheck > 0) {
    while ($row = mysqli_fetch_assoc($resquery)) {
        echo '<tr>';
        echo '<td class="fw-bold">' . ++$no . '.</td>';
        echo '<td>' . $row['tenant_lname'] . '</td>';
        echo '<td>₱ ' . number_format($row['marketfee']) . '</td>';
        
        // Calculate the number of months between rent_started and the current date
        $rentStartedDate = new DateTime($row['rent_started']);
        $currentDate = new DateTime();
        $monthsDiff = $rentStartedDate->diff($currentDate)->m + ($rentStartedDate->diff($currentDate)->y * 12);
        
        // Calculate unpaid amount based on monthsDiff
        $unpaidAmount = $monthsDiff > 0 ? $row['marketfee'] : 0;
        
        // Check if payments have been made for this tenant
        $totalPaidAmount = $row['totalPaidAmount'];
        
        // If payments have been made, deduct the paid amount from the unpaid amount
        if ($totalPaidAmount > 0) {
            $unpaidAmount = max(0, $unpaidAmount - $totalPaidAmount);
        }

        // Display the "Unpaid Amount" in the "Unpaid Amount" column
        echo '<td>₱ ' . number_format(max(0, $unpaidAmount)) . '</td>'; 
        
        // Display the "Paid Amount" in the "Paid Amount" column
        echo '<td>₱ ' . number_format($totalPaidAmount) . '</td>'; 
        
        // Check payment status
        echo '<td class="fw-bold">';
        if ($unpaidAmount <= 0) {
            echo '<small><span class="bg-success text-white rounded"> &nbsp; Paid &nbsp; </span></small>';
            echo '<td class="text-center"><button type="button" class="btn btn-primary btn-sm" disabled><small>Add Payment</small></button></td>';
        } else {
            echo '<small><span class="bg-danger text-white rounded"> &nbsp; Unpaid &nbsp; </span></small>';
            echo '<td class="text-center"><a href="paymentForm.php?addPay='.$row['tenantid'].'" class="btn btn-primary btn-sm"><small>Add Payment</small></a></td>';
        }
        echo '</td>';
                            echo '<td class="text-center"><a href="payment.php?view=' . $row['tenantid'] . '" class="btn btn-primary btn-sm rounded"><i class="fa-solid fa-eye"></i></a></td>';
                            echo '<td class="text-center"><a href="paymentForm.php?editPayment=' . $row['tenantid'] . '" class="btn btn-warning btn-sm rounded"><i class="fa-solid fa-pen-to-square"></i></a></td>';
                            echo '<td class="text-center"><a href="includes/process.php?deletePayment=' . $row['tenantid'] . '" class="btn btn-danger btn-sm rounded"><i class="fa-solid fa-trash"></i></a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>



                    </div>
                    </div>
                </div>
        </div>
        <?php
            if(isset($_GET['view'])){
                $iddd = $_GET['view'];
                $sql = "SELECT * FROM payment_tbl WHERE paymentid=$iddd;";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                if($resultCheck > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        $a = $row['ornumber'];
                        $b = $row['paymentdate'];
                        $c = $row['paymenttime'];
                        $d = $row['holder'];
                        $e = $row['cluster'];
                        $f = $row['clusterno1'];
                        $g = $row['clusterno2'];
                        $h = $row['marketfee'];
                        $i = $row['electricity'];
                        $j = $row['water'];
                        $k = $row['garbage'];
                        $l = $row['other'];
                        $m =  $row['total'];
                    }
                }
                echo '<script>
                    let str = `<br>O.R. number:&nbsp;&nbsp;&nbsp;&nbsp; '.$a.'<br>Payment Date:&nbsp;&nbsp;&nbsp;&nbsp; '.$b.'<br>Payment Time:&nbsp;&nbsp;&nbsp;&nbsp; '.$c.'<br>
                    Holder Name:&nbsp;&nbsp;&nbsp;&nbsp; '.$d.'<br>Cluster/Section:&nbsp;&nbsp;&nbsp;&nbsp; '.$e.'<br>Stall No.:&nbsp;&nbsp;&nbsp;&nbsp; '.$f.'-'.$g.'
                    <br>Market Fee:&nbsp;&nbsp;&nbsp;&nbsp;₱ '.$h.'<br>Electricity:&nbsp;&nbsp;&nbsp;&nbsp;₱ '.$i.'<br>Water:&nbsp;&nbsp;&nbsp;&nbsp;₱ '.$j.'
                    <br>Garbage:&nbsp;&nbsp;&nbsp;&nbsp;₱ '.$k.'<br>Other Fee:&nbsp;&nbsp;&nbsp;&nbsp;₱ '.$l.'<br>Total:&nbsp;&nbsp;&nbsp;&nbsp;₱ '.$m.'<br>`
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