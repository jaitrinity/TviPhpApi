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
$filterCircleName = $jsonData->filterCircleName;
$filterProductType = $jsonData->filterProductType;
$filterSrStatus = $jsonData->filterSrStatus;
$filterStartDate = $jsonData->filterStartDate;
$filterEndDate = $jsonData->filterEndDate;
$reportType = $jsonData->reportType;

if($loginEmpRole == "SnM"){
	$loginEmpRole = "S&M";	
}
else if($loginEmpRole == "HO_SnM"){
	$loginEmpRole = "HO_S&M";	
}
else if($loginEmpRole == "SnM_MIS_Head"){
	$loginEmpRole = "S&M_MIS_Head";	
}


if($filterCircleName != ""){
	$filterCircleName = implode("','", explode(",", $filterCircleName));
}
else{
	$filterCircleName = implode("','", explode(",", $circleName));
}

$filterOperator = implode("','", explode(",", $operator));

// $filterSql = " and Operator in ('".$filterOperator."') and CIRCLE_NAME in ('".$filterCircleName."') ";
$filterSql = " and CIRCLE_NAME in ('".$filterCircleName."') ";
if($loginEmpRole == 'OPCO'){
	$filterSql .= " and Operator in ('".$filterOperator."') ";
}
if($operator != "" && $operator != "TVI"){
	$filterSql .= " and Operator in ('".$filterOperator."') ";
}
if($filterProductType != ""){
	if($reportType != 3){
		$filterSql .= " and TAB_NAME = '".$filterProductType."' ";
	}
}

// Summary Report
if($reportType == 1){
	// if($filterStartDate != ""){
	// 	$filterSql .= " and CREATE_DATE >= '".$filterStartDate."' ";
	// }
	// if($filterEndDate != ""){
	// 	$filterSql .= " and CREATE_DATE <= '".$filterEndDate."' ";
	// }

	if($filterSrStatus == "SR"){
		if($filterStartDate != "")
			$filterSql .= " and SR_DATE >= '$filterStartDate' ";
		else
			$filterSql .= " and SR_DATE is not null ";
	}
	else if($filterSrStatus =="SP"){
		if($filterStartDate != "")
			$filterSql .= " and SP_DATE >= '$filterStartDate' ";
		else
			$filterSql .= " and SP_DATE is not null ";
	}
	else if($filterSrStatus =="SO"){
		if($filterStartDate != "")
			$filterSql .= " and SO_DATE >= '$filterStartDate' ";
		else
			$filterSql .= " and SO_DATE is not null ";
	}
	else if($filterSrStatus =="RFI"){
		if($filterStartDate != "")
			$filterSql .= " and RFI_DATE >= '$filterStartDate' ";
		else
			$filterSql .= " and RFI_DATE is not null ";
	}
	else if($filterSrStatus =="RFI Accepted"){
		if($filterStartDate != "")
			$filterSql .= " and RFI_ACCEPTED_DATE >= '$filterStartDate' ";
		else
			$filterSql .= " and RFI_ACCEPTED_DATE is not null ";
	}
	else if($filterSrStatus =="RFS"){
		if($filterStartDate != "")
			$filterSql .= " and RFS_DATE >= '$filterStartDate' ";
		else
			$filterSql .= " and RFS_DATE is not null ";
	}
	else{
		if($filterStartDate != ""){
			$filterSql .= " and DATE_FORMAT(CREATE_DATE,'%Y-%m-%d') >= '$filterStartDate' ";
		}
		else{
			$filterSql .= " and DATE_FORMAT(CREATE_DATE,'%Y-%m-%d') >= '2020-07-01' ";
		}
	}

	if($filterEndDate != ""){
		if($filterSrStatus =="SR"){
			$filterSql .= " and SR_DATE <= '$filterEndDate' ";
		}
		else if($filterSrStatus =="SP"){
			$filterSql .= " and SP_DATE <= '$filterEndDate' ";
		}
		else if($filterSrStatus =="SO"){
			$filterSql .= " and SO_DATE <= '$filterEndDate' ";
		}
		else if($filterSrStatus =="RFI"){
			$filterSql .= " and RFI_DATE <= '$filterEndDate' ";
		}
		else if($filterSrStatus =="RFI Accepted"){
			$filterSql .= " and RFI_ACCEPTED_DATE <= '$filterEndDate' ";
		}
		else if($filterSrStatus =="RFS"){
			$filterSql .= " and RFS_DATE <= '$filterEndDate' ";
		}
		else{
			$filterSql .= " and DATE_FORMAT(CREATE_DATE,'%Y-%m-%d') <= '$filterEndDate' ";
		}
	}
	 
	$sql = "select t.CIRCLE_NAME, sum(t.sr_on) count_of_SR, sum(t.sp_on) count_of_SP, sum(t.so_on) count_of_SO, sum(t.rfi_on) count_of_RFI, sum(t.rfi_accepted_on) count_of_RFI_Accepted, sum(t.rfs_on) count_of_RFS from (SELECT CIRCLE_NAME, (case when SR_NUMBER is not null then 1 else 0 end) sr_on, (case when SP_NUMBER is not null then 1 else 0 end) sp_on, (case when SO_NUMBER is not null then 1 else 0 end) so_on, (case when RFI_DATE is not null then 1 else 0 end) rfi_on, (case when RFI_ACCEPTED_DATE is not null then 1 else 0 end) rfi_accepted_on, (case when RFS_DATE is not null then 1 else 0 end) rfs_on FROM `NBS_MASTER_HDR` where SR_NUMBER is not null ".$filterSql.") t GROUP by t.CIRCLE_NAME
		UNION
		select 'Grand Total' as CIRCLE_NAME, sum(t1.sr_on) count_of_SR, sum(t1.sp_on) count_of_SP, sum(t1.so_on) count_of_SO, sum(t1.rfi_on) count_of_RFI, 
		sum(t1.rfi_accepted_on) count_of_RFI_Accepted, sum(t1.rfs_on) count_of_RFS from (select t.CIRCLE_NAME, sum(t.sr_on) as sr_on, sum(t.sp_on) as sp_on, 
		sum(t.so_on) as so_on, sum(t.rfi_on) as rfi_on, sum(t.rfi_accepted_on) as rfi_accepted_on, sum(t.rfs_on) as rfs_on from 
		(SELECT CIRCLE_NAME, (case when SR_NUMBER is not null then 1 else 0 end) sr_on, (case when SP_NUMBER is not null then 1 else 0 end) sp_on, 
		(case when SO_NUMBER is not null then 1 else 0 end) so_on, (case when RFI_DATE is not null then 1 else 0 end) rfi_on, 
		(case when RFI_ACCEPTED_DATE is not null then 1 else 0 end) rfi_accepted_on, (case when RFS_DATE is not null then 1 else 0 end) rfs_on 
		FROM `NBS_MASTER_HDR` where SR_NUMBER is not null ".$filterSql.") 
		t GROUP by t.CIRCLE_NAME) t1";

	// echo $sql;	

	$result = mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);
	$columnName = array();
	foreach ($row as $key => $value) {
		array_push($columnName, $key);
	}
	
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=SR_Summary_Report.csv');
	$output = fopen('php://output', 'w');
	fputcsv($output, $columnName);

	mysqli_data_seek($result, 0);
	while($row=mysqli_fetch_assoc($result)){
		$exportData = array();
		foreach ($columnName as $key => $value) {
			array_push($exportData, $row[$value]);
		}
		fputcsv($output, $exportData);
	}
}
// Detail Report
else if($reportType == 2){
	if($filterSrStatus == "SR"){
		if($filterStartDate != "")
			$filterSql .= " and h.SR_DATE >= '$filterStartDate' ";
		else
			$filterSql .= " and h.SR_DATE is not null ";
	}
	else if($filterSrStatus =="SP"){
		if($filterStartDate != "")
			$filterSql .= " and h.SP_DATE >= '$filterStartDate' ";
		else
			$filterSql .= " and h.SP_DATE is not null ";
	}
	else if($filterSrStatus =="SO"){
		if($filterStartDate != "")
			$filterSql .= " and h.SO_DATE >= '$filterStartDate' ";
		else
			$filterSql .= " and h.SO_DATE is not null ";
	}
	else if($filterSrStatus =="RFI"){
		if($filterStartDate != "")
			$filterSql .= " and h.RFI_DATE >= '$filterStartDate' ";
		else
			$filterSql .= " and h.RFI_DATE is not null ";
	}
	else if($filterSrStatus =="RFI Accepted"){
		if($filterStartDate != "")
			$filterSql .= " and h.RFI_ACCEPTED_DATE >= '$filterStartDate' ";
		else
			$filterSql .= " and h.RFI_ACCEPTED_DATE is not null ";
	}
	else if($filterSrStatus =="RFS"){
		if($filterStartDate != "")
			$filterSql .= " and h.RFS_DATE >= '$filterStartDate' ";
		else
			$filterSql .= " and h.RFS_DATE is not null ";
	}
	else{
		if($filterStartDate != ""){
			$filterSql .= " and DATE_FORMAT(h.CREATE_DATE,'%Y-%m-%d') >= '$filterStartDate' ";
		}
		else{
			$filterSql .= " and DATE_FORMAT(h.CREATE_DATE,'%Y-%m-%d') >= '2020-07-01' ";
		}
	}

	if($filterEndDate != ""){
		if($filterSrStatus =="SR"){
			$filterSql .= " and h.SR_DATE <= '$filterEndDate' ";
		}
		else if($filterSrStatus =="SP"){
			$filterSql .= " and h.SP_DATE <= '$filterEndDate' ";
		}
		else if($filterSrStatus =="SO"){
			$filterSql .= " and h.SO_DATE <= '$filterEndDate' ";
		}
		else if($filterSrStatus =="RFI"){
			$filterSql .= " and h.RFI_DATE <= '$filterEndDate' ";
		}
		else if($filterSrStatus =="RFI Accepted"){
			$filterSql .= " and h.RFI_ACCEPTED_DATE <= '$filterEndDate' ";
		}
		else if($filterSrStatus =="RFS"){
			$filterSql .= " and h.RFS_DATE <= '$filterEndDate' ";
		}
		else{
			$filterSql .= " and DATE_FORMAT(h.CREATE_DATE,'%Y-%m-%d') <= '$filterEndDate' ";
		}
	}
	$sql = "SELECT h.SR_NUMBER, h.SP_NUMBER, h.SO_NUMBER, h.CIRCLE_NAME, h.AIRTEL_SITE_ID as Site_Id, h.TVI_SITE_ID, 
	(case when h.TAB_NAME='CreateNBS' then 'Macro Anchor' else h.TAB_NAME end) as Product_Type, 
	h.SR_DATE, h.SP_DATE, h.SO_DATE, 
	h.LATITUDE_1 as LATITUDE, h.LONGITUDE_1 as LONGITUDE,
	-- (case when h.SUGGESTED_LATITUDE is not null then h.SUGGESTED_LATITUDE else h.LATITUDE_1 end) LATITUDE, 
	-- (case when h.SUGGESTED_LONGITUDE is not null then h.SUGGESTED_LONGITUDE else h.LONGITUDE_1 end) LONGITUDE, 
	h.SUGGESTED_LATITUDE as Acquired_Lat, h.SUGGESTED_LONGITUDE as Acquired_Long,
	h.Operator, h.RFI_DATE, h.RFI_ACCEPTED_DATE, h.RFS_DATE, h.Site_Name, 
	(case when h.SUGGESTED_SITE_TYPE is not null then h.SUGGESTED_SITE_TYPE else h.SITE_TYPE end) as Tower_Type, h.TECHNOLOGY, h.BTS_TYPE, h.Sharing_Potential,
	h.Total_Rated_Power_in_KW as Total_Rated_Power_in_Watt, h.Additional_Load, h.Power_Rating_Of_Equipment, 
		h.NO_OF_MICROWAVE, 
		max(case when mic.Type_No = 1 then mic.MICROWAVE_HEIGHT end) as MICROWAVE_HEIGHT_1, max(case when mic.Type_No = 1 then mic.MICROWAVE_DIA end) as MICROWAVE_DIA_1, max(case when mic.Type_No = 1 then mic.MICROWAVE_AZIMUTH end) as MICROWAVE_AZIMUTH_1, 
		max(case when mic.Type_No = 2 then mic.MICROWAVE_HEIGHT end) as MICROWAVE_HEIGHT_2, max(case when mic.Type_No = 2 then mic.MICROWAVE_DIA end) as MICROWAVE_DIA_2, max(case when mic.Type_No = 2 then mic.MICROWAVE_AZIMUTH end) as MICROWAVE_AZIMUTH_2, 
		max(case when mic.Type_No = 3 then mic.MICROWAVE_HEIGHT end) as MICROWAVE_HEIGHT_3, max(case when mic.Type_No = 3 then mic.MICROWAVE_DIA end) as MICROWAVE_DIA_3, max(case when mic.Type_No = 3 then mic.MICROWAVE_AZIMUTH end) as MICROWAVE_AZIMUTH_3, 
		max(case when mic.Type_No = 4 then mic.MICROWAVE_HEIGHT end) as MICROWAVE_HEIGHT_4, max(case when mic.Type_No = 4 then mic.MICROWAVE_DIA end) as MICROWAVE_DIA_4, max(case when mic.Type_No = 4 then mic.MICROWAVE_AZIMUTH end) as MICROWAVE_AZIMUTH_4, 
		max(case when mic.Type_No = 5 then mic.MICROWAVE_HEIGHT end) as MICROWAVE_HEIGHT_5, max(case when mic.Type_No = 5 then mic.MICROWAVE_DIA end) as MICROWAVE_DIA_5, max(case when mic.Type_No = 5 then mic.MICROWAVE_AZIMUTH end) as MICROWAVE_AZIMUTH_5, 
		max(case when mic.Type_No = 6 then mic.MICROWAVE_HEIGHT end) as MICROWAVE_HEIGHT_6, max(case when mic.Type_No = 6 then mic.MICROWAVE_DIA end) as MICROWAVE_DIA_6, max(case when mic.Type_No = 6 then mic.MICROWAVE_AZIMUTH end) as MICROWAVE_AZIMUTH_6, 
		h.NO_OF_RRU, 
		max(case when rru.Type_No = 1 then rru.RRU_MAKE end) as RRU_MAKE_1, max(case when rru.Type_No = 1 then rru.RRU_MODEL end) as RRU_MODEL_1, max(case when rru.Type_No = 1 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_1, max(case when rru.Type_No = 1 then rru.RRU_WEIGHT end) as RRU_WEIGHT_1, 
		max(case when rru.Type_No = 2 then rru.RRU_MAKE end) as RRU_MAKE_2, max(case when rru.Type_No = 2 then rru.RRU_MODEL end) as RRU_MODEL_2, max(case when rru.Type_No = 2 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_2, max(case when rru.Type_No = 2 then rru.RRU_WEIGHT end) as RRU_WEIGHT_2, 
		max(case when rru.Type_No = 3 then rru.RRU_MAKE end) as RRU_MAKE_3, max(case when rru.Type_No = 3 then rru.RRU_MODEL end) as RRU_MODEL_3, max(case when rru.Type_No = 3 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_3, max(case when rru.Type_No = 3 then rru.RRU_WEIGHT end) as RRU_WEIGHT_3, 
		max(case when rru.Type_No = 4 then rru.RRU_MAKE end) as RRU_MAKE_4, max(case when rru.Type_No = 4 then rru.RRU_MODEL end) as RRU_MODEL_4, max(case when rru.Type_No = 4 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_4, max(case when rru.Type_No = 4 then rru.RRU_WEIGHT end) as RRU_WEIGHT_4, 
		max(case when rru.Type_No = 5 then rru.RRU_MAKE end) as RRU_MAKE_5, max(case when rru.Type_No = 5 then rru.RRU_MODEL end) as RRU_MODEL_5, max(case when rru.Type_No = 5 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_5, max(case when rru.Type_No = 5 then rru.RRU_WEIGHT end) as RRU_WEIGHT_5, 
		max(case when rru.Type_No = 6 then rru.RRU_MAKE end) as RRU_MAKE_6, max(case when rru.Type_No = 6 then rru.RRU_MODEL end) as RRU_MODEL_6, max(case when rru.Type_No = 6 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_6, max(case when rru.Type_No = 6 then rru.RRU_WEIGHT end) as RRU_WEIGHT_6, 
		max(case when rru.Type_No = 7 then rru.RRU_MAKE end) as RRU_MAKE_7, max(case when rru.Type_No = 7 then rru.RRU_MODEL end) as RRU_MODEL_7, max(case when rru.Type_No = 7 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_7, max(case when rru.Type_No = 7 then rru.RRU_WEIGHT end) as RRU_WEIGHT_7, 
		max(case when rru.Type_No = 8 then rru.RRU_MAKE end) as RRU_MAKE_8, max(case when rru.Type_No = 8 then rru.RRU_MODEL end) as RRU_MODEL_8, max(case when rru.Type_No = 8 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_8, max(case when rru.Type_No = 8 then rru.RRU_WEIGHT end) as RRU_WEIGHT_8, 
		max(case when rru.Type_No = 9 then rru.RRU_MAKE end) as RRU_MAKE_9, max(case when rru.Type_No = 9 then rru.RRU_MODEL end) as RRU_MODEL_9, max(case when rru.Type_No = 9 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_9, max(case when rru.Type_No = 9 then rru.RRU_WEIGHT end) as RRU_WEIGHT_9, 
		max(case when rru.Type_No = 10 then rru.RRU_MAKE end) as RRU_MAKE_10, max(case when rru.Type_No = 10 then rru.RRU_MODEL end) as RRU_MODEL_10, max(case when rru.Type_No = 10 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_10, max(case when rru.Type_No = 10 then rru.RRU_WEIGHT end) as RRU_WEIGHT_10, 
		max(case when rru.Type_No = 11 then rru.RRU_MAKE end) as RRU_MAKE_11, max(case when rru.Type_No = 11 then rru.RRU_MODEL end) as RRU_MODEL_11, max(case when rru.Type_No = 11 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_11, max(case when rru.Type_No = 11 then rru.RRU_WEIGHT end) as RRU_WEIGHT_11, 
		max(case when rru.Type_No = 12 then rru.RRU_MAKE end) as RRU_MAKE_12, max(case when rru.Type_No = 12 then rru.RRU_MODEL end) as RRU_MODEL_12, max(case when rru.Type_No = 12 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_12, max(case when rru.Type_No = 12 then rru.RRU_WEIGHT end) as RRU_WEIGHT_12, 
		max(case when rru.Type_No = 13 then rru.RRU_MAKE end) as RRU_MAKE_13, max(case when rru.Type_No = 13 then rru.RRU_MODEL end) as RRU_MODEL_13, max(case when rru.Type_No = 13 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_13, max(case when rru.Type_No = 13 then rru.RRU_WEIGHT end) as RRU_WEIGHT_13, 
		max(case when rru.Type_No = 14 then rru.RRU_MAKE end) as RRU_MAKE_14, max(case when rru.Type_No = 14 then rru.RRU_MODEL end) as RRU_MODEL_14, max(case when rru.Type_No = 14 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_14, max(case when rru.Type_No = 14 then rru.RRU_WEIGHT end) as RRU_WEIGHT_14, 
		max(case when rru.Type_No = 15 then rru.RRU_MAKE end) as RRU_MAKE_15, max(case when rru.Type_No = 15 then rru.RRU_MODEL end) as RRU_MODEL_15, max(case when rru.Type_No = 15 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_15, max(case when rru.Type_No = 15 then rru.RRU_WEIGHT end) as RRU_WEIGHT_15, 
		max(case when rru.Type_No = 16 then rru.RRU_MAKE end) as RRU_MAKE_16, max(case when rru.Type_No = 16 then rru.RRU_MODEL end) as RRU_MODEL_16, max(case when rru.Type_No = 16 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_16, max(case when rru.Type_No = 16 then rru.RRU_WEIGHT end) as RRU_WEIGHT_16, 
		max(case when rru.Type_No = 17 then rru.RRU_MAKE end) as RRU_MAKE_17, max(case when rru.Type_No = 17 then rru.RRU_MODEL end) as RRU_MODEL_17, max(case when rru.Type_No = 17 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_17, max(case when rru.Type_No = 16 then rru.RRU_WEIGHT end) as RRU_WEIGHT_17, 
		max(case when rru.Type_No = 18 then rru.RRU_MAKE end) as RRU_MAKE_18, max(case when rru.Type_No = 18 then rru.RRU_MODEL end) as RRU_MODEL_18, max(case when rru.Type_No = 18 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_18, max(case when rru.Type_No = 18 then rru.RRU_WEIGHT end) as RRU_WEIGHT_18, 
		max(case when rru.Type_No = 19 then rru.RRU_MAKE end) as RRU_MAKE_19, max(case when rru.Type_No = 19 then rru.RRU_MODEL end) as RRU_MODEL_19, max(case when rru.Type_No = 19 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_19, max(case when rru.Type_No = 19 then rru.RRU_WEIGHT end) as RRU_WEIGHT_19, 
		max(case when rru.Type_No = 20 then rru.RRU_MAKE end) as RRU_MAKE_20, max(case when rru.Type_No = 20 then rru.RRU_MODEL end) as RRU_MODEL_20, max(case when rru.Type_No = 20 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_20, max(case when rru.Type_No = 20 then rru.RRU_WEIGHT end) as RRU_WEIGHT_20, 
		max(case when rru.Type_No = 21 then rru.RRU_MAKE end) as RRU_MAKE_21, max(case when rru.Type_No = 21 then rru.RRU_MODEL end) as RRU_MODEL_21, max(case when rru.Type_No = 21 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_21, max(case when rru.Type_No = 21 then rru.RRU_WEIGHT end) as RRU_WEIGHT_21, 
		max(case when rru.Type_No = 22 then rru.RRU_MAKE end) as RRU_MAKE_22, max(case when rru.Type_No = 22 then rru.RRU_MODEL end) as RRU_MODEL_22, max(case when rru.Type_No = 22 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_22, max(case when rru.Type_No = 22 then rru.RRU_WEIGHT end) as RRU_WEIGHT_22, 
		max(case when rru.Type_No = 23 then rru.RRU_MAKE end) as RRU_MAKE_23, max(case when rru.Type_No = 23 then rru.RRU_MODEL end) as RRU_MODEL_23, max(case when rru.Type_No = 23 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_23, max(case when rru.Type_No = 23 then rru.RRU_WEIGHT end) as RRU_WEIGHT_23, 
		max(case when rru.Type_No = 24 then rru.RRU_MAKE end) as RRU_MAKE_24, max(case when rru.Type_No = 24 then rru.RRU_MODEL end) as RRU_MODEL_24, max(case when rru.Type_No = 24 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_24, max(case when rru.Type_No = 24 then rru.RRU_WEIGHT end) as RRU_WEIGHT_24, 
		max(case when rru.Type_No = 25 then rru.RRU_MAKE end) as RRU_MAKE_25, max(case when rru.Type_No = 25 then rru.RRU_MODEL end) as RRU_MODEL_25, max(case when rru.Type_No = 25 then rru.RRU_RATED_POWER_CONSUMPTION end) as RRU_RATED_POWER_CONSUMPTION_25, max(case when rru.Type_No = 25 then rru.RRU_WEIGHT end) as RRU_WEIGHT_25, 
		h.NO_OF_BTS, 
		max(case when bts.Type_No = 1 then bts.BTS_MAKE end) as BTS_MAKE_1, max(case when bts.Type_No = 1 then bts.BTS_MODEL end) as BTS_MODEL_1, max(case when bts.Type_No = 1 then bts.BTS_FLOOR_SPACE end) as BTS_FLOOR_SPACE_1, max(case when bts.Type_No = 1 then bts.BTS_POWER end) as BTS_POWER_1, 
		max(case when bts.Type_No = 2 then bts.BTS_MAKE end) as BTS_MAKE_2, max(case when bts.Type_No = 2 then bts.BTS_MODEL end) as BTS_MODEL_2, max(case when bts.Type_No = 2 then bts.BTS_FLOOR_SPACE end) as BTS_FLOOR_SPACE_2, max(case when bts.Type_No = 2 then bts.BTS_POWER end) as BTS_POWER_2, 
		max(case when bts.Type_No = 3 then bts.BTS_MAKE end) as BTS_MAKE_3, max(case when bts.Type_No = 3 then bts.BTS_MODEL end) as BTS_MODEL_3, max(case when bts.Type_No = 3 then bts.BTS_FLOOR_SPACE end) as BTS_FLOOR_SPACE_3, max(case when bts.Type_No = 3 then bts.BTS_POWER end) as BTS_POWER_3, 
		max(case when bts.Type_No = 4 then bts.BTS_MAKE end) as BTS_MAKE_4, max(case when bts.Type_No = 4 then bts.BTS_MODEL end) as BTS_MODEL_4, max(case when bts.Type_No = 4 then bts.BTS_FLOOR_SPACE end) as BTS_FLOOR_SPACE_4, max(case when bts.Type_No = 4 then bts.BTS_POWER end) as BTS_POWER_4, 
		h.NO_OF_BBU, 
		max(case when bbu.Type_No = 1 then bbu.BBU_MAKE end) as BBU_MAKE_1, max(case when bbu.Type_No = 1 then bbu.BBU_MODEL end) as BBU_MODEL_1, max(case when bbu.Type_No = 1 then bbu.BBU_RATED_POWER_CONSUMPTION end) as BBU_RATED_POWER_CONSUMPTION_1, max(case when bbu.Type_No = 1 then bbu.BBU_Positioning end) as BBU_Positioning_1, 
		max(case when bbu.Type_No = 2 then bbu.BBU_MAKE end) as BBU_MAKE_2, max(case when bbu.Type_No = 2 then bbu.BBU_MODEL end) as BBU_MODEL_2, max(case when bbu.Type_No = 2 then bbu.BBU_RATED_POWER_CONSUMPTION end) as BBU_RATED_POWER_CONSUMPTION_2, max(case when bbu.Type_No = 2 then bbu.BBU_Positioning end) as BBU_Positioning_2, 
		max(case when bbu.Type_No = 3 then bbu.BBU_MAKE end) as BBU_MAKE_3, max(case when bbu.Type_No = 3 then bbu.BBU_MODEL end) as BBU_MODEL_3, max(case when bbu.Type_No = 3 then bbu.BBU_RATED_POWER_CONSUMPTION end) as BBU_RATED_POWER_CONSUMPTION_3, max(case when bbu.Type_No = 3 then bbu.BBU_Positioning end) as BBU_Positioning_3, 
		max(case when bbu.Type_No = 4 then bbu.BBU_MAKE end) as BBU_MAKE_4, max(case when bbu.Type_No = 4 then bbu.BBU_MODEL end) as BBU_MODEL_4, max(case when bbu.Type_No = 4 then bbu.BBU_RATED_POWER_CONSUMPTION end) as BBU_RATED_POWER_CONSUMPTION_4, max(case when bbu.Type_No = 4 then bbu.BBU_Positioning end) as BBU_Positioning_4, 
		max(case when bbu.Type_No = 5 then bbu.BBU_MAKE end) as BBU_MAKE_5, max(case when bbu.Type_No = 5 then bbu.BBU_MODEL end) as BBU_MODEL_5, max(case when bbu.Type_No = 5 then bbu.BBU_RATED_POWER_CONSUMPTION end) as BBU_RATED_POWER_CONSUMPTION_5, max(case when bbu.Type_No = 5 then bbu.BBU_Positioning end) as BBU_Positioning_5, 
		max(case when bbu.Type_No = 6 then bbu.BBU_MAKE end) as BBU_MAKE_6, max(case when bbu.Type_No = 6 then bbu.BBU_MODEL end) as BBU_MODEL_6, max(case when bbu.Type_No = 6 then bbu.BBU_RATED_POWER_CONSUMPTION end) as BBU_RATED_POWER_CONSUMPTION_6, max(case when bbu.Type_No = 6 then bbu.BBU_Positioning end) as BBU_Positioning_6, 
		h.NO_OF_RF_ANTENNA, 
		max(case when rf.Type_No = 1 then rf.RF_SIZE end) as RF_HEIGHT_1, max(case when rf.Type_No = 1 then rf.RF_WEIGHT end) as RF_WEIGHT_1, max(case when rf.Type_No = 1 then rf.RF_AZIMUTH end) as RF_AZIMUTH_1, max(case when rf.Type_No = 1 then rf.RF_MAKE end) as RF_MAKE_1, max(case when rf.Type_No = 1 then rf.RF_MODEL end) as RF_MODEL_1, max(case when rf.Type_No = 1 then rf.RF_GAIN end) as RF_GAIN_1, max(case when rf.Type_No = 1 then rf.RF_BAND end) as RF_BAND_1,
		max(case when rf.Type_No = 2 then rf.RF_SIZE end) as RF_HEIGHT_2, max(case when rf.Type_No = 2 then rf.RF_WEIGHT end) as RF_WEIGHT_2, max(case when rf.Type_No = 2 then rf.RF_AZIMUTH end) as RF_AZIMUTH_2, max(case when rf.Type_No = 2 then rf.RF_MAKE end) as RF_MAKE_2, max(case when rf.Type_No = 2 then rf.RF_MODEL end) as RF_MODEL_2, max(case when rf.Type_No = 2 then rf.RF_GAIN end) as RF_GAIN_2, max(case when rf.Type_No = 2 then rf.RF_BAND end) as RF_BAND_2, 
		max(case when rf.Type_No = 3 then rf.RF_SIZE end) as RF_HEIGHT_3, max(case when rf.Type_No = 3 then rf.RF_WEIGHT end) as RF_WEIGHT_3, max(case when rf.Type_No = 3 then rf.RF_AZIMUTH end) as RF_AZIMUTH_3, max(case when rf.Type_No = 3 then rf.RF_MAKE end) as RF_MAKE_3, max(case when rf.Type_No = 3 then rf.RF_MODEL end) as RF_MODEL_3, max(case when rf.Type_No = 3 then rf.RF_GAIN end) as RF_GAIN_3, max(case when rf.Type_No = 3 then rf.RF_BAND end) as RF_BAND_3, 
		max(case when rf.Type_No = 4 then rf.RF_SIZE end) as RF_HEIGHT_4, max(case when rf.Type_No = 4 then rf.RF_WEIGHT end) as RF_WEIGHT_4, max(case when rf.Type_No = 4 then rf.RF_AZIMUTH end) as RF_AZIMUTH_4, max(case when rf.Type_No = 4 then rf.RF_MAKE end) as RF_MAKE_4, max(case when rf.Type_No = 4 then rf.RF_MODEL end) as RF_MODEL_4, max(case when rf.Type_No = 4 then rf.RF_GAIN end) as RF_GAIN_4, max(case when rf.Type_No = 4 then rf.RF_BAND end) as RF_BAND_4, 
		max(case when rf.Type_No = 5 then rf.RF_SIZE end) as RF_HEIGHT_5, max(case when rf.Type_No = 5 then rf.RF_WEIGHT end) as RF_WEIGHT_5, max(case when rf.Type_No = 5 then rf.RF_AZIMUTH end) as RF_AZIMUTH_5, max(case when rf.Type_No = 5 then rf.RF_MAKE end) as RF_MAKE_5, max(case when rf.Type_No = 5 then rf.RF_MODEL end) as RF_MODEL_5, max(case when rf.Type_No = 5 then rf.RF_GAIN end) as RF_GAIN_5, max(case when rf.Type_No = 5 then rf.RF_BAND end) as RF_BAND_5, 
		max(case when rf.Type_No = 6 then rf.RF_SIZE end) as RF_HEIGHT_6, max(case when rf.Type_No = 6 then rf.RF_WEIGHT end) as RF_WEIGHT_6, max(case when rf.Type_No = 6 then rf.RF_AZIMUTH end) as RF_AZIMUTH_6, max(case when rf.Type_No = 6 then rf.RF_MAKE end) as RF_MAKE_6, max(case when rf.Type_No = 6 then rf.RF_MODEL end) as RF_MODEL_6, max(case when rf.Type_No = 6 then rf.RF_GAIN end) as RF_GAIN_6, max(case when rf.Type_No = 6 then rf.RF_BAND end) as RF_BAND_6, 
		max(case when rf.Type_No = 7 then rf.RF_SIZE end) as RF_HEIGHT_7, max(case when rf.Type_No = 7 then rf.RF_WEIGHT end) as RF_WEIGHT_7, max(case when rf.Type_No = 7 then rf.RF_AZIMUTH end) as RF_AZIMUTH_7, max(case when rf.Type_No = 7 then rf.RF_MAKE end) as RF_MAKE_7, max(case when rf.Type_No = 7 then rf.RF_MODEL end) as RF_MODEL_7, max(case when rf.Type_No = 7 then rf.RF_GAIN end) as RF_GAIN_7, max(case when rf.Type_No = 7 then rf.RF_BAND end) as RF_BAND_7, 
		max(case when rf.Type_No = 8 then rf.RF_SIZE end) as RF_HEIGHT_8, max(case when rf.Type_No = 8 then rf.RF_WEIGHT end) as RF_WEIGHT_8, max(case when rf.Type_No = 8 then rf.RF_AZIMUTH end) as RF_AZIMUTH_8, max(case when rf.Type_No = 8 then rf.RF_MAKE end) as RF_MAKE_8, max(case when rf.Type_No = 8 then rf.RF_MODEL end) as RF_MODEL_8, max(case when rf.Type_No = 8 then rf.RF_GAIN end) as RF_GAIN_8, max(case when rf.Type_No = 8 then rf.RF_BAND end) as RF_BAND_8, 
		max(case when rf.Type_No = 9 then rf.RF_SIZE end) as RF_HEIGHT_9, max(case when rf.Type_No = 9 then rf.RF_WEIGHT end) as RF_WEIGHT_9, max(case when rf.Type_No = 9 then rf.RF_AZIMUTH end) as RF_AZIMUTH_9, max(case when rf.Type_No = 9 then rf.RF_MAKE end) as RF_MAKE_9, max(case when rf.Type_No = 9 then rf.RF_MODEL end) as RF_MODEL_9, max(case when rf.Type_No = 9 then rf.RF_GAIN end) as RF_GAIN_9, max(case when rf.Type_No = 9 then rf.RF_BAND end) as RF_BAND_9, 
		max(case when rf.Type_No = 10 then rf.RF_SIZE end) as RF_HEIGHT_10, max(case when rf.Type_No = 10 then rf.RF_WEIGHT end) as RF_WEIGHT_10, max(case when rf.Type_No = 10 then rf.RF_AZIMUTH end) as RF_AZIMUTH_10, max(case when rf.Type_No = 10 then rf.RF_MAKE end) as RF_MAKE_10, max(case when rf.Type_No = 10 then rf.RF_MODEL end) as RF_MODEL_10, max(case when rf.Type_No = 10 then rf.RF_GAIN end) as RF_GAIN_10, max(case when rf.Type_No = 10 then rf.RF_BAND end) as RF_BAND_10, 
		max(case when rf.Type_No = 11 then rf.RF_SIZE end) as RF_HEIGHT_11, max(case when rf.Type_No = 11 then rf.RF_WEIGHT end) as RF_WEIGHT_11, max(case when rf.Type_No = 11 then rf.RF_AZIMUTH end) as RF_AZIMUTH_11, max(case when rf.Type_No = 11 then rf.RF_MAKE end) as RF_MAKE_11, max(case when rf.Type_No = 11 then rf.RF_MODEL end) as RF_MODEL_11, max(case when rf.Type_No = 11 then rf.RF_GAIN end) as RF_GAIN_11, max(case when rf.Type_No = 11 then rf.RF_BAND end) as RF_BAND_11, 
		max(case when rf.Type_No = 12 then rf.RF_SIZE end) as RF_HEIGHT_12, max(case when rf.Type_No = 12 then rf.RF_WEIGHT end) as RF_WEIGHT_12, max(case when rf.Type_No = 12 then rf.RF_AZIMUTH end) as RF_AZIMUTH_12, max(case when rf.Type_No = 12 then rf.RF_MAKE end) as RF_MAKE_12, max(case when rf.Type_No = 12 then rf.RF_MODEL end) as RF_MODEL_12, max(case when rf.Type_No = 12 then rf.RF_GAIN end) as RF_GAIN_12, max(case when rf.Type_No = 12 then rf.RF_BAND end) as RF_BAND_12, 
		max(case when rf.Type_No = 13 then rf.RF_SIZE end) as RF_HEIGHT_13, max(case when rf.Type_No = 13 then rf.RF_WEIGHT end) as RF_WEIGHT_13, max(case when rf.Type_No = 13 then rf.RF_AZIMUTH end) as RF_AZIMUTH_13, max(case when rf.Type_No = 13 then rf.RF_MAKE end) as RF_MAKE_13, max(case when rf.Type_No = 13 then rf.RF_MODEL end) as RF_MODEL_13, max(case when rf.Type_No = 13 then rf.RF_GAIN end) as RF_GAIN_13, max(case when rf.Type_No = 13 then rf.RF_BAND end) as RF_BAND_13, 
		max(case when rf.Type_No = 14 then rf.RF_SIZE end) as RF_HEIGHT_14, max(case when rf.Type_No = 14 then rf.RF_WEIGHT end) as RF_WEIGHT_14, max(case when rf.Type_No = 14 then rf.RF_AZIMUTH end) as RF_AZIMUTH_14, max(case when rf.Type_No = 14 then rf.RF_MAKE end) as RF_MAKE_14, max(case when rf.Type_No = 14 then rf.RF_MODEL end) as RF_MODEL_14, max(case when rf.Type_No = 14 then rf.RF_GAIN end) as RF_GAIN_14, max(case when rf.Type_No = 14 then rf.RF_BAND end) as RF_BAND_14, 
		max(case when rf.Type_No = 15 then rf.RF_SIZE end) as RF_HEIGHT_15, max(case when rf.Type_No = 15 then rf.RF_WEIGHT end) as RF_WEIGHT_15, max(case when rf.Type_No = 15 then rf.RF_AZIMUTH end) as RF_AZIMUTH_15, max(case when rf.Type_No = 15 then rf.RF_MAKE end) as RF_MAKE_15, max(case when rf.Type_No = 15 then rf.RF_MODEL end) as RF_MODEL_15, max(case when rf.Type_No = 15 then rf.RF_GAIN end) as RF_GAIN_15, max(case when rf.Type_No = 15 then rf.RF_BAND end) as RF_BAND_15, 
		max(case when rf.Type_No = 16 then rf.RF_SIZE end) as RF_HEIGHT_16, max(case when rf.Type_No = 16 then rf.RF_WEIGHT end) as RF_WEIGHT_16, max(case when rf.Type_No = 16 then rf.RF_AZIMUTH end) as RF_AZIMUTH_16, max(case when rf.Type_No = 16 then rf.RF_MAKE end) as RF_MAKE_16, max(case when rf.Type_No = 16 then rf.RF_MODEL end) as RF_MODEL_16, max(case when rf.Type_No = 16 then rf.RF_GAIN end) as RF_GAIN_16, max(case when rf.Type_No = 16 then rf.RF_BAND end) as RF_BAND_16, 
		max(case when rf.Type_No = 17 then rf.RF_SIZE end) as RF_HEIGHT_17, max(case when rf.Type_No = 17 then rf.RF_WEIGHT end) as RF_WEIGHT_17, max(case when rf.Type_No = 17 then rf.RF_AZIMUTH end) as RF_AZIMUTH_17, max(case when rf.Type_No = 17 then rf.RF_MAKE end) as RF_MAKE_17, max(case when rf.Type_No = 17 then rf.RF_MODEL end) as RF_MODEL_17, max(case when rf.Type_No = 17 then rf.RF_GAIN end) as RF_GAIN_17, max(case when rf.Type_No = 17 then rf.RF_BAND end) as RF_BAND_17, 
		max(case when rf.Type_No = 18 then rf.RF_SIZE end) as RF_HEIGHT_18, max(case when rf.Type_No = 18 then rf.RF_WEIGHT end) as RF_WEIGHT_18, max(case when rf.Type_No = 18 then rf.RF_AZIMUTH end) as RF_AZIMUTH_18, max(case when rf.Type_No = 18 then rf.RF_MAKE end) as RF_MAKE_18, max(case when rf.Type_No = 18 then rf.RF_MODEL end) as RF_MODEL_18, max(case when rf.Type_No = 18 then rf.RF_GAIN end) as RF_GAIN_18, max(case when rf.Type_No = 18 then rf.RF_BAND end) as RF_BAND_18, 
		max(case when rf.Type_No = 19 then rf.RF_SIZE end) as RF_HEIGHT_19, max(case when rf.Type_No = 19 then rf.RF_WEIGHT end) as RF_WEIGHT_19, max(case when rf.Type_No = 19 then rf.RF_AZIMUTH end) as RF_AZIMUTH_19, max(case when rf.Type_No = 19 then rf.RF_MAKE end) as RF_MAKE_19, max(case when rf.Type_No = 19 then rf.RF_MODEL end) as RF_MODEL_19, max(case when rf.Type_No = 19 then rf.RF_GAIN end) as RF_GAIN_19, max(case when rf.Type_No = 19 then rf.RF_BAND end) as RF_BAND_19, 
		max(case when rf.Type_No = 20 then rf.RF_SIZE end) as RF_HEIGHT_20, max(case when rf.Type_No = 20 then rf.RF_WEIGHT end) as RF_WEIGHT_20, max(case when rf.Type_No = 20 then rf.RF_AZIMUTH end) as RF_AZIMUTH_20, max(case when rf.Type_No = 20 then rf.RF_MAKE end) as RF_MAKE_20, max(case when rf.Type_No = 20 then rf.RF_MODEL end) as RF_MODEL_20, max(case when rf.Type_No = 20 then rf.RF_GAIN end) as RF_GAIN_20, max(case when rf.Type_No = 20 then rf.RF_BAND end) as RF_BAND_20, 
		max(case when rf.Type_No = 21 then rf.RF_SIZE end) as RF_HEIGHT_21, max(case when rf.Type_No = 21 then rf.RF_WEIGHT end) as RF_WEIGHT_21, max(case when rf.Type_No = 21 then rf.RF_AZIMUTH end) as RF_AZIMUTH_21, max(case when rf.Type_No = 21 then rf.RF_MAKE end) as RF_MAKE_21, max(case when rf.Type_No = 21 then rf.RF_MODEL end) as RF_MODEL_21, max(case when rf.Type_No = 21 then rf.RF_GAIN end) as RF_GAIN_21, max(case when rf.Type_No = 21 then rf.RF_BAND end) as RF_BAND_21, 
		max(case when rf.Type_No = 22 then rf.RF_SIZE end) as RF_HEIGHT_22, max(case when rf.Type_No = 22 then rf.RF_WEIGHT end) as RF_WEIGHT_22, max(case when rf.Type_No = 22 then rf.RF_AZIMUTH end) as RF_AZIMUTH_22, max(case when rf.Type_No = 22 then rf.RF_MAKE end) as RF_MAKE_22, max(case when rf.Type_No = 22 then rf.RF_MODEL end) as RF_MODEL_22, max(case when rf.Type_No = 22 then rf.RF_GAIN end) as RF_GAIN_22, max(case when rf.Type_No = 22 then rf.RF_BAND end) as RF_BAND_22, 
		max(case when rf.Type_No = 23 then rf.RF_SIZE end) as RF_HEIGHT_23, max(case when rf.Type_No = 23 then rf.RF_WEIGHT end) as RF_WEIGHT_23, max(case when rf.Type_No = 23 then rf.RF_AZIMUTH end) as RF_AZIMUTH_23, max(case when rf.Type_No = 23 then rf.RF_MAKE end) as RF_MAKE_23, max(case when rf.Type_No = 23 then rf.RF_MODEL end) as RF_MODEL_23, max(case when rf.Type_No = 23 then rf.RF_GAIN end) as RF_GAIN_23, max(case when rf.Type_No = 23 then rf.RF_BAND end) as RF_BAND_23, 
		max(case when rf.Type_No = 24 then rf.RF_SIZE end) as RF_HEIGHT_24, max(case when rf.Type_No = 24 then rf.RF_WEIGHT end) as RF_WEIGHT_24, max(case when rf.Type_No = 24 then rf.RF_AZIMUTH end) as RF_AZIMUTH_24, max(case when rf.Type_No = 24 then rf.RF_MAKE end) as RF_MAKE_24, max(case when rf.Type_No = 24 then rf.RF_MODEL end) as RF_MODEL_24, max(case when rf.Type_No = 24 then rf.RF_GAIN end) as RF_GAIN_24, max(case when rf.Type_No = 24 then rf.RF_BAND end) as RF_BAND_24, 
		max(case when rf.Type_No = 25 then rf.RF_SIZE end) as RF_HEIGHT_25, max(case when rf.Type_No = 25 then rf.RF_WEIGHT end) as RF_WEIGHT_25, max(case when rf.Type_No = 25 then rf.RF_AZIMUTH end) as RF_AZIMUTH_25, max(case when rf.Type_No = 25 then rf.RF_MAKE end) as RF_MAKE_25, max(case when rf.Type_No = 25 then rf.RF_MODEL end) as RF_MODEL_25, max(case when rf.Type_No = 25 then rf.RF_GAIN end) as RF_GAIN_25, max(case when rf.Type_No = 25 then rf.RF_BAND end) as RF_BAND_25, 
		h.NO_OF_MCB, 
		max(case when mcb.Type_No = 1 then mcb.MCB_RATING end) as MCB_RATING_1, 
		max(case when mcb.Type_No = 2 then mcb.MCB_RATING end) as MCB_RATING_2, 
		max(case when mcb.Type_No = 3 then mcb.MCB_RATING end) as MCB_RATING_3, 
		max(case when mcb.Type_No = 4 then mcb.MCB_RATING end) as MCB_RATING_4, 
		max(case when mcb.Type_No = 5 then mcb.MCB_RATING end) as MCB_RATING_5, 
		max(case when mcb.Type_No = 6 then mcb.MCB_RATING end) as MCB_RATING_6, 
		max(case when mcb.Type_No = 7 then mcb.MCB_RATING end) as MCB_RATING_7, 
		max(case when mcb.Type_No = 8 then mcb.MCB_RATING end) as MCB_RATING_8, 
		max(case when mcb.Type_No = 9 then mcb.MCB_RATING end) as MCB_RATING_9, 
		max(case when mcb.Type_No = 10 then mcb.MCB_RATING end) as MCB_RATING_10,
		h.No_of_ODSC,
		max(case when odsc.Type_No = 1 then odsc.ODSC_MAKE end) as ODSC_MAKE_1, max(case when odsc.Type_No = 1 then odsc.ODSC_MODEL end) as ODSC_MODEL_1, 
		max(case when odsc.Type_No = 2 then odsc.ODSC_MAKE end) as ODSC_MAKE_2, max(case when odsc.Type_No = 2 then odsc.ODSC_MODEL end) as ODSC_MODEL_2, 
		max(case when odsc.Type_No = 3 then odsc.ODSC_MAKE end) as ODSC_MAKE_3, max(case when odsc.Type_No = 3 then odsc.ODSC_MODEL end) as ODSC_MODEL_3, 
		max(case when odsc.Type_No = 4 then odsc.ODSC_MAKE end) as ODSC_MAKE_4, max(case when odsc.Type_No = 4 then odsc.ODSC_MODEL end) as ODSC_MODEL_4

		FROM NBS_MASTER_HDR h 
		left join NBS_MASTER_DET mic on h.SR_NUMBER = mic.SR_NUMBER and mic.TYPE = 'MICROWAVE'
		 
		left join NBS_MASTER_DET rru on h.SR_NUMBER = rru.SR_NUMBER and rru.TYPE = 'RRU'
		  
		left join NBS_MASTER_DET bts on h.SR_NUMBER = bts.SR_NUMBER and bts.TYPE = 'BTS'
		 
		left join NBS_MASTER_DET bbu on h.SR_NUMBER = bbu.SR_NUMBER and bbu.TYPE = 'BBU'

		left join NBS_MASTER_DET rf on h.SR_NUMBER = rf.SR_NUMBER and rf.TYPE = 'RF_ANTENNA'

		left join NBS_MASTER_DET mcb on h.SR_NUMBER = mcb.SR_NUMBER and mcb.TYPE = 'MCB'

		left join NBS_MASTER_DET odsc on h.SR_NUMBER = odsc.SR_NUMBER and odsc.TYPE = 'ODSC'

		where h.SR_NUMBER is not null ".$filterSql." 
		GROUP by h.SR_NUMBER";

		// echo $sql;

	$result = mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);
	$columnName = array();
	foreach ($row as $key => $value) {
		array_push($columnName, $key);
	}
	
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=SR_Detail_Report.csv');
	$output = fopen('php://output', 'w');
	fputcsv($output, $columnName);

	mysqli_data_seek($result, 0);
	while($row=mysqli_fetch_assoc($result)){
		$exportData = array();
		foreach ($columnName as $key => $value) {
			array_push($exportData, $row[$value]);
		}
		fputcsv($output, $exportData);
	}
}
// Acive Asset
else if($reportType == 3){
	$sql = "SELECT h.SR_NUMBER, h.SP_NUMBER, h.SO_NUMBER, h.CIRCLE_NAME, h.AIRTEL_SITE_ID as Site_Id, h.TVI_SITE_ID, h.TAB_NAME as Product_Type, h.SR_DATE, h.SP_DATE, h.SO_DATE, (case when h.SUGGESTED_LATITUDE is not null then h.SUGGESTED_LATITUDE else h.LATITUDE_1 end) as LATITUDE, (case when h.SUGGESTED_LONGITUDE is not null then h.SUGGESTED_LONGITUDE else h.LONGITUDE_1 end) as LONGITUDE, h.Operator, h.RFI_DATE, h.RFI_ACCEPTED_DATE, h.RFS_DATE, h.Site_Name, h.SITE_TYPE as Tower_Type, h.TECHNOLOGY, h.BTS_TYPE, h.Total_Rated_Power_in_KW as Total_Rated_Power_in_Watt, h.Additional_Load,  h.NO_OF_MICROWAVE, mw.MICROWAVE_HEIGHT_1, mw.MICROWAVE_DIA_1, mw.MICROWAVE_AZIMUTH_1, mw.MICROWAVE_HEIGHT_2, mw.MICROWAVE_DIA_2, mw.MICROWAVE_AZIMUTH_2, mw.MICROWAVE_HEIGHT_3, mw.MICROWAVE_DIA_3, mw.MICROWAVE_AZIMUTH_3, mw.MICROWAVE_HEIGHT_4, mw.MICROWAVE_DIA_4, mw.MICROWAVE_AZIMUTH_4, mw.MICROWAVE_HEIGHT_5, mw.MICROWAVE_DIA_5, mw.MICROWAVE_AZIMUTH_5, mw.MICROWAVE_HEIGHT_6, mw.MICROWAVE_DIA_6, mw.MICROWAVE_AZIMUTH_6, h.NO_OF_RRU, rru.RRU_MAKE_1, rru.RRU_MODEL_1, rru.RRU_RATED_POWER_CONSUMPTION_1, rru.RRU_WEIGHT_1, rru.RRU_MAKE_2, rru.RRU_MODEL_2, rru.RRU_RATED_POWER_CONSUMPTION_2, rru.RRU_WEIGHT_2, rru.RRU_MAKE_3, rru.RRU_MODEL_3, rru.RRU_RATED_POWER_CONSUMPTION_3, rru.RRU_WEIGHT_3, rru.RRU_MAKE_4, rru.RRU_MODEL_4, rru.RRU_RATED_POWER_CONSUMPTION_4, rru.RRU_WEIGHT_4, rru.RRU_MAKE_5, rru.RRU_MODEL_5, rru.RRU_RATED_POWER_CONSUMPTION_5, rru.RRU_WEIGHT_5, rru.RRU_MAKE_6, rru.RRU_MODEL_6, rru.RRU_RATED_POWER_CONSUMPTION_6, rru.RRU_WEIGHT_6, rru.RRU_MAKE_7, rru.RRU_MODEL_7, rru.RRU_RATED_POWER_CONSUMPTION_7, rru.RRU_WEIGHT_7, rru.RRU_MAKE_8, rru.RRU_MODEL_8, rru.RRU_RATED_POWER_CONSUMPTION_8, rru.RRU_WEIGHT_8, rru.RRU_MAKE_9, rru.RRU_MODEL_9, rru.RRU_RATED_POWER_CONSUMPTION_9, rru.RRU_WEIGHT_9, rru.RRU_MAKE_10, rru.RRU_MODEL_10, rru.RRU_RATED_POWER_CONSUMPTION_10, rru.RRU_WEIGHT_10, rru.RRU_MAKE_11, rru.RRU_MODEL_11, rru.RRU_RATED_POWER_CONSUMPTION_11, rru.RRU_WEIGHT_11, rru.RRU_MAKE_12, rru.RRU_MODEL_12, rru.RRU_RATED_POWER_CONSUMPTION_12, rru.RRU_WEIGHT_12, rru.RRU_MAKE_13, rru.RRU_MODEL_13, rru.RRU_RATED_POWER_CONSUMPTION_13, rru.RRU_WEIGHT_13, rru.RRU_MAKE_14, rru.RRU_MODEL_14, rru.RRU_RATED_POWER_CONSUMPTION_14, rru.RRU_WEIGHT_14, rru.RRU_MAKE_15, rru.RRU_MODEL_15, rru.RRU_RATED_POWER_CONSUMPTION_15, rru.RRU_WEIGHT_15, rru.RRU_MAKE_16, rru.RRU_MODEL_16, rru.RRU_RATED_POWER_CONSUMPTION_16, rru.RRU_WEIGHT_16, rru.RRU_MAKE_17, rru.RRU_MODEL_17, rru.RRU_RATED_POWER_CONSUMPTION_17, rru.RRU_WEIGHT_17, rru.RRU_MAKE_18, rru.RRU_MODEL_18, rru.RRU_RATED_POWER_CONSUMPTION_18, rru.RRU_WEIGHT_18, rru.RRU_MAKE_19, rru.RRU_MODEL_19, rru.RRU_RATED_POWER_CONSUMPTION_19, rru.RRU_WEIGHT_19, rru.RRU_MAKE_20, rru.RRU_MODEL_20, rru.RRU_RATED_POWER_CONSUMPTION_20, rru.RRU_WEIGHT_20, rru.RRU_MAKE_21, rru.RRU_MODEL_21, rru.RRU_RATED_POWER_CONSUMPTION_21, rru.RRU_WEIGHT_21, rru.RRU_MAKE_22, rru.RRU_MODEL_22, rru.RRU_RATED_POWER_CONSUMPTION_22, rru.RRU_WEIGHT_22, rru.RRU_MAKE_23, rru.RRU_MODEL_23, rru.RRU_RATED_POWER_CONSUMPTION_23, rru.RRU_WEIGHT_23, rru.RRU_MAKE_24, rru.RRU_MODEL_24, rru.RRU_RATED_POWER_CONSUMPTION_24, rru.RRU_WEIGHT_24, rru.RRU_MAKE_25, rru.RRU_MODEL_25, rru.RRU_RATED_POWER_CONSUMPTION_25, rru.RRU_WEIGHT_25, h.NO_OF_BTS, bts.BTS_MAKE_1, bts.BTS_MODEL_1, bts.BTS_FLOOR_SPACE_1, bts.BTS_POWER_1, bts.BTS_MAKE_2, bts.BTS_MODEL_2, bts.BTS_FLOOR_SPACE_2, bts.BTS_POWER_2, bts.BTS_MAKE_3, bts.BTS_MODEL_3, bts.BTS_FLOOR_SPACE_3, bts.BTS_POWER_3, bts.BTS_MAKE_4, bts.BTS_MODEL_4, bts.BTS_FLOOR_SPACE_4, bts.BTS_POWER_4, h.NO_OF_BBU, bbu.BBU_MAKE_1, bbu.BBU_MODEL_1, bbu.BBU_RATED_POWER_CONSUMPTION_1, bbu.BBU_Positioning_1, bbu.BBU_MAKE_2, bbu.BBU_MODEL_2, bbu.BBU_RATED_POWER_CONSUMPTION_2, bbu.BBU_Positioning_2, bbu.BBU_MAKE_3, bbu.BBU_MODEL_3, bbu.BBU_RATED_POWER_CONSUMPTION_3, bbu.BBU_Positioning_3, bbu.BBU_MAKE_4, bbu.BBU_MODEL_4, bbu.BBU_RATED_POWER_CONSUMPTION_4, bbu.BBU_Positioning_4, bbu.BBU_MAKE_5, bbu.BBU_MODEL_5, bbu.BBU_RATED_POWER_CONSUMPTION_5, bbu.BBU_Positioning_5, bbu.BBU_MAKE_6, bbu.BBU_MODEL_6, bbu.BBU_RATED_POWER_CONSUMPTION_6, bbu.BBU_Positioning_6, h.NO_OF_RF_ANTENNA, rf.RF_HEIGHT_1, rf.RF_WEIGHT_1, rf.RF_AZIMUTH_1, rf.RF_MAKE_1, rf.RF_MODEL_1, rf.RF_GAIN_1, rf.RF_BAND_1, rf.RF_HEIGHT_2, rf.RF_WEIGHT_2, rf.RF_AZIMUTH_2, rf.RF_MAKE_2, rf.RF_MODEL_2, rf.RF_GAIN_2, rf.RF_BAND_2, rf.RF_HEIGHT_3, rf.RF_WEIGHT_3, rf.RF_AZIMUTH_3, rf.RF_MAKE_3, rf.RF_MODEL_3, rf.RF_GAIN_3, rf.RF_BAND_3, rf.RF_HEIGHT_4, rf.RF_WEIGHT_4, rf.RF_AZIMUTH_4, rf.RF_MAKE_4, rf.RF_MODEL_4, rf.RF_GAIN_4, rf.RF_BAND_4, rf.RF_HEIGHT_5, rf.RF_WEIGHT_5, rf.RF_AZIMUTH_5, rf.RF_MAKE_5, rf.RF_MODEL_5, rf.RF_GAIN_5, rf.RF_BAND_5, rf.RF_HEIGHT_6, rf.RF_WEIGHT_6, rf.RF_AZIMUTH_6, rf.RF_MAKE_6, rf.RF_MODEL_6, rf.RF_GAIN_6, rf.RF_BAND_6, rf.RF_HEIGHT_7, rf.RF_WEIGHT_7, rf.RF_AZIMUTH_7, rf.RF_MAKE_7, rf.RF_MODEL_7, rf.RF_GAIN_7, rf.RF_BAND_7, rf.RF_HEIGHT_8, rf.RF_WEIGHT_8, rf.RF_AZIMUTH_8, rf.RF_MAKE_8, rf.RF_MODEL_8, rf.RF_GAIN_8, rf.RF_BAND_8, rf.RF_HEIGHT_9, rf.RF_WEIGHT_9, rf.RF_AZIMUTH_9, rf.RF_MAKE_9, rf.RF_MODEL_9, rf.RF_GAIN_9, rf.RF_BAND_9, rf.RF_HEIGHT_10, rf.RF_WEIGHT_10, rf.RF_AZIMUTH_10, rf.RF_MAKE_10, rf.RF_MODEL_10, rf.RF_GAIN_10, rf.RF_BAND_10, rf.RF_HEIGHT_11, rf.RF_WEIGHT_11, rf.RF_AZIMUTH_11, rf.RF_MAKE_11, rf.RF_MODEL_11, rf.RF_GAIN_11, rf.RF_BAND_11, rf.RF_HEIGHT_12, rf.RF_WEIGHT_12, rf.RF_AZIMUTH_12, rf.RF_MAKE_12, rf.RF_MODEL_12, rf.RF_GAIN_12, rf.RF_BAND_12, rf.RF_HEIGHT_13, rf.RF_WEIGHT_13, rf.RF_AZIMUTH_13, rf.RF_MAKE_13, rf.RF_MODEL_13, rf.RF_GAIN_13, rf.RF_BAND_13, rf.RF_HEIGHT_14, rf.RF_WEIGHT_14, rf.RF_AZIMUTH_14, rf.RF_MAKE_14, rf.RF_MODEL_14, rf.RF_GAIN_14, rf.RF_BAND_14, rf.RF_HEIGHT_15, rf.RF_WEIGHT_15, rf.RF_AZIMUTH_15, rf.RF_MAKE_15, rf.RF_MODEL_15, rf.RF_GAIN_15, rf.RF_BAND_15, rf.RF_HEIGHT_16, rf.RF_WEIGHT_16, rf.RF_AZIMUTH_16, rf.RF_MAKE_16, rf.RF_MODEL_16, rf.RF_GAIN_16, rf.RF_BAND_16, rf.RF_HEIGHT_17, rf.RF_WEIGHT_17, rf.RF_AZIMUTH_17, rf.RF_MAKE_17, rf.RF_MODEL_17, rf.RF_GAIN_17, rf.RF_BAND_17, rf.RF_HEIGHT_18, rf.RF_WEIGHT_18, rf.RF_AZIMUTH_18, rf.RF_MAKE_18, rf.RF_MODEL_18, rf.RF_GAIN_18, rf.RF_BAND_18, rf.RF_HEIGHT_19, rf.RF_WEIGHT_19, rf.RF_AZIMUTH_19, rf.RF_MAKE_19, rf.RF_MODEL_19, rf.RF_GAIN_19, rf.RF_BAND_19, rf.RF_HEIGHT_20, rf.RF_WEIGHT_20, rf.RF_AZIMUTH_20, rf.RF_MAKE_20, rf.RF_MODEL_20, rf.RF_GAIN_20, rf.RF_BAND_20, rf.RF_HEIGHT_21, rf.RF_WEIGHT_21, rf.RF_AZIMUTH_21, rf.RF_MAKE_21, rf.RF_MODEL_21, rf.RF_GAIN_21, rf.RF_BAND_21, rf.RF_HEIGHT_22, rf.RF_WEIGHT_22, rf.RF_AZIMUTH_22, rf.RF_MAKE_22, rf.RF_MODEL_22, rf.RF_GAIN_22, rf.RF_BAND_22, rf.RF_HEIGHT_23, rf.RF_WEIGHT_23, rf.RF_AZIMUTH_23, rf.RF_MAKE_23, rf.RF_MODEL_23, rf.RF_GAIN_23, rf.RF_BAND_23, rf.RF_HEIGHT_24, rf.RF_WEIGHT_24, rf.RF_AZIMUTH_24, rf.RF_MAKE_24, rf.RF_MODEL_24, rf.RF_GAIN_24, rf.RF_BAND_24, rf.RF_HEIGHT_25, rf.RF_WEIGHT_25, rf.RF_AZIMUTH_25, rf.RF_MAKE_25, rf.RF_MODEL_25, rf.RF_GAIN_25, rf.RF_BAND_25, h.NO_OF_MCB, mcb.MCB_RATING_1, mcb.MCB_RATING_2, mcb.MCB_RATING_3, mcb.MCB_RATING_4, mcb.MCB_RATING_5, mcb.MCB_RATING_6, mcb.MCB_RATING_7, mcb.MCB_RATING_8, mcb.MCB_RATING_9, mcb.MCB_RATING_10, h.No_of_ODSC, odsc.ODSC_MAKE_1, odsc.ODSC_MODEL_1, odsc.ODSC_MAKE_2, odsc.ODSC_MODEL_2, odsc.ODSC_MAKE_3, odsc.ODSC_MODEL_3, odsc.ODSC_MAKE_4, odsc.ODSC_MODEL_4 FROM NBS_MASTER_HDR_import h left join MW_Asset mw on h.SR_NUMBER = mw.SR_NUMBER left join RRU_Asset rru on h.SR_NUMBER = rru.SR_NUMBER left join BTS_Asset bts on h.SR_NUMBER = bts.SR_NUMBER left join BBU_Asset bbu on h.SR_NUMBER = bbu.SR_NUMBER left join RF_Asset rf on h.SR_NUMBER = rf.SR_NUMBER left join MCB_Asset mcb on h.SR_NUMBER = mcb.SR_NUMBER left join ODSC_Asset odsc on h.SR_NUMBER = odsc.SR_NUMBER where h.SR_NUMBER is not null ".$filterSql;

	// echo $sql;

	$result = mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);
	$columnName = array();
	foreach ($row as $key => $value) {
		array_push($columnName, $key);
	}
	
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Active_Asset_Report.csv');
	$output = fopen('php://output', 'w');
	fputcsv($output, $columnName);

	mysqli_data_seek($result, 0);
	while($row=mysqli_fetch_assoc($result)){
		$exportData = array();
		foreach ($columnName as $key => $value) {
			array_push($exportData, $row[$value]);
		}
		fputcsv($output, $exportData);
	}
}
// Site master
else if($reportType == 4){
	$filterSql = " and `Circle` in ('".$filterCircleName."') ";
	$sql="SELECT `Circle`, `TVISiteID`, `Anchor_Site_Built_for`, `Current_Anchor`, `Site Name`, `Latitude`, `Longitude`, `Address`, `District`, `GST_State`, `Cluster`, `Wind Zone`, `TypeofSite`, `Twr Make`, `Bldg Ht`, `Tower Height Mtrs`, `AGL`, `OD/ID`, `Airtel`, `BSNL`, `Voda`, `Idea`, `MTNL`, `RJIO`, `TCL Wimax`, `TCL (NLD)`, `TTSL/ TTML GSM`, `TTSL / TTML CDMA`, `VTL`, `VIL`, `TCL` FROM `Site_Master` WHERE 1=1 $filterSql and (`Is_Deleted` is null or `Is_Deleted`='N')";
	$result = mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);
	$columnName = array();
	foreach ($row as $key => $value) {
		array_push($columnName, $key);
	}
	
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Site_Master.csv');
	$output = fopen('php://output', 'w');
	fputcsv($output, $columnName);

	mysqli_data_seek($result, 0);
	while($row=mysqli_fetch_assoc($result)){
		$exportData = array();
		foreach ($columnName as $key => $value) {
			array_push($exportData, $row[$value]);
		}
		fputcsv($output, $exportData);
	}
}


?>