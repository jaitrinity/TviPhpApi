<?php
include("cpDbConfig_test.php");
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
$filterTviSiteId = $jsonData->filterTviSiteId;
$filterSiteId = $jsonData->filterSiteId;
$filterProductType = $jsonData->filterProductType;
$filterSrStatus = $jsonData->filterSrStatus;
$filterOperator = $jsonData->filterOperator;
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



// $sql = "select h.SR_NUMBER as SR_Number, (case when h.SP_NUMBER is not null then h.SP_NUMBER else '' end) as SP_Number, 
// (case when h.SO_NUMBER is not null then h.SO_NUMBER else '' end) as SO_Number, 
// (h.CIRCLE_NAME) as Circle_Name, (h.TVI_SITE_ID) as TVI_SITE_ID,
// (case when h.AIRTEL_SITE_ID is not null then h.AIRTEL_SITE_ID  else '' end) as Site_Id, 
// (case when h.Site_Name is not null then h.Site_Name else '' end) as Site_Name, 
// h.TECHNOLOGY, h.ExtensionType,h.Sharing_Potential,
// (case when ((h.TAB_NAME = 'CreateNBS' or h.TAB_NAME = 'ODSC_Anchor') and (h.STATUS = 'NB10' or h.STATUS = 'NB11' or h.STATUS = 'NB12' or h.STATUS = 'NB13' or h.STATUS = 'NB14' or h.STATUS = 'NB15' or h.STATUS = 'NB16' 
// or h.STATUS = 'NB17' or h.STATUS = 'NB18' or h.STATUS = 'NB19' or h.STATUS = 'NB20' or h.STATUS = 'RNB15' or h.STATUS = 'RNB16')) then 
// h.SUGGESTED_LATITUDE when (h.TAB_NAME = 'New_Tenency' or h.TAB_NAME = 'Site_Upgrade') then h.LATITUDE_1 else h.LATITUDE_1 end) as Latitude, 
// (case when ((h.TAB_NAME = 'CreateNBS' or h.TAB_NAME = 'ODSC_Anchor') and (h.STATUS = 'NB10' or h.STATUS = 'NB11' or h.STATUS = 'NB12' or h.STATUS = 'NB13' or h.STATUS = 'NB14' or h.STATUS = 'NB15' or h.STATUS = 'NB16' 
// or h.STATUS = 'NB17' or h.STATUS = 'NB18' or h.STATUS = 'NB19' or h.STATUS = 'NB20' or h.STATUS = 'RNB15' or h.STATUS = 'RNB16')) then 
// h.SUGGESTED_LONGITUDE when (h.TAB_NAME = 'New_Tenency' or h.TAB_NAME = 'Site_Upgrade') then h.LATITUDE_1 else h.LONGITUDE_1 end) as Longitude, 
// (h.Operator) as Operator, 
// (case when h.TAB_NAME = 'CreateNBS' then 'Macro Anchor' when h.TAB_NAME = 'ODSC_Anchor' then 'ODSC Anchor' else h.TAB_NAME end) as Product_Type, 
// (case when h.SR_DATE is not null then h.SR_DATE else '' end) as SR_Raise_Date, (case when h.SP_DATE is not null then h.SP_DATE else '' end) as SP_Raise_Date, 
// (case when h.SO_DATE is not null then h.SO_DATE else '' end) as SO_Raise_Date, (case when h.RFI_DATE is not null then h.RFI_DATE else '' end ) as RFI_Date, 
// (case when h.RFI_ACCEPTED_DATE is not null then h.RFI_ACCEPTED_DATE else '' end) as RFI_Accepted_Date, 
// (case when h.RFS_DATE is not null then h.RFS_DATE else '' end) as RFS_Date,
// (h.TAB_NAME) as pageType, h.STATUS, s.DESCRIPTION as Pending_To, s.DESC_DETAILS as Pending_For ";

$sql = "select h.SR_NUMBER as SR_Number, (case when h.SP_NUMBER is not null then h.SP_NUMBER else '' end) as SP_Number, 
(case when h.SO_NUMBER is not null then h.SO_NUMBER else '' end) as SO_Number, 
(h.CIRCLE_NAME) as Circle_Name, (h.TVI_SITE_ID) as TVI_SITE_ID,
(case when h.AIRTEL_SITE_ID is not null then h.AIRTEL_SITE_ID  else '' end) as Site_Id, 
(case when h.Site_Name is not null then h.Site_Name else '' end) as Site_Name, 
h.TECHNOLOGY, h.ExtensionType,h.Sharing_Potential,
(case when h.SUGGESTED_LATITUDE is not null then h.SUGGESTED_LATITUDE else h.LATITUDE_1 end) as Latitude, 
(case when h.SUGGESTED_LONGITUDE is not null then h.SUGGESTED_LONGITUDE else h.LONGITUDE_1 end) as Longitude, 
(h.Operator) as Operator, 
(case when h.TAB_NAME = 'CreateNBS' then 'Macro Anchor' when h.TAB_NAME = 'ODSC_Anchor' then 'ODSC Anchor' else h.TAB_NAME end) as Product_Type, 
(case when h.SR_DATE is not null then h.SR_DATE else '' end) as SR_Raise_Date, (case when h.SP_DATE is not null then h.SP_DATE else '' end) as SP_Raise_Date, 
(case when h.SO_DATE is not null then h.SO_DATE else '' end) as SO_Raise_Date, (case when h.RFI_DATE is not null then h.RFI_DATE else '' end ) as RFI_Date, 
(case when h.RFI_ACCEPTED_DATE is not null then h.RFI_ACCEPTED_DATE else '' end) as RFI_Accepted_Date, 
(case when h.RFS_DATE is not null then h.RFS_DATE else '' end) as RFS_Date,
(h.TAB_NAME) as pageType, h.STATUS, s.DESCRIPTION as Pending_To, s.DESC_DETAILS as Pending_For ";

$sql .= "from NBS_MASTER_HDR h left join NBS_STATUS s on h.STATUS = s.STATUS where h.SR_NUMBER is not null and h.TAB_NAME = s.TAB_NAME ";


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

if($filterTviSiteId != ""){
	$sql .= " and h.TVI_SITE_ID like '$filterTviSiteId' ";
}

if($filterSiteId != ""){
	$sql .= " and h.AIRTEL_SITE_ID = '$filterSiteId' ";
}

if($filterProductType != ""){
	$sql .= " and h.TAB_NAME = '$filterProductType' ";
}

if($filterOperator != ""){
	$sql .= " and h.Operator = '$filterOperator' ";
}

if($filterSrStatus == "SR"){
	if($filterStartDate != "")
		$sql .= " and h.SR_DATE >= '$filterStartDate' and h.SP_DATE is null  ";
	else
		$sql .= " and h.SR_DATE is not null and h.SP_DATE is null ";
}
else if($filterSrStatus =="SP"){
	if($filterStartDate != "")
		$sql .= " and h.SP_DATE >= '$filterStartDate' and h.SO_DATE is null ";
	else
		$sql .= " and h.SP_DATE is not null and h.SO_DATE is null ";
}
else if($filterSrStatus =="SO"){
	if($filterStartDate != "")
		$sql .= " and h.SO_DATE >= '$filterStartDate' and h.RFI_DATE is null ";
	else
		$sql .= " and h.SO_DATE is not null and h.RFI_DATE is null ";
}
else if($filterSrStatus =="RFI"){
	if($filterStartDate != "")
		$sql .= " and h.RFI_DATE >= '$filterStartDate' and h.RFI_ACCEPTED_DATE is null ";
	else
		$sql .= " and h.RFI_DATE is not null and h.RFI_ACCEPTED_DATE is null ";
}
else if($filterSrStatus =="RFI Accepted"){
	if($filterStartDate != "")
		$sql .= " and h.RFI_ACCEPTED_DATE >= '$filterStartDate' and h.RFS_DATE is null ";
	else
		$sql .= " and h.RFI_ACCEPTED_DATE is not null and h.RFS_DATE is null ";
}
else if($filterSrStatus =="RFS"){
	if($filterStartDate != "")
		$sql .= " and h.RFS_DATE >= '$filterStartDate' ";
	else
		$sql .= " and h.RFS_DATE is not null ";
}
else{
	if($filterStartDate != ""){
		$sql .= " and DATE_FORMAT(h.CREATE_DATE,'%Y-%m-%d') >= '$filterStartDate' ";
	}
	else{
		$sql .= " and DATE_FORMAT(h.CREATE_DATE,'%Y-%m-%d') >= '2020-07-01' ";
	}
}

if($filterEndDate != ""){
	if($filterSrStatus =="SR"){
		$sql .= " and h.SR_DATE <= '$filterEndDate' ";
	}
	else if($filterSrStatus =="SP"){
		$sql .= " and h.SP_DATE <= '$filterEndDate' ";
	}
	else if($filterSrStatus =="SO"){
		$sql .= " and h.SO_DATE <= '$filterEndDate' ";
	}
	else if($filterSrStatus =="RFI"){
		$sql .= " and h.RFI_DATE <= '$filterEndDate' ";
	}
	else if($filterSrStatus =="RFI Accepted"){
		$sql .= " and h.RFI_ACCEPTED_DATE <= '$filterEndDate' ";
	}
	else if($filterSrStatus =="RFS"){
		$sql .= " and h.RFS_DATE <= '$filterEndDate' ";
	}
	else{
		$sql .= " and DATE_FORMAT(h.CREATE_DATE,'%Y-%m-%d') <= '$filterEndDate' ";
	}
}

$sql .= "Order by h.CREATE_DATE desc ";
// echo $sql;

$result = mysqli_query($conn,$sql);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=TVI_Report.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('SR_Number', 'SP_Number', 'SO_Number', 'Circle_Name', 'Product_Type', 'TVI_Site_Id', 'Site_Id', 'Site_Name', 'Latitude', 'Longitude', 
	'TECHNOLOGY', 'Operator', 'SR_Raise_Date', 'SP_Raise_Date', 'SO_Raise_Date', 'RFI_Date', 'RFI_Accepted_Date', 'RFS_Date', 'Pending_With', 'Status', 
	'ExtensionType','Sharing_Potential'));

if($tabName == "dashbord"){

	while($row=mysqli_fetch_assoc($result)){
		$nbsStatus = $row["STATUS"];
		$pageType = $row["pageType"];

		$approvalFlowSql = "SELECT * FROM `Approval_Flow` where find_in_set('$nbsStatus',`Status`) <> 0 and `User_Role` = '$loginEmpRole' and `TAB_NAME` = '$pageType' 
		and `Is_Active` = 'Y' ";
		$approvalFlowResult = mysqli_query($conn,$approvalFlowSql);

		if(mysqli_num_rows($approvalFlowResult) !=0){
			$pendingTo = $row["Pending_To"];
			$pendingFor = $row["Pending_For"];
			if($loginEmpRole == 'OPCO'){
				$pendingTo = "WIP";
				$pendingFor = "WIP";
			}
			$exportData = array('col1' => $row["SR_Number"], 'col2' => $row["SP_Number"], 'col3' => $row["SO_Number"], 'col16' => $row["Circle_Name"], 
			'col9' => $row["Product_Type"], 'col18' => $row["TVI_SITE_ID"], 'col4' => $row["Site_Id"], 
			'col5' => $row["Site_Name"], 'col6' => $row["Latitude"], 'col7' => $row["Longitude"], 'col21' => $row["TECHNOLOGY"], 'col8' => $row["Operator"], 
			'col10' => $row["SR_Raise_Date"], 'col11' => $row["SP_Raise_Date"], 'col12' => $row["SO_Raise_Date"], 'col13' => $row["RFI_Date"], 
			'col14' => $row["RFI_Accepted_Date"], 'col15' => $row["RFS_Date"], 'col17' => $pendingTo, 'col20' => $pendingFor, 
			'col19' => $row["ExtensionType"], 'col22' => $row["Sharing_Potential"]);

			fputcsv($output, $exportData);
		}
	} 
}
else{

	while($row=mysqli_fetch_assoc($result)){
		$pendingTo = $row["Pending_To"];
		$pendingFor = $row["Pending_For"];
		if($loginEmpRole == 'OPCO'){
			$pendingTo = "WIP";
			$pendingFor = "WIP";
		}
		$exportData = array('col1' => $row["SR_Number"], 'col2' => $row["SP_Number"], 'col3' => $row["SO_Number"], 'col16' => $row["Circle_Name"], 
		 'col9' => $row["Product_Type"], 'col18' => $row["TVI_SITE_ID"], 'col4' => $row["Site_Id"], 
		'col5' => $row["Site_Name"], 'col6' => $row["Latitude"], 'col7' => $row["Longitude"], 'col21' => $row["TECHNOLOGY"], 'col8' => $row["Operator"],
		'col10' => $row["SR_Raise_Date"], 'col11' => $row["SP_Raise_Date"], 'col12' => $row["SO_Raise_Date"], 'col13' => $row["RFI_Date"], 
		'col14' => $row["RFI_Accepted_Date"], 'col15' => $row["RFS_Date"], 'col17' => $pendingTo, 'col20' => $pendingFor,  
		'col19' => $row["ExtensionType"], 'col22' => $row["Sharing_Potential"]);

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

