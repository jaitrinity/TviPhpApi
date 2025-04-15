<?php
include("cpDbConfig.php");
$json = file_get_contents('php://input');
$jsonData=json_decode($json);

$loginEmpId = $jsonData->loginEmpId;
$mobileNumber = $jsonData->mobileNumber;

$menuIdArr = [];
$sql = "SELECT `EMPLOYEE_ID` FROM `EMPLOYEE_MASTER` WHERE `EMPLOYEE_ID`= '$loginEmpId' and `MOBILE`= '$mobileNumber' ";
$query=mysqli_query($conn,$sql);
if(mysqli_num_rows($query) == 0){
	$output = array('responseDesc' => "Invalid username or mobile number, please check", 'wrappedList' => [], 'responseCode' => "102001");
}
else{
	$randomotp = rand(100000,999999);
	$wrappedList = [];
	array_push($wrappedList,$randomotp);

	require 'SendOtpClass.php';
	$classObj = new SendOtpClass();
	$otpResponse = $classObj->sendOtp($mobileNumber, $randomotp, 'TVI CP');
	// $responseData = json_decode($otpResponse);
	// $msgStatus = $responseData->return;
	$output = array('responseDesc' => "OTP sent to mobile, please check", 'wrappedList' => $wrappedList, 'responseCode' => "100000");
}

echo json_encode($output);
?>
