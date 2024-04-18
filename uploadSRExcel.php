<?php 
include("cpDbConfig.php");
$methodType = $_SERVER['REQUEST_METHOD'];
$json = file_get_contents('php://input');
$jsonData=json_decode($json);
$todayDate = date("Y-m-d");
$loginEmpId = $jsonData->loginEmpId;
$circleName = $jsonData->circleName;
$operator = $jsonData->operator;
$headerData = $jsonData->headerData;
$tabName = $jsonData->tabName;
if($tabName == "Site_Upgrade" && $methodType === 'POST'){
	$rfAntennaData = $jsonData->rfAntennaData;
	$bbuExcelData = $jsonData->bbuData;
	$rruExcelData = $jsonData->rruData;
	$mwExcelData = $jsonData->mwData;

	$successSrStatus = [];
	$hdrSrList = [];
	$status = false;
	$rfStatus = false;
	$bbuStatus = false;
	$rruStatus = false;
	$mwStatus = false;
	$notExist = false;
	$notMatch = "";
	for($i=0;$i<count($headerData);$i++){
		$tviSiteId = "";
		$srNumber = "";
		$noOfRF = 0;
		$noOfBBU = 0;
		$noOfRRU = 0;
		$noOfMW = 0;
		$totalRatedPower = 0;
		$tableColumn = "";
		$tableData = "";
		$randomSR = "SU_SR".(time()+($i*10));
		foreach ($headerData[$i] as $key => $value) {
			// echo $key.'---';
			if($key == "SR_NUMBER"){
				$tableColumn .= "`".$key."`,";
				$tableData .= "'".$randomSR."',";
				$srNumber = $value;
				array_push($hdrSrList, $randomSR);
			}
			else if($key == "TVI_SITE_ID"){
				$tviSiteId = $value;
				$tableColumn .= "`".$key."`,";
				$tableData .= "'".$value."',";
			}
			else if($key == "Additional_Load"){
				$totalRatedPower = $value;
				$tableColumn .= "`".$key."`,";
				$tableData .= "'".$value."',";
			}
			else{
				$tableColumn .= "`".$key."`,";
				$tableData .= "'".$value."',";
			}
		}

		// RF
		$rfColumn = "";
		for($rf=0;$rf<count($rfAntennaData);$rf++){
			if($rf==0){
				foreach ($rfAntennaData[$rf] as $rfKey => $rfValue) {
					$rfColumn .= "`".$rfKey."`,";
				}
			}
				
		}
		$rfColumn .= "`TYPE`, `Type_No`, `Insert_Type` ";
		$rfData = "";
		for($rf=0;$rf<count($rfAntennaData);$rf++){
			$rfSR = $rfAntennaData[$rf]->SR_NUMBER;
			if($rfSR == $srNumber){
				$rfData .= "(";
				$rfTypeNo = 0;
				foreach ($rfAntennaData[$rf] as $rfKey => $rfValue) {
					if($rfKey == "SR_NUMBER"){
						$noOfRF++;
						$rfTypeNo = $noOfRF;

						$rfData .= "'".$randomSR."',";
					}
					else{
						$rfData .= "'".$rfValue."',";
					}
				}
				$rfData .= "'RF_ANTENNA', $rfTypeNo, 'ExcelUpload'),";
			}	
		}
		$rfData = rtrim($rfData, ',');
		$rfSql = "insert into `NBS_MASTER_DET` ($rfColumn) values $rfData ";
		
		// BBU
		$bbuColumn = "";
		for($bbu=0;$bbu<count($bbuExcelData);$bbu++){
			if($bbu == 0){
				foreach ($bbuExcelData[$bbu] as $bbuKey => $bbuValue) {
					$bbuColumn .= "`".$bbuKey."`,";
				}
			}
				
		}
		$bbuColumn .= "`TYPE`, `Type_No`, `Insert_Type` ";
		$bbuData = "";
		for($bbu=0;$bbu<count($bbuExcelData);$bbu++){
			$bbuSR = $bbuExcelData[$bbu]->SR_NUMBER;
			if($bbuSR == $srNumber){
				$bbuData .= "(";
				$bbuTypeNo = 0;
				foreach ($bbuExcelData[$bbu] as $bbuKey => $bbuValue) {
					if($bbuKey == "SR_NUMBER"){
						$noOfBBU++;
						$bbuTypeNo = $noOfBBU;

						$bbuData .= "'".$randomSR."',";
						$bbuSr = $bbuValue;
					}
					else if($bbuKey == "BBU_RATED_POWER_CONSUMPTION"){
						$totalRatedPower += $bbuValue;
						$bbuData .= "'".$bbuValue."',";
					}
					else{
						$bbuData .= "'".$bbuValue."',";
					}
						
				}
				$bbuData .= "'BBU', $bbuTypeNo, 'ExcelUpload'),";
			}
				
		}
		$bbuData = rtrim($bbuData, ',');
		$bbuSql = "insert into `NBS_MASTER_DET` ($bbuColumn) values $bbuData ";
		
		// RRU
		$rruColumn = "";
		for($rru=0;$rru<count($rruExcelData);$rru++){
			if($rru == 0){
				foreach ($rruExcelData[$rru] as $rruKey => $rruValue) {
					$rruColumn .= "`".$rruKey."`,";
				}
			}
				
		}
		$rruColumn .= "`TYPE`, `Type_No`, `Insert_Type` ";
		$rruData = "";
		for($rru=0;$rru<count($rruExcelData);$rru++){
			$rruSR = $rruExcelData[$rru]->SR_NUMBER;
			if($rruSR == $srNumber){
				$rruData .= "(";
				$rruTypeNo = 0;
				foreach ($rruExcelData[$rru] as $rruKey => $rruValue) {
					if($rruKey == "SR_NUMBER"){
						$noOfRRU++;
						$rruTypeNo = $noOfRRU;

						$rruData .= "'".$randomSR."',";
						$rruSr = $rruValue;
					}
					else if($rruKey == "RRU_RATED_POWER_CONSUMPTION"){
						$totalRatedPower += $rruValue;
						$rruData .= "'".$rruValue."',";
					}
					else{
						$rruData .= "'".$rruValue."',";
					}
					
				}
				$rruData .= "'RRU', $rruTypeNo, 'ExcelUpload'),";
			}
				
		}
		$rruData = rtrim($rruData, ',');
		$rruSql = "insert into `NBS_MASTER_DET` ($rruColumn) values $rruData ";
		
		// MW
		$mwColumn = "";
		for($mw=0;$mw<count($mwExcelData);$mw++){
			if($mw==0){
				foreach ($mwExcelData[$mw] as $mwKey => $mwValue) {
					$mwColumn .= "`".$mwKey."`,";
				}
			}
				
		}
		$mwColumn .= "`TYPE`, `Type_No`, `Insert_Type` ";
		$mwData = "";
		for($mw=0;$mw<count($mwExcelData);$mw++){
			$mwSR = $mwExcelData[$mw]->SR_NUMBER;
			if($mwSR == $srNumber){
				$mwData .= "(";
				$mwTypeNo = 0;
				foreach ($mwExcelData[$mw] as $mwKey => $mwValue) {
					if($mwKey == "SR_NUMBER"){
						$noOfMW++;
						$mwTypeNo = $noOfMW;

						$mwData .= "'".$randomSR."',";
					}
					else{
						$mwData .= "'".$mwValue."',";
					}
				}
				$mwData .= "'MICROWAVE', $mwTypeNo, 'ExcelUpload'),";
			}	
		}
		$mwData = rtrim($mwData, ',');
		$mwSql = "insert into `NBS_MASTER_DET` ($mwColumn) values $mwData ";

		
		$tableColumn .= "`CIRCLE_NAME`, `Operator`, `NO_OF_RF_ANTENNA`, `NO_OF_BBU`, `NO_OF_RRU`, `NO_OF_MICROWAVE`, `Total_Rated_Power_in_KW`, `TAB_NAME`, `SR_DATE`, `STATUS`, `Insert_Type`, `CREATE_BY`, `CREATE_DATE`";
		$tableData .=  "'$circleName', '$operator', $noOfRF, $noOfBBU, $noOfRRU, $noOfMW, $totalRatedPower, '$tabName', '$todayDate', 'NB01', 'ExcelUpload', '$loginEmpId', current_timestamp";

		$tviSql = "SELECT * FROM `Site_Master` where `TVISiteID` = '$tviSiteId' and `Circle` = '$circleName' and `$operator` = 'Y' ";
		$tviQuery=mysqli_query($conn,$tviSql);
		$rowcount=mysqli_num_rows($tviQuery);
		if($rowcount == 0){
			$notExist = true;
			$notMatch .= ($i+1).") ".$tviSiteId." -> ".$circleName." -> ".$operator."\n";
			break;
		}else{
			$insertSql = "insert into `NBS_MASTER_HDR` ($tableColumn) values ($tableData) ";
			// echo $insertSql;
			$query=mysqli_query($conn,$insertSql);
			if($query){
				$successSR = array('srNumber' => $randomSR, 'circleName' => $circleName, 'operator' => $operator);
				array_push($successSrStatus, $successSR);
				$status = true;
				$rfQuery = mysqli_query($conn,$rfSql);
				if($rfData == "") $rfQuery = true;
				if($rfQuery){
					$rfStatus = true;
					$bbuQuery = mysqli_query($conn,$bbuSql);
					if($bbuData == "") $bbuQuery = true;
					if($bbuQuery){
						$bbuStatus = true;
						$rruQuery = mysqli_query($conn,$rruSql);
						if($rruData == "") $rruQuery = true;
						if($rruQuery){
							$rruStatus = true;
							$mwQuery = mysqli_query($conn,$mwSql);
							if($mwData == "") $mwQuery = true;
							if($mwQuery){
								$mwStatus = true;
							}
							else{
								break;
							}
						}
						else{
							break;
						}
					}
					else{
						break;
					}
				}
				else{
					break;
				}
			}
			else{
				break;
			}
		}		
	}

	$deleteHdrSql = "DELETE from `NBS_MASTER_HDR` where `SR_NUMBER` in ('".implode("','", $hdrSrList)."') ";
	$deleteDetSql = "DELETE from `NBS_MASTER_DET` where `SR_NUMBER` in ('".implode("','", $hdrSrList)."') ";

	$output = "";
	if($notExist){
		mysqli_query($conn,$deleteHdrSql);
		mysqli_query($conn,$deleteDetSql);
		$output -> status = false;
		$output -> message = "Combination of TVI_SITE_ID -> CIRCLE_NAME -> Operator not match in site master of below sites : \n".$notMatch."\n
		Please verify and upload again.";
	}
	else if($status == false){
		mysqli_query($conn,$deleteHdrSql);
		mysqli_query($conn,$deleteDetSql);
		$output -> status = false;
		$output -> message = "Something wrong while uploading `NBS_MASTER_HDR` excel.";
	}
	else if($rfStatus == false){
		mysqli_query($conn,$deleteHdrSql);
		mysqli_query($conn,$deleteDetSql);
		$output -> status = false;
		$output -> message = "Something wrong while uploading `RF_Antenna` excel.";
	}
	else if($bbuStatus == false){
		mysqli_query($conn,$deleteHdrSql);
		mysqli_query($conn,$deleteDetSql);
		$output -> status = false;
		$output -> message = "Something wrong while uploading `BBU` excel.";
	}
	else if($rruStatus == false){
		mysqli_query($conn,$deleteHdrSql);
		mysqli_query($conn,$deleteDetSql);
		$output -> status = false;
		$output -> message = "Something wrong while uploading `RRU` excel.";
	}
	else if($mwStatus == false){
		mysqli_query($conn,$deleteHdrSql);
		mysqli_query($conn,$deleteDetSql);
		$output -> status = false;
		$output -> message = "Something wrong while uploading `MW` excel.";
	}
	else{
		/*for($ii=0;$ii<count($successSrStatus);$ii++){
			$aa = $successSrStatus[$ii]["srNumber"];
			$bb = $successSrStatus[$ii]["circleName"];
			$cc = $successSrStatus[$ii]["operator"];
			sendMailAndSms($aa,$bb,$cc,$tabName);
		}*/
		
		$output -> status = true;
		$output -> message = "Successfully Upload";
	}
	echo json_encode($output);

	$insertResponseSql = "INSERT INTO `Response_Table`(`METHOD_NAME`, `REQUEST_JSON`, `RESPONSE_JSON`, `CREATED_DATE`) VALUES ('UploadExcel_$tabName', '".json_encode($jsonData)."', '".json_encode($output)."', current_timestamp)";
	mysqli_query($conn,$insertResponseSql);
}
else if($tabName == "HPSC" && $methodType === 'POST'){
	$polesExcelData = $jsonData->polesData;
	$hpscAntennaExcelData = $jsonData->hpscAntennaData;
	$bbuExcelData = $jsonData->bbuData;
	$rruExcelData = $jsonData->rruData;

	$successSrStatus = [];
	$hdrSrList = [];
	$status = false;
	$polesStatus = false;
	$hpscStatus = false;
	$bbuStatus = false;
	$rruStatus = false;
	$notExist = false;
	$notMatch = "";

	for($i=0;$i<count($headerData);$i++){
		$srNumber = "";
		$noOfPoles = 0;
		$noOfHpsc = 0;
		$noOfBBU = 0;
		$noOfRRU = 0;
		$totalRatedPower = 0;


		$tableColumn = "";
		$tableData = "";
		$randomSR = "HPSC_SR".(time()+($i*10));

		foreach ($headerData[$i] as $key => $value) {
			if($key == "SRNo"){
				$tableColumn .= "`SR_NUMBER`,";
				$tableData .= "'".$randomSR."',";
				$srNumber = $value;
				array_push($hdrSrList, $randomSR);
			}
			else if($key == "AGL_required_for_HPSC"){
				$tableColumn .= "`AGL_required_for_ODSC`,";
				$tableData .= "'".$value."',";
			}
			else if($key == "Backhaul"){
				$tableColumn .= "`Airtel_Backhaul`,";
				$tableData .= "'".$value."',";
			}
			else if($key == "Power_Rating_Of_Equipment"){
				$tableColumn .= "`".$key."`,";
				$tableData .= "'".$value."',";
				$totalRatedPower = $value;
			}
			else{
				$tableColumn .= "`".$key."`,";
				$tableData .= "'".$value."',";
			}
		}

		// POLE
		$polesColumn = "`TYPE`, `Type_No`, `Insert_Type`";
		for($poles=0;$poles<count($polesExcelData);$poles++){
			if($poles==0){
				foreach ($polesExcelData[$poles] as $polesKey => $polesValue) {
					if($polesKey == "SRNo"){
						$polesColumn .= ",`SR_NUMBER`";
					}
					else{
						$polesColumn .= ",`".$polesKey."`";
					}	
				}
			}
		}

		$polesColumnData = "";
		for($poles=0;$poles<count($polesExcelData);$poles++){
			$polesSR = $polesExcelData[$poles]->SRNo;
			if($polesSR == $srNumber){
				$noOfPoles++;
				$polesTypeNo = $noOfPoles;

				$polesColumnData .= "('POLE', $polesTypeNo, 'ExcelUpload'";
				foreach ($polesExcelData[$poles] as $polesKey => $polesValue) {
					if($polesKey == "SRNo"){
						$polesColumnData .= ",'".$randomSR."'";
					}
					else{
						$polesColumnData .= ",'".$polesValue."'";
					}
				}
				$polesColumnData .= "),";
			}	
		}
		$polesColumnData = rtrim($polesColumnData, ',');
		$polesSql = "insert into `NBS_MASTER_DET` ($polesColumn) values $polesColumnData ";

		// HPSC_Antenna
		$hpscColumn = "`TYPE`, `Type_No`, `Insert_Type`";
		for($hpsc=0;$hpsc<count($hpscAntennaExcelData);$hpsc++){
			if($hpsc==0){
				foreach ($hpscAntennaExcelData[$hpsc] as $hpscKey => $hpscValue) {
					if($hpscKey == "SRNo"){
						$hpscColumn .= ",`SR_NUMBER`";
					}
					else{
						$hpscColumn .= ",`".$hpscKey."`";
					}	
				}
			}
		}

		$hpscColumnData = "";
		for($hpsc=0;$hpsc<count($hpscAntennaExcelData);$hpsc++){
			$hpscSR = $hpscAntennaExcelData[$hpsc]->SRNo;
			if($hpscSR == $srNumber){
				$noOfHpsc++;
				$hpscTypeNo = $noOfHpsc;

				$hpscColumnData .= "('HPSC_Antenna', $hpscTypeNo, 'ExcelUpload'";
				foreach ($hpscAntennaExcelData[$hpsc] as $hpscKey => $hpscValue) {
					if($hpscKey == "SRNo"){
						$hpscColumnData .= ",'".$randomSR."'";
					}
					else{
						$hpscColumnData .= ",'".$hpscValue."'";
					}
				}
				$hpscColumnData .= "),";
			}	
		}
		$hpscColumnData = rtrim($hpscColumnData, ',');
		$hpscSql = "insert into `NBS_MASTER_DET` ($hpscColumn) values $hpscColumnData ";

		// BBU
		$bbuColumn = "`TYPE`, `Type_No`, `Insert_Type`";
		for($bbu=0;$bbu<count($bbuExcelData);$bbu++){
			if($bbu == 0){
				foreach ($bbuExcelData[$bbu] as $bbuKey => $bbuValue) {
					if($bbuKey == "SRNo"){
						$bbuColumn .= ",`SR_NUMBER`";
					}
					else{
						$bbuColumn .= ",`".$bbuKey."`";
					}
					
				}
			}		
		}

		$bbuColumnData = "";
		for($bbu=0;$bbu<count($bbuExcelData);$bbu++){
			$bbuSR = $bbuExcelData[$bbu]->SRNo;
			if($bbuSR == $srNumber){
				$noOfBBU++;
				$bbuTypeNo = $noOfBBU;

				$bbuColumnData .= "('BBU', $bbuTypeNo, 'ExcelUpload'";
				foreach ($bbuExcelData[$bbu] as $bbuKey => $bbuValue) {
					if($bbuKey == "SRNo"){
						$bbuColumnData .= ",'".$randomSR."'";
					}
					else if($bbuKey == "BBU_RATED_POWER_CONSUMPTION"){
						$totalRatedPower += $bbuValue;
						$bbuColumnData .= ",'".$bbuValue."'";
					}
					else{
						$bbuColumnData .= ",'".$bbuValue."'";
					}
				}
				$bbuColumnData .= "),";
			}	
		}
		$bbuColumnData = rtrim($bbuColumnData, ',');
		$bbuSql = "insert into `NBS_MASTER_DET` ($bbuColumn) values $bbuColumnData ";

		// RRU
		$rruColumn = "`TYPE`, `Type_No`, `Insert_Type`";
		for($rru=0;$rru<count($rruExcelData);$rru++){
			if($rru == 0){
				foreach ($rruExcelData[$rru] as $rruKey => $rruValue) {
					if($rruKey == "SRNo"){
						$rruColumn .= ",`SR_NUMBER`";
					}
					else{
						$rruColumn .= ",`".$rruKey."`";
					}
					
				}
			}		
		}

		$rruColumnData = "";
		for($rru=0;$rru<count($rruExcelData);$rru++){
			$rruSR = $rruExcelData[$rru]->SRNo;
			if($rruSR == $srNumber){
				$noOfRRU++;
				$rruTypeNo = $noOfRRU;

				$rruColumnData .= "('RRU', $rruTypeNo, 'ExcelUpload'";
				foreach ($rruExcelData[$rru] as $rruKey => $rruValue) {
					if($rruKey == "SRNo"){
						$rruColumnData .= ",'".$randomSR."'";
					}
					else if($rruKey == "RRU_RATED_POWER_CONSUMPTION"){
						$totalRatedPower += $rruValue;
						$rruColumnData .= ",'".$rruValue."'";
					}
					else{
						$rruColumnData .= ",'".$rruValue."'";
					}
				}
				$rruColumnData .= "),";
			}	
		}
		$rruColumnData = rtrim($rruColumnData, ',');
		$rruSql = "insert into `NBS_MASTER_DET` ($rruColumn) values $rruColumnData ";

		$tableColumn .= "`CIRCLE_NAME`, `Operator`, `No_Of_Poles`, `No_Of_HPSC_Antenna`, `NO_OF_BBU`, `NO_OF_RRU`, `TAB_NAME`, `SR_DATE`, `Total_Rated_Power_in_KW`, `STATUS`, `Insert_Type`, `CREATE_BY`, `CREATE_DATE`";
		$tableData .=  "'$circleName', '$operator', $noOfPoles, $noOfHpsc, $noOfBBU, $noOfRRU, '$tabName', '$todayDate', $totalRatedPower, 'NB01', 'ExcelUpload', '$loginEmpId', current_timestamp";

		$insertSql = "insert into `NBS_MASTER_HDR` ($tableColumn) values ($tableData) ";
		$query=mysqli_query($conn,$insertSql);
		if($query){
			$successSR = array('srNumber' => $randomSR, 'circleName' => $circleName, 'operator' => $operator);
			array_push($successSrStatus, $successSR);
			$status = true;
			$polesQuery = mysqli_query($conn,$polesSql);
			if($polesColumnData == "") $polesQuery = true;
			if($polesQuery){
				$polesStatus = true;
				$hpscQuery = mysqli_query($conn,$hpscSql);
				if($hpscColumnData == "") $hpscQuery = true;
				if($hpscQuery){
					$hpscStatus = true;
					$bbuQuery = mysqli_query($conn,$bbuSql);
					if($bbuColumnData == "") $bbuQuery = true;
					if($bbuQuery){
						$bbuStatus = true;
						$rruQuery = mysqli_query($conn,$rruSql);
						if($rruColumnData == "") $rruQuery = true;
						if($rruQuery){
							$rruStatus = true;
						}
						else{
							break;
						}
					}
					else{
						break;
					}
				}
				else{
					break;
				}	
			}
			else{
				break;
			}
		}
		else{
			break;
		}
	}

	$deleteHdrSql = "DELETE from `NBS_MASTER_HDR` where `SR_NUMBER` in ('".implode("','", $hdrSrList)."') ";
	$deleteDetSql = "DELETE from `NBS_MASTER_DET` where `SR_NUMBER` in ('".implode("','", $hdrSrList)."') ";

	$output = "";
	if($notExist){
		mysqli_query($conn,$deleteHdrSql);
		mysqli_query($conn,$deleteDetSql);
		$output -> status = false;
		$output -> message = "Combination of TVI_SITE_ID -> CIRCLE_NAME -> Operator not match in site master of below sites : \n".$notMatch."\n
		Please verify and upload again.";
	}
	else if($status == false){
		mysqli_query($conn,$deleteHdrSql);
		mysqli_query($conn,$deleteDetSql);
		$output -> status = false;
		$output -> message = "Something wrong while uploading `HPSC_MASTER_HDR` excel.";
	}
	else if($polesStatus == false){
		mysqli_query($conn,$deleteHdrSql);
		mysqli_query($conn,$deleteDetSql);
		$output -> status = false;
		$output -> message = "Something wrong while uploading `HPSC_POLES` excel.";
	}
	else if($hpscStatus == false){
		mysqli_query($conn,$deleteHdrSql);
		mysqli_query($conn,$deleteDetSql);
		$output -> status = false;
		$output -> message = "Something wrong while uploading `HPSC_Antenna` excel.";
	}
	else if($bbuStatus == false){
		mysqli_query($conn,$deleteHdrSql);
		mysqli_query($conn,$deleteDetSql);
		$output -> status = false;
		$output -> message = "Something wrong while uploading `HPSC_BBU` excel.";
	}
	else if($rruStatus == false){
		mysqli_query($conn,$deleteHdrSql);
		mysqli_query($conn,$deleteDetSql);
		$output -> status = false;
		$output -> message = "Something wrong while uploading `HPSC_RRU` excel.";
	}
	else{
		/*for($ii=0;$ii<count($successSrStatus);$ii++){
			$aa = $successSrStatus[$ii]["srNumber"];
			$bb = $successSrStatus[$ii]["circleName"];
			$cc = $successSrStatus[$ii]["operator"];
			sendMailAndSms($aa,$bb,$cc,$tabName);
		}*/
		
		$output -> status = true;
		$output -> message = "Successfully Upload";
	}
	echo json_encode($output);

	$insertResponseSql = "INSERT INTO `Response_Table`(`METHOD_NAME`, `REQUEST_JSON`, `RESPONSE_JSON`, `CREATED_DATE`) VALUES ('UploadExcel_$tabName', '".json_encode($jsonData)."', '".json_encode($output)."', current_timestamp)";
	mysqli_query($conn,$insertResponseSql);
}

?>

<?php 
function sendMailAndSms($srNumber, $circleName, $operator, $tabName){
	$url = "http://www.in3.co.in:8080/TVI_CP/tvi/sendMailMyPhp";

	$dataArray = ['srNumber' => $srNumber, 'circleName' => $circleName, 'operatorName' => $operator, 'currentTab' => $tabName];
	$data = http_build_query($dataArray);
	$getUrl = $url."?".$data;

	$ch = curl_init();   
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $getUrl);
    curl_setopt($ch, CURLOPT_TIMEOUT, 80);
       
    $response = curl_exec($ch);
        
    if(curl_error($ch)){
        // echo 'Request Error:' . curl_error($ch);
    }else{
        // echo $response;
    }
       
    curl_close($ch);
}
?>