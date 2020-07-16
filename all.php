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

//for total count of data
$countSql = "SELECT COUNT(appNo) FROM applicant";
$tot_result = $conn->query($countSql);

$limit = 249;

$row = $tot_result->fetch_row();
$total_records = $row[0];
$total_pages = ceil($total_records / $limit);

include('includes/head.php');
?>

<body>

    <div class="container">

        <?php include('includes/jumbotron.php') ?>

        <div class="row">
            <?php
            include('includes/searchButton.php')
            ?>

            <div class="col-12 col-sm-12 col-lg-6 top-buttons">
                <?php if ($_SESSION['role'] == 'Admin') {  ?>
                    <a href="admin.php"><button id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                    <a href="homepage.php"><button id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                    <a href="newpost.php"><button id="" type="button" class="btn-success btn-sm">Add Post</button></a>
                    <a href="posts.php"><button id="" type="button" class="btn-success btn-sm">Posts</button></a>
                    <a href="locations/locations.php"><button id="" type="button" class="btn-success btn-sm">By location</button></a>
                    <br>
                <?php } elseif ($_SESSION['role'] == 'Manager') { ?>
                    <a href="admin.php"><button id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                    <a href="homepage.php"><button id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                    <a href="newpost.php"><button id="" type="button" class="btn-success btn-sm">Add Post</button></a>
                    <a href="posts.php"><button id="" type="button" class="btn-success btn-sm">Posts</button></a>
                    <a href="locations/locations.php"><button id="" type="button" class="btn-success btn-sm">By location</button></a>
                    <br>
                <?php } elseif ($_SESSION['role'] == 'Employee') { ?>
                    <a href="homepage.php"><button id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                    <a href="posts.php"><button id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                    <a href="locations/locations.php"><button id="" type="button" class="btn-success btn-sm">By location</button></a>
                    <br>
                <?php } else { ?>
                    <a href="homepage.php"><button id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                <?php } ?>
            </div>
        </div>
        <br><br>
        <h3 class="titles">HORTICULTURE DATABASE</h3>
        <!--SEARCH-->

        <?php
        require_once('dbconnect.php');

        //SEARCHING IN THE DATABASE - GET TYPED DATA FROM THE FORM
        if (isset($_POST['btnSearch'])) {
            $searchKey = $conn->real_escape_string($_POST['search_key']);

            // QUERY TO SELECT DATA FROM THE DB
            $resultKey = $conn->query("SELECT * FROM applicant
                    LEFT JOIN businesscategory ON applicant.bCatId = businesscategory.bCatId
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
                            <table class="table table-sm w-auto">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="onSmall-hide">FORM CODE</th>
                                        <th>NAME</th>
                                        <th class="onSmall-hide">APPLICANT CATEGORY</th>
                                        <th class="onSmall-hide">BUSINESS CATEGORY</th>
                                        <th>DISTRICT</th>
                                        <th class="onSmall-hide">ID NUMBER</th>
                                        <th class="onSmall-hide">PHONE</th>
                                        <th>COMMODITY</th>
                                        <th class="onSmall-hide">COST</th>
                                        <th>MARKS</th>
                                        <th>SERVICE PROVIDER</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    //OUTPUT SEARCH RESULTS
                                    while ($rows = $resultKey->fetch_assoc()) { ?>

                                        <tr>
                                            <td class="onSmall-hide"> <strong style="color:rgb(192, 233, 201);"> <?php echo $rows['formCode']; ?> </strong></td>
                                            <td> <?php echo $rows['appName']; ?> </td>
                                            <td class="onSmall-hide"> <?php echo $rows['appCatName']; ?> </td>
                                            <td class="onSmall-hide"> <?php echo $rows['bCatName']; ?> </td>
                                            <td> <?php echo $rows['bDistrict']; ?> </td>
                                            <td class="onSmall-hide"> <?php echo $rows['idNbr']; ?> </td>
                                            <td class="onSmall-hide"> <?php echo $rows['phone']; ?> </td>
                                            <td> <?php echo $rows['crop1']; ?> </td>
                                            <td class="onSmall-hide"> <?php echo number_format($rows['totalCost']); ?> </td>
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

        <div id="myTable" class="row">
            <?php
            //The table will be loaded here
            ?>
        </div>

        <!--Loading the first time table-->
        <script type="text/javascript">
            jQuery("#myTable").load("table.php?page=1");
        </script>

        <!--List of pages number-->
        <ul class="pagination" id="pagination">
            <?php
            if (!empty($total_pages)) : for ($i = 1; $i <= $total_pages; $i++) :
                    if ($i == 1) : ?>
                        <li class='page-item active' id="<?php echo $i; ?>"><a href='table.php?page=<?php echo $i; ?>' class="page-link"><?php echo $i; ?></a></li>
                    <?php else : ?>
                        <li id="<?php echo $i; ?>" class="page-item"><a href='table.php?page=<?php echo $i; ?>' class="page-link"><?php echo $i; ?></a></li>
                    <?php endif; ?>
            <?php endfor;
            endif; ?>
        </ul>

        <!--Loading the specific table of clicked list number-->
        <script>
            jQuery("#pagination li").on('click', function(e) {
                e.preventDefault();
                jQuery("#myTable").html('<b style="color: green;">Loading...<b>');
                jQuery("#pagination li").removeClass('active');
                jQuery(this).addClass('active');
                var pageNum = this.id;
                jQuery("#myTable").load("table.php?page=" + pageNum);
            });
        </script>

        <?php
        include('includes/footer.php');
        ?>
    </div>

</body>

</html>