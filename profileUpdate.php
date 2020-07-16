<?php

require_once('server.php'); //for msg display

if (!isset($_SESSION['role'])) {
    header("location: logout.php");
    exit;
}

//fetch record to be updated
if (isset($_GET['edit'])) {

    $userident = $_GET['edit'];
    $edit_state = true;

    $sqlEditProfile = "SELECT * FROM tblUser
    WHERE u_id=$userident;";

    $resulProfile = $conn->query($sqlEditProfile);
    $recordP = $resulProfile->fetch_array();

    $uname = $recordP['Username'];
    $urole = $recordP['Role'];
    $fname = $recordP['Firstname'];
    $lname = $recordP['Lastname'];

    $uidentity = $recordP['u_id'];
}

require_once('includes/head.php');
?>

<body>

    <div class="container">
        <?php require_once('includes/jumbotron.php') ?>

        <h3 class="titles" style="color: #4525ef;">Update your profile picture</h3> <br>

        <div class="row">
            <div class="col-sm-12">
                <form method="POST" enctype="multipart/form-data" action="server.php" id="editNewForm">

                    <input type="hidden" name="user_Id" value="<?php echo $uidentity; ?>">

                    <?php
                    include('includes/messages.php');
                    ?>

                    <div class="form-group row">
                        <Label for="formCode" class="col-sm-3 col-form-label">Username</Label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="uname" id="" disabled value="<?php echo $uname; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <Label for="appName" class="col-sm-3 col-form-label">Role</Label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="urole" id="" disabled value="<?php echo $urole; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <Label class="col-sm-3 col-form-label">Firstname</Label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="fname" id="" value="<?php echo $fname; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <Label class="col-sm-3 col-form-label">Lastname</Label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="lname" id="" value="<?php echo $lname; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <Label class="col-sm-3 col-form-label">Profile Picture</Label>
                        <div style="color:crimson" class="col-sm-6">
                            <td>
                                <input type="file" name="fileToUpload" id="fileToUpload">
                            </td>
                        </div>
                    </div>

                    <div class="input-group">
                        <button type="submit" name="updateP" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        include('includes/footer.php');
        ?>
    </div>

</body>

</html>