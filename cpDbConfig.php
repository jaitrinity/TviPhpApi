<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers:content-type");
$conn=mysqli_connect("localhost","db","P@ssw0rd","TVICustomerPortal");
// $conn=mysqli_connect("localhost","root","Tr!n!ty@pp1@b","TVICustomerPortal");
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit();
}
mysqli_set_charset($conn, 'utf8');
?>