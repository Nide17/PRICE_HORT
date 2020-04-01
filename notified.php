<?php
//session for msg display
require_once('dbconnect.php');
require_once('server.php');

if (!isset($_SESSION['role'])) {
    header("location: logout.php");
    exit;
}

if ($_SESSION['role'] != 'Admin') {
    if ($_SESSION['role'] != 'Manager') {
        if ($_SESSION['role'] != 'Employee') {
            header("location: logout.php");
            exit;
        }
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
                <?php if ($_SESSION['role'] == 'Admin') {  ?>
                    <a href="admin.php"><button style="float:right; margin-right:5px;" id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                    <a href="homepage.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                    <a href="newpost.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Add Post</button></a>
                    <a href="posts.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Posts</button></a>
                    <a href="locations/locationsNotified.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">By location</button></a>
                    <br>
                <?php } elseif ($_SESSION['role'] == 'Manager') { ?>
                    <a href="admin.php"><button style="float:right; margin-right:5px;" id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                    <a href="homepage.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                    <a href="newpost.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Add Post</button></a>
                    <a href="posts.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Posts</button></a>
                    <a href="locations/locationsNotified.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">By location</button></a>
                    <br>
                <?php } else { ?>
                    <a href="posts.php"><button style="float:right; margin-right:5px;" id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                    <a href="all.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">All Applicants</button></a>
                    <a href="homepage.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                    <a href="locations/locationsNotified.php"><button style="float:right; margin-right:5px;" id="" type="button" class="btn-success btn-sm">By location</button></a>
                <?php } ?>
            </div>
        </div>

        <h3 style="text-align: center;">PRICE GRANT BENEFICIARIES</h3>

        <!--SEARCH-->

        <?php
        //SEARCHING IN THE DATABASE - GET TYPED DATA FROM THE FORM
        if (isset($_POST['btnSearch'])) {
            $searchKey = $conn->real_escape_string($_POST['search_key']);

            // QUERY TO SELECT NOTIFIED FROM THE DB
            $resultKey = $conn->query("SELECT * FROM notified
                    LEFT JOIN applicantcategory ON notified.appCatId = applicantcategory.appCatId
                    LEFT JOIN businesscategory ON notified.bCatId = businesscategory.bCatId 
                    WHERE Nname LIKE '%$searchKey%' OR pfi LIKE '%$searchKey%' 
                    OR commodity LIKE '%$searchKey%' OR phone LIKE '%$searchKey%' ");

            //Get Search results and Display
            if ($resultKey->num_rows > 0) {

                $_SESSION['msgSearch'] = $resultKey->num_rows . " result(s) found!";
                include('includes/messages.php');
        ?>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-sm w-auto">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>NO</th>
                                        <th>NAME</th>
                                        <th>APPLICANT CATEGORY</th>
                                        <th>BUSINESS CATEGORY</th>
                                        <th>PROVINCE</th>
                                        <th>DISTRICT</th>
                                        <th>SECTOR</th>
                                        <th>SEX</th>
                                        <th>PHONE</th>
                                        <th>COMMIDITY</th>
                                        <th>LOAN</th>
                                        <th>GRANT</th>
                                        <th>FINANCIAL INSTITUTION</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    //OUTPUT SEARCH RESULTS
                                    while ($rows = $resultKey->fetch_assoc()) { ?>

                                        <tr>
                                            <td> <strong style="color:rgb(192, 233, 201);"> <?php echo $rows['notID']; ?> </strong></td>
                                            <td> <?php echo $rows['Nname']; ?> </td>
                                            <td> <?php echo $rows['appCatName']; ?> </td>
                                            <td> <?php echo $rows['bCatName']; ?> </td>
                                            <td> <?php echo $rows['province']; ?> </td>
                                            <td> <?php echo $rows['district']; ?> </td>
                                            <td> <?php echo $rows['sector']; ?> </td>
                                            <td> <?php echo $rows['sex']; ?> </td>
                                            <td> <?php echo $rows['phone']; ?> </td>
                                            <td> <?php echo $rows['commodity']; ?> </td>
                                            <td> <?php echo number_format($rows['loan']); ?> </td>
                                            <td> <strong><?php echo number_format($rows['granted']); ?> </strong></td>
                                            <td> <?php echo $rows['pfi']; ?> </td>
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
        }

        if ($resultNotified->num_rows > 0) { ?>

            <div class="row">
                <div class="col-sm-12">
                    <!--displaying 50 database data-->

                    <div class="table-responsive">
                        <table id="tableData" class="table table-sm w-auto">
                            <thead class="thead-dark">
                                <tr>
                                    <th>NO</th>
                                    <th>NAME</th>
                                    <th>APPLICANT CATEGORY</th>
                                    <th>BUSINESS CATEGORY</th>
                                    <th>DISTRICT</th>
                                    <th>SECTOR</th>
                                    <th>SEX</th>
                                    <th>PHONE</th>
                                    <th>COMMIDITY</th>
                                    <th>LOAN</th>
                                    <th>GRANT</th>
                                    <th>FINANCIAL INSTITUTION</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php

                                //output data 50 rows (query from dbconnect.php)
                                $sum_cost = 0;
                                while ($row = $resultNotified->fetch_assoc()) { ?>
                                    <tr>
                                        <td> <strong style="color:rgb(192, 233, 201);"> <?php echo $row['notID']; ?> </strong></td>
                                        <td> <?php echo $row['Nname']; ?> </td>
                                        <td> <?php echo $row['appCatName']; ?> </td>
                                        <td> <?php echo $row['bCatName']; ?> </td>
                                        <td> <?php echo $row['district']; ?> </td>
                                        <td> <?php echo $row['sector']; ?> </td>
                                        <td> <?php echo $row['sex']; ?> </td>
                                        <td> <?php echo $row['phone']; ?> </td>
                                        <td> <?php echo $row['commodity']; ?> </td>
                                        <td> <?php echo number_format($row['loan']); ?> </td>
                                        <td> <strong><?php echo number_format($row['granted']); ?> </strong></td>
                                        <td> <?php echo $row['pfi']; ?> </td>
                                    </tr>
                                <?php
                                    $sum_cost += $row['granted'];
                                }
                                ?>
                                <tr class="text-center table-warning font-weight-bold text-info">
                                    <td colspan="10">
                                        <h6>TOTAL GRANT</h6>
                                    </td>
                                    <td>
                                        <?php echo "<h6>" . number_format($sum_cost) . "</h6>"; ?>
                                    </td>
                                    <td></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php
        } else {
            $_SESSION['msgSearchZero'] = " No results found!";
            include('../includes/messages.php');
        }
        include('includes/footer.php');
        ?>
    </div>

</body>

</html>