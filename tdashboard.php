<?php
    session_start();
    $_SESSION['actib'] = 'dboard';
    require 'tenantheader.php';

    $surveyid = '';
    $tenant_lname = "";
    $tenant_fname = "";
    $tenantgender = "";
    $stallname = "";
    $stallno1 = "";
    $stallno2 = "";
    $totresponse = '';
    $tid = $_SESSION['tenantId'];
    $qlength = 0;

    $query = "SELECT * FROM tenants WHERE tenantid = '$tid';";
    $resquery = mysqli_query($conn, $query);
    $resqueryCheck = mysqli_num_rows($resquery);
    
    if ($resqueryCheck > 0) {
        while ($row = mysqli_fetch_assoc($resquery)) {
            $tenant_lname = $row['tenant_lname'];
            $tenant_fname = $row['tenant_fname'];
            $gender = $row['tenant_gender'];
            $stallname = $row['stallname'];
            $stallno1 = $row['stallno1'];
            $stallno2 = $row['stallno2'];
        }
    }

    $stallno = $stallno1 . " - " . $stallno2;
    $sql_pending = "SELECT COUNT(concernid) AS tot_pending FROM tconcerns WHERE status='Not process yet' AND tenantid='$tid';";
    $result_pending = mysqli_query($conn, $sql_pending);
    $row_pending = mysqli_fetch_assoc($result_pending);
    $pending_concerns = $row_pending['tot_pending'];

    $sql_addressed = "SELECT COUNT(concernid) AS tot_addressed FROM tconcerns WHERE status='In process' AND tenantid='$tid';";
    $result_addressed = mysqli_query($conn, $sql_addressed);
    $row_addressed = mysqli_fetch_assoc($result_addressed);
    $addressed_concerns = $row_addressed['tot_addressed'];

    $sql_closed = "SELECT COUNT(concernid) AS tot_closed FROM tconcerns WHERE status='closed' AND tenantid='$tid';";
    $result_closed = mysqli_query($conn, $sql_closed);
    $row_closed = mysqli_fetch_assoc($result_closed);
    $closed_concerns = $row_closed['tot_closed'];
?>

<!-- Container Main start -->

<div class="height-100 bg-light-gray main-content">
    <div class="bg-light-gray mb-5 p-3 rounded">
        <h3 class="fw-bold mb-2"><i class='fas fa-tachometer-alt nav_icon'></i>Dashboard</h3><br>
        <div class="p-2 mb-2 bg-light-gray border-4 shadow-sm rounded">
            <div class="row g-3 my-2 justify-content-center bg-light-gray rounded">
                <div class="col-md-3">
                    <div class="row justify-content-center">
                        <div class="col-md-11 mt-4">
                            <p class="fs-6 text-end">Welcome <?php echo $tenant_lname . ', ' . $tenant_fname . '!'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-md-3">
                    <div class="row justify-content-center">
                        <a href="tconcerns.php?status=pending">
                            <div class="p-3 bg-primary shadow-sm p-3 mb-3 d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <p class="fs-5 text-white">Not process yet complaints</p>
                                    <h3 class="fs-2 text-white"><?php echo $pending_concerns; ?></h3>
                                </div>
                                <i class="fa-solid fa-newspaper fs-1 text-white rounded p-3"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row justify-content-center">
                        <a href="tconcerns.php?status=addressed">
                            <div class="p-3 bg-success shadow-sm p-3 mb-3 d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <p class="fs-5 text-white">Pending Complaints</p>
                                    <h3 class="fs-2 text-white"><?php echo $addressed_concerns; ?></h3>
                                </div>
                                <i class="fa-solid fa-newspaper fs-1 text-white rounded p-3"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row justify-content-center">
                        <a href="tconcerns.php?status=closed">
                            <div class="p-3 bg-dark shadow-sm p-3 mb-3 d-flex justify-content-around align-items-center rounded">
                                <div>
                                    <p class="fs-5 text-white">Closed Complaints</p>
                                    <h3 class="fs-2 text-white"><?php echo $closed_concerns; ?></h3>
                                </div>
                                <i class="fa-solid fa-newspaper fs-1 text-white rounded p-3"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>