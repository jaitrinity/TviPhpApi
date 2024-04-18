<?php
// include("dbConfiguration.php");
require 'PHPExcel/Classes/PHPExcel.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailerNew/src/Exception.php';
require 'PHPMailerNew/src/PHPMailer.php';
require 'PHPMailerNew/src/SMTP.php';

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
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	)
);

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1',"Col1")
    ->setCellValue('B1',"Col2")
    ->setCellValue('C1',"Col3")
    ->setCellValue('D1',"Col4");

$cellRow = 1;
for($i=0;$i<10;$i++){
	$cellRow++;
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.$cellRow,'Col1 - '.$i)
	->setCellValue('B'.$cellRow,'Col2 - '.$i)
	->setCellValue('C'.$cellRow,'Col3 - '.$i)
	->setCellValue('D'.$cellRow,'Col4 - '.$i);
}

$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:D1")->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":D".$i)->applyFromArray($border_style);
}
$objPHPExcel->getActiveSheet()->setTitle('Test');
$objPHPExcel->setActiveSheetIndex(0);
$filename='Test.xlsx';

header("Content-Type: application/vnd.ms-excel");
header("Cache-Control: max-age=0");

header("Content-Disposition: attachment;filename=".$filename);
$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save("/var/www/in3.co.in/TVI_CP/php/Report/".$filename);
$msg = "Dear Team, "."<br>";
$msg .= "Please find TA_DA report for $yesterdayDate date."."<br><br>";
// $msg .= "PFA"."<br><br>";
$msg .= "Regards"."<br>";
$msg .= "Trinity Automation Team.";
sendMail($msg, "/var/www/in3.co.in/TVI_CP/php/Report/".$filename);

?>

<?php 
function sendMail($msg, $attachment){
	$status = false;

	$message = $msg;
	
	$mail = new PHPMailer;
	
	$mail->isSMTP();                                      
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'communication@trinityapplab.co.in';
	$mail->Password = 'communication@Trinity';   
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	
	// To mail's
	// $mail->addAddress("anupama@nvgroup.co.in");
	// $mail->addAddress("akhilbhatnagar@nvgroup.co.in");
	$mail->addAddress("jai.prakash@trinityapplab.co.in");

	$mail->setFrom("communication@trinityapplab.co.in","Visit Report");
	$mail->addAttachment($attachment);
	$mail->isHTML(true);   

	// CC mail's
	// $mail->addCC('helpdesk@trinityapplab.co.in');
	// $mail->addCC('anupama@nvgroup.co.in');
	
	// BCC mail's
	// $mail->addBCC("jai.prakash@trinityapplab.co.in");

	
	$mail->Subject = 'Visit Report';
	$mail->Body = "$message<br>";
	
		
	if(!$mail->send())
	{
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		echo"<br>Could not send";
		$status = false;
	}
	else{
		echo "mail sent ";
		$status = true;
	}

	return $status;

}