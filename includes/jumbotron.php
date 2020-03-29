<div class="jumbotron bg-info row" style="padding: 40px">

    <div class="col-sm-6">
        <h2>Welcome <br>
            <?php
            if (isset($_SESSION['first'])) {
                echo $_SESSION['first'];
            }
            ?></h2>
    </div>
    <div class="col-sm-2">
    </div>
    <div class="col-sm-2">

        <div class="card" style="width:100%; background-color:lightgray">
            <a href="profileUpdate.php?edit=<?php echo $_SESSION['useridentity'] ?>" data-toggle="tooltip" title="Update your picture!"> <img class="card-img-top rounded" width="104" height="106" <?php

                                                                                                                                                                                                    $servername = "localhost";
                                                                                                                                                                                                    $username = "root";
                                                                                                                                                                                                    $password = "";
                                                                                                                                                                                                    $dbname = "hort_db";

                                                                                                                                                                                                    $imgIDUser = $_SESSION['useridentity'];

                                                                                                                                                                                                    $imgDBQuery = "SELECT * FROM tblUser WHERE u_id = '$imgIDUser' ";

                                                                                                                                                                                                    $resultImg = $conn->query($imgDBQuery);

                                                                                                                                                                                                    //COUNTING THE NUMBER OF ROWS RETURNED
                                                                                                                                                                                                    if ($resultImg->num_rows == 1) {
                                                                                                                                                                                                        //output row
                                                                                                                                                                                                        while ($rowImg = $resultImg->fetch_assoc()) {

                                                                                                                                                                                                            if (isset($rowImg['profile_image'])) {
                                                                                                                                                                                                                $img = $rowImg['profile_image'];
                                                                                                                                                                                                                echo 'src="data:image/jpeg;base64,' . base64_encode($img) . '"';
                                                                                                                                                                                                            }
                                                                                                                                                                                                        }
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?>></a>

            <script>
                $(document).ready(function() {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            </script>

            <h6 style="color:blue; text-align:center"><small class="card-title">(<?php
                                                                                    if (isset($_SESSION['role'])) {
                                                                                        echo $_SESSION['role'];
                                                                                    } ?>)</small></h6>
        </div>

    </div>

    <div class="col-sm-2">
        <a href="logout.php"><button style="float:right;" type="button" class="btn btn-outline-danger">Logout</button></a>
    </div>
</div>