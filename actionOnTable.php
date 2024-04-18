<?php 
include("cpDbConfig.php");
$methodType = $_SERVER['REQUEST_METHOD'];
$actionType = $_REQUEST["actionType"];
$json = file_get_contents('php://input');
$jsonData=json_decode($json);
if(($actionType == "Y" || $actionType == "N") && $methodType === 'POST'){
	$id = $jsonData->id;
	$action = $jsonData->action;
	$sql = "UPDATE `EMPLOYEE_MASTER` set `IS_ACTIVE` = '$action', `UPDATE_DATE` = current_timestamp where `ID` = $id ";
	if(mysqli_query($conn,$sql)){
		$output -> responseCode = "100000";
		$output -> responseDesc = "Successfully update";
	}
	else{
		$output -> responseCode = "0";
		$output -> responseDesc = "Something wrong";
	}
	echo json_encode($output);
}
else if($actionType == "insertEmployee" && $methodType === 'POST'){
	$employeeId = $jsonData->employeeId;
	$employeeName = $jsonData->employeeName;
	$mobile = $jsonData->mobile;
	$emailId = $jsonData->emailId;
	$organization = $jsonData->organization;
	$role = $jsonData->role;
	$circle = $jsonData->circle;
	$isHoUser = $jsonData->isHoUser;

	$sql = "INSERT INTO `EMPLOYEE_MASTER`(`EMPLOYEE_ID`, `NAME`, `MOBILE`, `EMAIL_ID`, `ORGANIZATION`, `ROLE`, `CIRCLE_NAME`, `PASSWORD`, `IS_HO_USER`, 
	`IS_ACTIVE`, `CREATE_DATE`) VALUES 
	('$employeeId', '$employeeName', '$mobile', '$emailId', '$organization', '$role', '$circle', 'tr$employeeId', '$isHoUser', 'Y', current_timestamp) ";
	if(mysqli_query($conn,$sql)){
		$output -> responseCode = "100000";
		$output -> responseDesc = "Successfully Insert";

		if($role == "S&M"){
			$upSql = "update `EMPLOYEE_MASTER` set `EMAIL_ID` = '$emailId' where `ROLE` = 'OPCO' and `CIRCLE_NAME` = '$circle'";
			mysqli_query($conn,$upSql);
		}
	}
	else{
		$output -> responseCode = "0";
		$output -> responseDesc = "Something wrong";
	}
	echo json_encode($output);
}
else if($actionType == "editEmployee" && $methodType === 'POST'){
	$id = $jsonData->id;
	$employeeId = $jsonData->employeeId;
	$employeeName = $jsonData->employeeName;
	$mobile = $jsonData->mobile;
	$emailId = $jsonData->emailId;
	$organization = $jsonData->organization;
	$role = $jsonData->role;
	$circle = $jsonData->circle;
	$isHoUser = $jsonData->isHoUser;

	$sql = "UPDATE `EMPLOYEE_MASTER` set `NAME` = '$employeeName', `MOBILE` = '$mobile', `EMAIL_ID` = '$emailId', `ORGANIZATION` = '$organization', `ROLE` = '$role', 
	`CIRCLE_NAME` = '$circle', `IS_HO_USER` = '$isHoUser', `UPDATE_DATE` = current_timestamp where `ID` = $id ";
	if(mysqli_query($conn,$sql)){
		$output -> responseCode = "100000";
		$output -> responseDesc = "Successfully update";
	}
	else{
		$output -> responseCode = "0";
		$output -> responseDesc = "Something wrong";
	}
	echo json_encode($output);
}
else if($actionType == "complain_o" && $methodType === 'POST'){
	$complainId = $jsonData->complainId;
	$tempDescription = $jsonData->closeDescription;
	$closeDescription = str_replace("<br>","",$tempDescription);
	$closeDescriptionMail = $jsonData->closeDescription;
	$loginEmpId = $jsonData->loginEmpId;
	$sql = "UPDATE `Complain` set `Close_Description` = '$closeDescription', `Close_Date` = curdate(), `Close_By` = '$loginEmpId', `Status` = 'Close' where `Complain_Id` = '$complainId' ";
	if(mysqli_query($conn,$sql)){
		$output -> status = true;
		$output -> message = "Successfully Update";

		$complainSql = "SELECT e.NAME, e.EMAIL_ID FROM Complain c join EMPLOYEE_MASTER e on c.Raise_By = e.EMPLOYEE_ID  where Complain_Id = $complainId ";
		$complainQuery = mysqli_query($conn,$complainSql);
		$complainRow = mysqli_fetch_assoc($complainQuery);
		$empName = $complainRow["NAME"];
		$empEmailId = $complainRow["EMAIL_ID"];
		// // $empEmailId = "jai.prakash@trinityapplab.co.in";
		// $ccEmailId = "jai.prakash@trinityapplab.co.in";
		// $msg = "Dear ".$empName.",<br>";
		// $msg .= "Complaint id - ".$complainId.", ".$closeDescription.".<br>";
		// // $msg .= "Please check. ";
		// $subject = "TVI Complaint - ".$complainId;
		// sendCompaintMailPhp2($empEmailId, $ccEmailId, $subject, $msg);

		$ccEmailId = "";
		$bccEmailId = "jai.prakash@trinityapplab.co.in";
		$msg = "Dear ".$empName.",<br>";
		$msg .= "Complaint id - ".$complainId.", ".$closeDescriptionMail."<br>";
		$emailFrom = 'Trinity Helpdesk';
		$subject = "TVI Complaint - ".$complainId;
		sendCompaintMailPhp($emailFrom, $empEmailId, $ccEmailId, $bccEmailId, $subject, $msg);
		
	}
	else{
		$output -> status = false;
		$output -> message = "Something Wrong";
	}
	echo json_encode($output);

}
else if($actionType == "complain" && $methodType === 'POST'){
	$complainId = $jsonData->complainId;
	$tempDescription = $jsonData->closeDescription;
	$closeDescription = str_replace("<br>","",$tempDescription);
	$loginEmpId = $jsonData->loginEmpId;
	$sql = "UPDATE `Complain` set `Close_Description` = ?, `Close_Date` = curdate(), `Close_By` = '$loginEmpId', `Status` = 'Close' where `Complain_Id` = '$complainId' ";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s", $closeDescription);
	if($stmt->execute()){
		$output -> status = true;
		$output -> message = "Successfully Update";

		$complainSql = "SELECT e.NAME, e.EMAIL_ID FROM Complain c join EMPLOYEE_MASTER e on c.Raise_By = e.EMPLOYEE_ID  where Complain_Id = $complainId ";
		$complainQuery = mysqli_query($conn,$complainSql);
		$complainRow = mysqli_fetch_assoc($complainQuery);
		$empName = $complainRow["NAME"];
		$empEmailId = $complainRow["EMAIL_ID"];

		$closeDescriptionMail = $tempDescription;
		$ccEmailId = "";
		$bccEmailId = "jai.prakash@trinityapplab.co.in";
		$msg = "Dear ".$empName.",<br>";
		$msg .= "Complaint id - ".$complainId.", ".$closeDescriptionMail."<br>";
		$emailFrom = 'Trinity Helpdesk';
		$subject = "TVI Complaint - ".$complainId;
		sendCompaintMailPhp($emailFrom, $empEmailId, $ccEmailId, $bccEmailId, $subject, $msg);
		
	}
	else{
		$output -> status = false;
		$output -> message = "Something Wrong";
	}
	echo json_encode($output);

}

?>

<?php 
function sendCompaintMailPhp($emailFrom, $empEmailId, $ccEmailId, $bccEmailId, $subject, $msg){
	$url = "http://www.in3.co.in:8080/TVI_CP/tvi/sendCompaintMailPhp";

	$dataArray = ['emailFrom' => $emailFrom, 'emailId' => $empEmailId, 'ccEmailId' => $ccEmailId, 'bccEmailId' => $bccEmailId, 'subject' => $subject, 
	'msg' => $msg];
	$data = http_build_query($dataArray);
	$getUrl = $url."?".$data;

	$ch = curl_init();   
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $getUrl);
    curl_setopt($ch, CURLOPT_TIMEOUT, 80);
       
    $response = curl_exec($ch);
        
    if(curl_error($ch)){
        // echo 'Request Error:' . curl_error($ch);
    }else{
        // echo $response;
    }
       
    curl_close($ch);
}
// function sendCompaintMailPhp2($empEmailId, $ccEmailId, $subject, $msg){
// 	$url = "http://www.in3.co.in:8080/TVI_CP_WSv1/tvi/sendCompaintMailPhp";

// 	$dataArray = ['emailId' => $empEmailId, 'ccEmailId' => $ccEmailId, 'subject' => $subject, 'msg' => $msg];
// 	$data = http_build_query($dataArray);
// 	$getUrl = $url."?".$data;

// 	$ch = curl_init();   
// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//     curl_setopt($ch, CURLOPT_URL, $getUrl);
//     curl_setopt($ch, CURLOPT_TIMEOUT, 80);
       
//     $response = curl_exec($ch);
        
//     if(curl_error($ch)){
//         // echo 'Request Error:' . curl_error($ch);
//     }else{
//         // echo $response;
//     }
       
//     curl_close($ch);
// }
?>