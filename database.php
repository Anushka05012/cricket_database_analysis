<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "cricket_database_analysis";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>