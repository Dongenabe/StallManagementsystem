<?php
    require 'dbh.inc.php';
    /* admin and staff */
    $userid = '';
    $lname = '';
    $fname  = '';
    $username = '';
    $usrtyp = '';
    $usemail = '';
    $usphone = '';
    
    
    /* stalls */
    $stallname = '';
    $stall  = '';
    $marketfee = '';
    $status = '';
    $image='';
    $location='';
    $description='';
    $size = '';
    
    /* market */
    $bmarket = '';
    $pmarket_id = '';

    /* tenants */
    $tenantid = '';
    $tlname = '';
    $tfname = '';
    $tmname = '';
    $tgender = '';
    $tbdate = '';
    $tphone = '';
    $taddress = '';
    $tstallname = '';
    $tage = ''; // Adding age field
    $tcivilstatus = ''; // Adding civil status field
    $tstall1 = '';
    $tstall2 = '';
    $tmarketfee = '';
    $tAdmit = date("Y-m-d");
    $msgtenant = '';

            /* Markets */

if (isset($_POST['market-submit'])) {
    $bmarket = $_POST['market_name'];


    if (empty($bmarket)) {
        header("Location: ../add_market.php?error=emptyinput");
        exit();
        }else{
            // Insert the new record
            $sql = "INSERT INTO market (market_name) VALUES('$bmarket');";
            $result = mysqli_query($conn, $sql);
            if($result){
                header("Location: ../add_market.php?error=none");
                exit();
            }
        }
    }


if(isset($_GET['editMarket'])){
        $market_id = $_GET['editMarket'];

        $sql = "SELECT * FROM market WHERE market_id = $market_id;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0){
            while($row = mysqli_fetch_assoc($result)){
                $bmarket = $row['market_name'];

            }
        }
    }
if (isset($_POST['market-update'])) {
    $market_id = $_POST['market_id']; // Retrieve the market ID
    $bmarket = $_POST['market_name'];

    if (empty($bmarket)) {
        header("Location: ../market.php?error=emptyinput&editMarket=".$market_id);
        exit();
    } else {
        $sql1 = "UPDATE market SET market_name='$bmarket' WHERE market_id=$market_id;";
        $result1 = mysqli_query($conn, $sql1);

        if ($result1) {
            header("Location: ../market.php?action=warning");
            exit();
        }
    }
}
if (isset($_GET['deleteMarket'])) {
    $market_id_to_delete = $_GET['deleteMarket'];

    // Perform a DELETE query to remove the market with the specified ID from the 'market' table
    $sql_delete = "DELETE FROM market WHERE market_id = $market_id_to_delete";
    $result_delete = mysqli_query($conn, $sql_delete);

    // Check if the deletion was successful and redirect with appropriate action parameter
    if ($result_delete) {
        // If the deletion was successful, redirect with action=danger to indicate a successful deletion
        header("Location: ../market.php?action=danger&market_name=" . urlencode($row['market_name']));
        exit();
    } else {
        // If there was an error during the deletion, redirect with action=error to indicate an error occurred
        header("Location: ../market.php?action=error");
        exit();
    }
}
/* stalls */
if (isset($_POST['rental-submit'])) {
    $stallname = $_POST['stallname'];
    $stall = $_POST['stallnum'];
    $marketfee = $_POST['marketfee'];

    // Check if renterid is provided or not
    if (isset($_POST['renterid']) && !empty($_POST['renterid'])) {
        $status = 'Occupied'; // Set the status to 'Occupied' when renterid is provided
        $renterid = $_POST['renterid'];
    } else {
        $status = 'Available'; // Set the status to 'Available' when renterid is not provided
        $renterid = null;
    }
    if (!empty($renterid)) {
        // Tenant is added, so set rent_started to the current date
        $rent_started = date("Y-m-d");
    } else {
        // No tenant is added, so set rent_started to NULL
        $rent_started = null;
    }

    $description = $_POST['stall_description'];
    $stall_size = $_POST['stall_size'];
    $stall_location = $_POST['stall_location'];
    $pmarket_id = $_POST['pmarket_id'];

    // Check if the selected pmarket_id exists in the market table
    $sql_check_market = "SELECT market_id FROM market WHERE market_id = '$pmarket_id'";
    $result_check_market = mysqli_query($conn, $sql_check_market);

    if (mysqli_num_rows($result_check_market) === 0) {
        header("Location: ../add_rental.php?error=invalidmarket");
        exit();
    }

    $target_path = "../img/stalls/";
    $target_path = $target_path . basename($_FILES['image']['name']);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
        $image = basename($_FILES['image']['name']);

        if (empty($stallname) || empty($stall) || empty($marketfee)) {
            header("Location: ../add_rental.php?error=emptyinput");
            exit();
        } else {
            // Check if the stallname and stallno already exist in the database
            $sql = "SELECT r.* FROM rental_tbl r
                    INNER JOIN market m ON r.pmarket_id = m.market_id
                    WHERE r.stallname = '$stallname' 
                    AND m.market_name = (SELECT market_name FROM market WHERE market_id = '$pmarket_id') 
                    AND r.stallno = '$stall'";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                header("Location: ../add_rental.php?error=alreadyexists");
                exit();
            } else {
                // Insert the new record into the rental_tbl table
                $sql = "INSERT INTO rental_tbl (stallname, stallno, marketfee, status, image, size, location, description, pmarket_id, renterid, rent_started)
                        VALUES ('$stallname','$stall','$marketfee','$status', '$image', '$stall_size', '$stall_location', '$description', '$pmarket_id', '$renterid', '$rent_started');";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    header("Location: ../add_rental.php?error=none");
                    exit();
                } else {
                    header("Location: ../add_rental.php?error=databaseerror");
                    exit();
                }
            }
        }
    } else {
        header("Location: ../add_rental.php?error=fileuploaderror");
        exit();
    }
}



if(isset($_GET['editRental'])){
    $rentalid = $_GET['editRental'];

    $sql = "SELECT * FROM rental_tbl WHERE rentalid=$rentalid;";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
            $stall  = $row['stallno'];
            $stallname = $row['stallname'];
            $marketfee = $row['marketfee'];
            $location = $row['location'];
            $size = $row['size'];
            $status = $row['status'];
            $description = $row['description'];
            $pmarket_id = $row['pmarket_id'];
            $renterid = $row['renterid'];
            $image = $row['image'];
        }
    }
}

if (isset($_POST['rental-update'])) {
    $rentalid = $_POST['rentalid'];
    $stallname = $_POST['stallname'];
    $stall = $_POST['stallnum'];
    $marketfee = $_POST['marketfee'];
    $location = $_POST['stall_location'];
    $description = $_POST['stall_description'];
    $size = $_POST['stall_size'];
    $pmarket_id = $_POST['pmarket_id']; // Added pmarket_id here
    $renterid = $_POST['renterid']; // Added renterid here

    // Determine the status based on the renterid
    if (!empty($renterid)) {
        $status = 'Occupied';
        // Check if rent_started is already set, if not, set it to the current date
        if (empty($_POST['rent_started'])) {
            $rent_started = date("Y-m-d");
        }
    } else {
        $status = 'Available';
    }

    // Check if the selected pmarket_id exists in the market table
    $sql_check_market = "SELECT market_id FROM market WHERE market_id = '$pmarket_id'";
    $result_check_market = mysqli_query($conn, $sql_check_market);
    if (mysqli_num_rows($result_check_market) === 0) {
        header("Location: ../rental.php?error=invalidmarket&editRental=" . $rentalid);
        exit();
    }

    $imageUpdated = false;
    if (!empty($_FILES['image']['tmp_name'])) {
        $target_path = "../img/stalls/";
        $target_path = $target_path . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image = basename($_FILES['image']['name']);
            $imageUpdated = true;
        }
    } else {
        $image = $_POST['current_image'];
    }

    if (empty($stallname) || empty($stall) || empty($marketfee) || empty($location) || empty($size)) {
        header("Location: ../rental.php?error=emptyinput&editRental=" . $rentalid);
        exit();
    } else {
        if ($imageUpdated) {
            $sql = "UPDATE rental_tbl SET stallname='$stallname', stallno='$stall', marketfee='$marketfee', size='$size', location='$location', description='$description', status='$status', image='$image', pmarket_id='$pmarket_id', renterid='$renterid', rent_started='$rent_started' WHERE rentalid=$rentalid;";
        } else {
            $sql = "UPDATE rental_tbl SET stallname='$stallname', stallno='$stall', marketfee='$marketfee', size='$size', location='$location', description='$description', status='$status', pmarket_id='$pmarket_id', renterid='$renterid', rent_started='$rent_started' WHERE rentalid=$rentalid;";
        }

        $result1 = mysqli_query($conn, $sql);
        if ($result1) {
            header("Location: ../rental.php?action=warning");
            exit();
        }
    }
}



if(isset($_GET['deleteRental'])){
    $rentalid  = $_GET['deleteRental'];
    $rentstallname = $_GET['deleterentstallname'];
    $rentstall = $_GET['deleterentstallno'];

    // Check if rent_started is already set, if not, set it to the current date
    $sql_check_rent_started = "SELECT rent_started FROM rental_tbl WHERE rentalid = '$rentalid'";
    $result_check_rent_started = mysqli_query($conn, $sql_check_rent_started);
    $row = mysqli_fetch_assoc($result_check_rent_started);
    
    if (empty($row['rent_started'])) {
        $rent_started = date("Y-m-d");
        $sql_update_rent_started = "UPDATE rental_tbl SET rent_started='$rent_started' WHERE rentalid='$rentalid'";
        mysqli_query($conn, $sql_update_rent_started);
    }

    $sql = "DELETE FROM rental_tbl WHERE rentalid='$rentalid';";
    $result = mysqli_query($conn, $sql);

    if($result){
        header("Location: ../rental.php?action=danger&stallname=".$rentstallname."&stallno=".$rentstall);
        exit();
    }
}

if (isset($_GET['renewDate'])) {
    $tenantid = $_GET['renewDate'];

    // Calculate the new end_date (increment the current year by 1)
    $sql = "SELECT date_end FROM tenants WHERE tenantid = '$tenantid';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentEndDate = $row['date_end'];

        // Calculate the new end_date (next year)
        $newEndDate = date('Y-m-d', strtotime($currentEndDate . ' + 1 year'));

        // Update the end_date in the database
        $updateSql = "UPDATE tenants SET date_end = '$newEndDate' WHERE tenantid = '$tenantid';";
        if (mysqli_query($conn, $updateSql)) {
            // Successfully updated the end_date
            header("Location: ../tenants.php"); // Redirect back to the tenant list page
            exit();
        } else {
            // Handle the case where the update failed
            echo "Error updating end_date: " . mysqli_error($conn);
        }
    }
}

/* tenants - Adding a new tenant */
if(isset($_POST['tenant-submit'])){
    $tlname = strtoupper($_POST['lname']);
    $tfname = strtoupper($_POST['fname']);
    $tmname = strtoupper($_POST['mname']);
    $tgender = strtoupper($_POST['gender']);
    $tbdate = $_POST['bday'];
    $tphone = $_POST['phone'];
    $taddress = strtoupper($_POST['address']);
    $tAdmit = $_POST['dateAdmit'];
    $tcivilstatus = $_POST['civilstatus'];
    $tage = $_POST['age'];
    $tmarket_id = $_POST['tmarket_id'];

    if (empty($tlname) || empty($tfname) || empty($tmname) || empty($tgender) || empty($tbdate) || empty($tphone) || empty($taddress) || empty($tAdmit)) {
        header("Location: ../tenantsignup.php?error=emptyinput");
        exit();
    }

    $currentYear = date('Y');
    $endDate = "$currentYear-12-28"; // December 28th of the current year

    $sqlcheck = "SELECT * FROM rental_tbl WHERE pmarket_id='$tmarket_id' AND status='Occupied';";

    $res = mysqli_query($conn, $sqlcheck);
    $rescheck = mysqli_num_rows($res);

    if ($rescheck > 0) {
        header("Location: ../tenantsignup.php?error=occupiedstall");
        exit();
    } else {
        $sql = "INSERT INTO tenants (tenant_lname, tenant_fname, tenant_midname, tenant_gender, age, civil_status, birthdate, phoneno, address, date_registered, date_end) 
                VALUES ('$tlname', '$tfname', '$tmname', '$tgender', '$tage', '$tcivilstatus', '$tbdate', '$tphone', '$taddress', '$tAdmit', '$endDate');";

        $result = mysqli_query($conn, $sql);

        if($result){
            $sikwel = "SELECT * from tenants WHERE tenant_lname='$tlname' AND date_registered='$tAdmit';";
            $sikwelres = mysqli_query($conn, $sikwel);
            $sikwelrescheck = mysqli_num_rows($sikwelres);

            if($sikwelrescheck > 0){
                while($rows = mysqli_fetch_assoc($sikwelres)){
                    $tenantid = $rows['tenantid'];
                    $rentername = $rows['tenant_lname'];
                }
            }

            // Update rental_tbl to Occupied for the new tenant (you may need to adjust this based on your table structure)
            $sql1 = "UPDATE rental_tbl SET renterid='$tenantid', status='Occupied' WHERE pmarket_id='$tmarket_id';";
            $result1 = mysqli_query($conn, $sql1);

            if ($result1) {
                header("Location: ../tenantsignup.php?error=none");
                exit();
            }
        }
    }
}

/* tenants - Updating a tenant */
if (isset($_POST['tenant-update'])) {
    $tenantid = $_POST['tenantid'];
    $tlname = strtoupper($_POST['lname']);
    $tfname = strtoupper($_POST['fname']);
    $tmname = strtoupper($_POST['mname']);
    $tgender = strtoupper($_POST['gender']);
    $tbdate = $_POST['bday'];
    $tphone = $_POST['phone'];
    $taddress = strtoupper($_POST['address']);
    $tAdmit = $_POST['dateAdmit'];
    $tcivilstatus = $_POST['civilstatus'];
    $tage = $_POST['age'];
    $tmarket_id = $_POST['tmarket_id'];

    $sql = "SELECT * FROM tenants WHERE tenantid = '$tenantid';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $temptlname = $row['tenant_lname'];
        }
    }

    if (empty($tlname) || empty($tfname) || empty($tmname) || empty($tgender) || empty($tbdate) || empty($tphone) || empty($taddress) || empty($tAdmit)) {
        header("Location: ../tenantsignup.php?error=emptyinput&editTenant=" . $tenantid);
        exit();
    } else {
        // Update tenant's information
        $sql2 = "UPDATE tenants SET tenant_lname='$tlname', tenant_fname='$tfname', tenant_midname='$tmname', tenant_gender='$tgender', civil_status='$tcivilstatus', age='$tage', birthdate='$tbdate', phoneno='$tphone', address='$taddress', date_registered='$tAdmit' WHERE tenantid = $tenantid;";
        $result2 = mysqli_query($conn, $sql2);

        if ($result2) {
            header("Location: ../tenants.php?action=warning&lname=" . $tlname);
            exit();
        }
    }
}

/* tenants - Deleting a tenant */
if(isset($_GET['deleteTenant'])){
    $tenantid = $_GET['deleteTenant'];

    // Get the rental information related to the tenant
    $sql_get_rental_info = "SELECT rentalid FROM rental_tbl WHERE renterid='$tenantid';";
    $result_get_rental_info = mysqli_query($conn, $sql_get_rental_info);

    while ($row = mysqli_fetch_assoc($result_get_rental_info)) {
        $rentalid = $row['rentalid'];

        // Set the renterid to 0 and status to 'Available' for the rental
        $sql_update_rental = "UPDATE rental_tbl SET renterid=0, status='Available', rent_started=null WHERE rentalid='$rentalid';";
        $result_update_rental = mysqli_query($conn, $sql_update_rental);
        
        if (!$result_update_rental) {
            // Handle the error if the rental update fails
            header("Location: ../tenants.php?action=danger&dellastname=".$tlname."&error=rentalupdateerror");
            exit();
        }
    }

    // Delete the tenant
    $sql2 = "DELETE FROM tenants WHERE tenantid = $tenantid;";
    $result2 = mysqli_query($conn, $sql2);

    if($result2){
        header("Location: ../tenants.php?action=danger&dellastname=".$tlname);
        exit();
    } else {
        // Handle the error if the tenant deletion fails
        header("Location: ../tenants.php?action=danger&dellastname=".$tlname."&error=tenantdeleteerror");
        exit();
    }
}


        /* payments */
if (isset($_POST['payment-submit'])) {
    $tpayment_id = $_POST['tpayment_id']; // Tenant ID
    $pdate = $_POST['pdate'];
    $ornumber = $_POST['ornumber'];
    $amount = $_POST['amount'];

    date_default_timezone_set('Asia/Manila');
    $timestamp = date('Y-m-d H:i:s');

    // Now, you need to fetch the rental information associated with the selected tenant.
    // You can use a SQL query to retrieve the rental information based on the tenant ID.
    // You would need to adjust this query to match your database schema.
    
    // For example, assuming you have a table named `rental_tbl`:
    $sql = "SELECT rentalid, stallname FROM rental_tbl WHERE renterid = '$tpayment_id'";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stall_id = $row['rentalid']; // Rental ID (stall_id)
        $stallname = $row['stallname'];
        
        // Now you have the necessary data to insert into the payments_tbl table.
        $sql1 = "INSERT INTO payments_tbl (tpayment_id, stall_id, ornumber, timestamp, paymentdate, paymenttime, amount) 
                 VALUES ('$tpayment_id', '$stall_id', '$ornumber', '$timestamp', '$pdate', NOW(), '$amount')";

        $result1 = mysqli_query($conn, $sql1);

        if ($result1) {
            header("Location: ../payments.php?action=success&lname=" . $stallname);
            exit();
        } else {
            header("Location: ../paymentForm.php?error=insertfailed");
            exit();
        }
    } else {
        header("Location: ../paymentForm.php?error=norentaldata");
        exit();
    }
}

if(isset($_GET['editPayment'])){
        $paymentid = $_GET['editPayment'];

        $sql = "SELECT * FROM payments_tbl WHERE paymentid='$paymentid';";
        $result = mysqli_query($conn, $sql);
        $rescheck = mysqli_num_rows($result);

        if($rescheck > 0){
            while($row = mysqli_fetch_assoc($result)){
                $tenantid = $row['tenantid'];
                $today = $row['paymentdate'];
                $holder = $row['holder'];
                $tstallname = $row['stallname'];
                $tstall1 = $row['stallno1'];
                $tstall2 = $row['stallno2'];
                $totalmarketfee = $row['marketfee'];
                $torno = $row['ornumber'];
            }
        }
    }
if (isset($_POST['payment-update'])) {
    $paymentid = $_POST['paymentid'];
    $tenantid = $_POST['tenantid'];
    $pdate = $_POST['pdate'];
    $pholder = $_POST['hiddenlname'];
    $pcluster = $_POST['hiddencluster'];
    $pstall = $_POST['hiddenstall'];
    $pmarketfee = $_POST['totmarketfee'];
    $pornum = $_POST['orn'];

    $sql = "SELECT * FROM payments_tbl WHERE paymentid='$paymentid';";
    $result = mysqli_query($conn, $sql);
    $rescheck = mysqli_num_rows($result);

    if ($rescheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tstallnamea = $row['stallname'];
            $tstall1 = $row['stallno1'];
            $tstall2 = $row['stallno2'];
        }
    }

    if (empty($pdate) || empty($pmarketfee) || empty($pornum)) {
        header("Location: ../paymentform.php?error=emptyinput&editPayment=".$paymentid);
        exit();
    }
    if (strlen($pornum) != 7) {
        header("Location: ../paymentform.php?error=ornumlength&editPayment=".$paymentid);
        exit();
    }
    $totalpayment = $pmarketfee;

    $sql1 = "UPDATE payments_tbl SET ornumber='$pornum', marketfee='$pmarketfee', total='$totalpayment' WHERE paymentid='$paymentid';";
    $result1 = mysqli_query($conn, $sql1);

    if ($result1) {
        header("Location: ../payments.php?action=warning&lname=".$pholder);
        exit();
    }
}
if (isset($_GET['deletePayment'])) {
    $paymentid = $_GET['deletePayment'];

    $query = "SELECT * FROM payments_tbl WHERE paymentid='$paymentid';";
    $resquery = mysqli_query($conn, $query);
    $resqueryCheck = mysqli_num_rows($resquery);

    if ($resqueryCheck > 0) {
        $row = mysqli_fetch_assoc($resquery);
        $holder = $row['holder'];

        $sql = "DELETE FROM payments_tbl WHERE paymentid='$paymentid';";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: ../payments.php?action=danger&lname=".$holder);
            exit();
        }
    }
}


        /* users */
if(isset($_GET['deleteUser'])){
    $userid = $_GET['deleteUser'];

    $query = "SELECT * FROM users WHERE userid = $userid";
    $resquery = mysqli_query($conn, $query);
    $resqueryCheck = mysqli_num_rows($resquery);

    if($resqueryCheck > 0){
        while($row = mysqli_fetch_assoc($resquery)){
            $userlast = $row['lname'];
            $userfirst = $row['fname'];
            $username = $row['username'];
            $usertype = $row['usertype'];
            $email = $row['email'];
            $phone = $row['phone'];
            $pwd = $row['pwd'];

            $usrtyp = $_GET['deleteusrtyp'];
            $usrlname = $_GET['deletelname'];
            $sql = "DELETE FROM users WHERE userid = '$userid';";
            $result = mysqli_query($conn, $sql);

            if($result){
                header("Location: ../users.php?action=danger&usertyp=".$usrtyp."&userlname=".$usrlname);
                exit();
            }
        }
    }

    }if(isset($_GET['editUser'])){
        $userid = $_GET['editUser'];

        $sql = "SELECT * FROM users WHERE userid = $userid;";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0){
            while($row = mysqli_fetch_assoc($result)){
                $lname = $row['lname'];
                $fname  = $row['fname'];
                $username = $row['username'];
                $usrtyp = $row['usertype'];
                $usemail = $row['email'];
                $usphone = $row['phone'];
            }
        }
    }
    if(isset($_POST['signup-update'])){
        $userid = $_POST['userid'];
        $lname = $_POST['lname'];
        $fname  = $_POST['fname'];
        $usrtyp = $_POST['usrtype'];
        $usphone = $_POST['phone'];

        if(empty($lname) || empty($fname) || empty($usrtyp) || empty($usphone)){
            header("Location: ../signup.php?error=emptyinput&editUser=".$userid);
            exit();
        }else{
            $sql1 = "UPDATE users SET lname='$lname', fname='$fname', usertype='$usrtyp', phone='$usphone' WHERE userid=$userid;";
            $result1 = mysqli_query($conn, $sql1);

            if($result1){
                header("Location: ../users.php?action=warning");
                exit();
            }
        }
    }





/* inquiry */
// Handle form submission
if (isset($_POST['action'])) {
    $concernId = $_POST['concern_id'];
    $status = $_POST['status'];

    // Update the status in the database
    $sql = "UPDATE tconcerns SET status = '$status' WHERE concernid = $concernId";
    mysqli_query($conn, $sql);

    // Set the success message
    $message = "Request record has been updated!";

    // Redirect to the same page with a success message
    header("Location: tconcerns.php?action=warning&message=" . urlencode($message));
    exit();
}
// Handle form submission for addressed
if (isset($_POST['actionadd'])) {
    $concernId = $_POST['concern_id'];
    $status = $_POST['status'];

    // Update the status in the database
    $sql = "UPDATE tconcerns SET status = '$status' WHERE concernid = $concernId";
    mysqli_query($conn, $sql);

    // Set the success message
    $message = "Request record has been updated!";

    // Redirect to the same page with a success message
    header("Location: tconcernsadd.php?action=warning&message=" . urlencode($message));
    exit();
}


if (isset($_GET['deleterequest'])) {
    $req_id = $_GET['deleterequest'];

    // Get the request date for the current request
    $sql = "SELECT req_date FROM request_tbl WHERE req_id=$req_id;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $req_date = $row['req_date'];

    // Delete all requests with the same request date
    $sql = "DELETE FROM request_tbl WHERE req_date = '$req_date';";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: ../request.php?action=danger&lastname=" . $inqlast);
        exit();
    }
}

if (isset($_GET['deleteConcerns'])) {
    $con_id = $_GET['deleteConcerns'];

    // Get the request date for the current request
    $sql = "SELECT date_time_created, tenantname FROM tconcerns WHERE concernid=$con_id;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $tenantname11 = $row['tenantname'];
    $date_time_created = $row['date_time_created'];

    // Delete all requests with the same request date
    $sql = "DELETE FROM tconcerns WHERE date_time_created = '$date_time_created';";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: ../tconcernsclosed.php?action=danger&tenantname=" . $tenantname11);
        exit();
    }
}



