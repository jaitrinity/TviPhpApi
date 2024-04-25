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
$isHoUser = $jsonData->isHoUser;
$filterPeriod = $jsonData->filterPeriod; // MTD, YTD
$periodStartDate = getPeriodStartDate($filterPeriod);
// $srStatus = $jsonData->srStatus; // SR, SP, SO, RFI, RFI Accept, RFS
$filterProductType = $jsonData->filterProductType;
$filterOperator = $jsonData->filterOperator;
$filterCircleName = $jsonData->filterCircleName;
$graphType = $jsonData->graphType;

$notInStatus = "'NB97','NB98','NB99','NB100','NB101','NB102','NB104','NB105','NB106','NB107','NB108','NB110'";

// $allOperator = "Airtel,BSNL,RJIO,VIL";
$allCircle = "AP,BH,CG,DL,GJ,HP,HR,JH,JK,KL,KT,MH,MP,OR,PB,RJ,TN,UPE,UPW,WB";

if($isHoUser == "N"){
	$filterOperator = $operator;
	$allCircle = $circleName;
}
// $operatorList = explode(",", $allOperator);
$circleList = explode(",", $allCircle);

$airtelColor = "#E90000";
$bsnlColor = "#BCBDC1";
$rjioColor = "#005AAC";
$vilColor = "#fbb40c";
$tclColor = "ORANGE";

// SR
if($graphType == 1){
	$filterSql = "";
	if($filterPeriod != ""){
		$filterSql .= "and `SR_DATE` >= '$periodStartDate'";
	}
	if($filterProductType != ""){
		$filterSql .= "and `TAB_NAME`='$filterProductType'";
	}

	$labelList = array();
	for($ii=0;$ii<count($circleList);$ii++){
		$loopCircleName1 = $circleList[$ii];
		array_push($labelList, $loopCircleName1);
	}
	$chartData = array();
	$bgColorList = array();

	if($filterOperator == "" || $filterOperator == "Airtel"){
		// Airtel
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`,  count(*) as `TotalSR` FROM `Airtel_SR` where `SP_DATE` is null and `CircleCode`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		// echo $sql;
		$airDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($airDataList, $totalSr);
		}
		$dataObj = array('data' => $airDataList, 'label' => 'Airtel');
		array_push($chartData, $dataObj);

		$airBgColor = array('backgroundColor' => $airtelColor);
		array_push($bgColorList, $airBgColor);
	}
	
	if($filterOperator == "" || $filterOperator == "RJIO"){
		// RJIO
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SP_DATE` is null and `Operator`='RJIO' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$rjioDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($rjioDataList, $totalSr);
		}

		$rjioDataObj = array('data' => $rjioDataList, 'label' => 'RJIO');
		array_push($chartData, $rjioDataObj);

		$rjioBgColor = array('backgroundColor' => $rjioColor);
		array_push($bgColorList, $rjioBgColor);
	}

	if($filterOperator == "" || $filterOperator == "BSNL"){
		// BSNL
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SP_DATE` is null and `Operator`='BSNL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$bsnlDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($bsnlDataList, $totalSr);
		}

		$bsnlDataObj = array('data' => $bsnlDataList, 'label' => 'BSNL');
		array_push($chartData, $bsnlDataObj);

		$bsnlBgColor = array('backgroundColor' => $bsnlColor);
		array_push($bgColorList, $bsnlBgColor);
	}	

	if($filterOperator == "" || $filterOperator == "VIL"){
		// VIL
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SP_DATE` is null and `Operator`='VIL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$vilDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($vilDataList, $totalSr);
		}

		$vilDataObj = array('data' => $vilDataList, 'label' => 'VIL');
		array_push($chartData, $vilDataObj);

		$vilBgColor = array('backgroundColor' => $vilColor);
		array_push($bgColorList, $vilBgColor);
	}

	if($filterOperator == "" || $filterOperator == "VIL"){
		// TCL
		// $sqlList = array();
		// for($i=0;$i<count($circleList);$i++){
		// 	$loopCircleName = $circleList[$i];
		// 	$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SP_DATE` is null and `Operator`='TCL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
		// 	array_push($sqlList, $sql);
		// }

		// $tclDataList = array();
		// $uniSql = implode(" UNION ALL ", $sqlList);
		// $result = mysqli_query($conn,$uniSql);
		// while($row=mysqli_fetch_assoc($result)){
		// 	$totalSr = $row["TotalSR"];
		// 	$totalSr = intval($totalSr);
		// 	array_push($tclDataList, $totalSr);
		// }

		// $tclDataObj = array('data' => $tclDataList, 'label' => 'TCL');
		// array_push($chartData, $tclDataObj);

		// $tclBgColor = array('backgroundColor' => $tclColor);
		// array_push($bgColorList, $tclBgColor);
	}

	$output = array('labelArr' => $labelList, 'dataArr' => $chartData, 'bgColorArr' => $bgColorList);
	echo json_encode($output);
}

// SP
else if($graphType == 2){
	$filterSql = "";
	if($filterPeriod != ""){
		$filterSql .= "and `SP_DATE` >= '$periodStartDate'";
	}
	if($filterProductType != ""){
		$filterSql .= "and `TAB_NAME`='$filterProductType'";
	} 

	// Airtel
	$labelList = array();
	for($ii=0;$ii<count($circleList);$ii++){
		$loopCircleName1 = $circleList[$ii];
		array_push($labelList, $loopCircleName1);
	}
	$chartData = array();
	$bgColorList = array();

	if($filterOperator == "" || $filterOperator == "Airtel"){
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`,  count(*) as `TotalSR` FROM `Airtel_SR` where `SP_DATE` is not null and `SO_DATE` is null and `CircleCode`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$airDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($airDataList, $totalSr);
		}
		$dataObj = array('data' => $airDataList, 'label' => 'Airtel');
		array_push($chartData, $dataObj);

		$airBgColor = array('backgroundColor' => $airtelColor);
		array_push($bgColorList, $airBgColor);
	}
	
	if($filterOperator == "" || $filterOperator == "RJIO"){
		// RJIO
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SO_DATE` is null and `Operator`='RJIO' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$rjioDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($rjioDataList, $totalSr);
		}

		$rjioDataObj = array('data' => $rjioDataList, 'label' => 'RJIO');
		array_push($chartData, $rjioDataObj);

		$rjioBgColor = array('backgroundColor' => $rjioColor);
		array_push($bgColorList, $rjioBgColor);
	}	

	if($filterOperator == "" || $filterOperator == "BSNL"){
		// BSNL
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SO_DATE` is null and `Operator`='BSNL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$bsnlDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($bsnlDataList, $totalSr);
		}

		$bsnlDataObj = array('data' => $bsnlDataList, 'label' => 'BSNL');
		array_push($chartData, $bsnlDataObj);

		$bsnlBgColor = array('backgroundColor' => $bsnlColor);
		array_push($bgColorList, $bsnlBgColor);
	}	

	if($filterOperator == "" || $filterOperator == "VIL"){
		// VIL
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SO_DATE` is null and `Operator`='VIL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$vilDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($vilDataList, $totalSr);
		}

		$vilDataObj = array('data' => $vilDataList, 'label' => 'VIL');
		array_push($chartData, $vilDataObj);

		$vilBgColor = array('backgroundColor' => $vilColor);
		array_push($bgColorList, $vilBgColor);
	}

	if($filterOperator == "" || $filterOperator == "TCL"){
		// TCL
		// $sqlList = array();
		// for($i=0;$i<count($circleList);$i++){
		// 	$loopCircleName = $circleList[$i];
		// 	$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SO_DATE` is null and `Operator`='TCL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
		// 	array_push($sqlList, $sql);
		// }

		// $tclDataList = array();
		// $uniSql = implode(" UNION ALL ", $sqlList);
		// $result = mysqli_query($conn,$uniSql);
		// while($row=mysqli_fetch_assoc($result)){
		// 	$totalSr = $row["TotalSR"];
		// 	$totalSr = intval($totalSr);
		// 	array_push($tclDataList, $totalSr);
		// }

		// $tclDataObj = array('data' => $tclDataList, 'label' => 'TCL');
		// array_push($chartData, $tclDataObj);

		// $tclBgColor = array('backgroundColor' => $tclColor);
		// array_push($bgColorList, $tclBgColor);
	}
	

	$output = array('labelArr' => $labelList, 'dataArr' => $chartData, 'bgColorArr' => $bgColorList);
	echo json_encode($output);
}

// SO
else if($graphType == 3){
	$filterSql = "";
	if($filterPeriod != ""){
		$filterSql .= "and `SO_DATE` >= '$periodStartDate'";
	}
	if($filterProductType != ""){
		$filterSql .= "and `TAB_NAME`='$filterProductType'";
	} 

	
	$labelList = array();
	for($ii=0;$ii<count($circleList);$ii++){
		$loopCircleName1 = $circleList[$ii];
		array_push($labelList, $loopCircleName1);
	}
	$chartData = array();
	$bgColorList = array();

	if($filterOperator == "" || $filterOperator == "Airtel"){
		// Airtel
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`,  count(*) as `TotalSR` FROM `Airtel_SR` where `SO_DATE` is not null and `RFI_DATE` is null and `CircleCode`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$airDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($airDataList, $totalSr);
		}
		$dataObj = array('data' => $airDataList, 'label' => 'Airtel');
		array_push($chartData, $dataObj);

		$airBgColor = array('backgroundColor' => $airtelColor);
		array_push($bgColorList, $airBgColor);
	}
	
	if($filterOperator == "" || $filterOperator == "RJIO"){
		// RJIO
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is null and `Operator`='RJIO' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$rjioDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($rjioDataList, $totalSr);
		}

		$rjioDataObj = array('data' => $rjioDataList, 'label' => 'RJIO');
		array_push($chartData, $rjioDataObj);

		$rjioBgColor = array('backgroundColor' => $rjioColor);
		array_push($bgColorList, $rjioBgColor);
	}	

	if($filterOperator == "" || $filterOperator == "BSNL"){
		// BSNL
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is null and `Operator`='BSNL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$bsnlDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($bsnlDataList, $totalSr);
		}

		$bsnlDataObj = array('data' => $bsnlDataList, 'label' => 'BSNL');
		array_push($chartData, $bsnlDataObj);

		$bsnlBgColor = array('backgroundColor' => $bsnlColor);
		array_push($bgColorList, $bsnlBgColor);
	}

	if($filterOperator == "" || $filterOperator == "VIL"){
		// VIL
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is null and `Operator`='VIL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$vilDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($vilDataList, $totalSr);
		}

		$vilDataObj = array('data' => $vilDataList, 'label' => 'VIL');
		array_push($chartData, $vilDataObj);

		$vilBgColor = array('backgroundColor' => $vilColor);
		array_push($bgColorList, $vilBgColor);
	}

	if($filterOperator == "" || $filterOperator == "TCL"){
		// TCL
		// $sqlList = array();
		// for($i=0;$i<count($circleList);$i++){
		// 	$loopCircleName = $circleList[$i];
		// 	$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is null and `Operator`='TCL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
		// 	array_push($sqlList, $sql);
		// }

		// $tclDataList = array();
		// $uniSql = implode(" UNION ALL ", $sqlList);
		// $result = mysqli_query($conn,$uniSql);
		// while($row=mysqli_fetch_assoc($result)){
		// 	$totalSr = $row["TotalSR"];
		// 	$totalSr = intval($totalSr);
		// 	array_push($tclDataList, $totalSr);
		// }

		// $tclDataObj = array('data' => $tclDataList, 'label' => 'TCL');
		// array_push($chartData, $tclDataObj);

		// $tclBgColor = array('backgroundColor' => $tclColor);
		// array_push($bgColorList, $tclBgColor);
	}

	$output = array('labelArr' => $labelList, 'dataArr' => $chartData, 'bgColorArr' => $bgColorList);
	echo json_encode($output);
}
// RFI
else if($graphType == 'RFI'){
	$filterSql = "";
	if($filterPeriod != ""){
		$filterSql .= "and `RFI_DATE` >= '$periodStartDate'";
	}
	if($filterProductType != ""){
		$filterSql .= "and `TAB_NAME`='$filterProductType'";
	} 

	
	$labelList = array();
	for($ii=0;$ii<count($circleList);$ii++){
		$loopCircleName1 = $circleList[$ii];
		array_push($labelList, $loopCircleName1);
	}
	$chartData = array();
	$bgColorList = array();

	if($filterOperator == "" || $filterOperator == "Airtel"){
		// Airtel
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`,  count(*) as `TotalSR` FROM `Airtel_SR` where `RFI_DATE` is not null and `CircleCode`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$airDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($airDataList, $totalSr);
		}
		$dataObj = array('data' => $airDataList, 'label' => 'Airtel');
		array_push($chartData, $dataObj);

		$airBgColor = array('backgroundColor' => $airtelColor);
		array_push($bgColorList, $airBgColor);
	}
	
	if($filterOperator == "" || $filterOperator == "RJIO"){
		// RJIO
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is not null and `Operator`='RJIO' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$rjioDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($rjioDataList, $totalSr);
		}

		$rjioDataObj = array('data' => $rjioDataList, 'label' => 'RJIO');
		array_push($chartData, $rjioDataObj);

		$rjioBgColor = array('backgroundColor' => $rjioColor);
		array_push($bgColorList, $rjioBgColor);
	}	

	if($filterOperator == "" || $filterOperator == "BSNL"){
		// BSNL
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is not null and `Operator`='BSNL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$bsnlDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($bsnlDataList, $totalSr);
		}

		$bsnlDataObj = array('data' => $bsnlDataList, 'label' => 'BSNL');
		array_push($chartData, $bsnlDataObj);

		$bsnlBgColor = array('backgroundColor' => $bsnlColor);
		array_push($bgColorList, $bsnlBgColor);
	}

	if($filterOperator == "" || $filterOperator == "VIL"){
		// VIL
		$sqlList = array();
		for($i=0;$i<count($circleList);$i++){
			$loopCircleName = $circleList[$i];
			$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is not null and `Operator`='VIL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
			array_push($sqlList, $sql);
		}

		$vilDataList = array();
		$uniSql = implode(" UNION ALL ", $sqlList);
		$result = mysqli_query($conn,$uniSql);
		while($row=mysqli_fetch_assoc($result)){
			$totalSr = $row["TotalSR"];
			$totalSr = intval($totalSr);
			array_push($vilDataList, $totalSr);
		}

		$vilDataObj = array('data' => $vilDataList, 'label' => 'VIL');
		array_push($chartData, $vilDataObj);

		$vilBgColor = array('backgroundColor' => $vilColor);
		array_push($bgColorList, $vilBgColor);
	}

	if($filterOperator == "" || $filterOperator == "TCL"){
		// TCL
		// $sqlList = array();
		// for($i=0;$i<count($circleList);$i++){
		// 	$loopCircleName = $circleList[$i];
		// 	$sql = "SELECT '$loopCircleName' as `CircleCode`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is not null and `Operator`='TCL' and `CIRCLE_NAME`='$loopCircleName' and `STATUS` not in ($notInStatus) $filterSql";
		// 	array_push($sqlList, $sql);
		// }

		// $tclDataList = array();
		// $uniSql = implode(" UNION ALL ", $sqlList);
		// $result = mysqli_query($conn,$uniSql);
		// while($row=mysqli_fetch_assoc($result)){
		// 	$totalSr = $row["TotalSR"];
		// 	$totalSr = intval($totalSr);
		// 	array_push($tclDataList, $totalSr);
		// }

		// $tclDataObj = array('data' => $tclDataList, 'label' => 'TCL');
		// array_push($chartData, $tclDataObj);

		// $tclBgColor = array('backgroundColor' => $tclColor);
		// array_push($bgColorList, $tclBgColor);
	}

	$output = array('labelArr' => $labelList, 'dataArr' => $chartData, 'bgColorArr' => $bgColorList);
	echo json_encode($output);
}
// SR aging
else if($graphType == 4){
	$filterSql = "";
	$opcoFilterSql = "";
	if($filterPeriod != ""){
		$filterSql .= "and `SR_DATE` >= '$periodStartDate'";
		$opcoFilterSql .= "and `SR_DATE` >= '$periodStartDate'";
	}
	if($filterProductType != ""){
		$filterSql .= "and `TAB_NAME`='$filterProductType'";
		$opcoFilterSql .= "and `TAB_NAME`='$filterProductType'";
	}
	if($filterCircleName != ""){
		$filterSql .= "and `CircleCode`='$filterCircleName'";
		$opcoFilterSql .= "and `CIRCLE_NAME`='$filterCircleName'";
	}

	$labelList = ["0>=7", "7>=14", "14>=21", "21>"];
	$chartData = array();
	$bgColorList = array();

	if($filterOperator == "" || $filterOperator == "Airtel"){
		// Airtel
		$airDataList = array();
		$sql = "SELECT sum(case when `AGING_SP_DATE` > 0 and `AGING_SP_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_SP_DATE` > 7 and `AGING_SP_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_SP_DATE` > 14 and `AGING_SP_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_SP_DATE` > 21 then 1 else 0 end) as '21>' FROM `Airtel_Graph_Aging` where `SP_DATE` is null $filterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($airDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($airDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($airDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($airDataList, $row["30>"] == null ? 0 : $row["21>"]);

		$dataObj = array('data' => $airDataList, 'label' => 'Airtel');
		array_push($chartData, $dataObj);

		$airBgColor = array('backgroundColor' => $airtelColor);
		array_push($bgColorList, $airBgColor);
	}
		

	if($filterOperator == "" || $filterOperator == "RJIO"){
		// RJIO
		$rjioDataList = array();
		$sql= "SELECT sum(case when `AGING_SP_DATE` > 0 and `AGING_SP_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_SP_DATE` > 7 and `AGING_SP_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_SP_DATE` > 14 and `AGING_SP_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_SP_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='RJIO' and `SP_DATE` is null $opcoFilterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($rjioDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($rjioDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($rjioDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($rjioDataList, $row["30>"] == null ? 0 : $row["21>"]);

		$rjioDataObj = array('data' => $rjioDataList, 'label' => 'RJIO');
		array_push($chartData, $rjioDataObj);

		$rjioBgColor = array('backgroundColor' => $rjioColor);
		array_push($bgColorList, $rjioBgColor);
	}
	

	if($filterOperator == "" || $filterOperator == "BSNL"){
		// BSNL
		$bsnlDataList = array();
		$sql= "SELECT sum(case when `AGING_SP_DATE` > 0 and `AGING_SP_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_SP_DATE` > 7 and `AGING_SP_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_SP_DATE` > 14 and `AGING_SP_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_SP_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='BSNL' and `SP_DATE` is null $opcoFilterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($bsnlDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($bsnlDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($bsnlDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($bsnlDataList, $row["30>"] == null ? 0 : $row["21>"]);

		$bsnlDataObj = array('data' => $bsnlDataList, 'label' => 'BSNL');
		array_push($chartData, $bsnlDataObj);

		$bsnlBgColor = array('backgroundColor' => $bsnlColor);
		array_push($bgColorList, $bsnlBgColor);
	}

	if($filterOperator == "" || $filterOperator == "VIL"){
		// VIL
		$vilDataList = array();
		$sql= "SELECT sum(case when `AGING_SP_DATE` > 0 and `AGING_SP_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_SP_DATE` > 7 and `AGING_SP_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_SP_DATE` > 14 and `AGING_SP_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_SP_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='VIL' and `SP_DATE` is null $opcoFilterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($vilDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($vilDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($vilDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($vilDataList, $row["30>"] == null ? 0 : $row["21>"]);

		$vilDataObj = array('data' => $vilDataList, 'label' => 'VIL');
		array_push($chartData, $vilDataObj);

		$vilBgColor = array('backgroundColor' => $vilColor);
		array_push($bgColorList, $vilBgColor);
	}	

	if($filterOperator == "" || $filterOperator == "TCL"){
		// TCL
		// $tclDataList = array();
		// $sql= "SELECT sum(case when `AGING_SP_DATE` > 0 and `AGING_SP_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_SP_DATE` > 7 and `AGING_SP_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_SP_DATE` > 14 and `AGING_SP_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_SP_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='TCL' and `SP_DATE` is null $opcoFilterSql";
		// $result = mysqli_query($conn,$sql);
		// $row=mysqli_fetch_assoc($result);
		// array_push($tclDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		// array_push($tclDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		// array_push($tclDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		// array_push($tclDataList, $row["30>"] == null ? 0 : $row["21>"]);

		// $tclDataObj = array('data' => $tclDataList, 'label' => 'TCL');
		// array_push($chartData, $tclDataObj);

		// $tclBgColor = array('backgroundColor' => $tclColor);
		// array_push($bgColorList, $tclBgColor);
	}

	$output = array('labelArr' => $labelList, 'dataArr' => $chartData, 'bgColorArr' => $bgColorList);
	echo json_encode($output);

}
// SP aging
else if($graphType == 5){
	$filterSql = "";
	$opcoFilterSql = "";
	if($filterPeriod != ""){
		$filterSql .= "and `SP_DATE` >= '$periodStartDate'";
		$opcoFilterSql .= "and `SP_DATE` >= '$periodStartDate'";
	}
	if($filterProductType != ""){
		$filterSql .= "and `TAB_NAME`='$filterProductType'";
		$opcoFilterSql .= "and `TAB_NAME`='$filterProductType'";
	}
	if($filterCircleName != ""){
		$filterSql .= "and `CircleCode`='$filterCircleName'";
		$opcoFilterSql .= "and `CIRCLE_NAME`='$filterCircleName'";
	}

	$labelList = ["0>=7", "7>=14", "14>=21", "21>"];
	$chartData = array();
	$bgColorList = array();

	if($filterOperator == "" || $filterOperator == "Airtel"){
		// Airtel
		$airDataList = array();
		$sql = "SELECT sum(case when `AGING_SO_DATE` > 0 and `AGING_SO_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_SO_DATE` > 7 and `AGING_SO_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_SO_DATE` > 14 and `AGING_SO_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_SO_DATE` > 21 then 1 else 0 end) as '21>' FROM `Airtel_Graph_Aging` where `SP_DATE` is not null and `SO_DATE` is null $filterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($airDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($airDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($airDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($airDataList, $row["21>"] == null ? 0 : $row["21>"]);

		$dataObj = array('data' => $airDataList, 'label' => 'Airtel');
		array_push($chartData, $dataObj);

		$airBgColor = array('backgroundColor' => $airtelColor);
		array_push($bgColorList, $airBgColor);
	}
		
	if($filterOperator == "" || $filterOperator == "RJIO"){
		// RJIO
		$rjioDataList = array();
		$sql = "SELECT sum(case when `AGING_SO_DATE` > 0 and `AGING_SO_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_SO_DATE` > 7 and `AGING_SO_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_SO_DATE` > 14 and `AGING_SO_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_SO_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='RJIO' and `SP_DATE` is not null and `SO_DATE` is null $opcoFilterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($rjioDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($rjioDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($rjioDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($rjioDataList, $row["21>"] == null ? 0 : $row["21>"]);

		$rjioDataObj = array('data' => $rjioDataList, 'label' => 'RJIO');
		array_push($chartData, $rjioDataObj);

		$rjioBgColor = array('backgroundColor' => $rjioColor);
		array_push($bgColorList, $rjioBgColor);
	}
		
	if($filterOperator == "" || $filterOperator == "BSNL"){
		// BSNL
		$bsnlDataList = array();
		$sql = "SELECT sum(case when `AGING_SO_DATE` > 0 and `AGING_SO_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_SO_DATE` > 7 and `AGING_SO_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_SO_DATE` > 14 and `AGING_SO_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_SO_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='BSNL' and `SP_DATE` is not null and `SO_DATE` is null $opcoFilterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($bsnlDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($bsnlDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($bsnlDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($bsnlDataList, $row["21>"] == null ? 0 : $row["21>"]);

		$bsnlDataObj = array('data' => $bsnlDataList, 'label' => 'BSNL');
		array_push($chartData, $bsnlDataObj);

		$bsnlBgColor = array('backgroundColor' => $bsnlColor);
		array_push($bgColorList, $bsnlBgColor);
	}
		
	if($filterOperator == "" || $filterOperator == "VIL"){
		// VIL
		$vilDataList = array();
		$sql = "SELECT sum(case when `AGING_SO_DATE` > 0 and `AGING_SO_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_SO_DATE` > 7 and `AGING_SO_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_SO_DATE` > 14 and `AGING_SO_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_SO_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='VIL' and `SP_DATE` is not null and `SO_DATE` is null $opcoFilterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($vilDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($vilDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($vilDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($vilDataList, $row["21>"] == null ? 0 : $row["21>"]);

		$vilDataObj = array('data' => $vilDataList, 'label' => 'VIL');
		array_push($chartData, $vilDataObj);

		$vilBgColor = array('backgroundColor' => $vilColor);
		array_push($bgColorList, $vilBgColor);
	}
	
	if($filterOperator == "" || $filterOperator == "TCL"){
		// TCL
		// $tclDataList = array();
		// $sql = "SELECT sum(case when `AGING_SO_DATE` > 0 and `AGING_SO_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_SO_DATE` > 7 and `AGING_SO_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_SO_DATE` > 14 and `AGING_SO_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_SO_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='VIL' and `SP_DATE` is not null and `SO_DATE` is null $opcoFilterSql";
		// $result = mysqli_query($conn,$sql);
		// $row=mysqli_fetch_assoc($result);
		// array_push($tclDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		// array_push($tclDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		// array_push($tclDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		// array_push($tclDataList, $row["21>"] == null ? 0 : $row["21>"]);

		// $tclDataObj = array('data' => $tclDataList, 'label' => 'TCL');
		// array_push($chartData, $tclDataObj);

		// $tclBgColor = array('backgroundColor' => $tclColor);
		// array_push($bgColorList, $tclBgColor);
	}

	$output = array('labelArr' => $labelList, 'dataArr' => $chartData, 'bgColorArr' => $bgColorList);
	echo json_encode($output);

}
// SO aging
else if($graphType == 6){
	$filterSql = "";
	$opcoFilterSql = "";
	if($filterPeriod != ""){
		$filterSql .= "and `SO_DATE` >= '$periodStartDate'";
		$opcoFilterSql .= "and `SO_DATE` >= '$periodStartDate'";
	}
	if($filterProductType != ""){
		$filterSql .= "and `TAB_NAME`='$filterProductType'";
		$opcoFilterSql .= "and `TAB_NAME`='$filterProductType'";
	}
	if($filterCircleName != ""){
		$filterSql .= "and `CircleCode`='$filterCircleName'";
		$opcoFilterSql .= "and `CIRCLE_NAME`='$filterCircleName'";
	}

	$labelList = ["0>=7", "7>=14", "14>=21", "21>"];
	$chartData = array();
	$bgColorList = array();

	if($filterOperator == "" || $filterOperator == "Airtel"){
		// Airtel
		$airDataList = array();
		$sql = "SELECT sum(case when `AGING_RFI_DATE` > 0 and `AGING_RFI_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_RFI_DATE` > 7 and `AGING_RFI_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_RFI_DATE` > 14 and `AGING_RFI_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_RFI_DATE` > 21 then 1 else 0 end) as '21>' FROM `Airtel_Graph_Aging` where `SO_DATE` is not null and `RFI_DATE` is null $filterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($airDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($airDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($airDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($airDataList, $row["21>"] == null ? 0 : $row["21>"]);

		$dataObj = array('data' => $airDataList, 'label' => 'Airtel');
		array_push($chartData, $dataObj);

		$airBgColor = array('backgroundColor' => $airtelColor);
		array_push($bgColorList, $airBgColor);
	}
		
	if($filterOperator == "" || $filterOperator == "RJIO"){
		// RJIO
		$rjioDataList = array();
		$sql = "SELECT sum(case when `AGING_RFI_DATE` > 0 and `AGING_RFI_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_RFI_DATE` > 7 and `AGING_RFI_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_RFI_DATE` > 14 and `AGING_RFI_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_RFI_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='RJIO' and `SO_DATE` is not null and `RFI_DATE` is null $filterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($rjioDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($rjioDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($rjioDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($rjioDataList, $row["21>"] == null ? 0 : $row["21>"]);

		$rjioDataObj = array('data' => $rjioDataList, 'label' => 'RJIO');
		array_push($chartData, $rjioDataObj);

		$rjioBgColor = array('backgroundColor' => $rjioColor);
		array_push($bgColorList, $rjioBgColor);
	}	
		
	if($filterOperator == "" || $filterOperator == "BSNL"){
		// BSNL
		$bsnlDataList = array();
		$sql = "SELECT sum(case when `AGING_RFI_DATE` > 0 and `AGING_RFI_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_RFI_DATE` > 7 and `AGING_RFI_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_RFI_DATE` > 14 and `AGING_RFI_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_RFI_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='BSNL' and `SO_DATE` is not null and `RFI_DATE` is null $filterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($bsnlDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($bsnlDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($bsnlDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($bsnlDataList, $row["21>"] == null ? 0 : $row["21>"]);

		$bsnlDataObj = array('data' => $bsnlDataList, 'label' => 'BSNL');
		array_push($chartData, $bsnlDataObj);

		$bsnlBgColor = array('backgroundColor' => $bsnlColor);
		array_push($bgColorList, $bsnlBgColor);
	}	

	if($filterOperator == "" || $filterOperator == "VIL"){
		// VIL
		$vilDataList = array();
		$sql = "SELECT sum(case when `AGING_RFI_DATE` > 0 and `AGING_RFI_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_RFI_DATE` > 7 and `AGING_RFI_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_RFI_DATE` > 14 and `AGING_RFI_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_RFI_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='VIL' and `SO_DATE` is not null and `RFI_DATE` is null $filterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($vilDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($vilDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($vilDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($vilDataList, $row["21>"] == null ? 0 : $row["21>"]);

		$vilDataObj = array('data' => $vilDataList, 'label' => 'VIL');
		array_push($chartData, $vilDataObj);

		$vilBgColor = array('backgroundColor' => $vilColor);
		array_push($bgColorList, $vilBgColor);
	}	

	if($filterOperator == "" || $filterOperator == "TCL"){
		// TCL
		// $tclDataList = array();
		// $sql = "SELECT sum(case when `AGING_RFI_DATE` > 0 and `AGING_RFI_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_RFI_DATE` > 7 and `AGING_RFI_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_RFI_DATE` > 14 and `AGING_RFI_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_RFI_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='TCL' and `SO_DATE` is not null and `RFI_DATE` is null $filterSql";
		// $result = mysqli_query($conn,$sql);
		// $row=mysqli_fetch_assoc($result);
		// array_push($tclDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		// array_push($tclDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		// array_push($tclDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		// array_push($tclDataList, $row["21>"] == null ? 0 : $row["21>"]);

		// $tclDataObj = array('data' => $tclDataList, 'label' => 'TCL');
		// array_push($chartData, $tclDataObj);

		// $tclBgColor = array('backgroundColor' => $tclColor);
		// array_push($bgColorList, $tclBgColor);
	}	

	$output = array('labelArr' => $labelList, 'dataArr' => $chartData, 'bgColorArr' => $bgColorList);
	echo json_encode($output);

}
// RFI Aging
else if($graphType == "RFI_Aging"){
	$filterSql = "";
	$opcoFilterSql = "";
	if($filterPeriod != ""){
		$filterSql .= "and `RFI_DATE` >= '$periodStartDate'";
		$opcoFilterSql .= "and `RFI_DATE` >= '$periodStartDate'";
	}
	if($filterProductType != ""){
		$filterSql .= "and `TAB_NAME`='$filterProductType'";
		$opcoFilterSql .= "and `TAB_NAME`='$filterProductType'";
	}
	if($filterCircleName != ""){
		$filterSql .= "and `CircleCode`='$filterCircleName'";
		$opcoFilterSql .= "and `CIRCLE_NAME`='$filterCircleName'";
	}

	$labelList = ["0>=7", "7>=14", "14>=21", "21>"];
	$chartData = array();
	$bgColorList = array();

	if($filterOperator == "" || $filterOperator == "Airtel"){
		// Airtel
		$airDataList = array();
		$sql = "SELECT sum(case when `AGING_RFI_DATE` > 0 and `AGING_RFI_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_RFI_DATE` > 7 and `AGING_RFI_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_RFI_DATE` > 14 and `AGING_RFI_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_RFI_DATE` > 21 then 1 else 0 end) as '21>' FROM `Airtel_Graph_Aging` where `RFI_DATE` is not null $filterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($airDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($airDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($airDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($airDataList, $row["21>"] == null ? 0 : $row["21>"]);

		$dataObj = array('data' => $airDataList, 'label' => 'Airtel');
		array_push($chartData, $dataObj);

		$airBgColor = array('backgroundColor' => $airtelColor);
		array_push($bgColorList, $airBgColor);
	}
		
	if($filterOperator == "" || $filterOperator == "RJIO"){
		// RJIO
		$rjioDataList = array();
		$sql = "SELECT sum(case when `AGING_RFI_DATE` > 0 and `AGING_RFI_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_RFI_DATE` > 7 and `AGING_RFI_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_RFI_DATE` > 14 and `AGING_RFI_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_RFI_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='RJIO' and `RFI_DATE` is not null $filterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($rjioDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($rjioDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($rjioDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($rjioDataList, $row["21>"] == null ? 0 : $row["21>"]);

		$rjioDataObj = array('data' => $rjioDataList, 'label' => 'RJIO');
		array_push($chartData, $rjioDataObj);

		$rjioBgColor = array('backgroundColor' => $rjioColor);
		array_push($bgColorList, $rjioBgColor);
	}	
		
	if($filterOperator == "" || $filterOperator == "BSNL"){
		// BSNL
		$bsnlDataList = array();
		$sql = "SELECT sum(case when `AGING_RFI_DATE` > 0 and `AGING_RFI_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_RFI_DATE` > 7 and `AGING_RFI_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_RFI_DATE` > 14 and `AGING_RFI_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_RFI_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='BSNL' and `RFI_DATE` is not null $filterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($bsnlDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($bsnlDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($bsnlDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($bsnlDataList, $row["21>"] == null ? 0 : $row["21>"]);

		$bsnlDataObj = array('data' => $bsnlDataList, 'label' => 'BSNL');
		array_push($chartData, $bsnlDataObj);

		$bsnlBgColor = array('backgroundColor' => $bsnlColor);
		array_push($bgColorList, $bsnlBgColor);
	}	

	if($filterOperator == "" || $filterOperator == "VIL"){
		// VIL
		$vilDataList = array();
		$sql = "SELECT sum(case when `AGING_RFI_DATE` > 0 and `AGING_RFI_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_RFI_DATE` > 7 and `AGING_RFI_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_RFI_DATE` > 14 and `AGING_RFI_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_RFI_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='VIL' and `RFI_DATE` is not null $filterSql";
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($result);
		array_push($vilDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		array_push($vilDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		array_push($vilDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		array_push($vilDataList, $row["21>"] == null ? 0 : $row["21>"]);

		$vilDataObj = array('data' => $vilDataList, 'label' => 'VIL');
		array_push($chartData, $vilDataObj);

		$vilBgColor = array('backgroundColor' => $vilColor);
		array_push($bgColorList, $vilBgColor);
	}	

	if($filterOperator == "" || $filterOperator == "TCL"){
		// TCL
		// $tclDataList = array();
		// $sql = "SELECT sum(case when `AGING_RFI_DATE` > 0 and `AGING_RFI_DATE` <= 7 then 1 else 0 end) as '0>=7', sum(case when `AGING_RFI_DATE` > 7 and `AGING_RFI_DATE` <= 14 then 1 else 0 end) as '7>=14', sum(case when `AGING_RFI_DATE` > 14 and `AGING_RFI_DATE` <= 21 then 1 else 0 end) as '14>=21', sum(case when `AGING_RFI_DATE` > 21 then 1 else 0 end) as '21>' FROM `Opco_Graph_Aging` where `Operator`='TCL' and `RFI_DATE` is not null $filterSql";
		// array_push($tclDataList, $row["0>=7"] == null ? 0 : $row["0>=7"]);
		// array_push($tclDataList, $row["7>=14"] == null ? 0 : $row["7>=14"]);
		// array_push($tclDataList, $row["14>=21"] == null ? 0 : $row["14>=21"]);
		// array_push($tclDataList, $row["21>"] == null ? 0 : $row["21>"]);

		// $tclDataObj = array('data' => $tclDataList, 'label' => 'TCL');
		// array_push($chartData, $tclDataObj);

		// $tclBgColor = array('backgroundColor' => $tclColor);
		// array_push($bgColorList, $tclBgColor);
	}	

	$output = array('labelArr' => $labelList, 'dataArr' => $chartData, 'bgColorArr' => $bgColorList);
	echo json_encode($output);

}
// SO SOM
else if($graphType == "soSom"){
	$filterSql = "";
	if($filterPeriod != ""){
		$filterSql .= "and `SO_DATE` >= '$periodStartDate'";
	}

	$sqlList = array();
	$sql = "SELECT 'Airtel' as `Operator`, count(*) as `TotalSR` FROM `Airtel_SR` where `SO_DATE` is not null and `RFI_DATE` is null and `STATUS` not in ($notInStatus) $filterSql";
	array_push($sqlList, $sql);

	$sql = "SELECT 'RJIO' as `Operator`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SO_DATE` is not null and `RFI_DATE` is null and `Operator`='RJIO' and `STATUS` not in ($notInStatus) $filterSql";
	array_push($sqlList, $sql);

	$sql = "SELECT 'BSNL' as `Operator`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SO_DATE` is not null and `RFI_DATE` is null and `Operator`='BSNL' and `STATUS` not in ($notInStatus) $filterSql";
	array_push($sqlList, $sql);

	$sql = "SELECT 'VIL' as `Operator`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SO_DATE` is not null and `RFI_DATE` is null and `Operator`='VIL' and `STATUS` not in ($notInStatus) $filterSql";
	array_push($sqlList, $sql);

	// $sql = "SELECT 'TCL' as `Operator`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `SO_DATE` is not null and `RFI_DATE` is null and `Operator`='TCL' and `STATUS` not in ($notInStatus) $filterSql";
	// array_push($sqlList, $sql);

	$uniSql = implode(" UNION ALL ", $sqlList);
	$result = mysqli_query($conn,$uniSql);

	$sum = 0;
	$valueList = array();
	while($row=mysqli_fetch_assoc($result)){
		// $operator = $row["Operator"];
		$totalSr = $row["TotalSR"];
		$totalSr = intval($totalSr);
		$sum += $totalSr;

		// $valueObj = array('operator' => $operator, 'value' => $totalSr);
		// array_push($valueList, $valueObj);
	}

	mysqli_data_seek($result, 0);

	$labelList = array();
	$chartData = array();
	while($row=mysqli_fetch_assoc($result)){
		$operator = $row["Operator"];
		$totalSr = $row["TotalSR"];
		$totalSr = intval($totalSr);
		$percent = ($totalSr/$sum)*100;
		$percent = round($percent);

		array_push($labelList, $operator.' - '.$percent. '% ('.$totalSr.')');

		array_push($chartData, $percent);
	}

	$bgColorList = array();
	array_push($bgColorList, $airtelColor);
	array_push($bgColorList, $rjioColor);
	array_push($bgColorList, $bsnlColor);
	array_push($bgColorList, $vilColor);

	$borderColorList = array();
	array_push($borderColorList, $airtelColor);
	array_push($borderColorList, $rjioColor);
	array_push($borderColorList, $bsnlColor);
	array_push($borderColorList, $vilColor);

	$soColor = array('backgroundColor' => $bgColorList, 'borderColor' => $borderColorList);

	$colorList = array();
	array_push($colorList, $soColor);

	$output = array('labelArr' => $labelList, 'dataArr' => $chartData, 'bgColorArr' => $colorList, 
		'valueArr' => $valueList);
	echo json_encode($output);
}

// RFI SOM
else if($graphType == "rfiSom"){
	$filterSql = "";
	if($filterPeriod != ""){
		$filterSql .= "and `RFI_DATE` >= '$periodStartDate'";
	}

	$sqlList = array();
	$sql = "SELECT 'Airtel' as `Operator`, count(*) as `TotalSR` FROM `Airtel_SR` where `RFI_DATE` is not null and `STATUS` not in ($notInStatus) $filterSql";
	array_push($sqlList, $sql);

	$sql = "SELECT 'RJIO' as `Operator`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is not null and `Operator`='RJIO' and `STATUS` not in ($notInStatus) $filterSql";
	array_push($sqlList, $sql);

	$sql = "SELECT 'BSNL' as `Operator`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is not null and `Operator`='BSNL' and `STATUS` not in ($notInStatus) $filterSql";
	array_push($sqlList, $sql);

	$sql = "SELECT 'VIL' as `Operator`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is not null and `Operator`='VIL' and `STATUS` not in ($notInStatus) $filterSql";
	array_push($sqlList, $sql);

	// $sql = "SELECT 'TCL' as `Operator`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is not null and `RFI_DATE` is null and `Operator`='TCL' and `STATUS` not in ($notInStatus) $filterSql";
	// array_push($sqlList, $sql);

	$uniSql = implode(" UNION ALL ", $sqlList);
	$result = mysqli_query($conn,$uniSql);

	$sum = 0;
	$valueList = array();
	while($row=mysqli_fetch_assoc($result)){
		// $operator = $row["Operator"];
		$totalSr = $row["TotalSR"];
		
		$totalSr = intval($totalSr);
		$sum += $totalSr;

		// $valueObj = array('operator' => $operator, 'value' => $totalSr);
		// array_push($valueList, $valueObj);
	}

	mysqli_data_seek($result, 0);

	$labelList = array();
	$chartData = array();
	while($row=mysqli_fetch_assoc($result)){
		$operator = $row["Operator"];
		$totalSr = $row["TotalSR"];
		$totalSr = intval($totalSr);
		$percent = ($totalSr/$sum)*100;
		$percent = round($percent);

		array_push($labelList, $operator.' - '.$percent. '% ('.$totalSr.')');

		array_push($chartData, $percent);
	}

	$bgColorList = array();
	array_push($bgColorList, $airtelColor);
	array_push($bgColorList, $rjioColor);
	array_push($bgColorList, $bsnlColor);
	array_push($bgColorList, $vilColor);

	$borderColorList = array();
	array_push($borderColorList, $airtelColor);
	array_push($borderColorList, $rjioColor);
	array_push($borderColorList, $bsnlColor);
	array_push($borderColorList, $vilColor);

	$soColor = array('backgroundColor' => $bgColorList, 'borderColor' => $borderColorList);

	$colorList = array();
	array_push($colorList, $soColor);

	$output = array('labelArr' => $labelList, 'dataArr' => $chartData, 'bgColorArr' => $colorList, 
		'valueArr' => $valueList);
	echo json_encode($output);
}
// else if($graphType == "rfiSom_old"){
// 	$filterSql = "";
// 	if($filterPeriod != ""){
// 		$filterSql .= "and `RFI_DATE` >= '$periodStartDate'";
// 	}

// 	$sqlList = array();
// 	$sql = "SELECT 'Airtel' as `Operator`, count(*) as `TotalSR` FROM `Airtel_SR` where `RFI_DATE` is not null and `STATUS` not in ($notInStatus) $filterSql";
// 	array_push($sqlList, $sql);

// 	$sql = "SELECT 'RJIO' as `Operator`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is not null and `Operator`='RJIO' and `STATUS` not in ($notInStatus) $filterSql";
// 	array_push($sqlList, $sql);

// 	$sql = "SELECT 'BSNL' as `Operator`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is not null and `Operator`='BSNL' and `STATUS` not in ($notInStatus) $filterSql";
// 	array_push($sqlList, $sql);

// 	$sql = "SELECT 'VIL' as `Operator`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is not null and `Operator`='VIL' and `STATUS` not in ($notInStatus) $filterSql";
// 	array_push($sqlList, $sql);

// 	// $sql = "SELECT 'TCL' as `Operator`, count(*) as `TotalSR` FROM `NBS_MASTER_HDR` where `RFI_DATE` is not null and `RFI_DATE` is null and `Operator`='TCL' and `STATUS` not in ($notInStatus) $filterSql";
// 	// array_push($sqlList, $sql);

// 	$uniSql = implode(" UNION ALL ", $sqlList);
// 	$result = mysqli_query($conn,$uniSql);

// 	$sum = 0;
// 	$labelList = array();
// 	$chartData = array();
// 	while($row=mysqli_fetch_assoc($result)){
// 		$operator = $row["Operator"];
// 		$totalSr = $row["TotalSR"];
// 		array_push($labelList, $operator.' - '.$totalSr);

		
// 		$totalSr = intval($totalSr);
// 		$sum += $totalSr;
// 		array_push($chartData, $totalSr);
// 	}

// 	mysqli_data_seek($result, 0);
	
// 	while($row=mysqli_fetch_assoc($result)){
// 		$operator = $row["Operator"];
// 		$totalSr = $row["TotalSR"];
// 		$totalSr = intval($totalSr);
// 		$percent = ($totalSr/$sum)*100;
// 		$percent = round($percent);

// 		$percentObj = array('operator' => $operator, 'percent' => $percent);
// 		array_push($percentList, $percentObj);
// 	}

// 	$bgColorList = array();
// 	array_push($bgColorList, $airtelColor);
// 	array_push($bgColorList, $rjioColor);
// 	array_push($bgColorList, $bsnlColor);
// 	array_push($bgColorList, $vilColor);

// 	$borderColorList = array();
// 	array_push($borderColorList, $airtelColor);
// 	array_push($borderColorList, $rjioColor);
// 	array_push($borderColorList, $bsnlColor);
// 	array_push($borderColorList, $vilColor);

// 	$soColor = array('backgroundColor' => $bgColorList, 'borderColor' => $borderColorList);

// 	$colorList = array();
// 	array_push($colorList, $soColor);

// 	$output = array('labelArr' => $labelList, 'dataArr' => $chartData, 'bgColorArr' => $colorList, 'percentArr' => $percentList);
// 	echo json_encode($output);
// }

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

?>