<?php
include("cpDbConfig_test.php");
require 'PHPExcel/Classes/PHPExcel.php';

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

$firstRowCol=["S.NO", "UAN NO", "EPF NO.", "ESI NO", "IFSC CODE", "ACCOUNT NO", "Catogory Code", "Name of contract Labour", "FATHERS NAME", "Category(Un Skilled/Semi Skilled/Skilled)", "Basic wages", "HRA", "CONVEYANCE", "SPL ALLOWENCE", "PF WAGES", "ESI WAGES", "GROSS Wages per Month", "Actual minimum wages rate per day(Rs)", "TOTAL WORKING DAYS", "Actual physical attendance of contract labour", "BASIC WAGES", "GROSS Wages per Month", "P.F WAGES (LESS THAN 15000 ON BASIC)", "BONUS WAGES", "BONUS 8.33%", "LEAVENCASH 4.81%", "Gross ESI WAGES", "TOTAL GROSS WAGES", "SIGN", "PF 12%", "ESI .75%", "DEDU", "SALARY IN HAND"];
$excelColName=array();
$lastColName="";
for($cc=0;$cc<count($firstRowCol);$cc++){
	$colValue = $firstRowCol[$cc];
	$colIndex = $cc+1;
	$colName = numberToColumnName($colIndex);
	array_push($excelColName, $colName);
	$lastColName=$colName;
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue($colName.'3',$colValue);
}

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:'.$lastColName.'1');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','D S HEADQUARTERS');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:'.$lastColName.'2');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2','Minimum Wages Rate of contract Labour for the Month of------ DECEMBER 2024');

$sql = "SELECT `S.NO`, `UAN NO`, `EPF NO.`, `ESI NO`, `IFSC CODE`, `ACCOUNT NO`, `Catogory Code`, `Name of contract Labour`, `FATHERS NAME`, `Category(Un Skilled/Semi Skilled/Skilled)`, `Basic wages`, `HRA`, `CONVEYANCE`, `SPL ALLOWENCE`, `PF WAGES`, `ESI WAGES`, `GROSS Wages per Month`, `Actual minimum wages rate per day(Rs)`, `TOTAL WORKING DAYS`, `Actual physical attendance of contract labour`, `BASIC WAGES 1`, `GROSS Wages per Month 1`, `P.F WAGES (LESS THAN 15000 ON BASIC)`, `BONUS WAGES`, `BONUS 8.33%`, `LEAVENCASH 4.81%`, `Gross ESI WAGES`, `TOTAL GROSS WAGES`, `SIGN`, `PF 12%`, `ESI .75%`, `DEDU`, `SALARY IN HAND` FROM `book1`";
$sql .= " UNION ";
$sql .= "SELECT '' as `S.NO`, '' as `UAN NO`, '' as `EPF NO.`, '' as `ESI NO`, '' as `IFSC CODE`, '' as `ACCOUNT NO`, '' as `Catogory Code`, '' as `Name of contract Labour`, '' as `FATHERS NAME`, '' as `Category(Un Skilled/Semi Skilled/Skilled)`, '' as `Basic wages`, '' as `HRA`, '' as `CONVEYANCE`, '' as `SPL ALLOWENCE`, '' as `PF WAGES`, '' as `ESI WAGES`, '' as `GROSS Wages per Month`, '' as `Actual minimum wages rate per day(Rs)`, 'Total' as  `TOTAL WORKING DAYS`, sum(`Actual physical attendance of contract labour`) as `Actual physical attendance of contract labour`, sum(`BASIC WAGES 1`) as `BASIC WAGES 1`, sum(`GROSS Wages per Month 1`) as `GROSS Wages per Month 1`, sum(`P.F WAGES (LESS THAN 15000 ON BASIC)`) as `P.F WAGES (LESS THAN 15000 ON BASIC)`, sum(`BONUS WAGES`) as `BONUS WAGES`, sum(`BONUS 8.33%`) as `BONUS 8.33%`, sum(`LEAVENCASH 4.81%`) as `LEAVENCASH 4.81%`, sum(`Gross ESI WAGES`) as `Gross ESI WAGES`, sum(`TOTAL GROSS WAGES`) as `TOTAL GROSS WAGES`, sum(`SIGN`) as `SIGN`, sum(`PF 12%`) as `PF 12%`, sum(`ESI .75%`) as `ESI .75%`, sum(`DEDU`) as `DEDU`, sum(`SALARY IN HAND`) as `SALARY IN HAND` from `book1`";
$query = mysqli_query($conn,$sql);	
$cellRow = 3;
while($row = mysqli_fetch_assoc($query)){
	$cellRow++;
	$colIndex=0;
	foreach ($row as $key => $value) {
		$colName = $excelColName[$colIndex];
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue($colName.''.$cellRow,$value);
		$colIndex++;
	}
}
$sheet = $objPHPExcel->getActiveSheet();
$sheet->getStyle("A1:".$lastColName."1")->getFont()->setBold(true);
$sheet->getStyle("A2:".$lastColName."2")->getFont()->setBold(true);
$sheet->getStyle("A3:".$lastColName."3")->getFont()->setBold(true);
$sheet->getStyle("A".$cellRow.":".$lastColName."".$cellRow)->getFont()->setBold(true);
for($i=1;$i<=$cellRow;$i++){
	$sheet->getStyle("A".$i.":".$lastColName.$i)->applyFromArray($border_style);
}
$sheetName="TEPAYROLL";
$objPHPExcel->getActiveSheet()->setTitle($sheetName);
$objPHPExcel->setActiveSheetIndex(0);

$filename = "TEPAYROLL";
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