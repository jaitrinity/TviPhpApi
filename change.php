<?php
include("cpDbConfig.php");
// $sql = "SELECT * FROM `NBS_MASTER_HDR` where `Circle_Operation_Head_Attachment` is not null";
$sql = "SELECT * FROM `NBS_MASTER_HDR` where `Google_Snapshot_Attachment` like '%4125%'";

$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
	$sr = $row["SR_NUMBER"];
	$data = $row["Google_Snapshot_Attachment"];
	$dataExplode = explode("TVI_CP/", $data);
	$newData = 'http://www.in3.co.in/in3.co.in/TVI_CP/'.$dataExplode[1];
	// echo $newData.'..........';

	$updateSql = "update `NBS_MASTER_HDR` set `Google_Snapshot_Attachment` = '$newData' where `SR_NUMBER` = '$sr' ";
	echo $updateSql.';';
	mysqli_query($conn,$updateSql);
}


?>
