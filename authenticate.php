<?php
include("dbConfiguration.php");

$json = file_get_contents('php://input');
$jsonData=json_decode($json);

$empId = $jsonData->username;
$password = $jsonData->password;

$sql = "SELECT `Login_Master`.`Emp_Id`, `Login_Master`.`Emp_Name` from `Login_Master` WHERE `Login_Master`.`Emp_Id` = '$empId' and `Login_Master`.`Password` = BINARY('$password') 
and `Login_Master`.`Is_Active` = 1 ";
// echo $sql;
$query=mysqli_query($conn,$sql);
$empArr = array();
if(mysqli_num_rows($query) != 0){
	while($row = mysqli_fetch_assoc($query)){
		
		$json = array(
			'empId' => $row["Emp_Id"], 'empName' => $row["Emp_Name"]
		);
		array_push($empArr,$json);
	}
	$output = array();
	$output = array('responseCode' => '100000','responseDesc' => 'SUCCESSFUL','wrappedList' => $empArr);
	echo json_encode($output);
}
else{
	$output = array();
	$output = array('responseCode' => '102001','responseDesc' => 'No Record Found','wrappedList' => $empArr);
	echo json_encode($output);
}



?>