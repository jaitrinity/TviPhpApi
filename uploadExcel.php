<?php
include("dbConfiguration.php");
$json = file_get_contents('php://input');
$jsonData=json_decode($json);

$month = $jsonData->month;
$excelData = $jsonData->excelData;
$billingType = $jsonData->billingType;
$operatorName = $jsonData->operatorName;

$firstDate = date('d-M-y', strtotime('01-'.$month));
$lastDate = date('t-M-y', strtotime('01-'.$month));
$datediff = (strtotime($lastDate) - strtotime($firstDate));
$noOfDays = round($datediff / (60 * 60 * 24)) +1;
$compDate = date('d-M-y', strtotime('01-Apr-21'));

$wrappedList = [];
if($billingType == 'Airtel'){
	if(strtotime($firstDate) < strtotime($compDate)){
		for($i=0;$i<count($excelData);$i++){
			$loopSiteId = "";
			$tableColumn = "";
			$tableData = "";
			foreach ($excelData[$i] as $key => $value) {
				// echo $key.'---';
				if($key == 'Site ID') $loopSiteId = $value;

				$tableColumn .= "`".$key."`,";
				$tableData .= "'".$value."',";
			}
			$tableColumn .= "`Billing nature`,`Insert_Type`,`Bill_Month`";
			$tableData .=  "'Passthrough','Manual','".$month."'";

			$insertSql = "insert into `airtel_output_april` ($tableColumn) value ($tableData) ";
			// echo $insertSql;
			$query=mysqli_query($conn,$insertSql);
			if(!$query){
				array_push($wrappedList, $loopSiteId);
			}
		}
	}
	else{
		for($i=0;$i<count($excelData);$i++){
			$loopSiteId = "";
			$tableColumn = "";
			$tableData = "";
			foreach ($excelData[$i] as $key => $value) {
				// echo $key.'---';
				if($key == 'Site ID') $loopSiteId = $value;

				$tableColumn .= "`".$key."`,";
				$tableData .= "'".$value."',";
			}
			$tableColumn .= "`Insert_Type`,`Bill_Month`";
			$tableData .=  "'Manual','".$month."'";

			$insertSql = "insert into `airtel_provision_consoldata` ($tableColumn) value ($tableData) ";
			// echo $insertSql;
			$query=mysqli_query($conn,$insertSql);
			if(!$query){
				array_push($wrappedList, $loopSiteId);
			}
		}
	}
		
}
else if($billingType == 'RJIO'){
	for($i=0;$i<count($excelData);$i++){
		$loopSiteId = "";
		$tableColumn = "";
		$tableData = "";
		foreach ($excelData[$i] as $key => $value) {
			// echo $key.'---';
			if($key == 'TVI Site ID') $loopSiteId = $value;

			$tableColumn .= "`".$key."`,";
			$tableData .= "'".$value."',";
		}
		$tableColumn .= "`DG_CPH_Cabex`,`DGRate`,`DGHrs`,`EB_CPH_Cabex`,`EBRate`,`EBHrs`,`Billing nature`,`Insert_Type`,`Bill_Month`";
		$tableData .=  "'0','0','0','0','0','0','Passthrough','Manual','".$month."'";

		$insertSql = "insert into `rjio_output_april` ($tableColumn) value ($tableData) ";
		// echo $insertSql;
		$query=mysqli_query($conn,$insertSql);
		if(!$query){
			array_push($wrappedList, $loopSiteId);
		}
	}
}
else if($billingType == 'BSNL'){
	for($i=0;$i<count($excelData);$i++){
		$loopSiteId = "";
		$tableColumn = "";
		$tableData = "";
		foreach ($excelData[$i] as $key => $value) {
			// echo $key.'---';
			if($key == 'IP Site ID') $loopSiteId = $value;

			$tableColumn .= "`".$key."`,";
			$tableData .= "'".$value."',";
		}
		$tableColumn .= "`Insert_Type`,`Bill_Month`";
		$tableData .=  "'Manual','".$month."'";

		$insertSql = "insert into `bsnl_output_april` ($tableColumn) value ($tableData) ";
		// echo $insertSql;
		$query=mysqli_query($conn,$insertSql);
		if(!$query){
			array_push($wrappedList, $loopSiteId);
		}
	}
}
// else if($billingType == 'VIL'){
// 	for($i=0;$i<count($excelData);$i++){
// 		$loopSiteId = "";
// 		$tableColumn = "";
// 		$tableData = "";
// 		foreach ($excelData[$i] as $key => $value) {
// 			// echo $key.'---';
// 			if($key == 'TVI Site ID') $loopSiteId = $value;

// 			$tableColumn .= "`".$key."`,";
// 			$tableData .= "'".$value."',";
// 		}
// 		$tableColumn .= "`Insert_Type`,`BillCycleMonth`";
// 		$tableData .=  "'Manual','".$month."'";

// 		$insertSql = "insert into `vil_output_consol` ($tableColumn) value ($tableData) ";
// 		// echo $insertSql;
// 		$query=mysqli_query($conn,$insertSql);
// 		if(!$query){
// 			array_push($wrappedList, $loopSiteId);
// 		}
// 	}
// }
else if($billingType == 'Other' && $operatorName == "VIL"){
	for($i=0;$i<count($excelData);$i++){
		$loopSiteId = "";
		$tableColumn = "";
		$tableData = "";
		foreach ($excelData[$i] as $key => $value) {
			// echo $key.'---';
			if($key == 'TVI Site ID') $loopSiteId = $value;

			$tableColumn .= "`".$key."`,";
			$tableData .= "'".$value."',";
		}
		$tableColumn .= "`Insert_Type`,`Bill_Month`";
		$tableData .=  "'Manual','".$month."'";

		$insertSql = "insert into `vil_output_consol` ($tableColumn) value ($tableData) ";
		// echo $insertSql;
		$query=mysqli_query($conn,$insertSql);
		if(!$query){
			array_push($wrappedList, $loopSiteId);
		}
	}
}
else if($billingType == 'Other' && $operatorName == "PB_HFCL"){
	for($i=0;$i<count($excelData);$i++){
		$loopSiteId = "";
		$tableColumn = "";
		$tableData = "";
		foreach ($excelData[$i] as $key => $value) {
			// echo $key.'---';
			if($key == 'IP Site ID') $loopSiteId = $value;

			$tableColumn .= "`".$key."`,";
			$tableData .= "'".$value."',";
		}
		$tableColumn .= "`Insert_Type`,`Bill_Month`";
		$tableData .=  "'Manual','".$month."'";

		$insertSql = "insert into `pbhfcl_output_april` ($tableColumn) value ($tableData) ";
		// echo $insertSql;
		$query=mysqli_query($conn,$insertSql);
		if(!$query){
			array_push($wrappedList, $loopSiteId);
		}
	}
}
else if($billingType == 'Other' && $operatorName == "TCL"){
	for($i=0;$i<count($excelData);$i++){
		$loopSiteId = "";
		$tableColumn = "";
		$tableData = "";
		foreach ($excelData[$i] as $key => $value) {
			// echo $key.'---';
			if($key == 'IP Site ID') $loopSiteId = $value;

			$tableColumn .= "`".$key."`,";
			$tableData .= "'".$value."',";
		}
		$tableColumn .= "`Insert_Type`,`Bill_Month`";
		$tableData .=  "'Manual','".$month."'";

		$insertSql = "insert into `tcl_output_april` ($tableColumn) value ($tableData) ";
		// echo $insertSql;
		$query=mysqli_query($conn,$insertSql);
		if(!$query){
			array_push($wrappedList, $loopSiteId);
		}
	}
}
else if($billingType == 'Other' && $operatorName == "TTSL"){
	for($i=0;$i<count($excelData);$i++){
		$loopSiteId = "";
		$tableColumn = "";
		$tableData = "";
		foreach ($excelData[$i] as $key => $value) {
			// echo $key.'---';
			if($key == 'SITE ID') $loopSiteId = $value;

			$tableColumn .= "`".$key."`,";
			$tableData .= "'".$value."',";
		}
		$tableColumn .= "`Insert_Type`,`Bill_Month`";
		$tableData .=  "'Manual','".$month."'";

		$insertSql = "insert into `ttsl_output_april` ($tableColumn) value ($tableData) ";
		// echo $insertSql;
		$query=mysqli_query($conn,$insertSql);
		if(!$query){
			array_push($wrappedList, $loopSiteId);
		}
	}
}

$output = array('responseDesc' => "SUCCESSFUL", 'wrappedList' => $wrappedList, 'responseCode' => "100000");
echo json_encode($output);

?>