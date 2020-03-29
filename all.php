<?php
//session for msg display
include('dbconnect.php');
include('server.php');

if (!isset($_SESSION['role'])) {
    header("location: logout.php");
    exit;
}

if ($_SESSION['role'] != 'Admin') {
    if ($_SESSION['role'] != 'Manager') {
        if ($_SESSION['role'] != 'Employee') {
            if ($_SESSION['role'] != 'User') {
                header("location: logout.php");
                exit;
            }
        }
    }
}

include('includes/head.php');
?>

<body>

    <div class="container">

        <?php include('includes/jumbotron.php') ?>

        <div class="row">
            <?php
            include('includes/searchButton.php')
            ?>

            <div class="col-sm-6">
                <?php if ($_SESSION['role'] == 'Admin') {  ?>
                    <a href="admin.php"><button style="float:right; margin-right:5px;" id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                    <a href="homepage.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                    <a href="newpost.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Add Post</button></a>
                    <a href="posts.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Posts</button></a>
                    <a href="locations/locations.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">By location</button></a>
                    <br>
                <?php } elseif ($_SESSION['role'] == 'Manager') { ?>
                    <a href="admin.php"><button style="float:right; margin-right:5px;" id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                    <a href="homepage.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                    <a href="newpost.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Add Post</button></a>
                    <a href="posts.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Posts</button></a>
                    <a href="locations/locations.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">By location</button></a>
                    <br>
                <?php } elseif ($_SESSION['role'] == 'Employee') { ?>
                    <a href="homepage.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                    <a href="posts.php"><button style="float:right; margin-right:5px;" id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                    <a href="locations/locations.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">By location</button></a>
                    <br>
                <?php } else { ?>
                    <a href="homepage.php"><button style="float:right; margin-right:5px;" id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                <?php } ?>
            </div>
        </div>

        <h3 style="text-align: center;">HORTICULTURE DATABASE</h3>
        <!--SEARCH-->

        <?php
        require_once('dbconnect.php');

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

                $_SESSION['msgSearch'] = $resultKey->num_rows . " result(s) found!";
                include('includes/messages.php');
        ?>

                <div class="row">
                    <div class="col-sm-12">
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
                                            <?php
                                            if ($rows['marks'] < 55) {

                                                echo '<td> <b style="color:red;">' . $rows['marks'] . '</b></td><td></td> ';
                                            } else {
                                                echo '<td><b style="color:green;">' . $rows['marks'] . '</b></td>'; ?>

                                                <td> <strong><?php echo $rows['spName'];
                                                            } ?> </strong></td>
                                        </tr>



                                    <?php } ?>
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

        <div class="row">
            <div class="col-sm-12">
                <!--displaying 50 database data-->

                <div class="table-responsive">
                    <table id="tableData" class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>FORM CODE</th>
                                <th>NAME</th>
                                <th>APPLICANT CATEGORY</th>
                                <th>BUSINESS CATEGORY</th>
                                <th>ID NUMBER</th>
                                <th>PHONE</th>
                                <th>COMMODITY</th>
                                <th>COST</th>
                                <th>MARKS</th>
                                <th>SERVICE PROVIDER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            if ($result->num_rows > 0) {
                                //output data 50 rows (query from dbconnect.php)
                                while ($row = $result->fetch_assoc()) { ?>

                                    <tr>
                                        <td> <strong style="color:rgb(192, 233, 201);"> <?php echo $row['formCode']; ?> </strong></td>
                                        <td> <?php echo $row['appName']; ?> </td>
                                        <td> <?php echo $row['appCatName']; ?> </td>
                                        <td> <?php echo $row['bCatName']; ?> </td>
                                        <td> <?php echo $row['idNbr']; ?> </td>
                                        <td> <?php echo $row['phone']; ?> </td>
                                        <td> <?php echo $row['crop1']; ?> </td>
                                        <td> <?php echo number_format($row['totalCost']); ?> </td>
                                        <?php
                                        if ($row['marks'] < 55) {
                                            echo '<td><b style="color:red;">' . $row['marks'] . '</b></td><td></td>';
                                        } else {
                                            echo '<td><b style="color:green;">' . $row['marks'] . '</b></td>';
                                        ?>
                                            <td> <strong><?php echo $row['spName'];
                                                        } ?> </strong></td>
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