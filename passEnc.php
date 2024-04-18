<?php 
// include("cpDbConfig.php");
// $sql = "SELECT * FROM `EMPLOYEE_MASTER` where `PASSWORD_ENC` is null";
// $success = 0;
// $fail = 0;
// $query=mysqli_query($conn,$sql);
// while($row = mysqli_fetch_assoc($query)){
// 	$id = $row["ID"];
// 	// $empId = $row["EmpId"];
// 	$password = $row["PASSWORD"];
// 	$encode = base64_encode($password);
// 	// $decode = base64_decode($encode);
// 	// echo $password." --- ".$encode.' --- '.$decode;

// 	$passEnc = "UPDATE `EMPLOYEE_MASTER` set `PASSWORD_ENC` = '$encode' where `ID` = $id";
// 	if(mysqli_query($conn,$passEnc)){
// 		$success++;
// 	}
// 	else{
// 		$fail++;
// 	}
// }
// $output = array('success' => $success, 'fail' => $fail);
// echo json_encode($output);


$str = '9958965924';
$encode = base64_encode($str);
echo 'Encode : '.$encode.'<br>';
$decode = base64_decode($encode);
echo 'Decode : '.$decode;
?>