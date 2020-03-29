<?php
require_once('dbconnect.php'); //tables
require_once('server.php');  //sessions and authentication

//session_start();

if (!isset($_SESSION['role'])) {
    header("location: logout.php");
    exit;
}

if ($_SESSION['role'] != 'Admin') {
    if ($_SESSION['role'] != 'Manager') {
        header("location: logout.php");
        exit;
    }
}

require_once('includes/head.php');
?>

<body>

    <div class="container">

        <?php require_once('includes/jumbotron.php') ?>


        <div class="row">
            <?php
            include('includes/searchButton.php')
            ?>
            <div class="col-sm-6">
                <a href="applicant.php"><button id="formUpdateNewAPP" type="button" class="btn btn-secondary btn-sm" style="float:right; margin-right:5px;">New Applicant</button></a>
                <a href="all.php"><button id="allApps" type="button" class="btn btn-secondary btn-sm" style="float:right; margin-right:5px;">All</button></a>
                <a href="newpost.php"><button id="formUpdateNewAPP" type="button" class="btn btn-secondary btn-sm" style="float:right; margin-right:5px;">New Post</button></a>
                <a href="posts.php"><button id="formUpdateNewAPP" type="button" class="btn btn-secondary btn-sm" style="float:right; margin-right:5px;">Posts</button></a>
                <a href="notified.php"><button id="formUpdateNewAPP" type="button" class="btn btn-secondary btn-sm" style="float:right; margin-right:5px;">Notified</button></a>

            </div>

        </div>
        <h3 style="text-align: center;">HORTICULTURE DATABASE</h3>

        <?php
        include('includes/messages.php');
        ?>

        <!--SEARCH-->
        <div class="row">
            <div class="col-sm-12">

                <?php
                //SEARCHING IN THE DATABASE - GET TYPED DATA FROM THE FORM
                if (isset($_POST['btnSearch'])) {
                    $searchKey = $conn->real_escape_string($_POST['search_key']);

                    // QUERY TO SELECT DATA FROM THE DB
                    $resultKey = $conn->query("SELECT * FROM applicant
                    LEFT JOIN businessCategory ON applicant.bCatId = businessCategory.bCatId
                    LEFT JOIN applicantcategory ON applicant.appCatId = applicantcategory.appCatId
                    LEFT JOIN serviceprovider ON applicant.spId = serviceprovider.spId 
                    WHERE appName LIKE '%$searchKey%' OR represName LIKE '%$searchKey%' 
                    OR idNbr LIKE '%$searchKey%' OR phone LIKE '%$searchKey%' ");

                    //Get Search results and Display
                    if ($resultKey->num_rows > 0) {
                        $_SESSION['msgSearch'] = $resultKey->num_rows . " result(s) found!"; ?>

                        <?php
                        include('includes/messages.php');
                        ?>

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>FORM CODE</th>
                                        <th>NAME</th>
                                        <th>APPLICANT CATEGORY</th>
                                        <th>BUSINESS CATEGORY</th>
                                        <th>DISTRICT</th>
                                        <th>ID NUMBER</th>
                                        <th>PHONE</th>
                                        <th>COMMODITY</th>
                                        <th>COST</th>
                                        <th>MARKS</th>
                                        <th>SERVICE PROVIDER</th>
                                        <th colspan="2">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    //OUTPUT SEARCH RESULTS
                                    while ($rows = $resultKey->fetch_assoc()) { ?>

                                        <tr>
                                            <td> <strong style="color:rgb(192, 233, 201);"> <?php echo $rows['formCode']; ?> </strong></td>
                                            <td> <?php echo $rows['appName']; ?> </td>
                                            <td> <?php echo $rows['appCatName']; ?> </td>
                                            <td> <?php echo $rows['bCatName']; ?> </td>
                                            <td> <?php echo $rows['bDistrict']; ?> </td>
                                            <td> <?php echo $rows['idNbr']; ?> </td>
                                            <td> <?php echo $rows['phone']; ?> </td>
                                            <td> <?php echo $rows['crop1']; ?> </td>
                                            <td> <?php echo number_format($rows['totalCost']); ?> </td>
                                            <td> <?php
                                                    if ($rows['marks'] < 55) {
                                                        echo '<b style="color:red;">' . $rows['marks'] . '</b>';
                                                    } else {
                                                        echo '<b style="color:blue;">' . $rows['marks'] . '</b>';
                                                    } ?> </td>
                                            <td> <strong><?php echo $rows['spName']; ?> </strong></td>
                                            <td>
                                                <a class="edit_btn" href="applicant.php?edit=<?php echo $rows['appNo'];  ?>">Edit </a>
                                            </td>
                                            <td>
                                                <a class="del_btn" href="dbconnect.php?del=<?php echo $rows['appNo'];  ?>">Delete </a>
                                            </td>
                                        </tr>

                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>
            </div>
        </div>
<?php
                    } else {
                        //NO RESULTS FOUND
                        $_SESSION['msgZeroNot'] = "Not found!";
                        include('includes/messages.php');
                    }
                } ?>

<button id="tableHide" type="button" class="btn-warning" onclick="document.getElementById('tableData').style.display='none'">Hide the table</button>
<button id="tableHide" type="button" class="btn-info" onclick="document.getElementById('tableData').style.display='block'">Show the table</button>

<div class="row">
    <div class="col-sm-12">

        <div class="table-responsive">
            <table id="tableData" class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>FORM CODE</th>
                        <th>NAME</th>
                        <th>APPLICANT CATEGORY</th>
                        <th>BUSINESS CATEGORY</th>
                        <th>DISTRICT</th>
                        <th>ID NUMBER</th>
                        <th>PHONE</th>
                        <th>COMMODITY</th>
                        <th>COST</th>
                        <th>MARKS</th>
                        <th>SERVICE PROVIDER</th>
                        <th colspan="2">ACTION</th>
                    </tr>
                </thead>

                <tbody>

                    <?php

                    if ($result->num_rows > 0) {
                        //output data of each row
                        while ($row = $result->fetch_assoc()) { ?>

                            <tr>
                                <td> <strong style="color:rgb(192, 233, 201);"> <?php echo $row['formCode']; ?> </strong></td>
                                <td> <?php echo $row['appName']; ?> </td>
                                <td> <?php echo $row['appCatName']; ?> </td>
                                <td> <?php echo $row['bCatName']; ?> </td>
                                <td> <?php echo $row['bDistrict']; ?> </td>
                                <td> <?php echo $row['idNbr']; ?> </td>
                                <td> <?php echo $row['phone']; ?> </td>
                                <td> <?php echo $row['crop1']; ?> </td>
                                <td> <?php echo number_format($row['totalCost']); ?> </td>
                                <td> <?php
                                        if ($row['marks'] < 55) {
                                            echo '<b style="color:red;">' . $row['marks'] . '</b>';
                                        } else {
                                            echo '<b style="color:blue;">' . $row['marks'] . '</b>';
                                        } ?> </td>
                                <td> <strong><?php echo $row['spName']; ?> </strong></td>
                                <td>
                                    <a class="edit_btn" href="applicant.php?edit=<?php echo $row['appNo'];  ?>">Edit </a>
                                </td>
                                <td>
                                    <a class="del_btn" href="dbconnect.php?del=<?php echo $row['appNo'];  ?>">Delete </a>
                                </td>
                            </tr>
                    <?php }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include('includes/footer.php');
?>
    </div>

</body>

</html>