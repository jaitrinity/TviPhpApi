<?php
ini_set('max_execution_time', 123456);
ini_set('memory_limit', '2048M');
include("cpDbConfig.php");
require 'PHPExcel/Classes/PHPExcel.php';

function getSafeRequestValue($key){
	$val = $_REQUEST[$key];
	return isset($val)? $val:"";
}

$jsonData = getSafeRequestValue('jsonData');
$jsonData=json_decode($jsonData);

$loginEmpId = $jsonData->loginEmpId;
$loginEmpRole = $jsonData->loginEmpRole;
$isHoUser = $jsonData->isHoUser;
$circleName = $jsonData->circleName;
$filterCircleName = $jsonData->filterCircleName;
$filterProductType = $jsonData->filterProductType;
$filterStartDate = $jsonData->filterStartDate;
$filterEndDate = $jsonData->filterEndDate;

$filterSql = "";
if($filterCircleName != ""){
	$filterCircleName = implode("','", explode(",", $filterCircleName));
	$filterSql .= "and `CircleCode` in ('$filterCircleName')";
}
else{
	$filterCircleName = implode("','", explode(",", $circleName));
	$filterSql .= "and `CircleCode` in ('$filterCircleName')";
}
if($filterProductType != ""){
	$filterSql .= "and sr.`TAB_NAME`='$filterProductType'";
}

if($filterStartDate != ""){
	$filterSql .= " and `SR_DATE` >= '$filterStartDate' ";
}
if($filterEndDate != ""){
	$filterSql .= " and `SR_DATE` <= '$filterEndDate' ";
}

// $srRejectStatus = "'NB97','NB98','NB99','NB100','NB101','NB102','NB104','NB105','NB106','NB107','NB108','NB110'";
// $filterSql .= " and sr.`STATUS` not in ($srRejectStatus)";

$objPHPExcel = new PHPExcel();
$border_style= array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array(
				'argb' => '000000'
			)
		)
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	)
);

$activeSheetIndex=0;
$firstRowCol=["SR_Number", "SP_Number", "SO_Number", "Ref_Number_TVIPL", "SiteId", "UniqueRequestId", "Remarks", "TAB_NAME", "STATUS", "SR_DATE", "SP_DATE", "SO_DATE", "RFI_DATE", "RFI_ACCEPTED_DATE", "TOCO_Site_Id", "Customer_Site_Id", "Customer_Site_Name", "Circle", "State", "Cell_Type", "Site_Type", "City", "Search_Ring_Radious_Mtrs", "Infill_NewTown", "ShowCase_Non_Showcase", "_3_11_Towns", "Town", "Request_for_Network_Type", "Project_Name", "Authority_Name", "Preferred_Product_Type", "Recommended_Product_Type_by_Acquisition", "Customer_Product_Type", "No_of_TMA_TMB", "Weight_of_each_TMA_TMB", "Combined_wt_of_TMA_TMB_Kgs", "Height_at_which_needs_to_be_mounted_Mtrs", "Other_Equipment", "Fiber_Required", "No_of_Fiber_Pairs", "Is_Fiber_Node_Provisioning_Required", "No_of_Pairs", "Distance_Length_of_Fiber_in_Meter", "SACFA_Number", "Is_Diesel_Generator_DG_required", "Product_Name", "Activity_Type", "Request_Ref_No", "RL_Type", "Upgrade_Type", "BSC", "BTS_Cabinet", "Extend_Tenure", "Fiber_Node_Provisioning", "Micro_to_Macro_conversion", "MW_Antenna", "Other_Nodes", "Radio_Antenna", "Strategic_Conversion", "Tower_Mounted_Booster", "MW_IDU", "Pole", "HubTag_Untag", "Other_Equipment2", "Cluster", "MSA_Type", "Name_of_District_SSA", "Withdrawal_Type", "Withdrawal_Reason", "withdraw_remark", "Accept_Reject", "Reject_Remarks", "Reject_Remarks_Others", "Rejection_Category", "Rejection_Reason", "Reject_SP_Remark", "Financial_Site_Id", "Expected_monthly_Rent_Approved", "CAPEX_Amount_Approved", "OPEX_Amount_Approved", "Tentative_Billing_Amount_Approved", "Target_Date", "TargetDate_DD_MM_YYYY", "Date", "Date_of_Proposal", "Power_Rating", "Site_Electrification_Distance", "Tentative_EB_Availibility", "Additional_Charge", "Address1", "Head_Load_Charge", "Electrification_Cost", "Electrification_Line_Distance", "Electricity_Connection_HT_LT", "Infra_Details", "Site_Classification", "Expected_Rent_to_Landlord", "Non_Refundable_Deposit", "Estimated_Deployment_Time__in_days_", "Additional_Capex", "Standard_Rates", "Fiber_Charges", "Rental_Threshold", "Excess_Rent_beyond_Threshold", "Tentative_Rental_Premium", "Additional_Rent", "IPFee", "Field_Operation_Charges", "Security_Guard_Charges", "Mobilization_Charges", "Erection_Charges", "Battery_backup_Hrs", "Land_Lord_Charges_or_Rent_Charges", "Wind_Speed", "TowerHeight", "Agl", "Distance_from_P1_Lat_Long_in_meter", "Rejection_Remarks", "Difficult", "Tower_Completion", "Shelter_Equipment_RoomReady", "AirConditioner_Commissioned", "DG_Commissioned", "Acceptance_Testing_Of_Site_Infrastructure_Completed_Status", "EB_Status", "Created_By", "OFC_Duct_Laying_Done", "Access_To_Site_Available_Status", "Engineer_Name", "Engineer_Phone_Number", "Notice_Form_Generation_Date", "Tenure_In_Years", "SO_Accept_Reject", "RFI_Accept_Reject", "RFI_Reject_Remarks", "RFI_Reject_Remarks_Others", "Total_Rated_Power_In_KW", "Total_Rated_Power_In_Watt", "Sharing_Potential", "SP_Latitude", "SP_Longitude", "Clutter", "Force_Reject", "SuggesstedSiteAddress", "SuggestedDistrict", "SuggestedState", "SuggestedPincode", "SuggestedTownVillage", "SuggestedCity", "SuggestedLatitude", "SuggestedLongitude", "SuggestedDeviation", "SuggestedTowerType", "SuggestedBuildingHeight", "SuggestedTowerHeight", "SuggestedClutter", "SuggestedLandOwnerRent", "SuggestedElectrificationCharges", "SuggestedMcCharges", "Association_AreyouWorkingInAnyBhartiGroup", "Association_IfyesmentiontheBhartiUnitName", "Association_NameOftheEmployee", "Association_EmployeeId", "Relative_AnyRelativesareWorkingWithBhartiGroup", "Relative_IfyesmentiontheBhartiUnitName", "Relative_NameOftheEmployee", "Relative_EmployeeId", "Relative_LandlordRelationshipwithEmployee", "Relative_MobileNumberOfrelativeWithAirtel", "Declaration"];
$excelColName=array();
$lastColName="";
for($cc=0;$cc<count($firstRowCol);$cc++){
	$colValue = $firstRowCol[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	$lastColName=$colName;
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
	->setCellValue($colName.'1',$colValue);
}

$srNoList = array();
$sql = "SELECT sr.`SR_Number`, `SP_Number`, `SO_Number`, `Ref_Number_TVIPL`, `SiteId`, `UniqueRequestId`, `Remarks`, (case when sr.`TAB_NAME`='CreateNBS' then 'Macro Anchor' when sr.`TAB_NAME`='HPSC' then 'HPSC Anchor' when sr.`TAB_NAME`='Site_Upgrade' then 'Site Upgrade' when sr.`TAB_NAME`='New_Tenency' then 'New Tenency' end) as `TAB_NAME`, s.`AirtelStatus` as `STATUS`, `SR_DATE`, `SP_DATE`, `SO_DATE`, `RFI_DATE`, `RFI_ACCEPTED_DATE`, `TOCO_Site_Id`, `Customer_Site_Id`, `Customer_Site_Name`, `Circle`, `State`, `Cell_Type`, `Site_Type`, `City`, `Search_Ring_Radious_Mtrs`, `Infill_NewTown`, `ShowCase_Non_Showcase`, `_3_11_Towns`, `Town`, `Request_for_Network_Type`, `Project_Name`, `Authority_Name`, `Preferred_Product_Type`, `Recommended_Product_Type_by_Acquisition`, `Customer_Product_Type`, `No_of_TMA_TMB`, `Weight_of_each_TMA_TMB`, `Combined_wt_of_TMA_TMB_Kgs`, `Height_at_which_needs_to_be_mounted_Mtrs`, `Other_Equipment`, `Fiber_Required`, `No_of_Fiber_Pairs`, `Is_Fiber_Node_Provisioning_Required`, `No_of_Pairs`, `Distance_Length_of_Fiber_in_Meter`, `SACFA_Number`, `Is_Diesel_Generator_DG_required`, `Product_Name`, `Activity_Type`, `Request_Ref_No`, `RL_Type`, `Upgrade_Type`, `BSC`, `BTS_Cabinet`, `Extend_Tenure`, `Fiber_Node_Provisioning`, `Micro_to_Macro_conversion`, `MW_Antenna`, `Other_Nodes`, `Radio_Antenna`, `Strategic_Conversion`, `Tower_Mounted_Booster`, `MW_IDU`, `Pole`, `HubTag_Untag`, `Other_Equipment2`, `Cluster`, `MSA_Type`, `Name_of_District_SSA`, `Withdrawal_Type`, `Withdrawal_Reason`, `withdraw_remark`, `Accept_Reject`, `Reject_Remarks`, `Reject_Remarks_Others`, `Rejection_Category`, `Rejection_Reason`, `Reject_SP_Remark`, `Financial_Site_Id`, `Expected_monthly_Rent_Approved`, `CAPEX_Amount_Approved`, `OPEX_Amount_Approved`, `Tentative_Billing_Amount_Approved`, `Target_Date`, `TargetDate_DD_MM_YYYY`, `Date`, `Date_of_Proposal`, `Power_Rating`, `Site_Electrification_Distance`, `Tentative_EB_Availibility`, `Additional_Charge`, `Address1`, `Head_Load_Charge`, `Electrification_Cost`, `Electrification_Line_Distance`, `Electricity_Connection_HT_LT`, `Infra_Details`, `Site_Classification`, `Expected_Rent_to_Landlord`, `Non_Refundable_Deposit`, `Estimated_Deployment_Time__in_days_`, `Additional_Capex`, `Standard_Rates`, `Fiber_Charges`, `Rental_Threshold`, `Excess_Rent_beyond_Threshold`, `Tentative_Rental_Premium`, `Additional_Rent`, `IPFee`, `Field_Operation_Charges`, `Security_Guard_Charges`, `Mobilization_Charges`, `Erection_Charges`, `Battery_backup_Hrs`, `Land_Lord_Charges_or_Rent_Charges`, `Wind_Speed`, `TowerHeight`, `Agl`, `Distance_from_P1_Lat_Long_in_meter`, `Rejection_Remarks`, `Difficult`, `Tower_Completion`, `Shelter_Equipment_RoomReady`, `AirConditioner_Commissioned`, `DG_Commissioned`, `Acceptance_Testing_Of_Site_Infrastructure_Completed_Status`, `EB_Status`, `Created_By`, `OFC_Duct_Laying_Done`, `Access_To_Site_Available_Status`, `Engineer_Name`, `Engineer_Phone_Number`, `Notice_Form_Generation_Date`, `Tenure_In_Years`, `SO_Accept_Reject`, `RFI_Accept_Reject`, `RFI_Reject_Remarks`, `RFI_Reject_Remarks_Others`, `Total_Rated_Power_In_KW`, `Total_Rated_Power_In_Watt`, `Sharing_Potential`, `SP_Latitude`, `SP_Longitude`, `Clutter`, `Force_Reject`, `SuggesstedSiteAddress`, `SuggestedDistrict`, `SuggestedState`, `SuggestedPincode`, `SuggestedTownVillage`, `SuggestedCity`, `SuggestedLatitude`, `SuggestedLongitude`, `SuggestedDeviation`, `SuggestedTowerType`, `SuggestedBuildingHeight`, `SuggestedTowerHeight`, `SuggestedClutter`, `SuggestedLandOwnerRent`, `SuggestedElectrificationCharges`, `SuggestedMcCharges`, `Association_AreyouWorkingInAnyBhartiGroup`, `Association_IfyesmentiontheBhartiUnitName`, `Association_NameOftheEmployee`, `Association_EmployeeId`, `Relative_AnyRelativesareWorkingWithBhartiGroup`, `Relative_IfyesmentiontheBhartiUnitName`, `Relative_NameOftheEmployee`, `Relative_EmployeeId`, `Relative_LandlordRelationshipwithEmployee`, `Relative_MobileNumberOfrelativeWithAirtel`, `Declaration` from `Airtel_SR` sr left join `NBS_STATUS` s on sr.`TAB_NAME` = s.`TAB_NAME` and sr.`STATUS` = s.`STATUS` where 1=1 $filterSql";
// and `Id` in (20104,20103,20091,19645,19177,19153,14195,12374,12312,18721,18508,18486)
$query = mysqli_query($conn,$sql);	
$cellRow = 1;
while($row = mysqli_fetch_assoc($query)){
	array_push($srNoList, $row["SR_Number"]);

	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);

for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
}
$sheetName="SR";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex($activeSheetIndex);

$impSrList = implode("','", $srNoList);

// sheet 2 
$activeSheetIndex=1;
$objPHPExcel->createSheet();
$columnNameArr = ["SR_Number", "Feasibility", "Customer_Punched_Or_Planning", "Sector_Details", "Action", "Source", "RadioAntenna_i_WAN", "Height_AGL_m", "Azimuth_Degree", "Length_m", "Width_m", "Depth_m", "No_of_Ports", "BandFrequencyMHz_FrequencyCombination", "RadioAntenna_Type", "Total_Ports", "Max_Ports", "Bands_List", "InsertType"];

$excelColName=array();
$lastColName="";
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	$lastColName=$colName;
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
	->setCellValue($colName.'1',$colValue);
}

$sqlColName = implode("`, `", $columnNameArr);
$sql = "SELECT `$sqlColName` FROM `Airtel_Radio_Antenna` where `SR_Number` in ('$impSrList') and `InsertType` in ('SR','SP')";
$query = mysqli_query($conn,$sql);	
$cellRow = 1;
while($row = mysqli_fetch_assoc($query)){
	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
}
$sheetName="Radio_Antenna";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex($activeSheetIndex);

// sheet 3
$activeSheetIndex=2;
$objPHPExcel->createSheet();
$columnNameArr = ["SR_Number", "Feasibility", "Customer_Punched_Or_Planning", "Action", "Node_Type", "Node_Location", "Node_Manufacturer", "Node_Model", "Length_Mtrs", "Breadth_Mtrs", "Height_Mtrs", "Weight_Kg", "Node_Voltage", "Power_Rating_in_Kw", "FullRack", "Tx_Rack_Space_Required_In_Us", "Remarks", "InsertType"];

$excelColName=array();
$lastColName="";
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	$lastColName=$colName;
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
	->setCellValue($colName.'1',$colValue);
}

$sqlColName = implode("`, `", $columnNameArr);
$sql = "SELECT `$sqlColName` FROM `Airtel_Other_Node` where `SR_Number` in ('$impSrList') and `InsertType` in ('SR','SP')";
$query = mysqli_query($conn,$sql);	

$cellRow = 1;
while($row = mysqli_fetch_assoc($query)){
	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
}
$sheetName="Other_Node";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex($activeSheetIndex); 

// sheet 4
$activeSheetIndex=3;
$objPHPExcel->createSheet();
$columnNameArr = ["SR_Number", "Feasibility", "Action", "Source_Request_RefNo", "Other_Equipment_Category", "Other_Equipment_Type", "Equipment_to_be_relocated", "Target_Indus_Site_Id", "Target_Request_RefNo", "CustomerPunchedOrPlanning", "Deletion_OR_Relocation", "InsertType"];

$excelColName=array();
$lastColName="";
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	$lastColName=$colName;
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
	->setCellValue($colName.'1',$colValue);
}

$sqlColName = implode("`, `", $columnNameArr);
$sql = "SELECT `$sqlColName` FROM `Airtel_Other_Equipment` where `SR_Number` in ('$impSrList') and `InsertType` in ('SR','SP')";
$query = mysqli_query($conn,$sql);	
$cellRow = 1;
while($row = mysqli_fetch_assoc($query)){
	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
}
$sheetName="Other_Equipment";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex($activeSheetIndex);

// sheet 5
$activeSheetIndex=4;
$objPHPExcel->createSheet();
$columnNameArr = ["SR_Number", "Feasibility", "Customer_Punched_Or_Planning", "Sector_Details", "Action", "Source", "Additional_Transmission_Rack_Space_Power_Upgrade_Requirement", "TotalIDUs_Magazines_tobe_Installed", "Transmission_Rack_Space_Required_in_Us", "Power_Rating_in_Kw", "Power_Plant_Voltage", "MWAntenna_i_WAN", "Size_of_MW", "Height_in_Mtrs", "Azimuth_Degree", "InsertType"];

$excelColName=array();
$lastColName="";
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	$lastColName=$colName;
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
	->setCellValue($colName.'1',$colValue);
}

$sqlColName = implode("`, `", $columnNameArr);
$sql = "SELECT `$sqlColName` FROM `Airtel_MW` where `SR_Number` in ('$impSrList') and `InsertType` in ('SR','SP')";
$query = mysqli_query($conn,$sql);	
$cellRow = 1;
while($row = mysqli_fetch_assoc($query)){
	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
}
$sheetName="MW";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex($activeSheetIndex); 

// sheet 6
$activeSheetIndex=5;
$objPHPExcel->createSheet();
$columnNameArr = ["SR_Number", "Feasibility", "Customer_Punched_Or_Planning", "Total_No_of_MCB_Required", "_06A", "_10A", "_16A", "_24A", "_32A", "_40A", "_63A", "_80A", "InsertType"];

$excelColName=array();
$lastColName="";
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	$lastColName=$colName;
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
	->setCellValue($colName.'1',$colValue);
}

$sqlColName = implode("`, `", $columnNameArr);
$sql = "SELECT `$sqlColName` FROM `Airtel_MCB` where `SR_Number` in ('$impSrList') and `InsertType` in ('SR','SP')";
$query = mysqli_query($conn,$sql);	
$cellRow = 1;
while($row = mysqli_fetch_assoc($query)){
	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
}
$sheetName="MCB";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex($activeSheetIndex); 

// sheet 7
$activeSheetIndex=6;
$objPHPExcel->createSheet();
$columnNameArr = ["SR_Number", "Feasibility", "Customer_Punched_Or_Planning", "Action", "Source", "Node_Type", "Node_Location", "Node_Manufacturer", "Node_Model", "Length_Mtrs", "Breadth_Mtrs", "Height_Mtrs", "Weight_Kg", "Node_Voltage", "Power_Rating_in_Kw", "FullRack", "Tx_Rack_Space_required_in_Us", "Is_Right_Of_Way_ROW_Required_Inside_The_Indus_Premises", "Type_Of_Fiber_Laying", "Type_Of_FMS", "Remarks", "Full_Rack", "InsertType"];

$excelColName=array();
$lastColName="";
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	$lastColName=$colName;
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
	->setCellValue($colName.'1',$colValue);
}

$sqlColName = implode("`, `", $columnNameArr);
$sql = "SELECT `$sqlColName` FROM `Airtel_Fibre_Node` where `SR_Number` in ('$impSrList') and `InsertType` in ('SR','SP')";
$query = mysqli_query($conn,$sql);	
$cellRow = 1;
while($row = mysqli_fetch_assoc($query)){
	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
}
$sheetName="Fibre_Node";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex($activeSheetIndex); 

// sheet 8
$activeSheetIndex=7;
$objPHPExcel->createSheet();
$columnNameArr = ["SR_Number", "Feasibility", "Customer_Punched_Or_Planning", "Action", "Source", "Config_type_1", "Config_type_2", "Config_type_3", "Config_Carriers", "NetWork_Type", "BTS_Type", "Band", "Manufacturer", "Make_of_BTS", "Length_Mtrs", "Width_Mtrs", "Height_Mtrs", "BTS_Power_Rating_KW", "BTS_Location", "BTS_Voltage", "Main_Unit_incase_of_TT_Split_Version", "Space_Occupied_in_Us_incase_of_TT_Split_Version", "RRU_Unit", "No_of_RRU_Units_incase_of_TT_Split_Version", "Combined_wt_of_RRU_Unit_incase_of_TT_Split_Version", "AGL_of_RRU_unit_in_M", "Weight_of_BTS_including_TMA_TMB_Kg", "Billable_Weigtht", "InsertType"];

$excelColName=array();
$lastColName="";
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	$lastColName=$colName;
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
	->setCellValue($colName.'1',$colValue);
}

$sqlColName = implode("`, `", $columnNameArr);
$sql = "SELECT `$sqlColName` FROM `Airtel_BTS` where `SR_Number` in ('$impSrList') and `InsertType` in ('SR','SP')";
$query = mysqli_query($conn,$sql);	
$cellRow = 1;
while($row = mysqli_fetch_assoc($query)){
	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
}
$sheetName="BTS";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex($activeSheetIndex); 

// sheet 9
$activeSheetIndex=8;
$objPHPExcel->createSheet();
$columnNameArr = ["SR_Number", "Is_it_Strategic", "Shelter_Size", "Length_Mtrs", "Breadth_Mtrs", "Height_AGL_Mtrs", "DG_Redundancy", "Extra_Battery_Bank_Requirement", "Extra_Battery_BackUp", "Anyother_Specific_Requirements", "Additional_Info_If_any", "Other_Additional_Info1", "Other_Additional_Info2", "TargetDate_DD_MM_YYYY", "Is_it_Relocaiton_SR", "Source_Req_Ref_No", "Source_Indus_SiteId", "Relocaiton_Reason"];

$excelColName=array();
$lastColName="";
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	$lastColName=$colName;
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
	->setCellValue($colName.'1',$colValue);
}

$sqlColName = implode("`, `", $columnNameArr);
$sql = "SELECT `$sqlColName` FROM `Airtel_Additional_Information` where `SR_Number` in ('$impSrList')";
$query = mysqli_query($conn,$sql);	
$cellRow = 1;
while($row = mysqli_fetch_assoc($query)){
	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
}
$sheetName="Additional_Information";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex($activeSheetIndex); 

// sheet 10
$activeSheetIndex=9;
$objPHPExcel->createSheet();
$columnNameArr = ["SR_Number", "P1_Site_Address", "P1_Tower_Type", "P1_Latitude", "P1_Longitude", "P1_LandLord_Contact_Detail", "P2_Site_Address", "P2_Tower_Type", "P2_Latitude", "P2_Longitude", "P2_LandLord_Contact_Detail", "P3_Site_Address", "P3_Tower_Type", "P3_Latitude", "P3_Longitude", "P3_LandLord_Contact_Detail"];

$excelColName=array();
$lastColName="";
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	$lastColName=$colName;
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
	->setCellValue($colName.'1',$colValue);
}
$sqlColName = implode("`, `", $columnNameArr);
$sql = "SELECT `$sqlColName` FROM `Airtel_Priority_Details` where `SR_Number` in ('$impSrList')";
$query = mysqli_query($conn,$sql);	
$cellRow = 1;
while($row = mysqli_fetch_assoc($query)){
	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex($activeSheetIndex)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
}
$sheetName="Priority_Details";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex($activeSheetIndex); 

// =======================================================
$filename = "I Deploye Details Report";
header('Content-Type: application/vnd.ms-excel');
header('Cache-Control: max-age=0');
// $fileExt = "xls";
$fileExt = "xlsx";
if($fileExt == "xls"){
	header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
}
else if($fileExt == "xlsx"){
	header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
}
$objWriter->save('php://output');
exit;
?>


<?php 
function numberToColumnName($number){
    $abc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $abc_len = strlen($abc);

    $result_len = 1; // how much characters the column's name will have
    $pow = 0;
    while( ( $pow += pow($abc_len, $result_len) ) < $number ){
        $result_len++;
    }

    $result = "";
    $next = false;
    // add each character to the result...
    for($i = 1; $i<=$result_len; $i++){
        $index = ($number % $abc_len) - 1; // calculate the module

        // sometimes the index should be decreased by 1
        if( $next || $next = false ){
            $index--;
        }

        // this is the point that will be calculated in the next iteration
        $number = floor($number / strlen($abc));

        // if the index is negative, convert it to positive
        if( $next = ($index < 0) ) {
            $index = $abc_len + $index;
        }

        $result = $abc[$index].$result; // concatenate the letter
    }
    return $result;
}
?>