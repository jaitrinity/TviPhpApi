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
$detailData = $jsonData->detailData;
$rfAntennaData = $jsonData->rfAntennaData;
$bbuExcelData = $jsonData->bbuData;
$rruExcelData = $jsonData->rruData;
$tabName = "Site_Upgrade";
if($methodType === 'POST'){
	$successSrStatus = [];
	$hdrSrList = [];
	$status = false;
	$rfStatus = false;
	$bbuStatus = false;
	$rruStatus = false;
	$notExist = false;
	$notMatch = "";
	for($i=0;$i<count($headerData);$i++){
		$tviSiteId = "";
		$srNumber = "";
		$noOfRF = 0;
		$noOfBBU = 0;
		$noOfRRU = 0;
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
		// echo $rfSql.'-------';

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
		// echo $bbuSql.'-------';

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
		// echo $rruSql."-------";
		
		$tableColumn .= "`CIRCLE_NAME`, `Operator`, `NO_OF_RF_ANTENNA`, `NO_OF_BBU`, `NO_OF_RRU`, `Total_Rated_Power_in_KW`, `TAB_NAME`, `SR_DATE`, 
		`STATUS`, `Insert_Type`, `CREATE_BY`, `CREATE_DATE`";
		$tableData .=  "'$circleName', '$operator', $noOfRF, $noOfBBU, $noOfRRU, $totalRatedPower, '$tabName', '$todayDate', 'NB01', 'ExcelUpload', 
		'$loginEmpId', current_timestamp";

		$tviSql = "SELECT * FROM `Site_Master` where `TVISiteID` = '$tviSiteId' and `Circle` = '$circleName' and `$operator` = 'Y' ";
		$tviQuery=mysqli_query($conn,$tviSql);
		$rowcount=mysqli_num_rows($tviQuery);
		if($rowcount == 0){
			$notExist = true;
			// $notMatch .= ($i+1).") ".$tviSiteId." -> ".$circleName." -> ".$operator."\n";
			$notMatch .= $srNumber.") ".$tviSiteId." -> ".$circleName." -> ".$operator."\n";
			// break;
		}else{
			$insertSql = "insert into `NBS_MASTER_HDR` ($tableColumn) values ($tableData) ";
			// echo $insertSql;
			$query=mysqli_query($conn,$insertSql);
			if($query){
				$successSR = array('srNumber' => $randomSR, 'circleName' => $circleName, 'operator' => $operator);
				array_push($successSrStatus, $successSR);
				$status = true;
				$rfQuery = mysqli_query($conn,$rfSql);
				if($rfQuery || $noOfRF == 0){
					$rfStatus = true;
					$bbuQuery = mysqli_query($conn,$bbuSql);
					if($bbuQuery  || $noOfBBU == 0){
						$bbuStatus = true;
						$rruQuery = mysqli_query($conn,$rruSql);
						if($rruQuery  || $noOfRRU == 0){
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
	}

	$srImplode = implode("','", $hdrSrList);

	$deleteHdrSql = "DELETE from `NBS_MASTER_HDR` where `SR_NUMBER` in ('".$srImplode."') ";
	$deleteDetSql = "DELETE from `NBS_MASTER_DET` where `SR_NUMBER` in ('".$srImplode."') ";

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
	else{
		// for($ii=0;$ii<count($successSrStatus);$ii++){
		// 	$aa = $successSrStatus[$ii]["srNumber"];
		// 	$bb = $successSrStatus[$ii]["circleName"];
		// 	$cc = $successSrStatus[$ii]["operator"];
		// 	sendMailAndSms($aa,$bb,$cc,$tabName);
		// }
		
		$output -> status = true;
		$output -> message = "Successfully Upload";
	}
	

	echo json_encode($output);
	
}

?>

<?php 
function sendMailAndSms($srNumber, $circleName, $operator, $tabName){
	$url = "http://www.in3.co.in:8080/TVI_CP_WSv1/tvi/sendMailMyPhp";

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