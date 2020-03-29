<?php
/*
    ================================================
    =           AJAX:                              =
    =           Retrieve IN BG                     =
    =           DB LIVE                            =
    =                                              =
    =                                              =    
    = @Niyomwnugeri Parmenide Ishimwe              = 
    ================================================
*/

//Database connection variables;
require_once('../includes/dbvariables.php');

//FETCHING

$pro = (isset($_GET["province"]));
$dis = (isset($_GET["district"]));
$sec = (isset($_GET["sector"]));
$cel = (isset($_GET["cell"]));
$vil = (isset($_GET["village"]));

if ($pro != "") {
	$res = $conn->query("SELECT * FROM districts WHERE pid=$_GET[province]");
	echo "<select style='padding:5px 10px; background-color:#EAEDED; width: 100%; border-radius: 4px; border:2px solid #F9F904;' name='districts' id='districtd' onchange='change_district()'>";
	echo "<option>-- Select --</option>";
	while ($row = $res->fetch_assoc()) {
		echo "<option value='$row[did]'>";
		echo $row["dname"];
		echo "</option>";
	}
	echo "</select>";
}

if ($dis != "") {
	$res = $conn->query("SELECT * FROM sectors WHERE did=$_GET[district]");
	echo "<select style='padding:5px 10px; background-color:#EAEDED; width: 100%; border-radius: 4px; border:2px solid #F9F904;' name='sectors' id='sectord' onchange='change_sector()'>";
	echo "<option>-- Select --</option>";
	while ($row = $res->fetch_assoc()) {
		echo "<option value='$row[sid]'>";
		echo $row["sname"];
		echo "</option>";
	}
	echo "</select>";
}
if ($sec != "") {
	$res = $conn->query("SELECT * FROM cells WHERE sid=$_GET[sector]");
	echo "<select style='padding:5px 10px; background-color:#EAEDED; width: 100%; border-radius: 4px; border:2px solid #F9F904;' name='cells' id='celld' onchange='change_cell()'>";
	echo "<option>-- Select --</option>";
	while ($row = $res->fetch_assoc()) {
		echo "<option value='$row[cid]'>";
		echo $row["cname"];
		echo "</option>";
	}
	echo "</select>";
}

if ($cel != "") {
	$res = $conn->query("SELECT * FROM villages WHERE cid=$_GET[cell]");
	echo "<select style='padding:5px 10px; background-color:#EAEDED; width: 100%; border-radius: 4px; border:2px solid #F9F904;' name='villages'>";
	echo "<option>-- Select --</option>";
	while ($row = $res->fetch_assoc()) {
		echo "<option value='$row[vid]'>";
		echo $row["vname"];
		echo "</option>";
	}
	echo "</select>";
}
