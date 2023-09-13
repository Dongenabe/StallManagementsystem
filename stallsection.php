<style>
    /* Add custom CSS styles here */
    .container {
        padding: 20px;
    }

    .h1 {
        text-align: center;
    }

    /* Style for the dropdown filter */
    #stall-filter {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        margin-bottom: 20px;
    }



    /* Style for the modal */
    .modal-content {
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .modal-body {
        padding: 20px;
    }

    #stall-img {
        height: 200px;
        width: 100%;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .modal-footer {
        padding: 10px;
        text-align: right;
    }

    .btn-secondary {
        background-color: #888;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<div class="container">
    <div class="row justify-content-center" id="Stalls" data-aos="fade-down">
        <h1 class="h1">Stall Varieties</h1>
    </div>
    <hr>

    <!-- Add the dropdown filters for stallname and pmarket_id -->
    <div class="row">
        <div class="col-md-6">
            <label for="stall-filter">Filter by Stall Name:</label>
            <select id="stall-filter" onchange="filterStalls()">
                <option value="all">All Stalls</option>
                <?php
                $sel_stallnames = "SELECT DISTINCT stallname FROM rental_tbl WHERE status = 'Available'";
                $rs_stallnames = $conn->query($sel_stallnames);
                while ($rws_stallnames = $rs_stallnames->fetch_assoc()) {
                    $stallname = $rws_stallnames['stallname'];
                    echo "<option value='$stallname'>$stallname</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="pmarket-filter">Filter by PMarket ID:</label>
            <select id="pmarket-filter" onchange="filterStalls()">
                <option value="all">All PMarket IDs</option>
                <?php
                $sel_pmarket_ids = "SELECT DISTINCT rental_tbl.pmarket_id, market.market_name 
                                    FROM rental_tbl 
                                    INNER JOIN market ON rental_tbl.pmarket_id = market.market_id
                                    WHERE rental_tbl.status = 'Available'";
                $rs_pmarket_ids = $conn->query($sel_pmarket_ids);
                while ($rws_pmarket_ids = $rs_pmarket_ids->fetch_assoc()) {
                    $pmarket_id = $rws_pmarket_ids['pmarket_id'];
                    $market_name = $rws_pmarket_ids['market_name'];
                    echo "<option value='$pmarket_id'>$market_name </option>";
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row">
        <?php
        $sel_stalls = "SELECT * FROM rental_tbl WHERE status = 'Available'";
        $rs_stalls = $conn->query($sel_stalls);
        while ($rws_stalls = $rs_stalls->fetch_assoc()) {
            ?>
            <div class="col-md-4 stall-item" data-stallname="<?php echo $rws_stalls['stallname']; ?>"
                 data-pmarketid="<?php echo $rws_stalls['pmarket_id']; ?>">
                <div class="card" data-aos="zoom-in" style="display: block;">
                    <img src="img/stalls/<?php echo $rws_stalls['image']; ?>"
                         alt="<?php echo $rws_stalls['stallname']; ?> Stall"
                         class="card-img-top stall-image">
                    <div class="card-body">
                        <p><span
                                    class="badge bg-<?php echo $rws_stalls['status'] === 'Available' ? 'success' : 'danger'; ?>"><?php echo $rws_stalls['status']; ?></span>
                        </p>
                        <p><?php echo $rws_stalls['description']; ?></p>
                    </div>
                    <div class="card-footer">
                        <button class="rent-now-btn"
                                onclick="showStallDetails(<?php echo htmlspecialchars(json_encode($rws_stalls)); ?>)"
                                data-toggle="modal" data-target="#modalId">View Details
                        </button>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>
</div>
    <!-- Modal -->
    <div class="modal fade" id="modalId">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mt-2 p-3">
                        <div class="col-md-6">
                            <img id="stall-img" src="" alt="" class="card-img-top stall-image border">
                        </div>
                        <div class="col-md-6 text-dark">
                            <h4 class="mb-4 font-weight-bold">Stall Details</h4>
                            <p class="mb-2 font-weight-bold">Stall Name: <span class="font-weight-normal" id="stall-name"></span></p>
                            <p class="mb-2 font-weight-bold">Stall No.: <span class="font-weight-normal" id="stall-no"></span></p>
                            <p class="mb-2 font-weight-bold">Location: <span class="font-weight-normal" id="stall-location"></span></p>
                            <p class="mb-2 font-weight-bold">Size: <span class="font-weight-normal" id="stall-size"></span></p>
                            <p class="mb-2 h4 font-weight-bold">Fee: <span class="font-weight-normal" id="stall-fee"></span></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    function toggleStallSection(stallname) {
        var section = document.getElementById('stall-section-' + stallname);
        if (section.classList.contains('hide')) {
            section.classList.remove('hide');
        } else {
            section.classList.add('hide');
        }
    }

    function showStallDetails(stall) {
        document.getElementById('stall-img').src = 'img/stalls/' + stall.image;
        document.getElementById('stall-img').alt = stall.stallname + ' Stall';
        document.getElementById('stall-name').textContent = stall.stallname;
        document.getElementById('stall-no').textContent = stall.stallno;
        document.getElementById('stall-location').textContent = stall.location;
        document.getElementById('stall-size').textContent = stall.size;
        document.getElementById('stall-fee').textContent = '₱' + stall.marketfee;
    }

    // Function to filter stalls by selected stallname
    function filterStalls() {
        var selectedStall = document.getElementById('stall-filter').value;
        var stallItems = document.getElementsByClassName('stall-item');

        for (var i = 0; i < stallItems.length; i++) {
            var stallname = stallItems[i].getAttribute('data-stallname');
            if (selectedStall === 'all' || selectedStall === stallname) {
                stallItems[i].style.display = 'block';
            } else {
                stallItems[i].style.display = 'none';
            }
        }
    }

    function filterStalls() {
        var selectedStall = document.getElementById('stall-filter').value;
        var selectedPmarketId = document.getElementById('pmarket-filter').value;
        var stallItems = document.getElementsByClassName('stall-item');

        for (var i = 0; i < stallItems.length; i++) {
            var stallname = stallItems[i].getAttribute('data-stallname');
            var pmarketId = stallItems[i].getAttribute('data-pmarketid');
            var shouldShowStall = (selectedStall === 'all' || selectedStall === stallname);
            var shouldShowPmarket = (selectedPmarketId === 'all' || selectedPmarketId === pmarketId);
            var shouldShow = shouldShowStall && shouldShowPmarket;

            stallItems[i].style.display = shouldShow ? 'block' : 'none';
        }
    }
</script>
