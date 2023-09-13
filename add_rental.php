<?php
    session_start();
    require 'headerr.php';

?>
    <div class="height-100 bg-light main-content">
        <div class="container bg-light p-4 rounded">
        <?php
            if(isset($_GET['editRental'])){
                echo '<h3 class="text-center">Edit Stall</h3>';
            }else{
                echo '<h3 class="text-center"> Add Stall</h3>';
            }?><hr>
        <div class="row justify-content-center">
            <?php
                if(isset($_GET['error'])){
                    if($_GET['error'] == "emptyinput"){
                        echo '<div class="alert shadow alert-warning alert-dismissible fade show" role="alert">
                            <strong> <i class="bi bi-exclamation-square-fill"></i>&nbsp; Please fill out all fields.</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }elseif($_GET['error'] == "alreadyexists"){
                        echo '<div class="alert shadow alert-danger alert-dismissible fade show" role="alert">
                            <strong> <i class="bi bi-check-circle-fill"></i> Stall number already exists</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';

                    
                    }elseif($_GET['error'] == "none"){
                        echo '<div class="alert shadow alert-success alert-dismissible fade show" role="alert">
                            <strong> <i class="bi bi-check-circle-fill"></i> New stall has been added!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';

                    }
                }
                
            ?>
        </div>
            <form action="includes/process.php" method="post" class="row g-1 sform mb-2 shadow" enctype="multipart/form-data">
                <div class="row g-3 ">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Stall/Section:</label>
                            <select class="form-select form-select-sm" name="stallname" aria-label="Default select example" required>
                                <option selected disabled>Cluster/Section...</option>
                                <option value="Fish Section (Inside)" <?php if($stallname == 'Fish Section (Inside)'){ echo 'selected';}?>>Fish Section (Inside)</option>
                                <option value="Fish Section (Outside)" <?php if($stallname == 'Fish Section (Outside)'){ echo 'selected';}?>>Fish Section (Outside)</option>
                                <option value="Meat Section (Inside)" <?php if($stallname == 'Meat Section (Inside)'){ echo 'selected';}?>>Meat Section (Inside)</option>
                                <option value="Meat Section (Outside)" <?php if($stallname == 'Meat Section (Outside)'){ echo 'selected';}?>>Meat Section (Outside)</option>
                                <option value="Dried Fish Section (Inside)" <?php if($stallname == 'Dried Fish Section (Inside)'){ echo 'selected';}?>>Dried Fish Section (Inside)</option>
                                <option value="Dried Fish Section (Outside)" <?php if($stallname == 'Dried Fish Section (Outside)'){ echo 'selected';}?>>Dried Fish Section (Outside)</option>
                                <option value="Grocery/Handicraft Section (Inside)" <?php if($stallname == 'Grocery/Handicraft Section (Inside)'){ echo 'selected';}?>>Grocery/Handicraft Section (Inside)</option>
                                <option value="Grocery/Handicraft Section (Outside)" <?php if($stallname == 'Grocery/Handicraft Section (Outside)'){ echo 'selected';}?>>Grocery/Handicraft Section (Outside)</option>
                                <option value="Rice/Grain Section (Inside)" <?php if($stallname == 'Rice/Grain Section (Inside)'){ echo 'selected';}?>>Rice/Grain Section (Inside)</option>
                                <option value="Rice/Grain Section (Outside)" <?php if($stallname == 'Rice/Grain Section (Outside)'){ echo 'selected';}?>>Rice/Grain Section (Outside)</option>
                                <option value="Fruits and Vegetable Section (Inside)" <?php if($stallname == 'Fruits and Vegetable Section (Inside)'){ echo 'selected';}?>>Fruits and Vegetable Section (Inside)</option>
                                <option value="Fruits and Vegetable Section (Outside)" <?php if($stallname == 'Fruits and Vegetable Section (Outside)'){ echo 'selected';}?>>Fruits and Vegetable Section (Outside)</option>
                                <option value="Eatery (Commercial) Section (Inside)" <?php if($stallname == 'Eatery (Commercial) Section (Inside)'){ echo 'selected';}?>>Eatery (Commercial) Section (Inside)</option>
                                <option value="Eatery (Commercial) Section (Outside)" <?php if($stallname == 'Eatery (Commercial) Section (Outside)'){ echo 'selected';}?>>Eatery (Commercial) Section (Outside)</option>
                                <option value="Veterinary & Agricultural Section (Inside)" <?php if($stallname == 'Veterinary & Agricultural Section (Inside)'){ echo 'selected';}?>>Veterinary & Agricultural Section (Inside)</option>
                                <option value="Veterinary & Agricultural Section (Outside)" <?php if($stallname == 'Veterinary & Agricultural Section (Outside)'){ echo 'selected';}?>>Veterinary & Agricultural Section (Outside)</option>
                                <option value="General Business (Commercial) Section (Inside)" <?php if($stallname == 'General Business (Commercial) Section (Inside)'){ echo 'selected';}?>>General Business (Commercial) Section (Inside)</option>
                                <option value="General Business (Commercial) Section (Outside)" <?php if($stallname == 'General Business (Commercial) Section (Outside)'){ echo 'selected';}?>>General Business (Commercial) Section (Outside)</option>
                                <option value="Miscellaneous Section (Inside)" <?php if($stallname == 'Miscellaneous Section (Inside)'){ echo 'selected';}?>>Miscellaneous Section (Inside)</option>
                                <option value="Miscellaneous Section (Outside)" <?php if($stallname == 'Miscellaneous Section (Outside)'){ echo 'selected';}?>>Miscellaneous Section (Outside)</option>
                            </select>
                    </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Market:</label>
                <select class="form-select form-select-sm" name="pmarket_id" aria-label="Default select example" required>
                    <option selected disabled>Market location...</option>
                    <?php 
                    $market = $conn->query("SELECT * FROM market order by market_name asc");
                    if ($market->num_rows > 0) {
                        while ($row = $market->fetch_assoc()) {
                            $selected = ($row['market_id'] == $pmarket_id) ? 'selected' : '';
                            echo '<option value="' . $row['market_id'] . '" ' . $selected . '>' . $row['market_name'] . '</option>';
                        }
                    } else {
                        echo '<option selected="" value="" disabled="">Please check the category list.</option>';
                    }
                    ?>
                </select>
            </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Stall no.:</label>    
                        <input type="number" name="stallnum" class="form-control form-control-sm" min="1" placeholder="Stall no..." value="<?php echo $stall;?>" required >
                    </div>
                <div class="col-md-6">
                    <label for="tenantName" class="form-label">Tenant name:</label>
                    <select class="form-select form-select-sm" name="renterid" aria-label="Default select example">
                        <option value="">Select tenant...</option>
                    <?php 
                    $market = $conn->query("SELECT * FROM tenants order by tenant_fname asc");
                    if ($market->num_rows > 0) {
                        while ($row = $market->fetch_assoc()) {
                            $selected = ($row['tenantid'] == $renterid) ? 'selected' : '';
                            echo '<option value="' . $row['tenantid'] . '" ' . $selected . '>' . $row['tenant_lname'] . ', ' . $row['tenant_fname'] . ' ' . $row['tenant_midname']; '</option>';
                        }
                    } else {
                        echo '<option selected="" value="" disabled="">Please check the category list.</option>';
                    }
                    ?>
                    </select>
                </div>
                </div>

                <div class="row g-3 justify-content-center">
                    <div class="col-md-6">
                        <label for="" class="form-label">Market fee:</label>    
                        <input type="number" name="marketfee" class="form-control form-control-sm" min="10" placeholder="Market fee..." value="<?php echo $marketfee;?>"required >
                    </div>
                <div class="col-md-6">
                    <label for="" class="form-label">Size:</label>
                    <select class="form-select form-select-sm" name="stall_size" id="inputEmail4"required >
                        <option selected disabled>Choose stall size...</option>
                        <option value="5x5 ft" <?php if($size == '5x5 ft'){ echo 'selected';}?>>5x5 ft</option>
                        <option value="10x10 ft" <?php if($size == '10x10 ft'){ echo 'selected';}?>>10x10 ft</option>
                        <option value="15x15 ft" <?php if($size == '15x15 ft'){ echo 'selected';}?>>15x15 ft</option>
                        <option value="20x20 ft" <?php if($size == '20x20 ft'){ echo 'selected';}?>>20x20 ft</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="row g-3 justify-content-center">
                    <div class="row mb-3">
                        <div class="col-md-9">
                            <label for=""><small>Location:</small></label>
                            <input type="text" class="form-control" id="location" name="stall_location" rows="3" value="<?php echo $location;?>" required >
                        </div>
                    </div>
                </div>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-9">
                            <label for="" class="form-label">Notes or Comments:</label>
                            <textarea class="form-control" id="description" name="stall_description" rows="3" placeholder="Description of stalls" required><?php echo $description;?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Status:</label>
                        <select class="form-select form-select-sm" name="status" aria-label="Default select example"required >
                            <option selected disabled>Status...</option>
                            <option value="Available" <?php if($status == 'Available'){ echo 'selected';}?>>Available</option>
                            <option value="Occupied" <?php if($status == 'Occupied'){ echo 'selected';}?>>Occupied</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputImage" class="form-label">Image:</label>
                        <input type="file" class="form-control form-control-sm" name="image" id="inputImage" accept="image/jpeg" >
                    </div>
                </div>

                <input type="hidden" name="rentalid" value="<?php echo $rentalid?>">
                <div class="row g-3 justify-content-center mb-4">
                    <div class="col-md-6">
                        <center>
                            <?php
                                if(isset($_GET['editRental'])){
                                    echo '<a href="rental.php" class="btn btn-danger btn-sm">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button type="submit" name="rental-update" formaction="includes/process.php" class="btn btn-primary btn-sm">Update</button>';
                                }else{
                                    echo '<a href="rental.php" class="btn btn-danger btn-sm">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button type="submit" name="rental-submit" class="btn btn-primary btn-sm">Save</button>';
                                }
                            ?>
                        </center>
                    </div>
                </div>

            </form><hr>
        </div>

    </div>
    <!--Container Main end-->
<!-- You can place the code for editing rentals here -->
<!-- Rest of your HTML content, such as footer or other elements -->
<!-- Include necessary JavaScript libraries and files -->
<?php
    require 'footer1.php';
?>