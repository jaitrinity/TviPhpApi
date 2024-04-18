<?php
include("cpDbConfig.php");
$json = file_get_contents('php://input');
$jsonData=json_decode($json);

$circleName = $jsonData->circleName;
$operator = $jsonData->operator;
$tabName = $jsonData->tabName; // New_Tenency, Site_Upgrade

// $sql = "SELECT * from `Site_Master` where `Circle` = '".$circleName."' and `Current_Anchor` <> '".$operator."' ";
$sql = "";
if($tabName == "New_Tenency" || $operator == 'TCL')
	$sql = "SELECT * from `Site_Master` where `Circle` = '".$circleName."' and `$operator` <> 'Y' and `Is_Deleted` is null ";
else
	$sql = "SELECT * from `Site_Master` where `Circle` = '".$circleName."' and `$operator` = 'Y' and `Is_Deleted` is null ";
// echo $sql;
$result=mysqli_query($conn,$sql);
$wrappedList = [];
while($row=mysqli_fetch_assoc($result)){
	$jsonOutput = array(
		'paramCode' => $row["TVISiteID"], 'paramDesc' => $row["TVISiteID"]." ", 
		'siteName' => $row["Site Name"], 'latitude' => $row["Latitude"], 'longitude' => $row["Longitude"], 'address' => $row["Address"], 
		'district' => $row["District"], 'state' => $row["GST_State"],  'siteType' => $row["TypeofSite"], 'cluster' => $row["Cluster"], 
		'aglRequired' => $row["AGL"]
		);
	array_push($wrappedList,$jsonOutput);
}
$output = array('responseDesc' => "SUCCESSFUL", 'wrappedList' => $wrappedList, 'responseCode' => "100000");
echo json_encode($output);
?>