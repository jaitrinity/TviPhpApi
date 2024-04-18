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

// Audit - HPSC Anchor
$firstRowCol=["","Circle OPCO","As Actual","Circle OPCO","Circle Sales","","HO RF","","Circle SAQ","","CH/RBH","","HO RF","","Circle Sales","","Circle Sales","","Circle OPCO","","Circle Sales","","Circle SAQ","","Circle Legal","","HO Legal","","Circle Projects","","Circle Projects","","Circle OPCO","","Circle OPCO",""];
for($cc=0;$cc<count($firstRowCol);$cc++){
	$colValue = $firstRowCol[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue($colName.'1',$colValue);
}
$objPHPExcel->setActiveSheetIndex(0)
->mergeCells('E1:F1')->mergeCells('G1:H1')->mergeCells('I1:J1')->mergeCells('K1:L1')->mergeCells('M1:N1')->mergeCells('O1:P1')
->mergeCells('Q1:R1')->mergeCells('S1:T1')->mergeCells('U1:V1')->mergeCells('W1:X1')->mergeCells('Y1:Z1')
->mergeCells('AA1:AB1')->mergeCells('AC1:AD1')->mergeCells('AE1:AF1')->mergeCells('AG1:AH1')->mergeCells('AI1:AJ1');

$columnNameArr=["Operator","SR_NUMBER","Circle","SR Date","SR Acceptance","","SR Approval","","SEAF Submission","","RBH Approval","","SEAF Approval 1st Stage","", "SP Submission","","Release SO","","Approve SO","","Agreement Submission","","Legal Validation","","Agreement Approval","","Site ID Creation","","RFAI WIP","","RFAI Declaration","","RFAI Acceptance","","RFS Acceptance",""]; 
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
->mergeCells('E2:F2')->mergeCells('G2:H2')->mergeCells('I2:J2')->mergeCells('K2:L2')->mergeCells('M2:N2')->mergeCells('O2:P2')
->mergeCells('Q2:R2')->mergeCells('S2:T2')->mergeCells('U2:V2')->mergeCells('W2:X2')->mergeCells('Y2:Z2')
->mergeCells('AA2:AB2')->mergeCells('AC2:AD2')->mergeCells('AE2:AF2')->mergeCells('AG2:AH2')->mergeCells('AI2:AJ2');

$thirdRowCol=["","","","","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging","Date","Aging"];
for($cc=0;$cc<count($thirdRowCol);$cc++){
	$colValue = $thirdRowCol[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue($colName.'3',$colValue);
}

$sql = "SELECT `Operator`, `SR_NUMBER`, `CIRCLE_NAME`, `NB01`, `NB02Date`, `NB02`, `NB03Date`, `NB03`, `NB04Date`, `NB04`, `NB05Date`, `NB05`, `NB06Date`, `NB06`, `NB08Date`, `NB08`, `NB09Date`, `NB09`, `NB10Date`, `NB10`, `NB11Date`, `NB11`, `NBB12Date`, `NBB12`, `NB12Date`, `NB12`, `NB15Date`, `NB15`, `NB16Date`, `NB16`, `NB17Date`, `NB17`, `NB18Date`, `NB18`, `NB19Date`, `NB19` FROM `Opco_HPSC_Audit` ";
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
		$dateColArr = [3,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34];
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
$objPHPExcel->setActiveSheetIndex(0);

// Aging - HPSC Anchor
$objPHPExcel->createSheet();
$columnNameArr=["Type", "SR Acceptance", "SR Approval","SEAF Submission","CH/RBH Approval","SEAF Approval 1st Stage","SP Submission","Release SO","Approve SO","Agreement Submission","Legal Validation","Agreement Approval","Site ID Creation","RFAI WIP","RFAI Declaration","RFAI Acceptance","RFS Acceptance"]; 
$excelColName=array();
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex(1)
	->setCellValue($colName.'1',$colValue);
}

$sql = "SELECT `Type`, `NB02`, `NB03`, `NB04`, `NB05`, `NB06`, `NB08`, `NB09`, `NB10`, `NB11`, `NBB12`, `NB12`, `NB15`, `NB16`, `NB17`, `NB18`, `NB19` FROM `Opco_HPSC_Aging`";
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
$sheetName="Aging - HPSC Anchor";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex(1);



$filename = "HPSC - Audit & Aging Report";
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
?>