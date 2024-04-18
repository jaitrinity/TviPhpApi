<?php 
include("cpDbConfig.php");
$methodType = $_SERVER['REQUEST_METHOD'];
$json = file_get_contents('php://input');
$jsonData=json_decode($json);
if($methodType === 'POST'){
	$loginEmpId = $jsonData->loginEmpId;
	$loginEmpRole = $jsonData->loginEmpRole;

	$sql = "SELECT `Complain_Id`, `SR_Number`, `Raise_Description`, `Raise_By`, `Raise_Date`, `Image`, `Close_Description`, `Close_By`, `Close_Date`, `Status` 
	FROM `Complain` where 1=1 ";
	if($loginEmpRole != 'Trinity_Helpdesk'){
		$sql .= "and `Raise_By` = '$loginEmpId' ";
	}
	$sql .= "order by `Complain_Id` desc ";
	$query = mysqli_query($conn,$sql);
	$wrappedList = [];
	while ($row = mysqli_fetch_assoc($query)) {
		$resultJson = array('complainId' => $row["Complain_Id"], 
			'srNumber' => $row["SR_Number"], 
			'description' => $row["Raise_Description"], 
			'image' => $row["Image"],
			'raiseBy' => $row["Raise_By"],
			'raiseDate' => $row["Raise_Date"], 
			'closeDesciption' => $row["Close_Description"], 
			'closeBy' => $row["Close_By"], 
			'closeDate' => $row["Close_Date"], 
			'status' => $row["Status"]);
		array_push($wrappedList, $resultJson);
	}

	$output = "";
	if(count($wrappedList) == 0){
		$output = array('status' => false, 'wrappedList' => $wrappedList, 'message' => 'No Data Found');
	}
	else{
		$output = array('status' => true, 'wrappedList' => $wrappedList, 'message' => 'Success');
	}
	echo json_encode($output);
}
?>