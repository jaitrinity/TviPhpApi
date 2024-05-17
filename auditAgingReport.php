<?php
include("cpDbConfig_db.php");
require 'PHPExcel/Classes/PHPExcel.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailerNew/src/Exception.php';
require 'PHPMailerNew/src/PHPMailer.php';
require 'PHPMailerNew/src/SMTP.php';

$format = 'yyyy-mm-dd';
$objPHPExcel = new PHPExcel();
$border_style= array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array(
				'argb' => '000000'
			)
		)
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	)
);

// Audit - Macro Anchor
$firstRowCol=["Circle OPCO","As Actual","Circle OPCO","Circle Sales","","HO RF","","Circle SAQ","","CH/RBH","","HO RF","","Circle Sales","","Circle Sales","","Circle OPCO","","Circle Sales","","Circle SAQ","","Circle Legal","","HO Legal","","Circle Projects","","Circle Projects","","Circle Projects","","Circle OPCO",""];
for($cc=0;$cc<count($firstRowCol);$cc++){
	$colValue = $firstRowCol[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue($colName.'1',$colValue);
}
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('D1:E1')->mergeCells('F1:G1')->mergeCells('H1:I1')->mergeCells('J1:K1')->mergeCells('L1:M1')->mergeCells('N1:O1')
->mergeCells('P1:Q1')->mergeCells('R1:S1')->mergeCells('T1:U1')->mergeCells('V1:W1')->mergeCells('X1:Y1')
->mergeCells('Z1:AA1')->mergeCells('AB1:AC1')->mergeCells('AD1:AE1')->mergeCells('AF1:AG1')->mergeCells('AH1:AI1');

$columnNameArr=["SR_NUMBER","Circle","SR Date","SR Acceptance","","SR Approval","","SEAF Submission","","RBH Approval","","SEAF Approval 1st Stage","","SP Submission","","SP Release to Airtel","","SP Accepted by Airtel","","Approve SO","","Agreement Submission","","Legal Validation","","Agreement Approval","","Site ID Creation","","RFAI WIP","","RFAI Declaration","","RFAI Acceptance",""]; 
$excelColName=array();
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue($colName.'2',$colValue);
}
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('D2:E2')->mergeCells('F2:G2')->mergeCells('H2:I2')->mergeCells('J2:K2')->mergeCells('L2:M2')->mergeCells('N2:O2')
->mergeCells('P2:Q2')->mergeCells('R2:S2')->mergeCells('T2:U2')->mergeCells('V2:W2')->mergeCells('X2:Y2')
->mergeCells('Z2:AA2')->mergeCells('AB2:AC2')->mergeCells('AD2:AE2')->mergeCells('AF2:AG2')->mergeCells('AH2:AI2');

$thirdRowCol=["","","","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging"];
for($cc=0;$cc<count($thirdRowCol);$cc++){
	$colValue = $thirdRowCol[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue($colName.'3',$colValue);
}

$sql = "SELECT `SR_NUMBER`, `Circle`, `NB01`, `NB02Date`, `NB02`, `NB03Date`, `NB03`, `NB04Date`, `NB04`, `NB05Date`, `NB05`, `NB08Date`, `NB08`, `NB09Date`, `NB09`, `NB103Date`, `NB103`, `NB10Date`, `NB10`, `NB11Date`, `NB11`, `NBB12Date`, `NBB12`, `NB12Date`, `NB12`, `NB015Date`, `NB015`, `NB15Date`, `NB15`, `NB16Date`, `NB16`, `NB17Date`, `NB17`, `NB18Date`, `NB18` FROM `Airtel_NBS_Audit` ";
$query = mysqli_query($conn,$sql);	
$lastColName="";
$cellRow = 3;
while($row = mysqli_fetch_assoc($query)){
	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
		$lastColName=$colName;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
$sheet->getStyle("A2:".$lastColName."2")->getFont()->setBold(true);
$sheet->getStyle("A3:".$lastColName."3")->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
	if($i > 3){
		$dateColArr = [2,3,5,7,9,11,13,15,17,19,21,23,25,27,29,31,33];
		for($dateCol=0;$dateCol<count($dateColArr);$dateCol++){
			$allDate = $sheet->getCellByColumnAndRow($dateColArr[$dateCol], $i)->getValue();
			if($allDate !=""){
				$sheet->setCellValueByColumnAndRow($dateColArr[$dateCol], $i,  PHPExcel_Shared_Date::PHPToExcel($allDate));
				$sheet->getStyleByColumnAndRow($dateColArr[$dateCol], $i) ->getNumberFormat()->setFormatCode($format);
			}
				
		}
	}
}
$sheetName="Audit - Macro Anchor";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex(0);

// Aging - Macro Anchor
$objPHPExcel->createSheet();
$columnNameArr=["Type", "SR Acceptance", "SR Approval","SEAF Submission","CH/RBH Approval","SEAF Approval 1st Stage","SP Submission","SP Release to Airtel","SP Accepted by Airtel","Approve SO","Agreement Submission","Legal Validation","Agreement Approval","Site ID Creation","RFAI WIP","RFAI Declaration","RFAI Acceptance"]; 
$excelColName=array();
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex(1)
	->setCellValue($colName.'1',$colValue);
}

$sql = "SELECT `Type`, `NB02`, `NB03`, `NB04`, `NB05`, `NB08`, `NB09`, `NB103`, `NB10`, `NB11`, `NBB12`, `NB12`, `NB015`, `NB15`, `NB16`, `NB17`, `NB18` FROM `Airtel_NBS_Aging`";
$query = mysqli_query($conn,$sql);	
$lastColName="";
$cellRow = 1;
while($row = mysqli_fetch_assoc($query)){
	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex(1)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
		$lastColName=$colName;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
}
$sheetName="Aging - Macro Anchor";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex(1);

$status = true;
if($status == true){
	// Audit - HPSC Anchor
	$objPHPExcel->createSheet();
	$firstRowCol=["SR_NUMBER","Circle","SR Date","SR Acceptance","","SR Approval","","Site details submission","","RBH Approval","","Site detail approval","","Final Site detail approval","","SP Submission","","SP Release to Airtel","","SP Accepted by Airtel","","Approve SO","","Agreement Submission","","For SO Approval","","Agreement Approval","","RFAI WIP","","RFAI Declaration","","RFAI Acceptance",""];
	for($cc=0;$cc<count($firstRowCol);$cc++){
		$colValue = $firstRowCol[$cc];
		$colIndex = $cc+1;
		$colName = numberToColumnName($colIndex);
		array_push($excelColName, $colName);
		$objPHPExcel->setActiveSheetIndex(2)
		->setCellValue($colName.'1',$colValue);
	}
	$objPHPExcel->setActiveSheetIndex(2)
	->mergeCells('D1:E1')->mergeCells('F1:G1')->mergeCells('H1:I1')->mergeCells('J1:K1')->mergeCells('L1:M1')
	->mergeCells('N1:O1')
	->mergeCells('P1:Q1')->mergeCells('R1:S1')->mergeCells('T1:U1')->mergeCells('V1:W1')->mergeCells('X1:Y1')
	->mergeCells('Z1:AA1')->mergeCells('AB1:AC1')->mergeCells('AD1:AE1')->mergeCells('AF1:AG1')->mergeCells('AH1:AI1');


	$columnNameArr=["","","","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging"]; 
	$excelColName=array();
	for($cc=0;$cc<count($columnNameArr);$cc++){
		$colValue = $columnNameArr[$cc];
		$colIndex = $cc+1;
		$colName = numberToColumnName($colIndex);
		array_push($excelColName, $colName);
		$objPHPExcel->setActiveSheetIndex(2)
		->setCellValue($colName.'2',$colValue);
	}


	$sql = "SELECT `SR_NUMBER`, `Circle`, `NB01`, `NB02Date`, `NB02`, `NB03Date`, `NB03`, `NB04Date`, `NB04`, `NB05Date`, `NB05`, `NB06Date`, `NB06`, `NB08Date`, `NB08`, `NB09Date`, `NB09`, `NB103Date`, `NB103`, `NB10Date`, `NB10`, `NB11Date`, `NB11`, `NBB12Date`, `NBB12`, `NB12Date`, `NB12`, `NB15Date`, `NB15`, `NB16Date`, `NB16`, `NB17Date`, `NB17`, `NB18Date`, `NB18` FROM `Airtel_HPSC_Audit` ";
	$query = mysqli_query($conn,$sql);	
	$lastColName="";
	$cellRow = 2;
	while($row = mysqli_fetch_assoc($query)){
		$cellRow++;
		$colIndex=0;
		foreach ($row as $key => $value) {
			$colName = $excelColName[$colIndex];
			$objPHPExcel->setActiveSheetIndex(2)
			->setCellValue($colName.''.$cellRow,$value);
			$colIndex++;
			$lastColName=$colName;
		}
	}
	$sheet = $objPHPExcel->getActiveSheet();
	$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
	$sheet->getStyle("A2:".$lastColName."2")->getFont()->setBold(true);
	for($i=1;$i<=$cellRow;$i++){
		$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
		if($i > 2){
			$dateColArr = [2,3,5,7,9,11,13,15,17,19,21,23,25,27,29,31,33];
			for($dateCol=0;$dateCol<count($dateColArr);$dateCol++){
				$allDate = $sheet->getCellByColumnAndRow($dateColArr[$dateCol], $i)->getValue();
				if($allDate !=""){
					$sheet->setCellValueByColumnAndRow($dateColArr[$dateCol], $i,  PHPExcel_Shared_Date::PHPToExcel($allDate));
					$sheet->getStyleByColumnAndRow($dateColArr[$dateCol], $i) ->getNumberFormat()->setFormatCode($format);
				}
					
			}
		}
	}
	$sheetName="Audit - HPSC Anchor";
	$objPHPExcel->getActiveSheet()->setTitle($sheetName);
	$objPHPExcel->setActiveSheetIndex(2);

	// Aging - HPSC Anchor
	$objPHPExcel->createSheet();
	$columnNameArr=["Type", "SR Acceptance", "SR Approval","Site details submission","RBH Approval","Site detail approval","Final Site detail approval","SP Submission","SP Release to Airtel","SP Accepted by Airtel","Approve SO","Agreement Submission","For SO Approval","Agreement Approval","RFAI WIP","RFAI Declaration","RFAI Acceptance"]; 
	$excelColName=array();
	for($cc=0;$cc<count($columnNameArr);$cc++){
		$colValue = $columnNameArr[$cc];
		$colIndex = $cc+1;
		$colName = numberToColumnName($colIndex);
		array_push($excelColName, $colName);
		$objPHPExcel->setActiveSheetIndex(3)
		->setCellValue($colName.'1',$colValue);
	}

	$sql = "SELECT `Type`, `NB02`, `NB03`, `NB04`, `NB05`, `NB06`, `NB08`, `NB09`, `NB103`, `NB10`, `NB11`, `NBB12`, `NB12`, `NB15`, `NB16`, `NB17`, `NB18` FROM `Airtel_HPSC_Aging`";
	$query = mysqli_query($conn,$sql);	
	$lastColName="";
	$cellRow = 1;
	while($row = mysqli_fetch_assoc($query)){
		$cellRow++;
		$colIndex=0;
		foreach ($row as $key => $value) {
			$colName = $excelColName[$colIndex];
			$objPHPExcel->setActiveSheetIndex(3)
			->setCellValue($colName.''.$cellRow,$value);
			$colIndex++;
			$lastColName=$colName;
		}
	}
	$sheet = $objPHPExcel->getActiveSheet();
	$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
	for($i=1;$i<=$cellRow;$i++){
		$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
	}
	$sheetName="Aging - HPSC Anchor";
	$objPHPExcel->getActiveSheet()->setTitle($sheetName);
	$objPHPExcel->setActiveSheetIndex(3);
}
$status1 = true;
if($status1 == true){
	// Audit - Site Upgrade
	$objPHPExcel->createSheet();
	$firstRowCol=["SR_NUMBER", "Circle", "SR Date", "SP Release to Airtel","","SP Accepted by Airtel","","Approve SO","","RFAI WIP","","RFAI Declaration","","AT Acceptance","","RFS Acceptance",""];
	for($cc=0;$cc<count($firstRowCol);$cc++){
		$colValue = $firstRowCol[$cc];
		$colIndex = $cc+1;
		$colName = numberToColumnName($colIndex);
		array_push($excelColName, $colName);
		$objPHPExcel->setActiveSheetIndex(4)
		->setCellValue($colName.'1',$colValue);
	}
	$objPHPExcel->setActiveSheetIndex(4)
	->mergeCells('D1:E1')->mergeCells('F1:G1')->mergeCells('H1:I1')->mergeCells('J1:K1')->mergeCells('L1:M1')
	->mergeCells('N1:O1')->mergeCells('P1:Q1');

	$columnNameArr=["", "", "", "Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging"]; 
	$excelColName=array();
	for($cc=0;$cc<count($columnNameArr);$cc++){
		$colValue = $columnNameArr[$cc];
		$colIndex = $cc+1;
		$colName = numberToColumnName($colIndex);
		array_push($excelColName, $colName);
		$objPHPExcel->setActiveSheetIndex(4)
		->setCellValue($colName.'2',$colValue);
	}

	$sql = "SELECT `SR_NUMBER`, `Circle`, `NB01`, `NB02Date`, `NB02`, `NB103Date`, `NB103`, `NB03Date`, `NB03`, `NB04Date`, `NB04`, `NB05Date`, `NB05`, `NB06Date`, `NB06`, `NB07Date`, `NB07` FROM `Airtel_SU_Audit` ";
	$query = mysqli_query($conn,$sql);	
	$lastColName="";
	$cellRow = 2;
	while($row = mysqli_fetch_assoc($query)){
		$cellRow++;
		$colIndex=0;
		foreach ($row as $key => $value) {
			$colName = $excelColName[$colIndex];
			$objPHPExcel->setActiveSheetIndex(4)
			->setCellValue($colName.''.$cellRow,$value);
			$colIndex++;
			$lastColName=$colName;
		}
	}
	$sheet = $objPHPExcel->getActiveSheet();
	$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
	$sheet->getStyle("A2:".$lastColName."2")->getFont()->setBold(true);
	for($i=1;$i<=$cellRow;$i++){
		$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
		if($i > 2){
			$dateColArr = [2,3,5,7,9,11,13,15];
			for($dateCol=0;$dateCol<count($dateColArr);$dateCol++){
				$allDate = $sheet->getCellByColumnAndRow($dateColArr[$dateCol], $i)->getValue();
				if($allDate !=""){
					$sheet->setCellValueByColumnAndRow($dateColArr[$dateCol], $i,  PHPExcel_Shared_Date::PHPToExcel($allDate));
					$sheet->getStyleByColumnAndRow($dateColArr[$dateCol], $i) ->getNumberFormat()->setFormatCode($format);
				}
					
			}
		}
	}
	$sheetName="Audit - Site Upgrade";
	$objPHPExcel->getActiveSheet()->setTitle($sheetName);
	$objPHPExcel->setActiveSheetIndex(4);

	// Aging - Site Upgrade
	$objPHPExcel->createSheet();
	$columnNameArr=["Type", "SP Release to Airtel","SP Accepted by Airtel","Approve SO","RFAI WIP","RFAI Declaration","AT Acceptance","RFS Acceptance"]; 
	$excelColName=array();
	for($cc=0;$cc<count($columnNameArr);$cc++){
		$colValue = $columnNameArr[$cc];
		$colIndex = $cc+1;
		$colName = numberToColumnName($colIndex);
		array_push($excelColName, $colName);
		$objPHPExcel->setActiveSheetIndex(5)
		->setCellValue($colName.'1',$colValue);
	}

	$sql = "SELECT `Type`, `NB02`, `NB103`, `NB03`, `NB04`, `NB05`, `NB06`, `NB07` FROM `Airtel_SU_Aging`";
	$query = mysqli_query($conn,$sql);	
	$lastColName="";
	$cellRow = 1;
	while($row = mysqli_fetch_assoc($query)){
		$cellRow++;
		$colIndex=0;
		foreach ($row as $key => $value) {
			$colName = $excelColName[$colIndex];
			$objPHPExcel->setActiveSheetIndex(5)
			->setCellValue($colName.''.$cellRow,$value);
			$colIndex++;
			$lastColName=$colName;
		}
	}
	$sheet = $objPHPExcel->getActiveSheet();
	$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
	for($i=1;$i<=$cellRow;$i++){
		$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
	}
	$sheetName="Aging - Site Upgrade";
	$objPHPExcel->getActiveSheet()->setTitle($sheetName);
	$objPHPExcel->setActiveSheetIndex(5);

	// Audit - New Tenency
	$objPHPExcel->createSheet();
	$firstRowCol=["SR_NUMBER", "Circle", "SR Date", "Feasibility Pending _ Circle","","SP Submission","","SP Release to Airtel","","SP Accepted by Airtel","","Approve SO","","RFAI WIP","","RFAI Declaration","","RFAI Acceptance","","RFS Acceptance",""];
	for($cc=0;$cc<count($firstRowCol);$cc++){
		$colValue = $firstRowCol[$cc];
		$colIndex = $cc+1;
		$colName = numberToColumnName($colIndex);
		array_push($excelColName, $colName);
		$objPHPExcel->setActiveSheetIndex(6)
		->setCellValue($colName.'1',$colValue);
	}
	$objPHPExcel->setActiveSheetIndex(6)
	->mergeCells('D1:E1')->mergeCells('F1:G1')->mergeCells('H1:I1')->mergeCells('J1:K1')->mergeCells('L1:M1')
	->mergeCells('N1:O1')->mergeCells('P1:Q1')->mergeCells('R1:S1')->mergeCells('T1:U1');

	$columnNameArr=["", "", "", "Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging"]; 
	$excelColName=array();
	for($cc=0;$cc<count($columnNameArr);$cc++){
		$colValue = $columnNameArr[$cc];
		$colIndex = $cc+1;
		$colName = numberToColumnName($colIndex);
		array_push($excelColName, $colName);
		$objPHPExcel->setActiveSheetIndex(6)
		->setCellValue($colName.'2',$colValue);
	}

	$sql = "SELECT `SR_NUMBER`, `Circle`, `NB01`, `NB02Date`, `NB02`, `NB03Date`, `NB03`, `NB04Date`, `NB04`, `NB103Date`, `NB103`, `NB05Date`, `NB05`, `NB06Date`, `NB06`, `NB07Date`, `NB07`, `NB08Date`, `NB08`, `NB09Date`, `NB09` FROM `Airtel_NT_Audit` ";
	$query = mysqli_query($conn,$sql);	
	$lastColName="";
	$cellRow = 2;
	while($row = mysqli_fetch_assoc($query)){
		$cellRow++;
		$colIndex=0;
		foreach ($row as $key => $value) {
			$colName = $excelColName[$colIndex];
			$objPHPExcel->setActiveSheetIndex(6)
			->setCellValue($colName.''.$cellRow,$value);
			$colIndex++;
			$lastColName=$colName;
		}
	}
	$sheet = $objPHPExcel->getActiveSheet();
	$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
	$sheet->getStyle("A2:".$lastColName."2")->getFont()->setBold(true);
	for($i=1;$i<=$cellRow;$i++){
		$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
		if($i > 2){
			$dateColArr = [2,3,5,7,9,11,13,15,17,19];
			for($dateCol=0;$dateCol<count($dateColArr);$dateCol++){
				$allDate = $sheet->getCellByColumnAndRow($dateColArr[$dateCol], $i)->getValue();
				if($allDate !=""){
					$sheet->setCellValueByColumnAndRow($dateColArr[$dateCol], $i,  PHPExcel_Shared_Date::PHPToExcel($allDate));
					$sheet->getStyleByColumnAndRow($dateColArr[$dateCol], $i) ->getNumberFormat()->setFormatCode($format);
				}
					
			}
		}
	}
	$sheetName="Audit - New Tenency";
	$objPHPExcel->getActiveSheet()->setTitle($sheetName);
	$objPHPExcel->setActiveSheetIndex(6);

	// Aging - New Tenency
	$objPHPExcel->createSheet();
	$columnNameArr=["Type", "Feasibility Pending _ Circle","SP Submission","SP Release to Airtel","SP Accepted by Airtel","Approve SO","RFAI WIP","RFAI Declaration","RFAI Acceptance","RFS Acceptance"]; 
	$excelColName=array();
	for($cc=0;$cc<count($columnNameArr);$cc++){
		$colValue = $columnNameArr[$cc];
		$colIndex = $cc+1;
		$colName = numberToColumnName($colIndex);
		array_push($excelColName, $colName);
		$objPHPExcel->setActiveSheetIndex(7)
		->setCellValue($colName.'1',$colValue);
	}

	$sql = "SELECT `Type`, `NB02`, `NB03`, `NB04`, `NB103`, `NB05`, `NB06`, `NB07`, `NB08`, `NB09` FROM `Airtel_NT_Aging`";
	$query = mysqli_query($conn,$sql);	
	$lastColName="";
	$cellRow = 1;
	while($row = mysqli_fetch_assoc($query)){
		$cellRow++;
		$colIndex=0;
		foreach ($row as $key => $value) {
			$colName = $excelColName[$colIndex];
			$objPHPExcel->setActiveSheetIndex(7)
			->setCellValue($colName.''.$cellRow,$value);
			$colIndex++;
			$lastColName=$colName;
		}
	}
	$sheet = $objPHPExcel->getActiveSheet();
	$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
	for($i=1;$i<=$cellRow;$i++){
		$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
	}
	$sheetName="Aging - New Tenency";
	$objPHPExcel->getActiveSheet()->setTitle($sheetName);
	$objPHPExcel->setActiveSheetIndex(7);
}

$filename = "Audit & Aging Report";
header('Content-Type: application/vnd.ms-excel');
header('Cache-Control: max-age=0');
// $fileExt = "xls";
$fileExt = "xlsx";
if($fileExt == "xls"){
	header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
}
else if($fileExt == "xlsx"){
	header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
}
$objWriter->save('php://output');
// $objWriter->save("/var/www/in3.co.in/TVI_CP/php/Report/".$filename.'.'.$fileExt);
// $msg = "Dear Team, "."<br>";
// $msg .= "Please find Audit & Aging report for today."."<br>";
// $msg .= "PFA"."<br><br>";
// $msg .= "Regards"."<br>";
// $msg .= "<b>Trinity Automation Team</b>.";
// sendMail($msg, "/var/www/in3.co.in/TVI_CP/php/Report/".$filename.'.'.$fileExt);
exit;
?>

<?php
function numberToColumnName($number){
    $abc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $abc_len = strlen($abc);

    $result_len = 1; // how much characters the column's name will have
    $pow = 0;
    while( ( $pow += pow($abc_len, $result_len) ) < $number ){
        $result_len++;
    }

    $result = "";
    $next = false;
    // add each character to the result...
    for($i = 1; $i<=$result_len; $i++){
        $index = ($number % $abc_len) - 1; // calculate the module

        // sometimes the index should be decreased by 1
        if( $next || $next = false ){
            $index--;
        }

        // this is the point that will be calculated in the next iteration
        $number = floor($number / strlen($abc));

        // if the index is negative, convert it to positive
        if( $next = ($index < 0) ) {
            $index = $abc_len + $index;
        }

        $result = $abc[$index].$result; // concatenate the letter
    }
    return $result;
}
function sendMail($msg, $attachment){
	$status = false;

	$message = $msg;
	
	$mail = new PHPMailer;
	
	$mail->isSMTP();                                      
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = '[emailId]';
	$mail->Password = '[password]';   
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	
	// To mail's
	$mail->addAddress("jai.prakash@trinityapplab.co.in");

	$mail->setFrom("[emailId]","Trinity Automation");
	$mail->addAttachment($attachment);
	$mail->isHTML(true);   

	// CC mail's
	// $mail->addCC('anupama@nvgroup.co.in');
	
	// BCC mail's
	// $mail->addBCC("jai.prakash@trinityapplab.co.in");

	
	$mail->Subject = 'SR Audit & Aging Report';
	$mail->Body = "$message<br>";
	
		
	if(!$mail->send())
	{
		// echo 'Mailer Error: ' . $mail->ErrorInfo;
		// echo"<br>Could not send";
		$status = false;
	}
	else{
		// echo "mail sent ";
		$status = true;
	}

	return $status;

}
?>