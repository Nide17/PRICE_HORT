<?php
//session for msg display
require_once('../dbconnect.php');
require_once('../server.php');

if (!isset($_SESSION['role'])) {
    header("location: ../logout.php");
    exit;
}

if ($_SESSION['role'] != 'Admin') {
    if ($_SESSION['role'] != 'Manager') {
        if ($_SESSION['role'] != 'Employee') {
            header("location: ../logout.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRICE Horticulture App</title>

    <link rel="stylesheet" type="text/css" href="../bootstrap_4.3.1_dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap_4.3.1_dist/css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico" />
    <link rel="stylesheet" href="../bootstrap_4.3.1_dist/css/font-awesome-4.7.0/css/font-awesome.min.css">
</head>

<body>

    <div class="container">

        <!-- jumbotron -->
        <div class="jumbotron bg-info" style="padding: 40px">
            <div class="row jumbotron-row">
                <div class="col-12 col-sm-12 col-lg-8">
                    <h2>Welcome <br>
                        <?php
                        if (isset($_SESSION['first'])) {
                            echo $_SESSION['first'];
                        }
                        ?></h2>
                </div>
                <div class="col-6 col-sm-4 col-lg-2">

                    <div class="card" style="width:100%; background-color:lightgray">
                        <a href="../profileUpdate.php?edit=<?php echo $_SESSION['useridentity'] ?>" data-toggle="tooltip" title="Update your picture!"> <img class="card-img-top rounded" width="104" height="106" <?php

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

                <div class="col-3 col-sm-2 col-lg-2 logout">
                    <a href="../logout.php"><button style="float:right;" type="button" class="btn btn-outline-danger">Logout</button></a>
                </div>
            </div>
        </div>
        <!-- end jumbotron -->
        <div class="col-12 col-sm-6 top-buttons">
            <?php if ($_SESSION['role'] == 'Admin') {  ?>
                <a href="../admin.php"><button id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                <a href="../homepage.php"><button id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                <a href="../newpost.php"><button id="" type="button" class="btn-success btn-sm">Add Post</button></a>
                <a href="../notified.php"><button id="" type="button" class="btn-success btn-sm">Granted</button></a>
                <br>
            <?php } elseif ($_SESSION['role'] == 'Manager') { ?>
                <a href="../admin.php"><button id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                <a href="../homepage.php"><button id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                <a href="../newpost.php"><button id="" type="button" class="btn-success btn-sm">Add Post</button></a>
                <a href="../notified.php"><button id="" type="button" class="btn-success btn-sm">Granted</button></a>
                <br>
            <?php } else { ?>
                <a href="../notified.php"><button id="backHome" type="button" class="btn-success btn-sm">Granted</button></a>
                <a href="../all.php"><button id="" type="button" class="btn-success btn-sm">All Applicants</button></a>
                <a href="../homepage.php"><button id="" type="button" class="btn-success btn-sm">Homepage</button></a>
            <?php } ?>
        </div>

        <h3 class="titles" style="color:#1B4F72;">VIEW NOTIFIED BY LOCATION</h3>

        <div class="row">

            <div class="col-sm-3"></div>
            <div class="col-sm-7" style="padding:20px;">


                <form style="background:rgb(165, 176, 189); border-radius:10px" name="provdis" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">

                    <br>

                    <table style="background:rgb(165, 176, 189); width:90%; font-size:15px">

                        <tr>
                            <td style="background:rgb(165, 176, 189);"><strong style="margin-left: 20px;">Select Province</strong></td>
                            <td><select style="padding:5px 10px; background-color:#EAEDED; width: 100%; border-radius: 4px; border:2px solid #F9F904;" name="provinces" id="provinced" onChange="change_province()">
                                    <option style="text-align:center;">-- Click to select a Province --</option>
                                    <?php
                                    $res = $conn->query("SELECT * FROM provinces");
                                    while ($row = $row = $res->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $row["pid"]; ?>"> <?php echo $row["pname"]; ?> </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td style="background:rgb(165, 176, 189);"><strong style="margin-left: 20px;">Select District</strong></td>

                            <td>
                                <div id="dID">
                                    <select style="padding:5px 10px; background-color:#EAEDED; width: 100%; border-radius: 4px; border:2px solid #F9F904;" name="districts">
                                        <option name="districts">-- Click to select a District --</option>
                                    </select>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="background:rgb(165, 176, 189);"><strong style="margin-left: 20px;">Select Sector</strong></td>
                            <td>
                                <div id="sID">
                                    <select style="padding:5px 10px; background-color:#EAEDED; width: 100%; border-radius: 4px; border:2px solid #F9F904;" name="sectors">
                                        <option name="sectors">-- Click to select a Sector --</option>
                                    </select>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input style="float:left; margin: 20px;" class="btn btn-primary" name="btnFetch" type="submit" value="View" />
                                <input style="float:right; margin: 20px;" class="btn btn-primary" name="Submit3" type="reset" value="Reset" /></td>
                        </tr>

                    </table>
                </form>


                <script type="text/javascript">
                    function change_province() {

                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.open("GET", "ajaxDB.php?province=" + document.getElementById("provinced").value, false);
                        xmlhttp.send(null);
                        document.getElementById("dID").innerHTML = xmlhttp.responseText;
                    }

                    function change_district() {
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.open("GET", "ajaxDB.php?district=" + document.getElementById("districtd").value, false);
                        xmlhttp.send(null);
                        document.getElementById("sID").innerHTML = xmlhttp.responseText;
                    }
                </script>

            </div>

            <div class="col-sm-2"></div>

        </div>


        <!--FETCH RESULTS-->

        <div class="row">
            <div class="col-sm-12">

                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "hort_db";
                $conn = new mysqli($servername, $username, $password, $dbname);
                //check connection
                if ($conn->connect_error) {
                    die("Can not connect" . $conn->connect_error);
                }

                //fetchING IN THE DATABASE - GET TYPED DATA FROM THE FORM
                if (isset($_POST['btnFetch'])) {

                    //fetch keys
                    $pro = $_POST["provinces"];
                    $dis = $_POST["districts"];
                    $sec = $_POST["sectors"];

                    //Setting database fetch results variables to null (empty)
                    $prov = NULL;
                    $dist = NULL;
                    $secs = NULL;

                    if ($pro != "") {

                        $loca = $conn->query("SELECT pname FROM provinces WHERE pid='$pro'");
                        while ($rows = $loca->fetch_assoc()) {

                            echo "<br/> <br/> <b style=" . "margin-left:35%;". "> You have selected to display info from: " .$rows["pname"] ."</b>";
                            $prov = $rows["pname"];
                        }
                    }

                    if ($dis != "") {

                        $loca = $conn->query("SELECT dname FROM districts WHERE did='$dis'");
                        while ($rows = $loca->fetch_assoc()) {

                            echo ", <b>" . $rows["dname"] ."</b>";
                            $dist = $rows["dname"];
                        }
                    }

                    if ($sec != "") {

                        $loca = $conn->query("SELECT sname FROM sectors WHERE sid='$sec'");
                        while ($rows = $loca->fetch_assoc()) {

                            echo ", <b>" . $rows["sname"] ."</b>";
                            $secs = $rows["sname"];
                        }
                    }

                    //IF ALL LOCATIONS ARE SET
                    if ($prov != "" && $dist != ""  && $secs != "") {

                        $fetchResult = $conn->query("SELECT * FROM notified
                    LEFT JOIN businesscategory ON notified.bCatId = businesscategory.bCatId
                    LEFT JOIN applicantcategory ON notified.appCatId = applicantcategory.appCatId  
                    WHERE province='$prov' AND district='$dist' AND sector='$secs'");
                ?>
                        <br />
                        <?php
                        //Get results and Display                       

                        if ($fetchResult->num_rows > 0) {
                            $_SESSION['msgSearchloc'] = $fetchResult->num_rows . " result(s) found!";
                            include('../includes/messages.php');
                        ?>

                            <div class="table-responsive">
                                <table class="table table-sm w-auto" id="locationTable">
                                    <thead class="thead-dark">
                                        <tr style="font-style:inherit">
                                            <th class="onSmall-hide">NO</th>
                                            <th>NAME</th>
                                            <th class="onSmall-hide">BUSINESS CATEGORY</th>
                                            <th class="onSmall-hide">COMPONENT</th>
                                            <th>DISTRICT</th>
                                            <th class="onSmall-hide">TELEPHONE</th>
                                            <th>SEX</th>
                                            <th class="onSmall-hide">YOUTH</th>
                                            <th>BUSINESS COMMODITY</th>
                                            <th class="onSmall-hide">LOAN AMOUNT </th>
                                            <th>GRANT</th>
                                            <th>FINANCIAL INSTITUTION</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    //OUTPUT 
                                    $i = 1;
                                    $sum_cost = 0;
                                    while ($rows = $fetchResult->fetch_assoc()) { ?>
                                        <tbody>
                                            <tr>
                                                <td class="onSmall-hide"> <?php echo $i; ?> </td>
                                                <td> <strong><?php echo $rows['Nname']; ?> </strong></td>
                                                <td class="onSmall-hide" d> <?php echo $rows['appCatName']; ?> </td>
                                                <td class="onSmall-hide"> <?php echo $rows['bCatName']; ?> </td>
                                                <td> <?php echo $rows['district']; ?> </td>
                                                <td class="onSmall-hide"> <?php echo $rows['phone']; ?> </td>
                                                <td> <?php echo $rows['sex']; ?> </td>
                                                <td class="onSmall-hide"> <?php echo $rows['youth']; ?> </td>
                                                <td> <?php echo $rows['commodity']; ?> </td>
                                                <td class="onSmall-hide"> <?php echo number_format($rows['loan']); ?> </td>
                                                <td> <?php echo number_format($rows['granted']); ?> </td>
                                                <td> <?php echo $rows['pfi']; ?> </td>
                                            </tr>

                                        <?php $i++;
                                        $sum_cost += $rows['granted'];
                                    }
                                        ?>
                                        <tr class="text-center table-warning font-weight-bold text-info onSmall-hide">
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

                            <button onclick="exportexcel()" class="btn btn-outline-warning" style="float:right;">Download as Ms Excel</button>

                        <?php
                        } else {
                            $_SESSION['msgSearchZero'] = " No results found!";
                            include('../includes/messages.php');
                        }

                        if (!isset($fetchResult)) {
                        ?>

                            <script type="text/javascript">
                                alert("Failed!");
                                history.go(1);
                            </script>
                        <?php
                            //echo"yes";
                        }
                    }


                    //IF SEC IS NOT SET
                    elseif ($prov != "" && $dist != "" && empty($secs)) {

                        $fetchResult = $conn->query("SELECT * FROM notified
                    LEFT JOIN businesscategory ON notified.bCatId = businesscategory.bCatId
                    LEFT JOIN applicantcategory ON notified.appCatId = applicantcategory.appCatId  
                    WHERE province='$prov' AND district='$dist'");
                        ?>

                        <br />

                        <?php
                        //Get results and Display

                        if ($fetchResult->num_rows > 0) {
                            $_SESSION['msgSearchloc'] = $fetchResult->num_rows . " result(s) found!";
                            include('../includes/messages.php'); ?>

                            <div class="table-responsive">
                                <table class="table table-sm w-auto" id="locationTable">
                                    <thead class="thead-dark">
                                        <tr style="font-style:inherit">
                                            <th class="onSmall-hide">NO</th>
                                            <th>NAME</th>
                                            <th class="onSmall-hide">BUSINESS CATEGORY</th>
                                            <th class="onSmall-hide">COMPONENT</th>
                                            <th>DISTRICT</th>
                                            <th class="onSmall-hide">TELEPHONE</th>
                                            <th>SEX</th>
                                            <th class="onSmall-hide">YOUTH</th>
                                            <th>BUSINESS COMMODITY</th>
                                            <th class="onSmall-hide">LOAN AMOUNT </th>
                                            <th>GRANT</th>
                                            <th>FINANCIAL INSTITUTION</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    //OUTPUT 
                                    $i = 1;
                                    $sum_cost = 0;
                                    while ($rows = $fetchResult->fetch_assoc()) { ?>

                                        <tbody>
                                            <tr>
                                                <td class="onSmall-hide"> <?php echo $i; ?> </td>
                                                <td> <strong><?php echo $rows['Nname']; ?> </strong></td>
                                                <td class="onSmall-hide"> <?php echo $rows['appCatName']; ?> </td>
                                                <td class="onSmall-hide"> <?php echo $rows['bCatName']; ?> </td>
                                                <td> <?php echo $rows['district']; ?> </td>
                                                <td class="onSmall-hide"> <?php echo $rows['phone']; ?> </td>
                                                <td> <?php echo $rows['sex']; ?> </td>
                                                <td class="onSmall-hide"> <?php echo $rows['youth']; ?> </td>
                                                <td> <?php echo $rows['commodity']; ?> </td>
                                                <td class="onSmall-hide"> <?php echo number_format($rows['loan']); ?> </td>
                                                <td> <?php echo number_format($rows['granted']); ?> </td>
                                                <td> <?php echo $rows['pfi']; ?> </td>
                                            </tr>

                                        <?php $i++;
                                        $sum_cost += $rows['granted'];
                                    }
                                        ?>
                                        <tr class="text-center table-warning font-weight-bold text-info onSmall-hide">
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

                            <button onclick="exportexcel()" class="btn btn-outline-warning" style="float:right;">Download as Ms Excel</button>

                        <?php

                        } else {
                            $_SESSION['msgSearchZero'] = " No results found!";
                            include('../includes/messages.php');
                        }


                        if (!isset($fetchResult)) {
                        ?>

                            <script type="text/javascript">
                                alert("Failed!");
                                history.go(1);
                            </script>
                        <?php
                            //echo"yes";
                        }
                        //IF PROV ONLY
                    } elseif ($prov != "" && empty($dist)  && empty($secs)) {

                        $fetchResult = $conn->query("SELECT * FROM notified
                    LEFT JOIN businesscategory ON notified.bCatId = businesscategory.bCatId 
                    LEFT JOIN applicantcategory ON notified.appCatId = applicantcategory.appCatId 
                    WHERE province='$prov'");
                        ?>

                        <br />

                        <?php
                        //Get results and Display

                        if ($fetchResult->num_rows > 0) {
                            $_SESSION['msgSearchloc'] = $fetchResult->num_rows . " result(s) found!";
                            include('../includes/messages.php'); ?>

                            <div class="table-responsive">
                                <table class="table table-sm w-auto" id="locationTable">
                                    <thead class="thead-dark">
                                        <tr style="font-style:inherit">
                                            <th class="onSmall-hide">NO</th>
                                            <th>NAME</th>
                                            <th class="onSmall-hide">BUSINESS CATEGORY</th>
                                            <th class="onSmall-hide">COMPONENT</th>
                                            <th>DISTRICT</th>
                                            <th class="onSmall-hide">TELEPHONE</th>
                                            <th>SEX</th>
                                            <th class="onSmall-hide">YOUTH</th>
                                            <th>BUSINESS COMMODITY</th>
                                            <th class="onSmall-hide">LOAN AMOUNT </th>
                                            <th>GRANT</th>
                                            <th>FINANCIAL INSTITUTION</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    //OUTPUT 
                                    $i = 1;
                                    $sum_cost = 0;
                                    while ($rows = $fetchResult->fetch_assoc()) { ?>

                                        <tbody>
                                            <tr>
                                                <td class="onSmall-hide"> <?php echo $i; ?> </td>
                                                <td> <strong><?php echo $rows['Nname']; ?> </strong></td>
                                                <td class="onSmall-hide"> <?php echo $rows['appCatName']; ?> </td>
                                                <td class="onSmall-hide"> <?php echo $rows['bCatName']; ?> </td>
                                                <td> <?php echo $rows['district']; ?> </td>
                                                <td class="onSmall-hide"> <?php echo $rows['phone']; ?> </td>
                                                <td> <?php echo $rows['sex']; ?> </td>
                                                <td class="onSmall-hide"> <?php echo $rows['youth']; ?> </td>
                                                <td> <?php echo $rows['commodity']; ?> </td>
                                                <td class="onSmall-hide"> <?php echo number_format($rows['loan']); ?> </td>
                                                <td> <?php echo number_format($rows['granted']); ?> </td>
                                                <td> <?php echo $rows['pfi']; ?> </td>
                                            </tr>

                                        <?php $i++;
                                        $sum_cost += $rows['granted'];
                                    }
                                        ?>
                                        <tr class="text-center table-warning font-weight-bold text-info onSmall-hide">
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

                            <button onclick="exportexcel()" class="btn btn-outline-warning" style="float:right;">Download as Ms Excel</button>

                        <?php


                        } else {
                            $_SESSION['msgSearchZero'] = " No results found!";
                            include('../includes/messages.php');
                        }

                        if (!isset($fetchResult)) {
                        ?>

                            <script type="text/javascript">
                                alert("Fail!");
                                history.go(1);
                            </script>
                        <?php
                            //echo"yes";
                        }
                    } else {

                        ?>
                        <script type="text/javascript">
                            alert("Please select a location");
                            history.go(1);
                        </script>
                <?php

                    }
                }

                ?>


            </div>

        </div>

        <?php
        include('../includes/footer.php');
        ?>
    </div>

    <script src="../bootstrap_4.3.1_dist/js/node_modules/jquery/jquery.min.js"></script>
    <script src="../bootstrap_4.3.1_dist/js/node_modules/popper.js/dist/popper.min.js"></script>
    <script src="../bootstrap_4.3.1_dist/js/bootstrap.min.js"></script>
    <script src="../node_modules/babel-polyfill/browser.js"></script>

    <script src="jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="jquery.table2excel.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        function exportexcel() {
            $("#locationTable").table2excel({
                name: "Table2Excel",
                filename: "notifiedApplicantsLocations",
                fileext: ".xlsx"
            });
        }
    </script>

</body>

</html>