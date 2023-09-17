<?php
    session_start();
    require 'headerr.php';
?>
    <div class="height-100 bg-light main-content">
        <div class="container bg-light p-4 rounded">
        <?php
            if(isset($_GET['editMarket'])){
                echo '<h3 class="text-center">Edit market</h3>';
            }else{
                echo '<h3 class="text-center"> Add Market Section</h3>';
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
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="row g-3 justify-content-center">
                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <label for=""><small>Market Section name:</small></label>
                                    <!-- Add hidden input field for the market ID -->
                                    <input type="hidden" name="market_section_id" value="<?php echo isset($_GET['editMarketsection']) ? $_GET['editMarketsection'] : ''; ?>">
                                    <input type="text" class="form-control" id="market_section" name="section_name" rows="3" value="<?php echo $bmarket_section; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 justify-content-center mb-4">
                        <div class="col-md-6">
                            <center>
                                <?php
                                    if (isset($_GET['editMarketsection'])) {
                                        echo '<a href="market_section.php" class="btn btn-danger btn-sm">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="submit" name="section-update" class="btn btn-primary btn-sm">Update</button>';
                                    } else {
                                        echo '<a href="market_section.php" class="btn btn-danger btn-sm">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button type="submit" name="section-submit" class="btn btn-primary btn-sm">Save</button>';
                                    }
                                ?>
                            </center>
                        </div>
                    </div>
                </div>
            </form>

        </div>

    </div>
    <!--Container Main end-->
<!-- You can place the code for editing rentals here -->
<!-- Rest of your HTML content, such as footer or other elements -->
<!-- Include necessary JavaScript libraries and files -->
<?php
    require 'footer1.php';
?>