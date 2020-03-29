<?php
/*
    ================================================
    = All about Data:                              =
    =           Retrieve                           =
    =           Delete                             =
    =           Update                             =
    =           Save                               =    
    = @Niyomwnugeri Parmenide Ishimwe              = 
    ================================================
*/

//Database connection variables;
require_once('includes/dbvariables.php');

//initialize applicant variable to be used in edit fields
$formCode = "";
$appName = "";
$bCategory = "";
$idNbr = "";
$phone = "";
$totCost = "";
$marks = "";
$sProv = "";
$id = 0;

$edit_state = false;


// if save applicant button is clicked (new applicant)!
if (isset($_POST['save'])) {
    session_start();

    $formCode = $_POST['fCode'];
    $appName = $_POST['aName'];
    $appCategory = $_POST['type'];
    $bCategory = $_POST['category'];
    $idNbr = $_POST['idNbr'];
    $phone = $_POST['phone'];
    $totCost = $_POST['cost'];
    $marks = $_POST['marks'];
    $sProv = $_POST['sp'];

    //Verify if formcode exist in DB
    $checkCode = "SELECT formCode FROM applicant WHERE formCode = '$formCode'";
    $checkFormCode = $conn->query($checkCode);

    if ($checkFormCode->num_rows > 0) {
        $_SESSION['msgApp'] = "Form code exists! try another.";
        header("location:" . $_SERVER['HTTP_REFERER']);
    } else {
        $sqlSaveData = "INSERT INTO applicant (formCode, appName, appCatId, bCatId, idNbr, phone, totalCost, marks, spId) 
        VALUES ('$formCode', '$appName', '$appCategory','$bCategory', '$idNbr', '$phone', '$totCost', '$marks', '$sProv')";

        if ($conn->query($sqlSaveData) === TRUE) {
            $_SESSION['msgAppOK'] = "Applicant saved!";
            header("location:" . $_SERVER['HTTP_REFERER']);
        } else {
            //catch any other error
            $_SESSION['msgApp'] = "Error!" . $sqlSaveData . $conn->error;
            header("location:" . $_SERVER['HTTP_REFERER']);
        }
    }
}


// if update applicant button is clicked (update applicant)!
//----------------UPDATE DATA IN THE DB-------------------//
if (isset($_POST['update'])) {
    session_start(); //FOR MESSAGE DISPLAY

    $formCode = mysqli_real_escape_string($conn, $_POST['fCode']);
    $appName = mysqli_real_escape_string($conn, $_POST['aName']);
    $appType = mysqli_real_escape_string($conn, $_POST['type']);
    $bCategory = mysqli_real_escape_string($conn, $_POST['category']);
    $idNbr = mysqli_real_escape_string($conn, $_POST['idNbr']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $totCost = mysqli_real_escape_string($conn, $_POST['cost']);
    $marks = mysqli_real_escape_string($conn, $_POST['marks']);
    $sProv = mysqli_real_escape_string($conn, $_POST['sp']);

    $id = mysqli_real_escape_string($conn, $_POST['appId']);

    $sqlUpdate = "UPDATE applicant SET formCode='$formCode', appName='$appName', appCatId='$appType', bCatId='$bCategory', 
    idNbr = '$idNbr', phone='$phone', totalCost='$totCost', marks='$marks', spId='$sProv' WHERE appNo=$id";

    if ($conn->query($sqlUpdate) === TRUE) {
        $_SESSION['msgAppOK1'] = "Applicant updated successfully!";
        header('location: admin.php');
    } else {
        $_SESSION['msgApp'] = "Error!" . $sqlUpdate . $conn->error;
        header("location:" . $_SERVER['HTTP_REFERER']);
    }
}


//------------Delete applicant record (admin.php)-----------//
if (isset($_GET['del'])) {
    session_start();  //FOR DISPLAYING THE MESSAGE

    $id = $_GET['del'];
    $sqlDelete = "DELETE FROM applicant WHERE appNo=$id";

    if ($conn->query($sqlDelete) === TRUE) {
        $_SESSION['msgDelAppOK'] = "Deleted successfully!";
        header("location:" . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['msgDelApp'] = "Error!" . $conn->error;
        header("location:" . $_SERVER['HTTP_REFERER']);
    }
}


// RETRIEVE DATA FROM DB (admin.php)
$sqlRetrieve = "SELECT * FROM applicant
LEFT JOIN businessCategory ON applicant.bCatId = businessCategory.bCatId
LEFT JOIN applicantcategory ON applicant.appCatId = applicantcategory.appCatId
LEFT JOIN serviceprovider ON applicant.spId = serviceprovider.spId
ORDER BY appNo DESC LIMIT 50;";
$result = $conn->query($sqlRetrieve);


// RETRIEVE NOTIFIED APPLICANTS (notified.php)
$sqlRetrieveNotified = "SELECT * FROM notified
                    LEFT JOIN applicantcategory ON notified.appCatId = applicantcategory.appCatId
                    LEFT JOIN businessCategory ON notified.bCatId = businessCategory.bCatId 
                    ORDER BY NotID ;";
$resultNotified = $conn->query($sqlRetrieveNotified);

$conn->close();
