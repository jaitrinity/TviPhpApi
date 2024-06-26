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
// $columnNameArr=["SR_NUMBER", "Circle", "SR Date", "NB02", "NB03", "NB04", "NB05", "NB08", "NB09", "NB103", "NB10", "NB11", "NBB12", "NB12", "NB015", "NB15", "NB16", "NB17", "NB18"]; 
$columnNameArr=["SR_NUMBER", "Circle", "SR Date", "SR Approval","SEAF Submission","RBH Approval","SEAF Approval 1st Stage","SP Submission","SP Release to Airtel","SP Accepted by Airtel","Approve SO","Agreement Submission","For SO Approval","Agreement Approval","Site ID Creation","RFAI WIP","RFAI Declaration","AT Acceptance","RFS Acceptance"]; 
$excelColName=array();
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue($colName.'1',$colValue);
}

$sql = "SELECT `SR_NUMBER`, `Circle`, `NB01`, `NB02`, `NB03`, `NB04`, `NB05`, `NB08`, `NB09`, `NB103`, `NB10`, `NB11`, `NBB12`, `NB12`, `NB015`, `NB15`, `NB16`, `NB17`, `NB18` FROM `Airtel_NBS_Audit` ";
$query = mysqli_query($conn,$sql);	
$lastColName="";
$cellRow = 1;
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
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
	if($i != 1){
		$srDate = $sheet->getCellByColumnAndRow(2, $i)->getValue();
		$sheet->setCellValueByColumnAndRow(2, $i,  PHPExcel_Shared_Date::PHPToExcel($srDate));
		$sheet->getStyleByColumnAndRow(2, $i) ->getNumberFormat()->setFormatCode($format);
	}
}
$sheetName="Audit - Macro Anchor";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex(0);

// Aging - Macro Anchor
$objPHPExcel->createSheet();
// $columnNameArr=["Type", "NB02", "NB03", "NB04", "NB05", "NB08", "NB09", "NB103", "NB10", "NB11", "NBB12", "NB12", "NB015", "NB15", "NB16", "NB17", "NB18"]; 
$columnNameArr=["Type", "SR Approval","SEAF Submission","RBH Approval","SEAF Approval 1st Stage","SP Submission","SP Release to Airtel","SP Accepted by Airtel","Approve SO","Agreement Submission","For SO Approval","Agreement Approval","Site ID Creation","RFAI WIP","RFAI Declaration","AT Acceptance","RFS Acceptance"]; 
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

// Audit - HPSC Anchor
$objPHPExcel->createSheet();
// $columnNameArr=["SR_NUMBER", "Circle", "SR Date", "NB02", "NB03", "NB04", "NB05", "NB06", "NB08", "NB09", "NB103", "NB10", "NB11", "NBB12", "NB12", "NB15", "NB16", "NB17", "NB18"]; 
$columnNameArr=["SR_NUMBER", "Circle", "SR Date", "SR Approval","Site details submission","RBH Approval","Site detail approval","Final Site detail approval","SP Submission","SP Release to Airtel","SP Accepted by Airtel","Approve SO","Agreement Submission","For SO Approval","Agreement Approval","RFAI WIP","RFAI Declaration","AT Acceptance","RFS Acceptance"]; 
$excelColName=array();
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex(2)
	->setCellValue($colName.'1',$colValue);
}


$sql = "SELECT `SR_NUMBER`, `Circle`, `NB01`, `NB02`, `NB03`, `NB04`, `NB05`, `NB06`, `NB08`, `NB09`, `NB103`, `NB10`, `NB11`, `NBB12`, `NB12`, `NB15`, `NB16`, `NB17`, `NB18` FROM `Airtel_HPSC_Audit` ";
$query = mysqli_query($conn,$sql);	
$lastColName="";
$cellRow = 1;
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
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
	if($i != 1){
		$srDate = $sheet->getCellByColumnAndRow(2, $i)->getValue();
		$sheet->setCellValueByColumnAndRow(2, $i,  PHPExcel_Shared_Date::PHPToExcel($srDate));
		$sheet->getStyleByColumnAndRow(2, $i) ->getNumberFormat()->setFormatCode($format);
	}
}
$sheetName="Audit - HPSC Anchor";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex(2);

// Aging - HPSC Anchor
$objPHPExcel->createSheet();
// $columnNameArr=["Type", "NB02", "NB03", "NB04", "NB05", "NB06", "NB08", "NB09", "NB103", "NB10", "NB11", "NBB12", "NB12", "NB15", "NB16", "NB17", "NB18"]; 
$columnNameArr=["Type", "SR Approval","Site details submission","RBH Approval","Site detail approval","Final Site detail approval","SP Submission","SP Release to Airtel","SP Accepted by Airtel","Approve SO","Agreement Submission","For SO Approval","Agreement Approval","RFAI WIP","RFAI Declaration","AT Acceptance","RFS Acceptance"]; 
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

// Audit - Site Upgrade
$objPHPExcel->createSheet();
// $columnNameArr=["SR_NUMBER", "Circle", "SR Date", "NB02", "NB103", "NB03", "NB04", "NB05", "NB06", "NB07"]; 
$columnNameArr=["SR_NUMBER", "Circle", "SR Date", "SP Release to Airtel","SP Accepted by Airtel","Approve SO","RFAI WIP","RFAI Declaration","AT Acceptance","RFS Acceptance"]; 
$excelColName=array();
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex(4)
	->setCellValue($colName.'1',$colValue);
}

$sql = "SELECT `SR_NUMBER`, `Circle`, `NB01`, `NB02`, `NB103`, `NB03`, `NB04`, `NB05`, `NB06`, `NB07` FROM `Airtel_SU_Audit` ";
$query = mysqli_query($conn,$sql);	
$lastColName="";
$cellRow = 1;
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
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
	if($i != 1){
		$srDate = $sheet->getCellByColumnAndRow(2, $i)->getValue();
		$sheet->setCellValueByColumnAndRow(2, $i,  PHPExcel_Shared_Date::PHPToExcel($srDate));
		$sheet->getStyleByColumnAndRow(2, $i) ->getNumberFormat()->setFormatCode($format);
	}
}
$sheetName="Audit - Site Upgrade";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex(4);

// Aging - Site Upgrade
$objPHPExcel->createSheet();
// $columnNameArr=["Type", "NB02", "NB103", "NB03", "NB04", "NB05", "NB06", "NB07"]; 
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
// $columnNameArr=["SR_NUMBER", "Circle", "SR Date", "NB02", "NB03", "NB04", "NB103", "NB05", "NB06", "NB07", "NB08", "NB09"]; 
$columnNameArr=["SR_NUMBER", "Circle", "SR Date", "Feasibility Pending _ Circle","SP Submission","SP Release to Airtel","SP Accepted by Airtel","Approve SO","RFAI WIP","RFAI Declaration","RFAI Acceptance","RFS Acceptance"]; 
$excelColName=array();
for($cc=0;$cc<count($columnNameArr);$cc++){
	$colValue = $columnNameArr[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	array_push($excelColName, $colName);
	$objPHPExcel->setActiveSheetIndex(6)
	->setCellValue($colName.'1',$colValue);
}

$sql = "SELECT `SR_NUMBER`, `Circle`, `NB01`, `NB02`, `NB03`, `NB04`, `NB103`, `NB05`, `NB06`, `NB07`, `NB08`, `NB09` FROM `Airtel_NT_Audit` ";
$query = mysqli_query($conn,$sql);	
$lastColName="";
$cellRow = 1;
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
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
	if($i != 1){
		$srDate = $sheet->getCellByColumnAndRow(2, $i)->getValue();
		$sheet->setCellValueByColumnAndRow(2, $i,  PHPExcel_Shared_Date::PHPToExcel($srDate));
		$sheet->getStyleByColumnAndRow(2, $i) ->getNumberFormat()->setFormatCode($format);
	}
}
$sheetName="Audit - New Tenency";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex(6);

// Aging - New Tenency
$objPHPExcel->createSheet();
// $columnNameArr=["Type", "NB02", "NB03", "NB04", "NB103", "NB05", "NB06", "NB07", "NB08", "NB09"]; 
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