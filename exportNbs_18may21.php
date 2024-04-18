<?php
include("cpDbConfig.php");
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
$operator = $jsonData->operator;
$tabName = $jsonData->tabName;
$filterSrNumber = $jsonData->filterSrNumber;
$filterCircleName = $jsonData->filterCircleName;
$filterProductType = $jsonData->filterProductType;
$filterStartDate = $jsonData->filterStartDate;
$filterEndDate = $jsonData->filterEndDate;

if($loginEmpRole == "SnM"){
	$loginEmpRole = "S&M";	
}
else if($loginEmpRole == "HO_SnM"){
	$loginEmpRole = "HO_S&M";	
}
else if($loginEmpRole == "SnM_MIS_Head"){
	$loginEmpRole = "S&M_MIS_Head";	
}



$sql = "select h.SR_NUMBER as SR_Number, (case when h.SP_NUMBER is not null then h.SP_NUMBER else '' end) as SP_Number, 
(case when h.SO_NUMBER is not null then h.SO_NUMBER else '' end) as SO_Number, 
(case when h.AIRTEL_SITE_ID is not null then h.AIRTEL_SITE_ID  else '' end) as Site_Id, 
(case when h.Site_Name is not null then h.Site_Name else '' end) as Site_Name, 
(case when h.STATUS = 'NB10' or h.STATUS = 'NB11' or h.STATUS = 'NB12' or h.STATUS = 'NB13' or h.STATUS = 'NB14' or h.STATUS = 'NB15' or h.STATUS = 'NB16' 
or h.STATUS = 'NB17' or h.STATUS = 'NB18' or h.STATUS = 'NB19' or h.STATUS = 'NB20' or h.STATUS = 'RNB15' or h.STATUS = 'RNB16' then 
h.SUGGESTED_LATITUDE else h.LATITUDE_1 end) as Latitude, 
(case when h.STATUS = 'NB10' or h.STATUS = 'NB11' or h.STATUS = 'NB12' or h.STATUS = 'NB13' or h.STATUS = 'NB14' or h.STATUS = 'NB15' or h.STATUS = 'NB16' 
or h.STATUS = 'NB17' or h.STATUS = 'NB18' or h.STATUS = 'NB19' or h.STATUS = 'NB20' or h.STATUS = 'RNB15' or h.STATUS = 'RNB16' then 
h.SUGGESTED_LONGITUDE else h.LONGITUDE_1 end) as Longitude, 
(h.Operator) as Operator, 
(case when h.TAB_NAME = 'CreateNBS' then 'Macro Anchor' when h.TAB_NAME = 'ODSC_Anchor' then 'ODSC Anchor' else h.TAB_NAME end) as Product_Type, 
(case when h.SR_DATE is not null then h.SR_DATE else '' end) as SR_Raise_Date, (case when h.SP_DATE is not null then h.SP_DATE else '' end) as SP_Raise_Date, 
(case when h.SO_DATE is not null then h.SO_DATE else '' end) as SO_Raise_Date, (case when h.RFI_DATE is not null then h.RFI_DATE else '' end ) as RFI_Date, 
(case when h.RFI_ACCEPTED_DATE is not null then h.RFI_ACCEPTED_DATE else '' end) as RFI_Accepted_Date, 
(case when h.RFS_DATE is not null then h.RFS_DATE else '' end) as RFS_Date, (h.CIRCLE_NAME) as Circle_Name, 
(h.TAB_NAME) as pageType, h.STATUS, "; 

if($loginEmpRole != 'OPCO'){
	$sql .= "(SELECT s.DESCRIPTION FROM `NBS_STATUS` s where s.STATUS = h.STATUS and s.TAB_NAME = h.TAB_NAME) as Pending_For ";
}
else {
	$sql .= " (case 
			when ((h.TAB_NAME = 'CreateNBS' or h.TAB_NAME = 'ODSC_Anchor') and (h.STATUS = 'NB19' or h.STATUS = 'NB100')) 
					then (SELECT s.DESCRIPTION FROM `NBS_STATUS` s where s.STATUS = h.STATUS and s.TAB_NAME = h.TAB_NAME) 
			when ((h.TAB_NAME = 'New_Tenency') and (h.Status = 'NB10' or h.STATUS = 'NB100')) 
					then (SELECT s.DESCRIPTION FROM `NBS_STATUS` s where s.STATUS = h.STATUS and s.TAB_NAME = h.TAB_NAME)
			when ((h.TAB_NAME = 'Site_Upgrade') and (h.Status = 'NB08' or h.STATUS = 'NB100')) 
					then (SELECT s.DESCRIPTION FROM `NBS_STATUS` s where s.STATUS = h.STATUS and s.TAB_NAME = h.TAB_NAME)

			else 'WIP' end) as Pending_For ";
}

$sql .= "from NBS_MASTER_HDR h where h.SR_NUMBER is not null ";


if($operator != 'TVI'){
	$sql .= " and h.Operator = '$operator' ";
}

if($filterSrNumber != ""){
	$sql .= " and (h.SR_NUMBER like '%$filterSrNumber%' or  h.SP_NUMBER like '%$filterSrNumber%' or h.SO_NUMBER like '%$filterSrNumber%') ";
}

if($filterCircleName != ""){
	$sql .= " and h.CIRCLE_NAME = '$filterCircleName' ";
}
else{
	$inOpCircle = prepareInOperatorStr(explode(",", $circleName));
	$sql .= " and h.CIRCLE_NAME in ($inOpCircle) ";
}

if($filterProductType != ""){
	$sql .= " and h.TAB_NAME = '$filterProductType' ";
}

if($filterStartDate != ""){
	$sql .= " and h.CREATE_DATE >= '$filterStartDate' ";
}else{
	$sql .= " and h.CREATE_DATE >= '2020-07-01' ";
}

if($filterEndDate != ""){
	$sql .= " and h.CREATE_DATE <= '$filterEndDate' ";
}
$sql .= " order by h.CREATE_DATE desc ";

// echo $sql;

$result = mysqli_query($conn,$sql);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=TVI_Report.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('SR_Number', 'SP_Number', 'SO_Number', 'Site_Id', 'Site_Name', 'Latitude', 'Longitude', 'Operator', 'Product_Type', 'SR_Raise_Date', 
	'SP_Raise_Date', 'SO_Raise_Date', 'RFI_Date', 'RFI_Accepted_Date', 'RFS_Date', 'Circle_Name', 'Pending_For'));

if($tabName == "dashbord"){

	while($row=mysqli_fetch_assoc($result)){
		$nbsStatus = $row["STATUS"];
		$pageType = $row["pageType"];

		$approvalFlowSql = "SELECT * FROM `Approval_Flow` where find_in_set('$nbsStatus',`Status`) <> 0 and `User_Role` = '$loginEmpRole' and `TAB_NAME` = '$pageType' 
		and `Is_Active` = 'Y' ";
		$approvalFlowResult = mysqli_query($conn,$approvalFlowSql);

		if(mysqli_num_rows($approvalFlowResult) !=0){
		
			$exportData = array('col1' => $row["SR_Number"], 'col2' => $row["SP_Number"], 'col3' => $row["SO_Number"], 'col4' => $row["Site_Id"], 
			'col5' => $row["Site_Name"], 'col6' => $row["Latitude"], 'col7' => $row["Longitude"], 'col8' => $row["Operator"], 'col9' => $row["Product_Type"], 
			'col10' => $row["SR_Raise_Date"], 'col11' => $row["SP_Raise_Date"], 'col12' => $row["SO_Raise_Date"], 'col13' => $row["RFI_Date"], 
			'col14' => $row["RFI_Accepted_Date"], 'col15' => $row["RFS_Date"], 'col16' => $row["Circle_Name"], 'col17' => $row["Pending_For"]);

			fputcsv($output, $exportData);
		}
	} 
}
else{

	while($row=mysqli_fetch_assoc($result)){
		$exportData = array('col1' => $row["SR_Number"], 'col2' => $row["SP_Number"], 'col3' => $row["SO_Number"], 'col4' => $row["Site_Id"], 
		'col5' => $row["Site_Name"], 'col6' => $row["Latitude"], 'col7' => $row["Longitude"], 'col8' => $row["Operator"], 'col9' => $row["Product_Type"], 
		'col10' => $row["SR_Raise_Date"], 'col11' => $row["SP_Raise_Date"], 'col12' => $row["SO_Raise_Date"], 'col13' => $row["RFI_Date"], 
		'col14' => $row["RFI_Accepted_Date"], 'col15' => $row["RFS_Date"], 'col16' => $row["Circle_Name"], 'col17' => $row["Pending_For"]);

		fputcsv($output, $exportData);
	}
}

	

?>

<?php
function prepareInOperatorStr($dataList){
	$inOperatorStr = "";
	for($i=0;$i<count($dataList);$i++){
		$inOperatorStr .= "'".$dataList[$i]. "'";
		if($i < count($dataList)-1){
			$inOperatorStr .= ',';
		}
	}
	return $inOperatorStr;
}
?>


