<?php


function getSafeRequestValue($key){
	$val = $_REQUEST[$key];
	return isset($val)? $val:"";
}

$period = getSafeRequestValue('period'); //single select
$operatorName = getSafeRequestValue('operatorName');
// $circleName = getSafeRequestValue('circleName');

$periodString = "";
// $circleNameString = "";

// if($circleName != ""){
	// $circleNameArray = explode(",",$circleName);
	// for($y=0;$y< count($circleNameArray);$y++){
		// if($circleNameString != ""){
			// $circleNameString .= ",'$circleNameArray[$y]'"; 
		// }
		// else{
			// $circleNameString .= "'$circleNameArray[$y]'"; 
		// }
	// }
// }
if($period != ""){
	$periodArray = explode(",",$period);
	for($x=0;$x< count($periodArray);$x++){
		if($periodString != ""){
			$periodString .= ",'$periodArray[$x]'"; 
		}
		else{
			$periodString .= "'$periodArray[$x]'"; 
		}
	}
}
				
$startClause = " Select r2.*,(r2.TotalRevenue - r2.TotalCost) as TotalMargin,
				r2.TotalCost/r2.OperationalTenancy as CostPerTenant,
				r2.TotalRevenue/r2.OperationalTenancy as RevenuePerTenant,
				(r2.TotalRevenue - r2.TotalCost)/r2.OperationalTenancy as MarginPerTenant,
				((r2.TotalRevenue - r2.TotalCost)/r2.TotalRevenue) *100 as MarginPercentage
				from
				(Select r1.OperatorName,r1.CircleName,
				(case when r1.OperatorName != 'ZTS' and sum(r1.OperationalTenancy) = 0 then null else sum(r1.OperationalTenancy) end) as OperationalTenancy,
				sum(r1.TotalCost) as TotalCost,sum(r1.TotalRevenue) as TotalRevenue
				from
				(Select r.OperatorName,r.CircleName,
				(case when r.TotalCost is null then 0 else r.TotalCost end ) as TotalCost,
				(case when r.TotalRevenue is null then 0 else r.TotalRevenue end ) as TotalRevenue,
				r.opTenancy as OperationalTenancy
				from
				( ";				
$endClause = ") r )r1 group by r1.CircleName,r1.OperatorName)r2 where r2.OperationalTenancy is not null";
$operatorClause = "";
$unionClause = " UNION ";


$airtelOpClause = " SELECT 'Airtel' as OperatorName,a.`Circle Name` as CircleName,
					a.`Site ID` as siteId,
					a.`Airtel(Energy Cost)` as TotalCost,
					a.`Airtel(Energy Revenue)` as TotalRevenue,
					a.`Airtel_Min of Operator on Date ('April'20)` as OnDate,
					a.`Airtel_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(a.`UploadMonth`, 1,3),'-',SUBSTRING(a.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					a.`airtel_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` a where a.`Site ID` is  not null and a.`Airtel(Margin)` is not null";
					
$bsnlOpClause = " SELECT 'BSNL' as OperatorName,b.`Circle Name` as CircleName,
					b.`Site ID` as siteId,
					b.`BSNL(Energy Cost)` as TotalCost,
					b.`BSNL(Energy Revenue)` as TotalRevenue,
					b.`BSNL_Min of Operator on Date ('April'20)` as OnDate,
					b.`BSNL_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(b.`UploadMonth`, 1,3),'-',SUBSTRING(b.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					b.`bsnl_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` b where b.`Site ID` is  not null and b.`BSNL(Margin)` is not null";					

$rjioOpClause = " SELECT 'RJIO' as OperatorName,rj.`Circle Name` as CircleName,
					rj.`Site ID` as siteId,
					rj.`RJIO(Energy Cost)` as TotalCost,
					rj.`RJIO(Energy Revenue)` as TotalRevenue,
					rj.`RJIO_Min of Operator on Date ('April'20)` as OnDate,
					rj.`RJIO_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(rj.`UploadMonth`, 1,3),'-',SUBSTRING(rj.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					rj.`rjio_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` rj where rj.`Site ID` is  not null and rj.`RJIO(Margin)` is not null";		

$tgOpClause = " SELECT 'TTSL-GSM' as OperatorName,tg.`Circle Name` as CircleName,
					tg.`Site ID` as siteId,
					tg.`TTS-GSM (Energy Cost)` as TotalCost,
					tg.`TTS-GSM (Energy Revenue)` as TotalRevenue,
					tg.`TTSL_Min of Operator on Date ('April'20)` as OnDate,
					tg.`TTSL_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(tg.`UploadMonth`, 1,3),'-',SUBSTRING(tg.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					tg.`ttsl_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` tg where tg.`Site ID` is  not null and tg.`TTS-GSM (Margin)` is not null";		

$tcOpClause = " SELECT 'Pulse Telesystem' as OperatorName,tc.`Circle Name` as CircleName,
					tc.`Site ID` as siteId,
					tc.`TTSL-CDMA (Energy Cost)` as TotalCost,
					tc.`TTSL-CDMA (Energy Revenue)` as TotalRevenue,
					tc.`TTSL_CDMA_Min of Operator on Date ('April'20)` as OnDate,
					tc.`TTSL_CDMA_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(tc.`UploadMonth`, 1,3),'-',SUBSTRING(tc.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					tc.`ttslCdma_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` tc where tc.`Site ID` is  not null and tc.`TTSL-CDMA (Margin)` is not null";		

$ideaOpClause = " SELECT 'IDEA' as OperatorName,i.`Circle Name` as CircleName,
					i.`Site ID` as siteId,
					i.`IDEA(Energy Cost)` as TotalCost,
					i.`IDEA(Energy Revenue)` as TotalRevenue,
					i.`IDEA_Min of Operator on Date ('April'20)` as OnDate,
					i.`IDEA_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(i.`UploadMonth`, 1,3),'-',SUBSTRING(i.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					i.`idea_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` i where i.`Site ID` is  not null and i.`IDEA(Margin)` is not null";	

$vodafoneOpClause = " SELECT 'Vodafone' as OperatorName,v.`Circle Name` as CircleName,
					v.`Site ID` as siteId,
					v.`Vodafone (Energy Cost)` as TotalCost,
					v.`Vodafone (Energy Revenue)` as TotalRevenue,
					v.`Vodafone_Min of Operator on Date ('April'20)` as OnDate,
					v.`Vodafone_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(v.`UploadMonth`, 1,3),'-',SUBSTRING(v.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					v.`vodafone_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` v where v.`Site ID` is  not null and v.`Vodafone (Margin)` is not null";			

$twOpClause = " SELECT 'TCL-Wimax' as OperatorName,tw.`Circle Name` as CircleName,
					tw.`Site ID` as siteId,
					tw.`TCL-Wimax(Energy Cost)` as TotalCost,
					tw.`TCL-Wimax(Energy Revenue)` as TotalRevenue,
					tw.`TCL_Wimax_Min of Operator on Date ('April'20)` as OnDate,
					tw.`TCL_Wimax_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(tw.`UploadMonth`, 1,3),'-',SUBSTRING(tw.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					tw.`tclWimax_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` tw where tw.`Site ID` is  not null and tw.`TCL-Wimax(Margin)` is not null";

$tnOpClause = " SELECT 'TCL-NLD' as OperatorName,tn.`Circle Name` as CircleName,
					tn.`Site ID` as siteId,
					tn.`TCL-NLD (Energy Cost)` as TotalCost,
					tn.`TCL-NLD (Energy Revenue)` as TotalRevenue,
					tn.`TCL_NLD_Min of Operator on Date ('April'20)` as OnDate,
					tn.`TCL_NLD_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(tn.`UploadMonth`, 1,3),'-',SUBSTRING(tn.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					tn.`tclNld_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` tn where tn.`Site ID` is  not null and tn.`TCL-NLD (Margin)` is not null";	
					
$tiOpClause = " SELECT 'TCL-IOT' as OperatorName,ti.`Circle Name` as CircleName,
					ti.`Site ID` as siteId,
					ti.`TCL-IOT (Energy Cost)` as TotalCost,
					ti.`TCL-IOT (Energy Revenue)` as TotalRevenue,
					ti.`TCL_IOT_Min of Operator on Date ('April'20)` as OnDate,
					ti.`TCL_IOT_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(ti.`UploadMonth`, 1,3),'-',SUBSTRING(ti.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					ti.`tclIot_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` ti where ti.`Site ID` is  not null and ti.`TCL-IOT (Margin)` is not null";			

$trOpClause = " SELECT 'TCL-Redwin' as OperatorName,tr.`Circle Name` as CircleName,
					tr.`Site ID` as siteId,
					tr.`TCL-Redwin(Energy Cost)` as TotalCost,
					tr.`TCL-Redwin(Energy Revenue)` as TotalRevenue,
					tr.`TCL_Redwin_Min of Operator on Date ('April'20)` as OnDate,
					tr.`TCL_Redwin_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(tr.`UploadMonth`, 1,3),'-',SUBSTRING(tr.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					tr.`tclRedwin_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` tr where tr.`Site ID` is  not null and tr.`TCL-Redwin(Margin)` is not null";	

$sifyOpClause = " SELECT 'SIFY' as OperatorName,s.`Circle Name` as CircleName,
					s.`Site ID` as siteId,
					s.`Sify(Energy Cost)` as TotalCost,
					s.`Sify(Energy Revenue)` as TotalRevenue,
					s.`Sify_Min of Operator on Date ('April'20)` as OnDate,
					s.`Sify_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(s.`UploadMonth`, 1,3),'-',SUBSTRING(s.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					s.`sify_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` s where s.`Site ID` is  not null and s.`Sify(Margin)` is not null";						
									
$pbOpClause = " SELECT 'PB(HFCL)' as OperatorName,pb.`Circle Name` as CircleName,
					pb.`Site ID` as siteId,
					pb.`HFCL (Energy Cost)` as TotalCost,
					pb.`HFCL (Energy Revenue)` as TotalRevenue,
					pb.`PB_HFCL_Min of Operator on Date ('April'20)` as OnDate,
					pb.`PB_HFCL_Max of Billing stop Date('April'20` as OffDate,
					STR_TO_DATE(concat('01-',SUBSTRING(pb.`UploadMonth`, 1,3),'-',SUBSTRING(pb.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
					pb.`pbHfcl_Tenancy` as opTenancy
					FROM 
					`P&L Sitewise` pb where pb.`Site ID` is  not null and pb.`HFCL (Margin)` is not null";	
				
$ztsOpClause = " SELECT 'ZTS' as OperatorName,z.`Circle Name` as CircleName,
				z.`Site ID` as siteId,
				z.`ZTS Energy Cost` as TotalCost,
				z.`ZTS Energy Revenue` as TotalRevenue,
				'' as OnDate,'' as OffDate,
				STR_TO_DATE(concat('01-',SUBSTRING(z.`UploadMonth`, 1,3),'-',SUBSTRING(z.`UploadMonth`, 4,4)),'%e-%b-%y') as MonthFirstDate,
				'0' as opTenancy
				FROM 
				`P&L Sitewise` z where z.`Site ID` is  not null and z.`Operational Status` = 'ZTS'";

// if($circleNameString != ""){
	// $airtelOpClause .= " and a.`Circle Name` in ($circleNameString)";
	// $bsnlOpClause .= " and b.`Circle Name` in ($circleNameString)";
	// $rjioOpClause .= " and rj.`Circle Name` in ($circleNameString)";
	// $tgOpClause .= " and tg.`Circle Name` in ($circleNameString)";
	// $tcOpClause .= " and tc.`Circle Name` in ($circleNameString)";
	// $ideaOpClause .= " and i.`Circle Name` in ($circleNameString)";
	// $vodafoneOpClause .= " and v.`Circle Name` in ($circleNameString)";
	// $twOpClause .= " and tw.`Circle Name` in ($circleNameString)";
	// $tnOpClause .= " and tn.`Circle Name` in ($circleNameString)";
	// $tiOpClause .= " and ti.`Circle Name` in ($circleNameString)";
	// $trOpClause .= " and tr.`Circle Name` in ($circleNameString)";
	// $sifyOpClause .= " and s.`Circle Name` in ($circleNameString)";
	// $pbOpClause .= " and pb.`Circle Name` in ($circleNameString)";
	// $ztsOpClause .= " and z.`Circle Name` in ($circleNameString)";
// }	
if($periodString != ""){
	$airtelOpClause .= " and a.`UploadMonth` in ($periodString)";
	$bsnlOpClause .= " and b.`UploadMonth` in ($periodString)";
	$rjioOpClause .= " and rj.`UploadMonth` in ($periodString)";
	$tgOpClause .= " and tg.`UploadMonth` in ($periodString)";			
	$tcOpClause	.= " and tc.`UploadMonth` in ($periodString)";
	$ideaOpClause .= " and i.`UploadMonth` in ($periodString)";
	$vodafoneOpClause .= " and v.`UploadMonth` in ($periodString)";
	$twOpClause .= " and tw.`UploadMonth` in ($periodString)";
	$tnOpClause .= " and tn.`UploadMonth` in ($periodString)";
	$tiOpClause .= " and ti.`UploadMonth` in ($periodString)";
	$trOpClause .= " and tr.`UploadMonth` in ($periodString)";
	$sifyOpClause .= " and s.`UploadMonth` in ($periodString)";
	$pbOpClause .= " and pb.`UploadMonth` in ($periodString)";
	$ztsOpClause .= " and z.`UploadMonth` in ($periodString)";
}

if (strpos($operatorName, 'Airtel') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $airtelOpClause;
	}
	else{
		$operatorClause .= $unionClause.$airtelOpClause;
	}
}
if (strpos($operatorName, 'BSNL') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $bsnlOpClause;
	}
	else{
		$operatorClause .= $unionClause.$bsnlOpClause;
	}
}
if (strpos($operatorName, 'RJIO') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $rjioOpClause;
	}
	else{
		$operatorClause .= $unionClause.$rjioOpClause;
	}
}
if (strpos($operatorName, 'TTSL') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $tgOpClause;
	}
	else{
		$operatorClause .= $unionClause.$tgOpClause;
	}
}
// if (strpos($operatorName, 'TTSL_CDMA') !== false) {
//     if($operatorClause == ""){
// 		$operatorClause .= $tcOpClause;
// 	}
// 	else{
// 		$operatorClause .= $unionClause.$tcOpClause;
// 	}
// }
if (strpos($operatorName, 'Pulse_Telesystem') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $tcOpClause;
	}
	else{
		$operatorClause .= $unionClause.$tcOpClause;
	}
}
if (strpos($operatorName, 'IDEA') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $ideaOpClause;
	}
	else{
		$operatorClause .= $unionClause.$ideaOpClause;
	}
}
if (strpos($operatorName, 'Vodafone') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $vodafoneOpClause;
	}
	else{
		$operatorClause .= $unionClause.$vodafoneOpClause;
	}
}
if (strpos($operatorName, 'TCL_Wimax') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $twOpClause;
	}
	else{
		$operatorClause .= $unionClause.$twOpClause;
	}
}
if (strpos($operatorName, 'TCL_NLD') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $tnOpClause;
	}
	else{
		$operatorClause .= $unionClause.$tnOpClause;
	}
}
if (strpos($operatorName, 'TCL_IOT') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $tiOpClause;
	}
	else{
		$operatorClause .= $unionClause.$tiOpClause;
	}
}
if (strpos($operatorName, 'TCL_Redwin') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $trOpClause;
	}
	else{
		$operatorClause .= $unionClause.$trOpClause;
	}
}
if (strpos($operatorName, 'Sify') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $sifyOpClause;
	}
	else{
		$operatorClause .= $unionClause.$sifyOpClause;
	}
}
if (strpos($operatorName, 'PB_HFCL') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $pbOpClause;
	}
	else{
		$operatorClause .= $unionClause.$pbOpClause;
	}
}
if (strpos($operatorName, 'ZTS') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $ztsOpClause;
	}
	else{
		$operatorClause .= $unionClause.$ztsOpClause;
	}
}

if($operatorName == ""){
	$operatorClause .= $airtelOpClause;
	$operatorClause .= $unionClause.$bsnlOpClause;
	$operatorClause .= $unionClause.$rjioOpClause;
	$operatorClause .= $unionClause.$tgOpClause;
	$operatorClause .= $unionClause.$tcOpClause;
	$operatorClause .= $unionClause.$ideaOpClause;
	$operatorClause .= $unionClause.$vodafoneOpClause;
	$operatorClause .= $unionClause.$twOpClause;
	$operatorClause .= $unionClause.$tnOpClause;
	$operatorClause .= $unionClause.$tiOpClause;
	$operatorClause .= $unionClause.$trOpClause;
	$operatorClause .= $unionClause.$sifyOpClause;
	$operatorClause .= $unionClause.$pbOpClause;
	$operatorClause .= $unionClause.$ztsOpClause;
	
	$sql = $startClause.$operatorClause.$endClause;	
	
}
else{
	$sql = $startClause.$operatorClause.$endClause;	
}

//echo $sql;
 $conn=mysqli_connect("localhost","root","Tr!n!ty#321","TVIBilling");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
  }
$result = mysqli_query($conn,$sql);
$fieldcount=mysqli_num_fields($result);

//header info for browser
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=opcowise.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

/*******Start of Formatting for Excel*******/   

//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character

//start of printing column names as names of MySQL fields
while ($fieldinfo = $result -> fetch_field()) {
	echo $fieldinfo -> name . "\t";
}
echo "\n";    
//end of printing column names  

//start while loop to get data
while($row = mysqli_fetch_row($result))
{
	$schema_insert = "";
	for($j=0; $j < $fieldcount; $j++)
	{
		if(!isset($row[$j]))
			$schema_insert .= "NULL".$sep;
		elseif ($row[$j] != "")
			$schema_insert .= $row[$j].$sep;
		else
			$schema_insert .= "".$sep;
	}
	$schema_insert = str_replace($sep."$", "", $schema_insert);
	$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
	$schema_insert .= "\t";
	print(trim($schema_insert));
	print "\n";
} 

 
?>
