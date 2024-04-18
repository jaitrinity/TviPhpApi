<?php
include("dbConfiguration.php");

$period = $_REQUEST['period'];
/* $operatorName = $_REQUEST['operatorName'];
$circleName = $_REQUEST['circleName']; */

$firstDate = date('d-M-y', strtotime('01-'.$period));
$lastDate = date('t-M-y', strtotime('01-'.$period));
$datediff = (strtotime($lastDate) - strtotime($firstDate));
$noOfDays = round($datediff / (60 * 60 * 24)) +1;
$compDate = date('d-M-y', strtotime('01-Apr-21'));


$billingSql = "SELECT * FROM `billing_report` WHERE `period` = '$period' ";

$periodString = implode("','", explode(",",$period));
// $operatorNameString = implode("','", explode(",",$operatorName));
// $circleNameString = implode("','", explode(",",$circleName));

/* echo $periodString."\n"; 
echo $operatorNameString."\n";
echo $circleNameString."\n"; */

$operatorNameString = "";
if($operatorNameString != ''){
	$billingSql .= "and `operator_name` in ('$operatorNameString') ";
}

$circleNameString = "";
if($circleNameString != ''){
	$billingSql .= "and `telecom_circle` in ('$circleNameString') ";
}
//echo $billingSql;
$billingResult = mysqli_query($conn,$billingSql);
$rowcount=mysqli_num_rows($billingResult);
if($rowcount == 0){
	$unionClause = " Union All ";

	$airtel = "";
	if(strtotime($firstDate) < strtotime($compDate)){
		$airtel = "SELECT `Circle Name` as telecom_circle, `Billing State` as billing_state, '' as sub_state_name, '' as billing_type, '' as bp_code, '' as billing_nature, 'Airtel' as operator_name, '' as enery_type, SUBSTRING(`BillCycleMonth`, 1,3) as billing_month, `From DT` as billing_start_date, `To DT` as billing_end_date, `Site ID` as site_id, `Site Name` as site_name, `Total no of Operators` as tenancy, `Diesel rate` as diesel_rate, `Airtel Diesel Share` as diesel_share, '' as dg_cabex, `EB Bill from Date` as eb_from_date, `EB bill upto Date` as eb_end_date, `No of days` as no_of_days, '' as eb_unit_rate, `Airtel EB Share` as eb_share, '' as eb_cabex, `Airtel P&F Share Share` as total, '' as total_cabex, `BillCycleMonth` as `Period` FROM `airtel_provision_consoldata` where `BillCycleMonth` in ('$periodString') ";
	}
	else{
		if($periodString == 'Apr-21'){
			$airtel = "SELECT `Circle Name` as telecom_circle, `Billing State` as billing_state, '' as sub_state_name, '' as billing_type, '' as bp_code, '' as billing_nature, 'Airtel' as operator_name, '' as enery_type, SUBSTRING(`BillCycleMonth`, 1,3) as billing_month, `From DT` as billing_start_date, `To DT` as billing_end_date, `Site ID` as site_id, `Site Name` as site_name, `Total no of Operators` as tenancy, `Diesel rate` as diesel_rate, `Airtel Diesel Share` as diesel_share, '' as dg_cabex, `EB Bill from Date` as eb_from_date, `EB bill upto Date` as eb_end_date, `No of days` as no_of_days, '' as eb_unit_rate, `Airtel EB Share` as eb_share, '' as eb_cabex, `Airtel P&F Share Share` as total, '' as total_cabex, `BillCycleMonth` as `Period` FROM `airtel_provision_consoldata` where `BillCycleMonth` in ('$periodString') 
			Union All
			SELECT `Circle Name` as telecom_circle, `Billing State` as billing_state, `Sub State Name` as sub_state_name, `Billing Type` as billing_type, `BP Code` as bp_code, `Billing nature` as billing_nature, 'Airtel' as operator_name, `Energy type` as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, `From Date` as billing_start_date, `To Date` as billing_end_date, `Site ID` as site_id, `Site Name` as site_name, `Final Tenancy For Billing` as tenancy, `Diesel Rate` as diesel_rate, `Airtel Diesel Amount` as diesel_share, '' as dg_cabex, `From Date` as eb_from_date, `To Date` as eb_end_date, `Days` as no_of_days, `EB Rate` as eb_unit_rate, `Airtel EB Amount` as eb_share, '' as eb_cabex, `Diesel+EB` as total, '' as total_cabex, `Period`   FROM `airtel_output_april` where `Period` in ('$periodString') and `Billing nature` is null ";
		}
		else{
			$airtel = "SELECT `Circle Name` as telecom_circle, `Billing State` as billing_state, '' as sub_state_name, '' as billing_type, '' as bp_code, '' as billing_nature, 'Airtel' as operator_name, '' as enery_type, SUBSTRING(`BillCycleMonth`, 1,3) as billing_month, `From DT` as billing_start_date, `To DT` as billing_end_date, `Site ID` as site_id, `Site Name` as site_name, `Total no of Operators` as tenancy, `Diesel rate` as diesel_rate, `Airtel Diesel Share` as diesel_share, '' as dg_cabex, `EB Bill from Date` as eb_from_date, `EB bill upto Date` as eb_end_date, `No of days` as no_of_days, '' as eb_unit_rate, `Airtel EB Share` as eb_share, '' as eb_cabex, `Airtel P&F Share Share` as total, '' as total_cabex, `BillCycleMonth` as `Period` FROM `airtel_provision_consoldata` where `BillCycleMonth` in ('$periodString') ";
		}
		
	}

	$bsnl = "SELECT `Circle` as telecom_circle, `Billing State` as billing_state, `Sub State Name` as sub_state_name, `Billing Type` as billing_type, `BP Code` as bp_code, `Billing nature` as billing_nature, 'BSNL' as operator_name, `Energy type` as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, `From_Date` as billing_start_date, `To_Date` as billing_end_date, `IP Site ID` as site_id, `Site Name` as site_name, `No_of_Tenancy` as tenancy, `Diese Rate` as diesel_rate, `Total Diesel cost` as diesel_share, '' as dg_cabex, '' as eb_from_date, '' as eb_end_date, `Days` as no_of_days, `EB Rate` as eb_unit_rate, `Total EB cost` as eb_share, '' as eb_cabex, `Total Amount (EB+DG)` as total, '' as total_cabex, `Period` as `Period` FROM `bsnl_output_april` where `Period` in ('$periodString')";

	$pbHfcl = "SELECT `CIRCLE_NAME` as telecom_circle, `Billing State` as billing_state, `Sub State Name` as sub_state_name, `Billing Type` as billing_type, `BP Code` as bp_code, `Billing nature` as billing_nature, 'PB_HFCL' as operator_name, `Energy type` as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, `From Date` as billing_start_date, `To Date` as billing_end_date, `IP Site ID` as site_id, `Site Name` as site_name, `No_of_Tenancy` as tenancy, `DG Current Rate` as diesel_rate, `DG Billable Amt` as diesel_share, '' as dg_cabex, '' as eb_from_date, '' as eb_end_date, `Days` as no_of_days, `EB Current Rate` as eb_unit_rate, `EB Billable Amt` as eb_share, '' as eb_cabex, `Final Billable Amt` as total, '' as total_cabex, `Period` as `Period` FROM `pbhfcl_output_april` where `Period` in ('$periodString') ";

	
	$rjio = "";
	if(strtotime($firstDate) < strtotime($compDate)){
		$rjio = "SELECT `Billing Circle` as telecom_circle, `Billing State` as billing_state, `Sub State Name` as sub_state_name, '' as billing_type, `BP Code` as bp_code, `Billing nature` as billing_nature, 'RJIO' as operator_name, `Energy type` as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, `EffectiveStartDate` as billing_start_date, `EffectiveEndDate` as billing_end_date, `TVI Site ID` as site_id, `SITE NAME` as site_name, `No of Tenants` as tenancy, `DGRate` as diesel_rate, (`DG_CPH_Cabex` * `DGRate` * `DGHrs` * `NoOfDays` + `DG_Billing_Amt`) as diesel_share, `Cabex_DG` as dg_cabex, `EffectiveStartDate` as eb_from_date, `EffectiveEndDate` as eb_end_date, `NoOfDays` as no_of_days, `EBRate` as eb_unit_rate, (`EB_CPH_Cabex` * `EBRate` * `EBHrs` * `NoOfDays` + `EB_Billing_Amt`) as eb_share, `Cabex_EB` as eb_cabex, `TotalAmountChargable` as total, (`Cabex_DG` + `Cabex_EB`) as total_cabex FROM `rjio_output_april` where `Period` in ('$periodString') ";
	}
	else{
		$rjio = "SELECT `Billing Circle` as telecom_circle, `Billing State` as billing_state, `Sub State Name` as sub_state_name, '' as billing_type, `BP Code` as bp_code, `Billing nature` as billing_nature, 'RJIO' as operator_name, `Energy type` as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, `EffectiveStartDate` as billing_start_date, `EffectiveEndDate` as billing_end_date, `TVI Site ID` as site_id, `SITE NAME` as site_name, `No of Tenants` as tenancy, `DGRate` as diesel_rate, (`Cabex_DG` + `DG_Billing_Amt`) as diesel_share, `Cabex_DG` as dg_cabex, '' as eb_from_date, '' as eb_end_date, `NoOfDays` as no_of_days, `EBRate` as eb_unit_rate, (`Cabex_EB` + `EB_Billing_Amt`) as eb_share, `Cabex_EB` as eb_cabex, `TotalAmountChargable` as total, (`Cabex_DG` + `Cabex_EB`) as total_cabex, `Period` as `Period` FROM `rjio_output_april` where `Period` in ('$periodString') ";
	}

	$tcl = "SELECT `Circle Name` as telecom_circle, `Billing State` as billing_state, `Sub State Name` as sub_state_name, '' as billing_type, `BP Code` as bp_code, `Billing nature` as billing_nature, `CustomerName` as operator_name, `Energy type` as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, `From Date` as billing_start_date, `To Date` as billing_end_date, `IP Site ID` as site_id, `Site Name` as site_name, `No_of_Tenancy` as tenancy, `DG Current Rate` as diesel_rate, `DG Billable Amt` as diesel_share, '' as dg_cabex, '' as eb_from_date, '' as eb_end_date, '' as no_of_days, `EB Current Rate` as eb_unit_rate, `EB Billable Amt` as eb_share, '' as eb_cabex, `Final Billable Amt` as total, '' as total_cabex, `Period` as `Period` FROM `tcl_output_april` where `Period` in ('$periodString')";

	$ttsl = "SELECT `Circle` as telecom_circle, `Billing State` as billing_state, `Sub State Name` as sub_state_name, '' as billing_type, `BP Code` as bp_code, `Billing nature` as billing_nature, 'TTSL' as operator_name, `Energy type` as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, `Start Date` as billing_start_date, `End Date` as billing_end_date, `SITE ID` as site_id, `SITE NAME` as site_name, `Total no of Operators` as tenancy, `Diesel rate` as diesel_rate, `Total Diesel Share` as diesel_share, '' as dg_cabex, `From DT` as eb_from_date, `To DT` as eb_end_date, `No of days` as no_of_days, '' as eb_unit_rate, `Total EB Share` as eb_share, '' as eb_cabex, `Total P&F Share` as total, '' as total_cabex, `Period` as `Period`  FROM `ttsl_output_april` where `Period` in ('$periodString') ";

	$vil = "SELECT `Telecom Circle Name` as telecom_circle, `GST State` as billing_state, '' as sub_state_name, '' as billing_type, `BP Code` as bp_code, '' as billing_nature, `Operator Name` as operator_name, '' as enery_type, SUBSTRING(`BillCycleMonth`, 1,3) as billing_month, `Start Date` as billing_start_date, `End Date` as billing_end_date, `TVI Site ID` as site_id, `TVI Site Name` as site_name, `No of Operational Tenancy` as tenancy, '' as diesel_rate, `VIL Diesel Share` as diesel_share, '' as dg_cabex, `EB Bill from Date` as eb_from_date, `EB bill upto Date` as eb_end_date, `EBBill_No of days` as no_of_days, '' as eb_unit_rate, `VIL EB Share` as eb_share, '' as eb_cabex, `VIL Total Energy Share` as total, '' as total_cabex, `BillCycleMonth` as `Period` FROM `vil_output_consol` where `BillCycleMonth` in ('$periodString') ";


	$allUnion = $airtel.$unionClause .$bsnl.$unionClause. $pbHfcl.$unionClause. $rjio.$unionClause. $tcl.$unionClause. $ttsl.$unionClause. $vil;
						
						
	$sql = "select t.telecom_circle, t.billing_state, t.sub_state_name, t.billing_type, t.bp_code, t.billing_nature, t.operator_name, t.enery_type, t.billing_month, t.billing_start_date, t.billing_end_date, t.site_id, t.site_name, t.tenancy, t.diesel_rate, t.diesel_share, t.dg_cabex, t.eb_from_date, t.eb_end_date, t.no_of_days, t.eb_unit_rate, t.eb_share, t.eb_cabex, t.total, t.total_cabex from (".$allUnion.") t where t.site_id is not null ";

	if($operatorNameString != ""){
		$sql .= "and t.operator_name in ('$operatorNameString') ";
	}
	if($circleNameString != ""){
		$sql .= "and t.telecom_circle in ('$circleNameString') ";
	}

	//echo $sql;

	$periodUpper = strtoupper($period);

	$result = mysqli_query($conn,$sql);
	$i=0;

	$insertTable = "INSERT INTO `billing_report`(`SRNo`, `telecom_circle`, `billing_state`, `sub_state_name`, `billing_type`, `bp_code`, `billing_nature`, `operator_name`, `enery_type`, `billing_month`, `billing_start_date`, `billing_end_date`, `site_id`, `site_name`, `tenancy`, `diesel_rate`, `diesel_share`, `dg_cabex`, 
		`eb_from_date`, `eb_end_date`, `no_of_days`, `eb_unit_rate`, `eb_share`, `eb_cabex`, `total`, `total_cabex`, `period`, `create_date`) ";

	// $insertData = "";

	while($row = mysqli_fetch_assoc($result)){
		$i++;
		$srNo = str_replace('-','',$periodUpper).'_'.$i;

		$insertData = " ('".$srNo."', '".$row["telecom_circle"]."', '".$row["billing_state"]."', '".$row["sub_state_name"]."', '".$row["billing_type"]."', 
		'".$row["bp_code"]."', '".$row["billing_nature"]."', '".$row["operator_name"]."', '".$row["enery_type"]."', '".$row["billing_month"]."', 
		'".changeDateFormat($row["billing_start_date"])."', '".changeDateFormat($row["billing_end_date"])."', '".$row["site_id"]."', '".mysqli_real_escape_string($conn,$row["site_name"])."', 
		".checkIsNull($row["tenancy"]).", ".checkIsNull($row["diesel_rate"]).", 
		".checkIsNull($row["diesel_share"]).", '".$row["dg_cabex"]."', '".changeDateFormat($row["eb_from_date"])."', '".changeDateFormat($row["eb_end_date"])."', 
		".checkIsNull($row["no_of_days"]).", ".checkIsNull($row["eb_unit_rate"]).", 
		".checkIsNull($row["eb_share"]).", '".$row["eb_cabex"]."', ".checkIsNull($row["total"]).", '".$row["total_cabex"]."', '".$period."', current_timestamp) ";

		$insertSql = $insertTable.' Values '.$insertData;
		//echo $insertSql;
		if(mysqli_query($conn,$insertSql)){

		}
	}
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=billingReport.csv');
$output = fopen('php://output', 'w');

fputcsv($output, array('SRNo','telecom_circle','billing_state','sub_state_name','billing_type','bp_code','billing_nature','operator_name','enery_type','billing_month','billing_start_date','billing_end_date','site_id','site_name','tenancy','diesel_rate','diesel_share','dg_cabex','eb_from_date','eb_end_date','no_of_days','eb_unit_rate','eb_share','eb_cabex','total','total_cabex'));

$billingSql2 = $billingSql;
$billingResult2 = mysqli_query($conn,$billingSql2); 
$rowcount2=mysqli_num_rows($billingResult2);
while($roww = mysqli_fetch_assoc($billingResult2)){

	$jsonData = array('col1' => $roww['SRNo'], 'col2' => $roww['telecom_circle'], 'col3' => $roww['billing_state'], 'col4' => $roww['sub_state_name'], 
		'col25' => $roww['billing_type'],
		'col5' => $roww['bp_code'], 'col6' => $roww['billing_nature'], 'col7' => $roww['operator_name'], 'col8' => $roww['enery_type'], 
		'col9' => $roww['billing_month'], 'col10' => $roww['billing_start_date'], 'col11' => $roww['billing_end_date'], 'col12' => $roww['site_id'], 
		'col13' => $roww['site_name'], 'col14' => $roww['tenancy'], 'col15' => $roww['diesel_rate'], 'col16' => $roww['diesel_share'], 'col17' => $roww['dg_cabex'], 
		'col18' => $roww['eb_from_date'], 'col26' => $roww['eb_end_date'], 'col19' => $roww['no_of_days'], 'col20' => $roww['eb_unit_rate'], 
		'col21' => $roww['eb_share'], 'col22' => $roww['eb_cabex'], 
		'col23' => $roww['total'], 'col24' => $roww['total_cabex']);

	fputcsv($output, $jsonData);

}
?>

<?php
function changeDateFormat($orgDate){
	$date = str_replace('/', '-', $orgDate);
	$newDate = date("Y-m-d", strtotime($date));
	return $newDate;

}
function checkIsNull($orgValue){
	if($orgValue == null || trim($orgValue) == '' || trim($orgValue) == 'NULL' || trim($orgValue) == '-'){
		return 0;
	}
	return round($orgValue, 3);
}
?>
