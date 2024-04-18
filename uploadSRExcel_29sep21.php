<?php 
include("cpDbConfig_v1.php");
$methodType = $_SERVER['REQUEST_METHOD'];
$json = file_get_contents('php://input');
$jsonData=json_decode($json);
$todayDate = date("Y-m-d");
$loginEmpId = $jsonData->loginEmpId;
$headerData = $jsonData->headerData;
$detailData = $jsonData->detailData;
if($methodType === 'POST'){
	$hdrSrList = [];
	$status = false;
	for($i=0;$i<count($headerData);$i++){
		$loopSiteId = "";
		$tableColumn = "";
		$tableData = "";
		foreach ($headerData[$i] as $key => $value) {
			// echo $key.'---';
			$tableColumn .= "`".$key."`,";
			$tableData .= "'".$value."',";
		}
		$tableColumn .= "`TAB_NAME`, `SR_DATE`, `STATUS`, `Insert_Type`, `CREATE_BY`, `CREATE_DATE`";
		$tableData .=  "'Site_Upgrade', '$todayDate', 'NB01', 'ExcelUpload', '$loginEmpId', current_timestamp";

		$insertSql = "insert into `NBS_MASTER_HDR` ($tableColumn) value ($tableData) ";
		// echo $insertSql;
		$query=mysqli_query($conn,$insertSql);
		if($query){
			$srNo = mysqli_insert_id($conn);
			array_push($hdrSrList, $srNo);
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
				$tableColumn .= "`".$key."`,";
				$tableData .= "'".$value."',";
			}
			$tableColumn .= "`CREATE_DATE`";
			$tableData .=  "current_timestamp";

			$insertSql = "insert into `NBS_MASTER_DET` ($tableColumn) value ($tableData) ";
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
			$deleteHdrSql = "DELETE from `NBS_MASTER_HDR` where `SRNo` in (".implode(",", $hdrSrList).") ";
			// echo $deleteHdrSql.'-----------';
			mysqli_query($conn,$deleteHdrSql);
		}
		if(count($detSrList) !=0){
			$deleteDetSql = "DELETE from `NBS_MASTER_DET` where `DET_ID` in (".implode(",", $detSrList).") ";
			// echo $deleteDetSql.'-----------';
			mysqli_query($conn,$deleteDetSql); 
		}
		$output -> status = false;
		$output -> message = "Something went wrong";
	}

	echo json_encode($output);
	
}

?>