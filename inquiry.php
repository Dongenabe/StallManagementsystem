<div class="row justify-content-center" data-aos="zoom-in-up">
    <h1 class="discover-header">Begin Your Retail Journey!</h1>
</div>
<hr>
<div class="row justify-content-center">
    <div class="col-md-5">
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "norental") {
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <small><strong><i class="fa-solid fa-circle-exclamation"></i></strong> Unfortunately, ' . $_GET['stallname'] . ' is currently fully occupied. Please try another cluster or section.</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            } elseif ($_GET['error'] == "none") {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <small><strong><i class="fa-solid fa-circle-check"></i></strong> Thank you for your inquiry! We have received your submission and will be in touch with you shortly.</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            }
        }
        ?>
    </div>
</div>
<div class="custom">
    <form action="availstall.php#inquire" method="post">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="lastname"><small>Last name:</small></label>
                <input type="text" name="ilname" class="form-control" id="lastname" placeholder="Last name..." required>
            </div>
            <div class="col-md-6">
                <label for="firstname"><small>First name:</small></label>
                <input type="text" name="ifname" class="form-control" id="firstname" placeholder="First name..." required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="gender"><small>Gender:</small></label>
                <select name="igender" class="custom-select" id="gender" required>
                    <option selected>Gender...</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="contactno"><small>Contact no:</small></label>
                <input type="number" name="icontact" class="form-control" id="contactno" placeholder="Contact no..." min="0" pattern="[0-9]{11}" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="address"><small>Address:</small></label>
                <textarea class="form-control" id="address" name="iadress" rows="3" required></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="clustersection"><small>Cluster/Section:</small></label>
                <select name="istallname" class="custom-select" id="stallname" required>
                    <option selected>Cluster/Section...</option>
                    <?php
                    $sql = "SELECT DISTINCT(stallname) as stallname FROM rental_tbl WHERE status = 'available' ORDER BY stallname ASC;";
                    $result = mysqli_query($conn, $sql);
                    $resCheck = mysqli_num_rows($result);

                    if ($resCheck > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['stallname'] . '">' . $row['stallname'] . '</option>';
                        }
                    } else {
                        echo '<option disabled>No available clusters/sections</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="productname"><small>Desired Stall name:</small></label>
                <input type="text" name="iprodname" class="form-control" id="productname" placeholder="Product name..." required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <label for="exampleFormControlTextarea1"><small>Message us!</small></label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="iconcern" rows="3"></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12 d-flex justify-content-center">
                <button type="submit" name="submit-inquiry" class="btn btn-primary btn-recommended">Submit Inquiry</button>
            </div>
        </div>
        <hr>
    </form>
</div>
