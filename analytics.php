<?php
session_start();
$_SESSION['actib'] = 'stats';
require 'headerr.php';

// Initialize default values
$curr_month = date("m");
$curr_year = date("Y");
$dateYear = $curr_year . '-' . date("m");
$_SESSION['taon'] = $curr_year;
$curr_days = cal_days_in_month(CAL_GREGORIAN, date("m"), $curr_year);
$expectedCollection = 0;
$receivedCollection = 0;
$remaining = 0;


$_SESSION['taonbuwan'] = $dateYear;

// Handle search by date
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


// Handle search by year
if (isset($_POST['searchYear'])) {
    $taon = $_POST['Year'];
    $_SESSION['taon'] = $taon;
}



// Query to retrieve payment data
$sql = "SELECT rental_tbl.stallname, rental_tbl.marketfee, payments_tbl.amount
        FROM payments_tbl
        INNER JOIN rental_tbl ON payments_tbl.stall_id = rental_tbl.rentalid
        INNER JOIN tenants ON rental_tbl.renterid = tenants.tenantid
        WHERE MONTH(payments_tbl.paymentdate) = $curr_month AND YEAR(payments_tbl.paymentdate) = $curr_year
        ORDER BY payments_tbl.timestamp DESC;";
$result = mysqli_query($conn, $sql);
$resCheck = mysqli_num_rows($result);
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
        .bord {
            border-top: 2px solid #c33a08;
        }
    </style>

    <div class="bg-light-gray mb-5 p-3 rounded">

        <div class="row justify-content-around p-2 bg-light bordd border-4 shadow-sm rounded">
            <div class="col-md-5 g-5 my-2 bg-light shadow-sm rounded">
                <br>
                <h4 class="text-center"><i class="fa-solid fa-coins"></i> Collected Payment</h4>
                <h6 class="text-center">
                    <?php
                    $dateObj = DateTime::createFromFormat('!m', $curr_month);
                    $monthName = $dateObj->format('F');
                    echo $monthName . ', ' . $curr_year;
                    ?>
                </h6>
                <form action="" method="post">
                    <div class="col-md-3 input-group mb-3">
                        <input type="month" class="form-control form-control-sm" name="dateYear" aria-label="Example text with button addon" aria-describedby="button-addon1" value="<?php echo $dateYear; ?>">
                        <button class="btn btn-info btn-sm text-white" name="searchDate" type="submit" id="button-addon1"><small><i class="fa-solid fa-magnifying-glass"></i> Find</small></button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-striped table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Stallname</th>
                                <th>Total Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($resCheck > 0) {
                                $paymentsByStall = []; // Create an array to store payments by stallname
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $stallname = $row['stallname'];
                                    $amount = $row['amount'];

                                    // Check if the stallname exists in the array, if not, initialize it
                                    if (!isset($paymentsByStall[$stallname])) {
                                        $paymentsByStall[$stallname] = 0;
                                    }

                                    // Add the current payment amount to the stall's total
                                    $paymentsByStall[$stallname] += $amount;
                                }

                                // Loop through the grouped payments and display them
                                foreach ($paymentsByStall as $stallname => $totalPayment) {
                                    echo '<tr>';
                                    echo '<td>' . $stallname . '</td>';
                                    echo '<td>₱' . number_format($totalPayment) . '</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                // Calculate and display expected and received collections for each stall
                $query = "SELECT
                    rental_tbl.stallname,
                    rental_tbl.marketfee,
                    rental_tbl.rent_started,
                    COALESCE(SUM(payments_tbl.amount), 0) AS receivedCollection
                FROM rental_tbl
                LEFT JOIN payments_tbl ON rental_tbl.rentalid = payments_tbl.stall_id
                WHERE rental_tbl.status = 'Occupied'
                GROUP BY rental_tbl.stallname, rental_tbl.marketfee, rental_tbl.rent_started
                ORDER BY rental_tbl.stallname ASC;";

                $result = mysqli_query($conn, $query);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $stallname = $row['stallname'];
                        $marketfee = $row['marketfee'];
                        $receivedCollection = $row['receivedCollection'];
                        $rentStarted = strtotime($row['rent_started']);
                        $currentDate = strtotime(date('Y-m-d'));

                        // Calculate the number of months since the rent started
                        $monthsSinceStart = floor(($currentDate - $rentStarted) / (30 * 24 * 60 * 60)); // Assuming 30 days per month

                        // Calculate expected collection based on the month
                        if ($monthsSinceStart == 0) {
                            // First month of rent, expected collection is zero
                            $expectedCollection = 0;
                        } else {
                            // Subsequent months, use the market fee
                            $expectedCollection = $marketfee;
                        }

                        $receivedCollectionFormatted = number_format($receivedCollection, 2);
                        $expectedCollectionFormatted = number_format($expectedCollection, 2);
                        $remainingCollection = $expectedCollection - $receivedCollection;
                        $remainingCollectionFormatted = number_format($remainingCollection, 2);

                        echo '<small>';
                        echo '<p class="fw-bold">Stall: ' . $stallname . '</p>';
                        echo '<p class="fw-bold">Expected Collection: <span class="bg-primary text-white rounded">&nbsp;&nbsp; ₱ ' . $expectedCollectionFormatted . ' &nbsp;&nbsp;</span> </p>';
                        echo '<p class="fw-bold">Received Collection: <span class="bg-warning text-black rounded">&nbsp;&nbsp; ₱ ' . $receivedCollectionFormatted . ' &nbsp;&nbsp;</span> </p>';
                        echo '<p class="fw-bold">Remaining: <span class="bg-danger text-white rounded">&nbsp;&nbsp; ₱ ' . $remainingCollectionFormatted . ' &nbsp;&nbsp;</span> </p>';
                        echo '</small>';
                        echo '<hr>';
                    }
                }
                ?>


            </div>
            <div class="col-md-6 g-5 my-2 bg-light shadow-sm rounded">
                <br>
                <h4 class="text-center"><i class="fa-solid fa-coins"></i> Monthly Collection</h4>
                <hr>
                <form action="" method="post">
                    <div class="col-md-3 input-group mb-3">
                        <input type="number" class="form-control form-control-sm" name="Year" aria-label="Example text with button addon" aria-describedby="button-addon1" min="1900" max="<?php echo $curr_year; ?>" Placeholder="Enteryear here..." value="<?php echo $taon; ?>">
                        <button class="btn btn-info btn-sm text-white" name="searchYear" type="submit" id="button-addon1"><small><i class="fa-solid fa-magnifying-glass"></i> Find</small></button>
                    </div>
                </form>

                <div class="card">
                    <div class="class-card">
                        <canvas id="statsChart"></canvas>
                    </div>
                </div>
                <hr>
            </div>
            <hr>
        </div>
    <div class="row g-3 my-2 justify-content-around">
        <div class="col-md-12 g-5 my-2 py-3 bg-light borddd border-4 shadow-sm rounded"><br>
            <h4 class="text-start"><i class="fa-regular fa-clipboard"></i> Summary of Yearly Collection</h4>
            <hr>
            <?php
            $jan = 0;
            $feb = 0;
            $mar = 0;
            $apr = 0;
            $may = 0;
            $jun = 0;
            $jul = 0;
            $aug = 0;
            $sept = 0;
            $oct = 0;
            $nov = 0;
            $dec = 0;
            $totalEarnings = 0;


            $query = "SELECT DISTINCT(YEAR(paymentdate)) as years FROM payments_tbl;";
            $resquery = mysqli_query($conn, $query);
            $resqueryCheck = mysqli_num_rows($resquery);

            if ($resqueryCheck > 0) {
                while ($row = mysqli_fetch_assoc($resquery)) {
                    $years = $row['years'];
                    $query1 = "SELECT DISTINCT(MONTH(paymentdate)) as months FROM payments_tbl WHERE YEAR(paymentdate) = $years ORDER BY MONTH(paymentdate) ASC";
                    $resquery1 = mysqli_query($conn, $query1);
                    $resqueryCheck1 =  mysqli_num_rows($resquery1);

                    if ($resqueryCheck1 > 0) {
                        while ($row1 = mysqli_fetch_assoc($resquery1)) {
                            $months = $row1['months'];

                            $sql2 = "SELECT SUM(amount) as tototal FROM payments_tbl WHERE YEAR(paymentdate) = $years AND MONTH(paymentdate) = $months ORDER BY MONTH(paymentdate) ASC";
                            $result2 = mysqli_query($conn, $sql2);
                            $resCheck2 = mysqli_num_rows($result2);

                            if ($resCheck2 > 0) {

                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                    if ($months == 1) {
                                        $jan = $row2['tototal'];
                                    } elseif ($months == 2) {
                                        $feb = $row2['tototal'];
                                    } elseif ($months == 3) {
                                        $mar = $row2['tototal'];
                                    } elseif ($months == 4) {
                                        $apr = $row2['tototal'];
                                    } elseif ($months == 5) {
                                        $may = $row2['tototal'];
                                    } elseif ($months == 6) {
                                        $jun = $row2['tototal'];
                                    } elseif ($months == 7) {
                                        $jul = $row2['tototal'];
                                    } elseif ($months == 8) {
                                        $aug = $row2['tototal'];
                                    } elseif ($months == 9) {
                                        $sept = $row2['tototal'];
                                    } elseif ($months == 10) {
                                        $oct = $row2['tototal'];
                                    } elseif ($months == 11) {
                                        $nov = $row2['tototal'];
                                    } elseif ($months == 12) {
                                        $dec = $row2['tototal'];
                                    }
                                    $totalEarnings += $row2['tototal'];
                                }
                            }
                        }
                    }
                    $query2 = "SELECT reportyear FROM collectionreport_tbl WHERE reportyear = $years";
                    $resquery2 = mysqli_query($conn, $query2);
                    $resqueryCheck2 = mysqli_num_rows($resquery2);

                    if ($resqueryCheck2 > 0) {
                        $sikwel = "UPDATE collectionreport_tbl SET jan = $jan, feb = $feb, mar = $mar, apr = $apr, may = $may, jun = $jun, jul = $jul, aug = $aug, sept = $sept, oct = $oct, nov = $nov, dece = $dec, total = $totalEarnings
                                        WHERE reportyear = $years;";
                        $ressikwel =  mysqli_query($conn, $sikwel);
                    } else {
                        $sikwel1 = "INSERT INTO collectionreport_tbl (reportyear, jan, feb, mar, apr, may, jun, jul, aug, sept, oct, nov, dece, total) 
                                        VALUES('$years', '$jan', '$feb', '$mar', '$apr', '$may', '$jun', '$jul', '$aug', '$sept', '$oct', '$nov', '$dec', $totalEarnings);";
                        $ressikwel1 = mysqli_query($conn, $sikwel1);
                        echo mysqli_error($conn);
                    }
                    $totalEarnings = 0;
                }
            }
            ?>
            <div class="table-responsive">
                <table id="myDataTable" class="table custom-table table-hover table-bordered table-striped table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Year</th>
                            <th>Jan</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Apr</th>
                            <th>May</th>
                            <th>Jun</th>
                            <th>Jul</th>
                            <th>Aug</th>
                            <th>Sept</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th>Dec</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM collectionreport_tbl ORDER BY reportyear DESC;";
                        $res = mysqli_query($conn, $sql);
                        $resCheck = mysqli_num_rows($res);

                        if ($resCheck > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                echo '<tr>';
                                echo '<td>' . $row['reportyear'] . '</td>';
                                echo '<td>₱' . number_format($row['jan']) . '</td>';
                                echo '<td>₱' . number_format($row['feb'], 2) . '</td>';
                                echo '<td>₱' . number_format($row['mar'], 2) . '</td>';
                                echo '<td>₱' . number_format($row['apr'], 2) . '</td>';
                                echo '<td>₱' . number_format($row['may'], 2) . '</td>';
                                echo '<td>₱' . number_format($row['jun'], 2) . '</td>';
                                echo '<td>₱' . number_format($row['jul'], 2) . '</td>';
                                echo '<td>₱' . number_format($row['aug'], 2) . '</td>';
                                echo '<td>₱' . number_format($row['sept'], 2) . '</td>';
                                echo '<td>₱' . number_format($row['oct'], 2) . '</td>';
                                echo '<td>₱' . number_format($row['nov'], 2) . '</td>';
                                echo '<td>₱' . number_format($row['dece'], 2) . '</td>';
                                echo '<td>₱' . number_format($row['total'], 2) . '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <hr>
            </div>

    </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!--Container Main end-->

<?php
require 'footer1.php';
?>
