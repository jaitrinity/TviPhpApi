<?php
include("dbConfiguration.php");

$searchType=$_REQUEST['searchType'];
$billing_report_count = 0;
if($searchType == 'circleName'){
	$sql = "SELECT DISTINCT `Circle Name` FROM `P&L Sitewise`";
	$query = mysqli_query($conn,$sql);
	$circleNameArr = [];
	while($row=mysqli_fetch_assoc($query)){
		$circleName = $row["Circle Name"];
		$json = array(
			'paramCode' => $circleName,
			'paramDesc' => $circleName." ",
		);
		array_push($circleNameArr,$json);
	}
}
else if($searchType == 'billingCount'){
	$period=$_REQUEST['period'];

	$billingSql = "SELECT * FROM `billing_report` WHERE `period` = '$period' ";
	$billingResult = mysqli_query($conn,$billingSql);
	$billing_report_count=mysqli_num_rows($billingResult);

}

$output = array();
$output = array('circleList' => $circleNameArr, 'billing_report_count' => $billing_report_count);
echo json_encode($output);

?>