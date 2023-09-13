<?php
    session_start();
    require 'headerr.php';
?>
    <div class="height-100 bg-light main-content">
    <div class="container bg-light p-4 rounded">
        <h3 class="fw-bold text-center"><?php if(isset($_GET['editTenant'])){echo '<i class="fa-solid fa-user-pen"></i> Tenant';}else{echo '<i class="fa-solid fa-user-plus"></i> Add Tenant';}?></h3><hr>
        <div class="row justify-content-center">
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == "emptyinput"){
                        echo '<div class="alert shadow alert-warning alert-dismissible fade show" role="alert">
                            <strong> <i class="bi bi-exclamation-square-fill"></i>&nbsp; Please fill out all fields.</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }elseif($_GET['error'] == "occupiedstall"){
                        echo '<div class="alert shadow alert-warning alert-dismissible fade show" role="alert">
                            <strong> <i class="bi bi-exclamation-square-fill"></i>&nbsp; Stall number you\'ve entered is already occupied.</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }elseif($_GET['error'] == "none"){
                        echo '<div class="alert shadow alert-success alert-dismissible fade show" role="alert">
                            <strong> <i class="bi bi-check-circle-fill"></i> New tenant has been added!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';

                    }
                }
            ?>
        </div>
        
<form action="includes/process.php" method="post" class="row g-1 sform mb-2 shadow" enctype="multipart/form-data">
    <div class="row g-3 justify-content-center">
        <div class="col-md-2">
            <label for="lname" class="form-label">Last name:</label>
            <input type="text" name="lname" class="form-control form-control-sm" id="lname" placeholder="Last name..." value="<?php echo $tlname;?>" required>
        </div>
        <div class="col-md-2">
            <label for="fname" class="form-label">First name:</label>
            <input type="text" name="fname" class="form-control form-control-sm" id="fname" placeholder="First name..." value="<?php echo $tfname;?>" required>
        </div>
        <div class="col-md-2">
            <label for="mname" class="form-label">Middle name:</label>
            <input type="text" name="mname" class="form-control form-control-sm" id="mname" placeholder="Middle name..." value="<?php echo $tmname;?>" required>
        </div>
    </div>
    <div class="row g-3 justify-content-center">
        <div class="col-md-2">
            <label for="gender" class="form-label">Gender:</label>
            <select class="form-select form-select-sm" name="gender" id="gender" required>
                <option selected disabled>Gender...</option>
                <option value="Male" <?php if($tgender == 'MALE'){echo 'selected';} ?>>MALE</option>
                <option value="Female" <?php if($tgender == 'FEMALE'){echo 'selected';} ?>>FEMALE</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="bday" class="form-label">Birthdate:</label>    
            <input type="date" name="bday" class="form-control form-control-sm" id="bday" max="2002-12-31" min="1961-01-01" value="<?php echo $tbdate;?>" required>    
        </div>
        <div class="col-md-2">
            <label for="phone" class="form-label">Phone No.:</label>
            <input type="text" name="phone" class="form-control form-control-sm" id="phone" placeholder="Phone no..." value="<?php echo $tphone; ?>" required>
        </div>
    </div>
    <div class="row g-3 justify-content-center">
        <div class="col-md-6">
            <label for="address" class="form-label">Address:</label>
            <textarea class="form-control form-control-sm" name="address" id="address" rows="3"><?php echo $taddress;?></textarea>
        </div>
    </div>
    <div class="row g-3 justify-content-center">
        <div class="col-md-2">
            <label for="dateAdmit" class="form-label">Date Admitted:</label>    
            <input type="date" name="dateAdmit" class="form-control form-control-sm" id="dateAdmit" value="<?php echo $tAdmit;?>" required>
        </div>
        <div class="row g-3 justify-content-center">
            <div class="col-md-2">
                <label for="age" class="form-label">Age:</label>
                <input type="text" class="form-control form-control-sm" name="age" id="age"  value="<?php echo $tage; ?>"  >
            </div>
            <div class="col-md-2">
                <label for="civilstatus" class="form-label">Civil Status:</label>
                <select class="form-select form-select-sm" name="civilstatus" id="civilstatus" required>
                    <option selected disabled>Civil Status...</option>
                    <option value="Single" <?php if ($tcivilstatus == 'Single') echo 'selected'; ?>>Single</option>
                    <option value="Married" <?php if ($tcivilstatus == 'Married') echo 'selected'; ?>>Married</option>
                    <option value="Divorced" <?php if ($tcivilstatus == 'Divorced') echo 'selected'; ?>>Divorced</option>
                    <option value="Widowed" <?php if ($tcivilstatus == 'Widowed') echo 'selected'; ?>>Widowed</option>
                </select>
            </div>
        </div>

    <input type="hidden" name="tenantid" value="<?php echo $tenantid;?>">
    <div class="row g-3 justify-content-center mb-4">
        <div class="col-md-6">
            <center>
                <?php
                if(isset($_GET['editTenant'])){
                    echo '<a href="tenants.php" class="btn btn-danger btn-sm">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" name="tenant-update" class="btn btn-primary btn-sm">Update</button>';
                }else{
                    echo '<a href="tenants.php" class="btn btn-danger btn-sm">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="submit" name="tenant-submit" class="btn btn-primary btn-sm">Save</button>';
                }
                ?>
            </center>
        </div>
    </div>
</form>
<hr>


        </div>

    </div>
    <!--Container Main end-->
<?php
    require 'footer1.php';
?>