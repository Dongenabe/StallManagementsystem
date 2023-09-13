<?php
session_start();
$_SESSION['actib'] = 'concerns';
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
        .bord {
            border-top: 2px solid #c33a08;
        }
    </style>
        <nav class="navbar navbar-expand-lg navbar-light bg-light rounded shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ulu">
                        <li class="nav-item">
                            <a class="nav-link  fs-6" aria-current="page" href="tconcerns.php">Not Process yet complaints</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active  fs-6" aria-current="page" href="tconcernsadd.php"><strong><i class="bi bi-card-checklist"></i></strong> Pending complaints</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  fs-6" aria-current="page" href="tconcernsclosed.php"><i class='bx bx-bar-chart-alt-2'></i> Closed complaints</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <style>
.navbar-nav .nav-link.active::before {
                content: none;
            }
            nav .ulu{
                margin:auto;
            }
            nav .ulu li{
                margin-right:50px;
            }
            nav .ulu .active, li:hover{
                background-color: #DD4124;
                color: white !important;
                border-radius:4px;
            }
            .bord{
                border-top: 2px solid #FFBF00;
            }
            .col-ques{
                margin: auto;
            }
            .col-ques-img{
                margin: auto;
            }

        </style>
    <div class="bg-light-gray mb-5 p-3 rounded">
        <h3 class="fw-bold">Concerns of tenants</h3><br>
        <div class="row justify-content-around mb-3 p-2 bg-light bordddd border-4 shadow-sm rounded">
            <h5 class="text-start mt-4"><i class="fa-solid fa-face-grin-stars"></i>Tenants Concern</h5>
            <hr>
            <?php
            if(isset($_GET['action']) && isset($_GET['message'])){
                echo '<center><small><div class="text-start alert alert-'.$_GET['action'].' alert-dismissible fade show" role="alert">
                    <strong>';
                echo '<i class="fa-solid fa-user-pen"></i>&nbsp; ' . $_GET['message'];
                echo '</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div></small></center>';
            }
            ?>
            <?php
            $sql = "SELECT * FROM tconcerns WHERE status = 'In process' ORDER BY date_time_created DESC;";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            ?>
            <div class="table-responsive p-3 bg-light mb-3 rounded">
                <table id="myDataTable" class="table custom-table table-hover table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Status</th>
                            <th>Tenant name</th>
                            <th>Stall/Section</th>
                            <th>Date created</th>
                            <th class="text-center">View</th>
                            <th><small>Delete</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nn = "NONE";
                        $no = 0;
                        if ($resultCheck > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td class="fw-bold">' . ++$no . '.</td>';
                                if ($row['status'] == 'Not process yet') {
                                    echo '<td class="text-center"><p class="bg-danger text-white rounded"><small>' . $row['status'] . '</small></p></td>';
                                } elseif ($row['status'] == 'In process') {
                                    echo '<td class="text-center"><p class="bg-warning text-white rounded"><small>' . $row['status'] . '</small></p></td>';
                                } elseif ($row['status'] == 'closed') {
                                    echo '<td class="text-center"><p class="bg-warning text-white rounded"><small>' . $row['status'] . '</small></p></td>';
                                }
                                echo '<td>' . $row['tenantname'] . '</td>';
                                echo '<td>' . strtoupper($row['stallname']) . '</td>';
                                echo '<td>' . $row['date_time_created'] . '</td>';
                                echo '<td class="text-center"><a href="tconcernsadd.php?view=' . $row['concernid'] . '" class="btn btn-primary btn-sm rounded"><i class="fa-solid fa-eye"></i></a></td>';
                                echo '<td class="text-center"><a href="includes/process.php?deleteConcerns='.$row['concernid'].'&deleteconcernsname='.$row['tenantname'].'" class="btn btn-danger btn-sm rounded"><i class="fa-solid fa-trash"></i></a></td>';
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
<?php
if (isset($_GET['view'])) {
    $iddd = $_GET['view'];
    $sql = "SELECT * FROM tconcerns WHERE concernid=$iddd;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $p = $row['tenantname'];
            $k = $row['tenantgender'];
            $a = $row['stallname'];
            $b = $row['stallno'];
            $t = $row['concern_type'];
            $c = $row['concerns'];
            $h = $row['date_time_created'];
        }
    }
    echo '<script>
    let str = `<div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"><b>Name:</b></label>
                    <input type="text" class="form-control" value="' . $p . '" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Gender:</b></label>
                    <input type="text" class="form-control" value="' . $k . '" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Stall name:</b></label>
                    <input type="text" class="form-control" value="' . $a . '" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label"><b>Stall No.:</b></label>
                    <input type="text" class="form-control" value="' . $b . '" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>Date created:</b></label>
                    <input type="text" class="form-control" value="' . $h . '" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="mb-3">
                    <h5>Tenant\'s Concern type</h5>
                    <input type="text" class="form-control" value="' . $t . '" readonly>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <div class="mb-3">
                    <h5>Tenant\'s Concern Message</h5>
                    <input type="text" class="form-control" value="' . $c . '" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <form method="POST" action="">
                    <input type="hidden" name="concern_id" value="' . $iddd . '">
                    <select name="status" class="form-select form-select-sm">
                        <option value="addressed">Pending Complaint</option>
                        <option value="closed">Closed Complaint</option>
                    </select>
                    <button type="submit" name="actionadd" class="btn btn-success btn-sm rounded">Take Action</button>
                </form>
            </div>
        </div>
    </div>`;
    Alert.render(str);
</script>';
}
?>


<!--Container Main end-->

<?php
require 'footer1.php';
?>
