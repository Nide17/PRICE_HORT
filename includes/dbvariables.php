<?php
//Database connection variables;
$servername = "localhost";
$username = "root";
$password = "";
$dbname ="hort_db";

//create connection to hort_db
$conn = new mysqli($servername, $username, $password, $dbname);

//check connection
if ($conn->connect_error) {
    die ("Can not connect" .$conn->connect_error);
}
