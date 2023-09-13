<?php
    session_start();
    $_SESSION['actib'] = 'rental';
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
            border-top: 2px solid #005c5c;
        }
    </style>

    <div class="bg-light-gray mb-5 p-3 rounded">
        
        <h3 class="fw-bold">Stalls</h3><br>
        
        <?php
    require 'includes/dbh.inc.php';

            if(isset($_GET['action'])){
                echo '<center><small><div class="text-start alert alert-'.$_GET['action'].' alert-dismissible fade show" role="alert">
                    <strong>';
                    if($_GET['action'] == 'danger')
                        echo '<i class="fa-solid fa-trash"></i>&nbsp; '.$_GET['stallname'].', Stall no. '.$_GET['stallno'].' has been deleted !';
                    elseif($_GET['action'] == 'warning')
                        echo '<i class="fa-solid fa-user-pen"></i>&nbsp; Stall record has been updated !';
                echo '</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div></small></center>';
            }
        ?>        
        <?php
$sql = "SELECT rental_tbl.*, market.market_name, tenants.tenant_fname, tenants.tenant_lname
    FROM rental_tbl
    LEFT JOIN market ON rental_tbl.pmarket_id = market.market_id
    LEFT JOIN tenants ON rental_tbl.renterid = tenants.tenantid
    ORDER BY stallname ASC;";


            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
        ?>
        <div class="table-responsive p-3 bg-light-gray mb-3 bord border-4 shadow-sm rounded">
            <form action="" method="post">
                <button formaction="add_rental.php" type="submit" class="btn btn-dark btn-sm"><i class="fa-solid fa-circle-plus"></i><small> Add Stall</small></button>&nbsp;
                <button type="submit" formaction="rental.php" class="btn btn-success btn-sm" ><i class="fa-solid fa-arrow-rotate-right"></i><small> Refresh</small></button>
            </form><hr>
<table id="myDataTable" class="table table-hover table-bordered table-striped table-sm custom-table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Renter name</th>
            <th>Section</th>
            <th>Stall no.</th>
            <th>Public market location</th>
            <th>Description</th>
            <th>Status</th>
            <th class="text-center">View</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nn = "____";
        $no = 0;
        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td class="fw-bold">' . ++$no . '.</td>';
                if (empty($row['tenant_lname']) && empty($row['tenant_fname'])) {
                    echo '<td class="fw-bold">' . $nn . '</td>';
                } else {
                    echo '<td class="fw-bold">' . $row['tenant_lname'] . ', ' . $row['tenant_fname'] . '</td>';
                }
                echo '<td>' . $row['stallname'] . '</td>';
                echo '<td>' . $row['stallno'] . '</td>';
                echo '<td>' . $row['market_name'] . '</td>';
                echo '<td>' . $row['description'] . '</td>';
                if ($row['status'] == 'Available') {
                    echo '<td class="text-center"><p class="bg-success text-white"><small>' . $row['status'] . '</small></p></td>';
                } elseif ($row['status'] == 'Maintenance') {
                    echo '<td class="text-center"><p class="bg-secondary text-white"><small>' . $row['status'] . '</small></p></td>';
                } elseif ($row['status'] == 'Reserved') {
                    echo '<td class="text-center"><p class="bg-primary text-white"><small>' . $row['status'] . '</small></p></td>';
                } elseif ($row['status'] == 'Occupied') {
                    echo '<td class="text-center"><p class="bg-warning text-white"><small>' . $row['status'] . '</small></p></td>';
                }

                echo '<td class="text-center"><a href="rental.php?view=' . $row['rentalid'] . '" class="btn btn-primary btn-sm rounded"><i class="fa-solid fa-eye"></i></a></td>';
                echo '<td class="text-center"><a href="add_rental.php?editRental=' . $row['rentalid'] . '" class="btn btn-warning btn-sm rounded"><i class="fa-solid fa-pen-to-square"></i></a></td>';
                echo '<td class="text-center"><a href="includes/process.php?deleteRental=' . $row['rentalid'] . '&deleterentstallname=' . $row['stallname'] . '&deleterentstallno=' . $row['stallno'] . '" class="btn btn-danger btn-sm rounded"><i class="fa-solid fa-trash"></i></a></td>';
                echo '</tr>';
            }
        }
        ?>
    </tbody>
</table>

        </div>
<?php
if (isset($_GET['view'])) {
    $iddd = $_GET['view'];
    $sql = "SELECT rental_tbl.*, market.market_name
            FROM rental_tbl
            LEFT JOIN market ON rental_tbl.pmarket_id = market.market_id
            WHERE rentalid = $iddd;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $k = $row['stallname'];
            $a = $row['stallno'];
            $b = $row['marketfee'];
            $c = $row['status'];
            $si = 'img/stalls/' . $row['image'];
            $p = $row['location'];
            $o = $row['size'];
            $pm = $row['pmarket_id']; // Added pmarket_id here
            $pm_name = $row['market_name']; // Added market_name here
        }
    }

    echo '<script>
            let str = `
            <div class="text-center mb-4">
                <img src="' . $si . '" alt="Stall Image" class="img-thumbnail" style="width: 200px; height: 200px;">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><b>Section:</b></label>
                        <input type="text" class="form-control" value="' . $k . '" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Stall number:</b></label>
                        <input type="text" class="form-control" value="' . $a . '" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Market Fee:</b></label>
                        <input type="text" class="form-control" value="' . $b . '" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Public Market Location:</b></label>
                        <input type="text" class="form-control" value="' . $pm_name . '" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label"><b>Status:</b></label>
                        <input type="text" class="form-control" value="' . $c . '" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Location:</b></label>
                        <input type="text" class="form-control" value="' . $p . '" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>Size:</b></label>
                        <input type="text" class="form-control" value="' . $o . '" readonly>
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