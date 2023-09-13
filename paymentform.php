<?php
    session_start();
    require 'headerr.php';
?>
    <div class="height-100 bg-light main-content">
    <div class="container bg-light p-4 rounded">
        <h3 class="fw-bold text-center"><i class="bi bi-credit-card-fill"></i> <?php if(isset($_GET['editPayment'])){echo 'Edit Payment';}else{echo 'Add Payment';}?></h3><hr>
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
                    }elseif($_GET['error'] == "ornumlength"){
                        echo '<div class="alert shadow alert-warning alert-dismissible fade show" role="alert">
                            <strong> <i class="bi bi-exclamation-square-fill"></i>&nbsp; O.R. number must contain 7 digits.</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }elseif($_GET['error'] == "none"){
                        echo '<div class="alert shadow alert-success alert-dismissible fade show" role="alert">
                            <strong> <i class="bi bi-check-circle-fill"></i> Payment has been added!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                }
            ?>
        </div>

        <form action="includes/process.php" method="post" class="row g-1 sform mb-2 shadow" enctype="multipart/form-data">
            <div class="row g-3 justify-content-center">
                <div class="col-md-4">
                    <label for="pdate" class="form-label">Payment Date:</label>
                    <input type="date" name="pdate" class="form-control form-control-sm" required>
                </div>
            </div>
            <div class="row g-3 justify-content-center">
                <div class="col-md-4">
                    <label for="tpayment_id" class="form-label">Select Tenant:</label>
                    <select name="tpayment_id" id="tenant_id" class="form-control form-control-sm" required>
                        <option selected disabled>Select Tenant...</option>
                        <?php 
                        $sql = "SELECT tenantid, tenant_lname
                                FROM tenants
                                WHERE tenantid IN (SELECT DISTINCT renterid FROM rental_tbl)
                                ORDER BY tenant_lname ASC";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = ($row['tenantid'] == $tpayment_id) ? 'selected' : '';
                                echo '<option value="' . $row['tenantid'] . '" ' . $selected . '>' . $row['tenant_lname'] . '</option>';
                            }
                        } else {
                            echo '<option selected="" value="" disabled="">No matching tenants found.</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- Add this div to display tenant details -->
            <div id="tenantDetails" class="mt-3 text-center">
                
            </div>
            <div class="row g-3 justify-content-center">
                <div class="col-md-4">
                    <label for="ornumber" class="form-label">O.R. number:</label>
                    <input type="number" name="ornumber" class="form-control form-control-sm" min="10" placeholder="O.R. number..." required>
                </div>
            </div>
            <div class="row g-3 justify-content-center">
                <div class="col-md-4">
                    <label for="amount" class="form-label">Total Amount:</label>
                    <input type="number" name="amount" class="form-control form-control-sm" min="10" placeholder="Payment Amount..." required>
                </div>
            </div>
            <div class="row g-3 justify-content-center">
                <div class="col-md-6">
                    <center>
                        <?php
                        if (isset($_GET['editPayment'])) {
                            echo '<a href="payments.php" class="btn btn-danger btn-sm">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="submit" name="payment-update" class="btn btn-primary btn-sm">Update</button>';
                        } else {
                            echo '<a href="tenants.php" class="btn btn-danger btn-sm">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="submit" name="payment-submit" class="btn btn-primary btn-sm">Save</button>';
                        }
                        ?>
                    </center>
                </div>
            </div>
        </form><hr>

        </div>

    </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tenantSelect = document.getElementById("tenant_id");
        const tenantDetails = document.getElementById("tenantDetails");

        tenantSelect.addEventListener("change", function () {
            const selectedTenantId = this.value;

            if (selectedTenantId) {
                // Create an AJAX request
                const xhr = new XMLHttpRequest();

                // Define the URL to your PHP script that retrieves tenant details
                const url = `get_tenant_details.php?tenant_id=${selectedTenantId}`;

                xhr.open("GET", url, true);

                // Define the callback function when the request is complete
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Update tenantDetails div with the response
                        tenantDetails.innerHTML = xhr.responseText;
                    }
                };

                // Send the AJAX request
                xhr.send();
            } else {
                tenantDetails.innerHTML = "";
            }
        });
    });
</script>


    <!--Container Main end-->
<?php
    require 'footer1.php';
?>