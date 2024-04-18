<?php 
include("cpDbConfig.php");
$json = file_get_contents('php://input');
$jsonData=json_decode($json);

$tviSiteId = $jsonData->tviSiteId;
$operator = $jsonData->operator;

$sql = "SELECT `SR_NUMBER` FROM `NBS_MASTER_HDR` where `TAB_NAME` = 'New_Tenency' and `TVI_SITE_ID` = '$tviSiteId' and `Operator` = '$operator' and `STATUS` != 'NB100' ";
$result=mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
$rowcount=mysqli_num_rows($result);
$output = "";
if($rowcount > 0){
	$output -> status = true;
	$output -> responseDesc = "`".$row["SR_NUMBER"]."` SR already available for this site id.";
}
else{
	$output -> status = false;
	$output -> responseDesc = "";
}
echo json_encode($output);
?>