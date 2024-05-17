<?php
$conn=mysqli_connect("[hostname]","[username]","[password]","[dbname]");
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit();
}
mysqli_set_charset($conn, 'utf8');
?>