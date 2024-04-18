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
	$unionClause = " union ";

	$airtel = "";
	if(strtotime($firstDate) < strtotime($compDate)){
		$airtel = "SELECT max(`Circle Name`) as telecom_circle, max(`Billing State`) as billing_state, max(`Sub State Name`) as sub_state_name, max(`Billing Type`) as billing_type, max(`BP Code`) as bp_code, max(`Billing nature`) as billing_nature, 'Airtel' as operator_name, max(`Energy type`) as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, max(`From Date`) as billing_start_date, max(`To Date`) as billing_end_date, `Site ID` as site_id, max(`Site Name`) as site_name, max(`Final Tenancy For Billing`) as tenancy, sum(`Diesel Rate`) as diesel_rate, sum(`Airtel Diesel Amount`) as diesel_share, '' as dg_cabex, max(`From Date`) as eb_from_date, max(`To Date`) as eb_end_date, max(`Days`) as no_of_days, sum(`EB Rate`) as eb_unit_rate, sum(`Airtel EB Amount`) as eb_share, '' as eb_cabex, sum(`Diesel+EB`) as total, '' as total_cabex   FROM `airtel_output_april` where Period in ('$periodString') and `From Date` like '%$periodString' group by `Site ID` ";
	}
	else{
		$airtel = "SELECT max(`Circle Name`) as telecom_circle, max(`Billing State`) as billing_state, '' as sub_state_name, '' as billing_type, '' as bp_code, '' as billing_nature, 'Airtel' as operator_name, '' as enery_type, SUBSTRING(`BillCycleMonth`, 1,3) as billing_month, max(`From DT`) as billing_start_date, max(`To DT`) as billing_end_date, `Site ID` as site_id, max(`Site Name`) as site_name, max(`Total no of Operators`) as tenancy, sum(`Diesel rate`) as diesel_rate, sum(`Airtel Diesel Share`) as diesel_share, '' as dg_cabex, max(`From DT`) as eb_from_date, max(`To DT`) as eb_end_date, max(`No of days`) as no_of_days, '' as eb_unit_rate, sum(`Airtel EB Share`) as eb_share, '' as eb_cabex, sum(`Airtel P&F Share Share`) as total, '' as total_cabex FROM `airtel_provision_consoldata` where `BillCycleMonth` in ('$periodString') and `From DT` like '%$periodString' group by `Site ID`";
	}

	$bsnl = "SELECT max(`Circle`) as telecom_circle, max(`Billing State`) as billing_state, max(`Sub State Name`) as sub_state_name, max(`Billing Type`) as billing_type, max(`BP Code`) as bp_code, max(`Billing nature`) as billing_nature, 'BSNL' as operator_name, max(`Energy type`) as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, max(`From_Date`) as billing_start_date, max(`To_Date`) as billing_end_date, `IP Site ID` as site_id, max(`Site Name`) as site_name, max(`No_of_Tenancy`) as tenancy, sum(`Diese Rate`) as diesel_rate, sum(`Total Diesel cost`) as diesel_share, '' as dg_cabex, max(`From_Date`) as eb_from_date, max(`To_Date`) as eb_end_date, max(`Days`) as no_of_days, sum(`EB Rate`) as eb_unit_rate, sum(`Total EB cost`) as eb_share, '' as eb_cabex, sum(`Total Amount (EB+DG)`) as total, '' as total_cabex FROM `bsnl_output_april` where Period in ('$periodString') and `From_Date` like '%$periodString' group by `IP Site ID` ";

	$pbHfcl = "SELECT max(`CIRCLE_NAME`) as telecom_circle, max(`Billing State`) as billing_state, max(`Sub State Name`) as sub_state_name, max(`Billing Type`) as billing_type, max(`BP Code`) as bp_code, max(`Billing nature`) as billing_nature, 'PB_HFCL' as operator_name, max(`Energy type`) as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, max(`From Date`) as billing_start_date, max(`To Date`) as billing_end_date, `IP Site ID` as site_id, max(`Site Name`) as site_name, max(`No_of_Tenancy`) as tenancy, sum(`DG Current Rate`) as diesel_rate, sum(`DG Billable Amt`) as diesel_share, '' as dg_cabex, max(`From Date`) as eb_from_date, max(`To Date`) as eb_end_date, max(`Days`) as no_of_days, sum(`EB Current Rate`) as eb_unit_rate, sum(`EB Billable Amt`) as eb_share, '' as eb_cabex, sum(`Final Billable Amt`) as total, '' as total_cabex FROM `pbhfcl_output_april` where Period in ('$periodString') and `From Date` like '%$periodString' group by `IP Site ID` ";


	$idea = "SELECT t1.telecom_circle, t1.billing_state, t1.sub_state_name, t1.billing_type, t1.bp_code, t1.billing_nature, t1.operator_name, t1.enery_type, t1.billing_month, t1.billing_start_date, t1.billing_end_date, t1.site_id, t1.site_name, t1.tenancy, t1.diesel_rate, t1.diesel_share, t1.dg_cabex, t1.eb_from_date, t1.eb_end_date, t1.no_of_days, t1.eb_unit_rate, t1.eb_share, t1.eb_cabex, (t1.diesel_share + t1.eb_share) as total, t1.total_cabex from (SELECT max(`Telecom Circle Name`) as telecom_circle, max(`GST State`) as billing_state, '' as sub_state_name, '' as billing_type, max(`BP Code`) as bp_code, '' as billing_nature, 'IDEA' as operator_name, '' as enery_type, SUBSTRING(`BillCycleMonth`, 1,3) as billing_month, max(`Start Date`) as billing_start_date, max(`End Date`) as billing_end_date, `TVI Site ID` as site_id, max(`TVI Site Name`) as site_name, max(`No of Operational Tenancy`) as tenancy, '' as diesel_rate, sum(`Idea Diesel Share` + `Idea Link Diesel Share`) as diesel_share, '' as dg_cabex, max(`Start Date`) as eb_from_date, max(`End Date`) as eb_end_date, max(`No of days`) as no_of_days, '' as eb_unit_rate, 
		(case 
			when (sum(`IDEA EB Share` + `Idea Link EB Share`)) = 0 and `Operator Name` = 'Idea' 
			then `VIL EB Share` 
			else 
			(sum(`IDEA EB Share` + `Idea Link EB Share`)) 
		end) as eb_share, 
	'' as eb_cabex, sum(`IDEA Total Energy Share` + `Idea Link Diesel Share` + `Idea Link EB Share`) as total, '' as total_cabex FROM `vil_output_consol` where `BillCycleMonth` in ('$periodString') and `IDEA EB Share` is not null group by `TVI Site ID`) t1 ";
	
	$rjio = "";
	if(strtotime($firstDate) < strtotime($compDate)){
		$rjio = "SELECT max(`Billing Circle`) as telecom_circle, max(`Billing State`) as billing_state, max(`Sub State Name`) as sub_state_name, '' as billing_type, max(`BP Code`) as bp_code, max(`Billing nature`) as billing_nature, 'RJIO' as operator_name, max(`Energy type`) as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, max(`EffectiveStartDate`) as billing_start_date, max(`EffectiveEndDate`) as billing_end_date, `TVI Site ID` as site_id, max(`SITE NAME`) as site_name, max(`No of Tenants`) as tenancy, sum(`DGRate`) as diesel_rate, SUM(`DG_CPH_Cabex` * `DGRate` * `DGHrs` * `NoOfDays` + `DG_Billing_Amt`) as diesel_share, sum(`Cabex_DG`) as dg_cabex, max(`EffectiveStartDate`) as eb_from_date, max(`EffectiveEndDate`) as eb_end_date, max(`NoOfDays`) as no_of_days, sum(`EBRate`) as eb_unit_rate, SUM(`EB_CPH_Cabex` * `EBRate` * `EBHrs` * `NoOfDays` + `EB_Billing_Amt`) as eb_share, sum(`Cabex_EB`) as eb_cabex, sum(`TotalAmountChargable`) as total, (sum(Cabex_DG) + sum(Cabex_EB)) as total_cabex FROM `rjio_output_april` where Period in ('$periodString') and `EffectiveStartDate` like '%$periodString' group by `TVI Site ID` ";
	}
	else{
		$rjio = "SELECT max(`Billing Circle`) as telecom_circle, max(`Billing State`) as billing_state, max(`Sub State Name`) as sub_state_name, '' as billing_type, max(`BP Code`) as bp_code, max(`Billing nature`) as billing_nature, 'RJIO' as operator_name, max(`Energy type`) as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, max(`EffectiveStartDate`) as billing_start_date, max(`EffectiveEndDate`) as billing_end_date, `TVI Site ID` as site_id, max(`SITE NAME`) as site_name, max(`No of Tenants`) as tenancy, sum(`DGRate`) as diesel_rate, SUM(`Cabex_DG` + `DG_Billing_Amt`) as diesel_share, sum(`Cabex_DG`) as dg_cabex, max(`EffectiveStartDate`) as eb_from_date, max(`EffectiveEndDate`) as eb_end_date, max(`NoOfDays`) as no_of_days, sum(`EBRate`) as eb_unit_rate, SUM(`Cabex_EB` + `EB_Billing_Amt`) as eb_share, sum(`Cabex_EB`) as eb_cabex, sum(`TotalAmountChargable`) as total, (sum(Cabex_DG) + sum(Cabex_EB)) as total_cabex FROM `rjio_output_april` where Period in ('$periodString') and `EffectiveStartDate` like '%$periodString' group by `TVI Site ID` ";
	}

	$tclWimax = "SELECT max(`Circle Name`) as telecom_circle, max(`Billing State`) as billing_state, max(`Sub State Name`) as sub_state_name, '' as billing_type, max(`BP Code`) as bp_code, max(`Billing nature`) as billing_nature, 'TCL_Wimax' as operator_name, max(`Energy type`) as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, max(`From Date`) as billing_start_date, max(`To Date`) as billing_end_date, `IP Site ID` as site_id, max(`Site Name`) as site_name, max(`No_of_Tenancy`) as tenancy, sum(`DG Current Rate`) as diesel_rate, sum(`DG Billable Amt`) as diesel_share, '' as dg_cabex, max(`From Date`) as eb_from_date, max(`To Date`) as eb_end_date, '' as no_of_days, sum(`EB Current Rate`) as eb_unit_rate, sum(`EB Billable Amt`) as eb_share, '' as eb_cabex, sum(`Final Billable Amt`) as total, '' as total_cabex FROM `tcl_output_april` where Period in ('$periodString') and `CustomerName` = 'TCL-Wimax' and `From Date` like '%$periodString' group by `IP Site ID` ";

	$tclNld = "SELECT max(`Circle Name`) as telecom_circle, max(`Billing State`) as billing_state, max(`Sub State Name`) as sub_state_name, '' as billing_type, max(`BP Code`) as bp_code, max(`Billing nature`) as billing_nature, 'TCL_NLD' as operator_name, max(`Energy type`) as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, max(`From Date`) as billing_start_date, max(`To Date`) as billing_end_date, `IP Site ID` as site_id, max(`Site Name`) as site_name, max(`No_of_Tenancy`) as tenancy, sum(`DG Current Rate`) as diesel_rate, sum(`DG Billable Amt`) as diesel_share, '' as dg_cabex, max(`From Date`) as eb_from_date, max(`To Date`) as eb_end_date, '' as no_of_days, sum(`EB Current Rate`) as eb_unit_rate, sum(`EB Billable Amt`) as eb_share, '' as eb_cabex, sum(`Final Billable Amt`) as total, '' as total_cabex   FROM `tcl_output_april` where Period in ('$periodString') and `CustomerName` = 'TCL - NLD' and `From Date` like '%$periodString' group by `IP Site ID` ";

	$ttsl = "SELECT max(`Circle`) as telecom_circle, max(`Billing State`) as billing_state, max(`Sub State Name`) as sub_state_name, '' as billing_type, max(`BP Code`) as bp_code, max(`Billing nature`) as billing_nature, 'TTSL' as operator_name, max(`Energy type`) as enery_type, SUBSTRING(`Period`, 1,3) as billing_month, max(`From DT`) as billing_start_date, max(`To DT`) as billing_end_date, `SITE ID` as site_id, max(`SITE NAME`) as site_name, max(`Total no of Operators`) as tenancy, sum(`Diesel rate`) as diesel_rate, sum(`Total Diesel Share`) as diesel_share, '' as dg_cabex, max(`From DT`) as eb_from_date, max(`To DT`) as eb_end_date, max(`No of days`) as no_of_days, '' as eb_unit_rate, sum(`Total EB Share`) as eb_share, '' as eb_cabex, sum(`Total P&F Share`) as total, '' as total_cabex   FROM `ttsl_output_april` where Period in ('$periodString') and `From DT` like '%$periodString' group by `SITE ID` ";

	$vodafone = "SELECT t1.telecom_circle, t1.billing_state, t1.sub_state_name, t1.billing_type, t1.bp_code, t1.billing_nature, t1.operator_name, t1.enery_type, t1.billing_month, t1.billing_start_date, t1.billing_end_date, t1.site_id, t1.site_name, t1.tenancy, t1.diesel_rate, t1.diesel_share, t1.dg_cabex, t1.eb_from_date, t1.eb_end_date, t1.no_of_days, t1.eb_unit_rate, t1.eb_share, t1.eb_cabex, (t1.diesel_share + t1.eb_share) as total, t1.total_cabex from (SELECT max(`Telecom Circle Name`) as telecom_circle, max(`GST State`) as billing_state, '' as sub_state_name, '' as billing_type, max(`BP Code`) as bp_code, '' as billing_nature, 'Vodafone' as operator_name, '' as enery_type, SUBSTRING(`BillCycleMonth`, 1,3) as billing_month, max(`Start Date`) as billing_start_date, max(`End Date`) as billing_end_date, `TVI Site ID` as site_id, max(`TVI Site Name`) as site_name, max(`No of Operational Tenancy`) as tenancy, '' as diesel_rate, sum(`Vodafone Diesel Share` + `VodaLink Diesel Share`) as diesel_share, '' as dg_cabex, max(`Start Date`) as eb_from_date, max(`End Date`) as eb_end_date, max(`No of days`) as no_of_days, '' as eb_unit_rate, 
		(case 
			when (sum(`Vodafone EB Share` + `VodaLink EB Share`)) = 0 and `Operator Name` = 'Vodafone' 
			then `VIL EB Share` 
			else 
			(sum(`Vodafone EB Share` + `VodaLink EB Share`)) 
		end) as eb_share, 
		'' as eb_cabex, 
		sum(`Vodafone Total Energy Share` + `VodaLink Diesel Share` + `VodaLink EB Share`) as total, '' as total_cabex   FROM `vil_output_consol` where `BillCycleMonth` in ('$periodString') and `Vodafone EB Share` is not null group by `TVI Site ID`) t1 ";


	$allUnion = $airtel.$unionClause .$bsnl.$unionClause. $pbHfcl.$unionClause. $idea.$unionClause. $rjio.$unionClause. $tclWimax.$unionClause. $tclNld.$unionClause. 
	$ttsl.$unionClause. $vodafone;
						
						
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
//echo $billingSql2;
//echo $rowcount2;
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
