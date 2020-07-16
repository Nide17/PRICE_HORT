<?php
include('dbconnect.php'); //tables
include('includes/dbvariables.php');
$limit = 249;

if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};

$start_from = ($page - 1) * $limit;
// RETRIEVE DATA FROM DB (admin.php)
$sqlRetrieve = "SELECT * FROM applicant
LEFT JOIN businesscategory ON applicant.bCatId = businesscategory.bCatId
LEFT JOIN applicantcategory ON applicant.appCatId = applicantcategory.appCatId
LEFT JOIN serviceprovider ON applicant.spId = serviceprovider.spId
ORDER BY appNo DESC LIMIT $start_from, $limit";

$result = $conn->query($sqlRetrieve);
?>

<div class="col-sm-12">
    <div class="table-responsive">
        <table class="table datatable table-sm w-auto">
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
                            <td class="onSmall-hide"> <strong style="color:rgb(192, 233, 201);"> <?php echo $row['formCode']; ?> </strong></td>
                            <td> <?php echo $row['appName']; ?> </td>
                            <td class="onSmall-hide"> <?php echo $row['appCatName']; ?> </td>
                            <td class="onSmall-hide"> <?php echo $row['bCatName']; ?> </td>
                            <td> <?php echo $row['bDistrict']; ?> </td>
                            <td class="onSmall-hide"> <?php echo $row['idNbr']; ?> </td>
                            <td class="onSmall-hide"> <?php echo $row['phone']; ?> </td>
                            <td> <?php echo $row['crop1']; ?> </td>
                            <td> <?php echo number_format($row['totalCost']); ?> </td>
                            <td> <?php
                                    if ($row['marks'] < 55) {
                                        echo '<b style="color:red;">' . $row['marks'] . '</b>';
                                    } else {
                                        echo '<b style="color:blue;">' . $row['marks'] . '</b>';
                                    } ?> </td>
                            <td> <strong><?php if ($row['marks'] < 55) {
                                echo "";
                            } else {
                                echo $row['spName']; 
                            }
                            ?> 
                            </strong></td> 
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
            <tfoot class="thead-dark">
                <tr>
                    <th class="onSmall-hide">FORM CODE</th>
                    <th>NAME</th>
                    <th class="onSmall-hide">APPLICANT CATEGORY</th>
                    <th class="onSmall-hide">BUSINESS CATEGORY</th>
                    <th>DISTRICT</th>
                    <th class="onSmall-hide">ID NUMBER</th>
                    <th class="onSmall-hide">PHONE</th>
                    <th>COMMODITY</th>
                    <th>COST</th>
                    <th>MARKS</th>
                    <th>SERVICE PROVIDER</th>
                    <th colspan="2">ACTION</th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>