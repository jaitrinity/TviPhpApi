<?php 
include("cpDbConfig.php");
$methodType = $_SERVER['REQUEST_METHOD'];
if($methodType != "POST"){
	return;
}
$requestJson = file_get_contents('php://input');
$jsonData=json_decode($requestJson);
$loginEmpId = $jsonData->loginEmpId;
$loginEmpRole = $jsonData->loginEmpRole;
$circleName = $jsonData->circleName;
$operator = $jsonData->operator;
// $isHoUser = $jsonData->isHoUser;
$filterPeriod = $jsonData->filterPeriod; // MTD, YTD
$periodStartDate = getPeriodStartDate($filterPeriod);
// $srStatus = $jsonData->srStatus; // SR, SP, SO, RFI, RFI Accept, RFS
$filterProductType = $jsonData->filterProductType;
$filterCircleName = $jsonData->filterCircleName;
$graphType = $jsonData->graphType;

$allOperator = "Airtel,BSNL,RJIO,VIL,TCL";
$operatorList = explode(",", $allOperator);

$allCircle = "AP,BH,CG,DL,GJ,HP,HR,JH,JK,KL,KT,MH,MP,OR,PB,RJ,TN,UPE,UPW,WB";
$circleList = explode(",", $allCircle);

if($graphType == 1){

	$dataList = array();
	for($i=0;$i<count($circleList);$i++){
		$loopCircleName = $circleList[$i];
		$sql = "SELECT 'Airtel' as `Operator`, '$loopCircleName' as `CircleCode`,  count(*) as `TotalSR` FROM `Airtel_SR` where `SP_DATE` is null and `CircleCode`='$loopCircleName' and `STATUS` not in ('NB97','NB98','NB99','NB100','NB101','NB102','NB104','NB105','NB106','NB107','NB108')";
		$sql .= " UNION ALL ";
		$sql .= "SELECT 'RJIO' as `Operator`, '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SP_DATE` is null and `Operator`='RJIO' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ('NB97','NB98','NB99','NB100','NB101','NB102','NB104','NB105','NB106','NB107','NB108')";
		$sql .= " UNION ALL ";
		$sql .= "SELECT 'BSNL' as `Operator`, '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SP_DATE` is null and `Operator`='BSNL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ('NB97','NB98','NB99','NB100','NB101','NB102','NB104','NB105','NB106','NB107','NB108')";
		$sql .= " UNION ALL ";
		$sql .= "SELECT 'VIL' as `Operator`, '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SP_DATE` is null and `Operator`='VIL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ('NB97','NB98','NB99','NB100','NB101','NB102','NB104','NB105','NB106','NB107','NB108')";
		$sql .= " UNION ALL ";
		$sql .= "SELECT 'TCL' as `Operator`, '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SP_DATE` is null and `Operator`='TCL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ('NB97','NB98','NB99','NB100','NB101','NB102','NB104','NB105','NB106','NB107','NB108')";

		$airtel = 0; $rjio = 0; $bsnl = 0; $vil = 0; $tcl = 0;
		$result = mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			$operator = $row["Operator"];
			if($operator == "Airtel"){
				$airtel = $totalSr;
			}
			else if($operator == "RJIO"){
				$rjio = $totalSr;
			}
			else if($operator == "BSNL"){
				$bsnl = $totalSr;
			}
			else if($operator == "VIL"){
				$vil = $totalSr;
			}
			else if($operator == "TCL"){
				$tcl = $totalSr;
			}
		}

		$dataObj = array(
			'circleName' => $loopCircleName, 
			'airtel' => $airtel, 
			'rjio' => $rjio, 
			'bsnl' => $bsnl, 
			'vil' => $vil,
			'tcl' => $tcl
		);

		array_push($dataList, $dataObj);
	}

	$seriesList = array();
	$seriesObj = array('type' => 'bar', 'xKey' => 'circleName', 'yKey' => 'airtel', 'yName' => 'Airtel');
	array_push($seriesList, $seriesObj);

	$seriesObj = array('type' => 'bar', 'xKey' => 'circleName', 'yKey' => 'rjio', 'yName' => 'RJIO');
	array_push($seriesList, $seriesObj);

	$seriesObj = array('type' => 'bar', 'xKey' => 'circleName', 'yKey' => 'bsnl', 'yName' => 'BSNL');
	array_push($seriesList, $seriesObj);

	$seriesObj = array('type' => 'bar', 'xKey' => 'circleName', 'yKey' => 'vil', 'yName' => 'VIL');
	array_push($seriesList, $seriesObj);

	$seriesObj = array('type' => 'bar', 'xKey' => 'circleName', 'yKey' => 'tcl', 'yName' => 'TCL');
	array_push($seriesList, $seriesObj);

	$output = array('data' => $dataList, 'series' => $seriesList);

	echo json_encode($output);
}
?>

<?php
function getPeriodStartDate($period){
	$periodStartDate = "";
	$monthNumber = date('m');
	$year = date('Y');
	if($period == "MTD"){
		if($monthNumber < 10){
			$periodStartDate = $year."-0".$monthNumber.'-01';	
		}
		else{
			$periodStartDate = $year."-".$monthNumber.'-01';
		}
		
	}
	else if($period == "YTD"){
		if($monthNumber == 1 || $monthNumber == 2 || $monthNumber == 3){
			$year = ($year - 1);
		}
		$periodStartDate = $year."-04-01";
	}
	return $periodStartDate;
}