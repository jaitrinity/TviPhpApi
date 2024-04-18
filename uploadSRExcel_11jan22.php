<?php 
include("cpDbConfig.php");
$methodType = $_SERVER['REQUEST_METHOD'];
$json = file_get_contents('php://input');
$jsonData=json_decode($json);
$todayDate = date("Y-m-d");
$loginEmpId = $jsonData->loginEmpId;
$opcoCircleName = $jsonData->opcoCircleName;
$headerData = $jsonData->headerData;
$detailData = $jsonData->detailData;
if($methodType === 'POST'){
	$hdrSrList = [];
	$notExist = false;
	$notMatch = "";
	$status = false;
	$srJson = "";
	for($i=0;$i<count($headerData);$i++){
		$loopSiteId = "";
		$tableColumn = "";
		$tableData = "";
		$operator = "";
		$tviSiteId = "";
		$circleName = "";
		$srNumber = "SU_SR".(time()+($i*10));
		foreach ($headerData[$i] as $key => $value) {
			// echo $key.'---';
			if($key == "SR_NUMBER"){
				$tableColumn .= "`".$key."`,";
				$tableData .= "'$srNumber',";
				$srJson -> $value = $srNumber;
			}
			else if($key == "CIRCLE_NAME"){
				$circleName = $value;
			}
			else if($key == "Operator"){
				$operator = $value;
			}
			else if($key == "TVI_SITE_ID"){
				$tviSiteId = $value;
			}
			else if($key == "Total_Rated_Power_in_Watt"){
				$tableColumn .= "`Total_Rated_Power_in_KW`,";
				$tableData .= "'".$value."',";
			}
			else{
				$tableColumn .= "`".$key."`,";
				$tableData .= "'".$value."',";
			}
		}

		$tviSql = "SELECT * FROM `Site_Master` where `TVISiteID` = '$tviSiteId' and `Circle` = '$circleName' and `$operator` = 'Y' ";
		$tviQuery=mysqli_query($conn,$tviQuery);
		$rowcount=mysqli_num_rows($tviQuery);
		if($rowcount == 0){
			$notExist = true;
			$notMatch .= ($i+1).") ".$tviSiteId." -> ".$circleName." -> ".$operator."\n";
		}
		else{
			$tableColumn .= "`TAB_NAME`, `SR_DATE`, `STATUS`, `Insert_Type`, `CREATE_BY`, `CREATE_DATE`";
			$tableData .=  "'Site_Upgrade', '$todayDate', 'NB01', 'ExcelUpload', '$loginEmpId', current_timestamp";

			$insertSql = "insert into `NBS_MASTER_HDR` ($tableColumn) value ($tableData) ";
			// echo $insertSql.'---111----';
			$query=mysqli_query($conn,$insertSql);
			if($query){
				$srNo = mysqli_insert_id($conn);
				// array_push($hdrSrList, $srNo);
				array_push($hdrSrList, $srNumber);
			}
		}	
	}

	$detSrList = [];
	if(count($hdrSrList) == count($headerData)){
		$status = true;
		for($i=0;$i<count($detailData);$i++){
			$loopSiteId = "";
			$tableColumn = "";
			$tableData = "";
			foreach ($detailData[$i] as $key => $value) {
				// echo $key.'---';
				if($key == "SR_NUMBER"){
					$tableColumn .= "`".$key."`,";
					$tableData .= "'".$srJson->$value."',";
				}
				else{
					$tableColumn .= "`".$key."`,";
					$tableData .= "'".$value."',";
				}
					
			}
			$tableColumn .= "`CREATE_DATE`";
			$tableData .=  "current_timestamp";

			$insertSql = "insert into `NBS_MASTER_DET` ($tableColumn) value ($tableData) ";
			// echo $insertSql.'---222----';
			$query=mysqli_query($conn,$insertSql);
			if($query){
				$srNo = mysqli_insert_id($conn);
				array_push($detSrList, $srNo);
			}
		}
		if(count($detSrList) == count($detailData)){
			$status = true;
		}
		else{
			$status = false;
		}
	}
	else{
		$status = false;
	}

	$output = "";
	if($status){
		$output -> status = true;
		$output -> message = "Successfully Upload";
	}
	else{
		if(count($hdrSrList) != 0){
			// $deleteHdrSql = "DELETE from `NBS_MASTER_HDR` where `SRNo` in (".implode(",", $hdrSrList).") ";
			$deleteHdrSql = "DELETE from `NBS_MASTER_HDR` where `SR_NUMBER` in ('".implode(",", $hdrSrList)."') ";
			// echo $deleteHdrSql.'-----------';
			mysqli_query($conn,$deleteHdrSql);
		}
		if(count($detSrList) !=0){
			$deleteDetSql = "DELETE from `NBS_MASTER_DET` where `DET_ID` in (".implode(",", $detSrList).") ";
			// echo $deleteDetSql.'-----------';
			mysqli_query($conn,$deleteDetSql); 
		}
		$output -> status = false;
		if($notExist){
			$output -> message = "Combination of TVI_SITE_ID -> CIRCLE_NAME -> Operator not match in site master of below sites : \n".$notMatch."\n Please verify and upload again.";
		}
		else{
			$output -> message = "Something went wrong";
		}
	}

	echo json_encode($output);
	
}

?>