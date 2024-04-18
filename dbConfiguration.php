<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers:content-type");
// $conn=mysqli_connect("localhost","root","Tr!n!ty@pp1@b","TVIBilling");
// $conn=mysqli_connect("66.23.200.162","jaiprakash","jai201292","TVIBilling");
$conn=mysqli_connect("66.23.200.162","jaiprakash","jai201292","TVIBilling_demo");
// $conn=mysqli_connect("66.23.200.162","root","Tr!n!ty#321","TVIBilling");
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit();
}
mysqli_set_charset($conn, 'utf8');
?>