<?php
require_once('dbconnect.php'); //for msg display
require_once('server.php');

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
?>

<?php

//fetch record to be updated
if (isset($_GET['edit'])) {

    $id = $_GET['edit'];
    $edit_state = true;

    $sqlEdit = "SELECT * FROM applicant
    LEFT JOIN businessCategory ON applicant.bCatId = businessCategory.bCatId
    LEFT JOIN applicantcategory ON applicant.appCatId = applicantcategory.appCatId
    LEFT JOIN serviceprovider ON applicant.spId = serviceprovider.spId
    WHERE appNo=$id;";

    $resul = $conn->query($sqlEdit);
    $record = $resul->fetch_array();

    $formCode = $record['formCode'];
    $appName = $record['appName'];
    $appCatId = $record['appCatId'];
    $bCatId = $record['bCatId'];
    $idNbr = $record['idNbr'];
    $phone = $record['phone'];
    $totCost = $record['totalCost'];
    $marks = $record['marks'];
    $spId = $record['spId'];
    $id = $record['appNo'];
}

require_once('includes/head.php')
?>

<body>

    <div class="container">

        <?php require_once('includes/jumbotron.php') ?>

        <div class="row">
            <a href="admin.php"><button id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
        </div>

        <form method="POST" action="dbconnect.php" id="editNewForm">

            <legend style="color: #4525ef;">
                <h4 style="text-align:center">REGISTER APPLICANT<br /><br /></h4>
            </legend>
            <input type="hidden" name="appId" value="<?php echo $id; ?>">

            <?php
            include('includes/messages.php');
            ?>

            <div class="form-group row">
                <Label for="formCode" class="col-sm-3 col-form-label">Form Code</Label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="fCode" id="" value="<?php echo $formCode; ?>">
                    <small id="code" class="form-text text-muted">Form code must be unique</small>
                </div>
            </div>
            <div class="form-group row">
                <Label for="appName" class="col-sm-3 col-form-label">Name</Label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="aName" id="" value="<?php echo $appName; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="type">Type</label>
                <div class="col-sm-6">
                    <select class="form-control" name="type" id="">

                        <?php

                        if (isset($appCatId)) {

                            if ($appCatId == 1) {
                                echo '<option value="1" selected="selected"> <b>ASSOCIATION</b></option>
                  <option value="2"><b>LIMITED COMPANY</b></option>
                  <option value="3"><b>COOPERATIVE</b></option>
                  <option value="4"><b>OTHER CATEGORY</b></option>
                  <option value="5"><b>INDIVIDUAL</b></option>';
                            }

                            if ($appCatId == 2) {
                                echo '<option value="1"> <b>ASSOCIATION</b></option>
                                <option value="2" selected="selected"><b>LIMITED COMPANY</b></option>
                                <option value="3"><b>COOPERATIVE</b></option>
                                <option value="4"><b>OTHER CATEGORY</b></option>
                                <option value="5"><b>INDIVIDUAL</b></option>';
                            }

                            if ($appCatId == 3) {
                                echo '<option value="1"> <b>ASSOCIATION</b></option>
                                <option value="2"><b>LIMITED COMPANY</b></option>
                                <option value="3" selected="selected"><b>COOPERATIVE</b></option>
                                <option value="4"><b>OTHER CATEGORY</b></option>
                                <option value="5"><b>INDIVIDUAL</b></option>';
                            }

                            if ($appCatId == 4) {
                                echo '<option value="1"> <b>ASSOCIATION</b></option>
                                <option value="2"><b>LIMITED COMPANY</b></option>
                                <option value="3"><b>COOPERATIVE</b></option>
                                <option value="4" selected="selected"><b>OTHER CATEGORY</b></option>
                                <option value="5"><b>INDIVIDUAL</b></option>';
                            }

                            if ($appCatId == 5) {
                                echo '<option value="1"> <b>ASSOCIATION</b></option>
                                <option value="2"><b>LIMITED COMPANY</b></option>
                                <option value="3"><b>COOPERATIVE</b></option>
                                <option value="4"><b>OTHER CATEGORY</b></option>
                                <option value="5" selected="selected"><b>INDIVIDUAL</b></option>';
                            }
                        } else {
                            echo '<option value="1"> <b>ASSOCIATION</b></option>
                            <option value="2"><b>LIMITED COMPANY</b></option>
                            <option value="3"><b>COOPERATIVE</b></option>
                            <option value="4"><b>OTHER CATEGORY</b></option>
                            <option value="5" selected="selected"><b>INDIVIDUAL</b></option>';
                        }

                        ?>

                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="category">Category</label>
                <div class="col-sm-6">
                    <select class="form-control" name="category" id="">

                        <?php

                        if (isset($bCatId)) {

                            if ($bCatId == 1) {
                                echo '<option value="1" selected="selected"> <b>PRIMARY</b></option>
                  <option value="2"><b>PLANTING</b></option>
                  <option value="3"><b>PACKAGING</b></option>
                  <option value="4"><b>PRIMARY & PLANTING</b></option>
                  <option value="5"><b>SEEDS PROPAGATION</b></option>
                  <option value="6"><b>NURSERY BED</b></option>';
                            }

                            if ($bCatId == 2) {
                                echo '<option value="1"> <b>PRIMARY</b></option>
              <option value="2" selected="selected"><b>PLANTING</b></option>
              <option value="3"><b>PACKAGING</b></option>
              <option value="4"><b>PRIMARY & PLANTING</b></option>
              <option value="5"><b>SEEDS PROPAGATION</b></option>
              <option value="6"><b>NURSERY BED</b></option>';
                            }

                            if ($bCatId == 3) {
                                echo '<option value="1"> <b>PRIMARY</b></option>
          <option value="2"><b>PLANTING</b></option>
          <option value="3" selected="selected"><b>PACKAGING</b></option>
          <option value="4"><b>PRIMARY & PLANTING</b></option>
          <option value="5"><b>SEEDS PROPAGATION</b></option>
          <option value="6"><b>NURSERY BED</b></option>';
                            }

                            if ($bCatId == 4) {
                                echo '<option value="1" selected="selected"> <b>PRIMARY</b></option>
          <option value="2"><b>PLANTING</b></option>
          <option value="3"><b>PACKAGING</b></option>
          <option value="4" selected="selected"><b>PRIMARY & PLANTING</b></option>
          <option value="5"><b>SEEDS PROPAGATION</b></option>
          <option value="6"><b>NURSERY BED</b></option>';
                            }

                            if ($bCatId == 5) {
                                echo '<option value="1" selected="selected"> <b>PRIMARY</b></option>
          <option value="2"><b>PLANTING</b></option>
          <option value="3"><b>PACKAGING</b></option>
          <option value="4"><b>PRIMARY & PLANTING</b></option>
          <option value="5" selected="selected"><b>SEEDS PROPAGATION</b></option>
          <option value="6"><b>NURSERY BED</b></option>';
                            }

                            if ($bCatId == 6) {
                                echo '<option value="1" selected="selected"> <b>PRIMARY</b></option>
          <option value="2"><b>PLANTING</b></option>
          <option value="3"><b>PACKAGING</b></option>
          <option value="4"><b>PRIMARY & PLANTING</b></option>
          <option value="4"><b>SEEDS PROPAGATION</b></option>
          <option value="5" selected="selected"><b>NURSERY BED</b></option>';
                            }
                        } else {
                            echo '<option value="1" selected="selected"> <b>PRIMARY</b></option>
                  <option value="2"><b>PLANTING</b></option>
                  <option value="3"><b>PACKAGING</b></option>
                  <option value="4"><b>PRIMARY & PLANTING</b></option>
                  <option value="5"><b>SEEDS PROPAGATION</b></option>
                  <option value="6"><b>NURSERY BED</b></option>';
                        }

                        ?>

                    </select>
                </div>
            </div>

            <div class="form-group row">
                <Label class="col-sm-3 col-form-label">ID</Label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="idNbr" id="" value="<?php echo $idNbr; ?>">
                </div>
            </div>
            <div class="form-group row">
                <Label class="col-sm-3 col-form-label">Phone</Label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" id="" value="<?php echo $phone; ?>">
                </div>
            </div>
            <div class="form-group row">
                <Label class="col-sm-3 col-form-label">Total Cost</Label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="cost" id="" value="<?php echo $totCost; ?>">
                </div>
            </div>
            <div class="form-group row">
                <Label class="col-sm-3 col-form-label">Marks</Label>
                <div class="col-sm-6">
                    <input type="number" step="0.1" min="0" max="100" class="form-control" name="marks" id="marks-input" value="<?php echo $marks; ?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label" for="sp">Service Provider</label>
                <div class="col-sm-6">
                    <select class="form-control" name="sp" id="sp-select">


                        <?php

                        if (isset($spId)) {

                            if ($spId == 1) {
                                echo '<option value="0"> <b>Failed</b></option>
                  <option value="1"  selected="selected"><b>ADC</b></option>
                  <option value="2"><b>SORWAFFA</b></option>';
                            }

                            if ($spId == 2) {
                                echo '<option value="0"> <b>Failed</b></option>
          <option value="1"><b>ADC</b></option>
          <option value="2"  selected="selected"><b>SORWAFFA</b></option>';
                            } else {
                                echo '<option value="0" selected="selected"> <b>Failed</b></option>
                  <option value="1"><b>ADC</b></option>
                  <option value="2"><b>SORWAFFA</b></option>';
                            }
                        } else {
                            echo '<option value="0" selected="selected"> <b>Failed</b></option>
                  <option value="1"><b>ADC</b></option>
                  <option value="2"><b>SORWAFFA</b></option>';
                        }

                        ?>

                    </select>
                </div>
            </div>

            <div class="input-group">
                <?php if ($edit_state == false) :  ?>
                    <button type="submit" name="save" id="save-btn" class="btn-success">Save</button>

                <?php else :  ?>
                    <button type="submit" name="update" id="update-btn" class="btn btn-success">Update</button>

                <?php endif  ?>
            </div>
        </form>

    </div>

</body>

</html>