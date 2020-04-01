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
        <div class="col-sm-10">
        <h3 style="text-align: center;">NEW POSTS</h3>

            <section class="list-group">
                <?php
                // RETRIEVE DATA FROM posts
                $sqlRetrievePosts = "SELECT * FROM posts ORDER BY postTime DESC LIMIT 2;";
                $resultPosts = $conn->query($sqlRetrievePosts);

                if ($resultPosts->num_rows > 0) {
                    //output data 50 rows (query from dbposts.php)
                    while ($row = $resultPosts->fetch_assoc()) { ?>

                        <article class="list-group-item" style="margin-bottom: 5px;">
                            <h5><?php echo $row['title']; ?></h5>
                            <p><?php echo $row['content']; ?></p>
                        </article>

                            <div class="row" style="margin-bottom: 5px;">
                                <div class="col-sm-11 offset-sm-1 text-right">
                                    <small style="margin:0px 50px 10px 0px;"><?php echo $row['postTime']; ?> : <?php echo $row['postCreator']; ?></small>
                                </div>
                            </div>

                <?php }
                }
                ?>
            </section>
            <button type="button" class="btn btn-outline-info btn-sm"><a href="posts.php">View more posts</a></button>
            
        </div>
        <div class="col-sm-2">
        <h3 style="text-align: center;">LINKS</h3>
            <a href="applicant.php"><button id="formUpdateNewAPP" type="button" class="btn btn-secondary btn-sm" style="margin-left:20px;">New Applicant</button></a>
            <br><br>
                <a href="all.php"><button id="allApps" type="button" class="btn btn-secondary btn-sm" style="margin-left:20px;">All Applicants</button></a>
                <br><br>
                <a href="newpost.php"><button id="formUpdateNewAPP" type="button" class="btn btn-secondary btn-sm" style="margin-left:20px;">New Post</button></a>
                <br><br>
                <a href="posts.php"><button id="formUpdateNewAPP" type="button" class="btn btn-secondary btn-sm" style="margin-left:20px;">More Posts</button></a>
                <br><br>
                <a href="notified.php"><button id="formUpdateNewAPP" type="button" class="btn btn-secondary btn-sm" style="margin-left:20px;">All Notified</button></a>

            </div>
        </div>

        <br><br>
        <h3 style="text-align: center;">HORTICULTURE DATABASE</h3>

        <?php
        include('includes/messages.php');
        ?>

<button id="tableHide" type="button" class="btn-warning" onclick="document.getElementById('tableData').style.display='none'">Hide the table</button>
<button id="tableHide" type="button" class="btn-info" onclick="document.getElementById('tableData').style.display='block'">Show the table</button>

<div class="row">
    <div class="col-sm-12">

        <div class="table-responsive">
            <table id="tableData" class="table datatable table-sm w-auto">
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
<a href="all.php"><button id="" type="button" class="btn btn-outline-warning btn-sm btn-block" style="margin-top:0px;">Click here to view more</button></a>

<br><br>
<h3 style="text-align: center;">NOTIFIED APPLICANTS</h3>

<button id="tableHide" type="button" class="btn-warning" onclick="document.getElementById('tableData1').style.display='none'">Hide the table</button>
<button id="tableHide" type="button" class="btn-info" onclick="document.getElementById('tableData1').style.display='block'">Show the table</button>

<div class="row">
                <div class="col-sm-12">
                    <!--displaying 50 database data-->

                    <div class="table-responsive">
                        <table id="tableData1" class="table table-sm w-auto">
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
                                while ($row = $resultNotified10->fetch_assoc()) { ?>
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
                                        <h6>TOTAL FOR 10 PEOPLE WITH HIGHER GRANT</h6>
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
            <a href="notified.php"><button id="" type="button" class="btn btn-outline-success btn-sm btn-block" style="margin-top:0px;">Click here to view more</button></a>


<?php
include('includes/footer.php');
?>
    </div>

</body>

</html>