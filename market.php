
<?php
    session_start();
    $_SESSION['actib'] = 'market';
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
                border-top: 2px solid #c33a08;
            }
        </style>

    <div class="bg-light-gray mb-5 p-3 rounded">
        
            <h3 class="fw-bold">Market</h3><br>
        
                <?php
                    if(isset($_GET['action'])){
                        echo '<center><small><div class="text-start alert alert-'.$_GET['action'].' alert-dismissible fade show" role="alert">
                            <strong>';
                            if($_GET['action'] == 'danger')
                                echo '<i class="fa-solid fa-trash"></i>&nbsp;  Public market  has been deleted !';
                            elseif($_GET['action'] == 'warning')
                                echo '<i class="fa-solid fa-user-pen"></i>&nbsp;  Public market has been updated !';
                        echo '</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div></small></center>';
                    }
                ?>     
        
        <?php
            $sql = "SELECT * FROM market ORDER BY market_name ASC;";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
        ?>

            <form action="" method="post">
                <button type="submit" formaction="market.php" class="btn btn-success btn-sm" ><i class="fa-solid fa-arrow-rotate-right"></i><small> Refresh</small></button>
                <button type="submit" formaction="add_market.php" class="btn btn-secondary btn-sm" ><i class='fas fa-store-alt nav_icon'></i><small> Add market</small></button>
            </form><hr>
        <div class="table-responsive p-3 bg-light-gray mb-3 bord border-4 shadow-sm rounded">
        <table id="myDataTable" class="table custom-table table-hover table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Market name</th>
                    <th><small>Edit</small></th>
                    <th><small>Delete</small></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 0;
                    if($resultCheck > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo '<tr>';
                                echo '<td class="fw-bold">'.++$no.'.</td>';
                                echo '<td>'.$row['market_name'].'</td>';
                                echo '<td class="text-center"><a href="add_market.php?editMarket='.$row['market_id'].'" class="btn btn-warning btn-sm rounded"><i class="fa-solid fa-pen-to-square"></i></a></td>';
                                echo '<td class="text-center"><a href="includes/process.php?deleteMarket='.$row['market_id'].'" class="btn btn-danger btn-sm rounded"><i class="fa-solid fa-trash"></i></a></td>';
                            echo '</tr>';
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
         </div>
</div>

<!--Container Main end-->

<?php
    require 'footer1.php';
?>