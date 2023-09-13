<?php
require 'indexHeader.php';
require 'includes/dbh.inc.php';

$ilname = "";
$ifname = "";
$igender = "";
$icontact = "";
$iadress = "";
$istallname = "";
$iprodname = "";
$iconcern = "";
$status = "unread";

if (isset($_POST['submit-inquiry'])) {
    $ilname = $_POST['ilname'];
    $ifname = $_POST['ifname'];
    $igender = $_POST['igender'];
    $icontact = $_POST['icontact'];
    $iadress = $_POST['iadress'];
    $istallname = $_POST['istallname'];
    $iprodname = $_POST['iprodname'];
    $iconcern = $_POST['iconcern'];

    $sql = "INSERT INTO request_tbl (status, lastname, firstname, gender, contact, address, stallname, productname, message)
            VALUES ('$status', '$ilname', '$ifname', '$igender', '$icontact', '$iadress', '$istallname', '$iprodname', '$iconcern');";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Redirect to the homepage with a success message
        header("Location: index.php?error=none#inquire");
        exit();
    } else {
        // Handle the case if the insertion fails
        // You can add appropriate error handling here
    }
}
?>

<main>
    <section class="home">
<div class="row justify-content-center">
    <div class="col-md-6 p-2 bg-light border rounded">
        <hr>
        <h2 style="color: #4CAF50; font-weight: bold; font-size: 24px; text-align: center; padding: 10px; border: 2px solid #4CAF50; border-radius: 10px; display: inline-block;" data-aos="fade-down">
            <i class="fas fa-store"></i> Recommended Stalls Just for You!
        </h2>
        <hr>
        <hr>
        <div class="card-body" data-aos="zoom-in">
            <h5 class="card-title" style="color:black;">Product name: <?php echo $iprodname; ?> ( <?php echo $istallname; ?> )</h5>
            <hr>
            <!-- Search and filter -->
            <div class="row justify-content-center mb-3">
                <div class="col-8">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search by Stall/Section">
                </div>
                <div class="col-4">
                    <button class="btn btn-primary" id="filterButton">Filter</button>
                </div>
            </div>
            
            <div class="row" id="stallsSection">
                <?php
if ($resCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $stallImageSrc = 'img/stalls/' . $row['image'];
        echo '<div class="col-12 col-sm-6 col-md-4 stall-card">';
        echo '<div class="card mb-4 shadow-sm">';
        echo '<div class="card-body">';
        echo '<img style="width:100%; height:auto; border-radius:25px;" src="' . $stallImageSrc . '" onclick="selectStall(this)" data-stallno="' . $row['stallno'] . '" data-rentalid="' . $row['rentalid'] . '">';
        echo '<h6 class="card-title">Stall/Section: ' . $row['stallname'] . '</h6>';
        echo '<p class="card-text">Stall no.: ' . $row['stallno'] . '</p>';
        echo '<p class="card-text">Status: <span class="badge bg-success">' . $row['status'] . '</span></p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

                ?>
            </div>

                    </div>
                    <div class="col-md-12 p-3">
                        <div class="bg-light p-2 border rounded">
                            <hr>
                            <form action="" method="post">

                            <input type="hidden" name="selected_rentalids" id="selected_rentalids" value="">
                            <input type="hidden" name="selected_stallnos" id="selected_stallnos" value="">
                            <input type="hidden" name="ilname" class="form-control" id="" placeholder="Last name..." value="<?php echo $ilname;?>">
                            <input type="hidden" name="ifname" class="form-control" id="" placeholder="First name..." value="<?php echo $ifname;?>">
                            <input type="hidden" name="igender" class="form-control" id="" placeholder="Gender..." value="<?php echo $igender;?>">
                            <input type="hidden" name="icontact" class="form-control" id="" placeholder="Contact no..." pattern="[0-9]{11}" value="<?php echo $icontact;?>">
                            <input type="hidden" name="iadress" class="form-control" id="" value="<?php echo $iadress;?>">
                            <input type="hidden" name="istallname" class="form-control" id="" placeholder="stall/Section..." value="<?php echo $istallname;?>">
                            <input type="hidden" name="iprodname" class="form-control" id="" placeholder="Product name..." value="<?php echo $iprodname;?>">
                                <label for="exampleFormControlTextarea1"><small>Message us!</small></label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="iconcern" rows="3"></textarea>
                                <div class="row justify-content-center">
                                    <div class="col-4 mt-2 p-2">
                                        <center>
                                            <button type="submit" name="submit-inq" class="btn btn-primary btinquire">Submit Inquiry</button>
                                        </center>
                                    </div>
                                </div>
                                <hr>
                            </form>
                        </div>
                    </div>
                        <div class="bg-secondary p-3 rounded">
                            <div class="row justify-content-center" data-aos="fade-down">
                                <h5 class="text-center text-white">Contact</h5>
                            </div>
                            <div class="row justify-content-center" data-aos="zoom-in">
                                <img class="log" src="img/MCPMS.png" alt="">
                            </div>
                            <br>
                            <div class="row justify-content-center" data-aos="fade-up">
                                <h6 class="text-center text-white">OIC incharge</h6>
                                <br>
                            </div>
                            <div class="row justify-content-center" data-aos="fade-up">
                                <p class="text-center"><small>Address</small></p>
                            </div>
                            <div class="row justify-content-center" data-aos="fade-up">
                                <p class="text-center"><strong><i class="fa-solid fa-phone"></i> 09</strong></p>
                            </div>
                         </div> <hr>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

            <style>
                .home {
                  color: #333;
                }

                .bord {
                  border-top: 3px solid #3a8bcd;
                }
            </style>


        <?php
if (isset($_POST['submit-inq'])) {
    $ilname = $_POST['ilname'];
    $ifname = $_POST['ifname'];
    $igender = $_POST['igender'];
    $icontact = $_POST['icontact'];
    $iadress = $_POST['iadress'];
    $istallname = $_POST['istallname'];
    $iprodname = strtoupper($_POST['iprodname']);
    $iconcern = $_POST['iconcern'];
    $status = "unread";
    $selected_stallnos = explode(',', $_POST['selected_stallnos']);
    $selected_rentalids = explode(',', $_POST['selected_rentalids']);

    for ($i = 0; $i < count($selected_stallnos); $i++) {
        $stallno = $selected_stallnos[$i];
        $rentalid = $selected_rentalids[$i];

        $sql = "INSERT INTO request_tbl (status, lastname, firstname, gender, contact, address, stallname, productname, message, stallno, rentalid)
        VALUES('$status', '$ilname', '$ifname', '$igender', '$icontact', '$iadress', '$istallname', '$iprodname', '$iconcern', '$stallno', '$rentalid');";
        $result = mysqli_query($conn, $sql);
    }

    if ($result) {
        echo '<script>window.location.href="index.php?error=none#inquire";</script>';
    }
}


            require 'indexFooter.php';
        ?>

<script>
// Initialize the selectedStalls array
const selectedStalls = [];

function selectStall(imageElement) {
    // Get the stall number and rental ID from the clicked image
    const stallNumber = parseInt(imageElement.dataset.stallno);
    const rentalId = imageElement.dataset.rentalid;

    // Check if the stall is already selected
    const stallIndex = selectedStalls.findIndex((stall) => stall.stallNumber === stallNumber);

    if (stallIndex > -1) {
        // If the stall is already selected, remove it from the array
        selectedStalls.splice(stallIndex, 1);
        // Remove the green border from the image
        imageElement.style.border = 'none';
    } else {
        // If the stall is not selected, add it to the array
        selectedStalls.push({ stallNumber, rentalId });
        // Add a green border to the selected image
        imageElement.style.border = '3px solid green';
    }

    // Sort the selectedStalls array by stallNumber
    selectedStalls.sort((a, b) => a.stallNumber - b.stallNumber);

    // Add all the stall numbers between the first and last selected stall numbers
    const allSelectedStalls = [];
    const firstSelectedStallNumber = selectedStalls[0]?.stallNumber;
    const lastSelectedStallNumber = selectedStalls[selectedStalls.length - 1]?.stallNumber;

    if (firstSelectedStallNumber && lastSelectedStallNumber) {
        for (let i = firstSelectedStallNumber; i <= lastSelectedStallNumber; i++) {
            const existingStall = selectedStalls.find((stall) => stall.stallNumber === i);

            if (existingStall) {
                allSelectedStalls.push(existingStall);
            } else {
                const rentalId = document.querySelector(`[data-stallno="${i}"]`)?.dataset.rentalid;
                if (rentalId) {
                    allSelectedStalls.push({ stallNumber: i, rentalId });
                }
            }
        }
    }

    // Loop through all images and update their border based on whether they are in the allSelectedStalls array
    const images = document.querySelectorAll('.stall-card img');
    images.forEach((img) => {
        const imgStallNumber = parseInt(img.dataset.stallno);
        const isSelected = allSelectedStalls.some((stall) => stall.stallNumber === imgStallNumber);

        if (isSelected) {
            img.style.border = '3px solid green';
        } else {
            img.style.border = 'none';
        }
    });

    // Update the hidden input fields with the selected stall numbers and rental IDs
    document.getElementById('selected_stallnos').value = allSelectedStalls.map((stall) => stall.stallNumber).join(',');
    document.getElementById('selected_rentalids').value = allSelectedStalls.map((stall) => stall.rentalId).join(',');
}

$(document).ready(function() {
    // Get the initial stalls HTML markup
    var initialStallsHtml = $('#stallsSection').html();

    // Handle filter button click event
    $('#filterButton').click(function() {
        var searchValue = $('#searchInput').val().toLowerCase();

        // Filter the stalls based on the search value
        var filteredStallsHtml = initialStallsHtml;
        if (searchValue !== '') {
            filteredStallsHtml = $(initialStallsHtml).filter(function() {
                return $(this).find('.card-title').text().toLowerCase().indexOf(searchValue) > -1;
            });
        }

        // Update the stalls section with the filtered stalls
        $('#stallsSection').html(filteredStallsHtml);
    });
});
</script>
