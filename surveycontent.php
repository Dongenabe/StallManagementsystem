<?php
    session_start();
    $_SESSION['actib'] = 'srvy';
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
    
    if($resqueryCheck > 0){
        while($row = mysqli_fetch_assoc($resquery)){
            $tenant_lname= $row['tenant_lname'];
            $tenant_fname = $row['tenant_fname'];
            $gender = $row['tenant_gender'];
            $stallname = $row['stallname'];
            $stallno1 = $row['stallno1'];
            $stallno2 = $row['stallno2'];
        }
    }
    $stallno = $stallno1." - ".$stallno2;

?>

    <!--Container Main start-->
    
    <!-- this is for alert -->
                <div class="row justify-content-center">
                        <?php
                            if(isset($_GET['recadd'])){
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong><i class="bi bi-check-circle-fill"></i></strong>&nbsp;&nbsp; Your recommendation has been submitted to the admin.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            }
                        ?>
                </div>
<div class="bg-light mb-5 p-4 rounded">

    <div class="row g-3 my-2 px-3 mb-4 justify-content-center bg-light shadow-sm rounded">
        <hr>
        <div class="col-md-4">
            <div class="row justify-content-center">
                <div class="col-md-11 mt-4">
                    <p class="fs-6 text-end">Welcome <?php echo $tenant_lname.', '.$tenant_fname.'!'; ?></p>
                </div>
            </div>
            <h4 class="my-2 text-center"><i class="bi bi-plus-circle"></i> Are there any concerns about your stalls? Please don't hesitate to send us a message</h4>
            <form action="" method="post">
                <select name="concern_type" class="form-control mb-3" required>
                    <option value="">Select Concern Type</option>
                    <option value="Stalls">Stalls</option>
                    <option value="Electricity">Electricity</option>
                    <option value="Water Leakage">Water Leakage</option>
                    <option value="Other">Other</option>
                </select>
                <textarea name="recomm" class="form-control" id="" cols="40" rows="3" placeholder="Please describe your concern" required></textarea>
                <center>
                    <button type="submit" name="submit-recom" class="mt-3 mb-3 btn btn-primary btn-sm">Submit</button>
                </center>
            </form>
        </div>
        <hr>
    </div>
</div>

    <?php
        if(isset($_POST['submit-recom'])){

            $tenantname = $tenant_lname.', '.$tenant_fname;
            $concern_type = $_POST['concern_type'];
            $recommendation = $_POST['recomm'];
            $status = "Not process yet";
            $mysql="INSERT INTO tconcerns (status,tenantid, tenantname, tenantgender, stallname, stallno, concern_type, concerns)
            VALUES('$status','$tid', '$tenantname', '$gender', '$stallname', '$stallno', '$concern_type', '$recommendation');";
            $mysqlresult = mysqli_query($conn, $mysql);

            if($mysqlresult){
                echo '<script>window.location.href="surveycontent.php?recadd=true";</script>';
            }
        }
    ?>
</div>
