<?php

function getSafeRequestValue($key){
	$val = $_REQUEST[$key];
	return isset($val)? $val:"";
}

$period = getSafeRequestValue('period');
$operatorName = getSafeRequestValue('operatorName');
$circleName = getSafeRequestValue('circleName');

$periodString = "";
//$operatorNameString = "";
$circleNameString = "";
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
if($circleName != ""){
	$circleNameArray = explode(",",$circleName);
	for($y=0;$y< count($circleNameArray);$y++){
		if($circleNameString != ""){
			$circleNameString .= ",'$circleNameArray[$y]'"; 
		}
		else{
			$circleNameString .= "'$circleNameArray[$y]'"; 
		}
	}
}
$periodClause = "";
if($period == ""){
 $periodClause = ",r1.`April`,r1.`May`,r1.`June`,r1.`July`,r1.`August`,r1.`September`,r1.`October`,r1.`November`,r1.`December`,r1.`January`,r1.`February`,r1.`March`";	
}
else{
	if (strpos($periodString, 'Apr') !== false) {
		$periodClause .= ",r1.`April`";
	}
	if (strpos($periodString, 'May') !== false) {
		$periodClause .= ",r1.`May`";
	}
	if (strpos($periodString, 'Jun') !== false) {
		$periodClause .= ",r1.`June`";
	}
	if (strpos($periodString, 'Jul') !== false) {
		$periodClause .= ",r1.`July`";
	}
	if (strpos($periodString, 'Aug') !== false) {
		$periodClause .= ",r1.`August`";
	}
	if (strpos($periodString, 'Sep') !== false) {
		$periodClause .= ",r1.`September`";
	}
	if (strpos($periodString, 'Oct') !== false) {
		$periodClause .= ",r1.`October`";
	}
	if (strpos($periodString, 'Nov') !== false) {
		$periodClause .= ",r1.`November`";
	}
	if (strpos($periodString, 'Dec') !== false) {
		$periodClause .= ",r1.`December`";
	}
	if (strpos($periodString, 'Jan') !== false) {
		$periodClause .= ",r1.`January`";
	}
	if (strpos($periodString, 'Feb') !== false) {
		$periodClause .= ",r1.`February`";
	}
	if (strpos($periodString, 'Mar') !== false) {
		$periodClause .= ",r1.`March`";
	}
}

$startClause = "Select r1.OperatorName,r1.SiteId,r1.SiteName,r1.TelecomCircleName,r1.BillingCircleName,r1.BillingState,
				'' as PassThruORFEM"
				.$periodClause
				." from
				 (Select r.SiteId,max(r.SiteName) as SiteName,max(r.TelecomCircleName) as TelecomCircleName,
				 max(( case when r.BillingCircleName is null then '' else r.BillingCircleName end )) as BillingCircleName,
				 max(( case when r.BillingState is null then '' else r.BillingState end )) as BillingState,
				 r.OperatorName,
				 max(( case when r.periodMonth = 'Apr' then r.EneryRevenue else '' end )) as April,
				 max(( case when r.periodMonth = 'May' then r.EneryRevenue else '' end )) as May,
				 max(( case when r.periodMonth = 'Jun' then r.EneryRevenue else '' end )) as June,
				 max(( case when r.periodMonth = 'Jul' then r.EneryRevenue else '' end )) as July,
				 max(( case when r.periodMonth = 'Aug' then r.EneryRevenue else '' end )) as August,
				 max(( case when r.periodMonth = 'Sep' then r.EneryRevenue else '' end )) as September,
				 max(( case when r.periodMonth = 'Oct' then r.EneryRevenue else '' end )) as October,
				 max(( case when r.periodMonth = 'Nov' then r.EneryRevenue else '' end )) as November,
				 max(( case when r.periodMonth = 'Dec' then r.EneryRevenue else '' end )) as December,
				 max(( case when r.periodMonth = 'Jan' then r.EneryRevenue else '' end )) as January,
				 max(( case when r.periodMonth = 'Feb' then r.EneryRevenue else '' end )) as February,
				 max(( case when r.periodMonth = 'Mar' then r.EneryRevenue else '' end )) as March
				 from
				 (";
$endClause = ")r group by r.SiteId,r.OperatorName) r1 ";
$operatorClause = "";
$unionClause = " UNION ";

$airtelOpClause = " Select 'Airtel' as OperatorName,a.`Site ID` as SiteId,a.`Site Name` as SiteName,a.`Circle Name` as TelecomCircleName,
					a.`Billing Circle Name` as BillingCircleName,a.`Billing State` as BillingState,
					SUBSTRING(a.`UploadMonth`, 1,3) as periodMonth,a.`Airtel(Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` a where a.`Site ID` is not null and a.`Airtel(Energy Revenue)` is not null and a.`Operational Status` != 'ZTS'";
				

$bsnlOpClause = " Select 'BSNL' as OperatorName,b.`Site ID` as SiteId,b.`Site Name` as SiteName,b.`Circle Name` as CircleName,
					b.`Billing Circle Name` as BillingCircleName,b.`Billing State` as BillingState,
					SUBSTRING(b.`UploadMonth`, 1,3) as periodMonth,
					b.`BSNL(Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` b where b.`Site ID` is not null and b.`BSNL(Energy Revenue)` is not null and b.`Operational Status` != 'ZTS'";

$rjioOpClause = " Select 'RJIO' as OperatorName,rj.`Site ID` as SiteId,rj.`Site Name` as SiteName,rj.`Circle Name` as CircleName,
					rj.`Billing Circle Name` as BillingCircleName,rj.`Billing State` as BillingState,
					SUBSTRING(rj.`UploadMonth`, 1,3) as periodMonth,
					rj.`RJIO(Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` rj where rj.`Site ID` is not null and rj.`RJIO(Energy Revenue)` is not null and rj.`Operational Status` != 'ZTS'";

$tgOpClause = " Select 'TTSL-GSM' as OperatorName,tg.`Site ID` as SiteId,tg.`Site Name` as SiteName,tg.`Circle Name` as CircleName,
					tg.`Billing Circle Name` as BillingCircleName,tg.`Billing State` as BillingState,
					 SUBSTRING(tg.`UploadMonth`, 1,3) as periodMonth,
					tg.`TTS-GSM (Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` tg where tg.`Site ID` is not null and tg.`TTS-GSM (Energy Revenue)` is not null and tg.`Operational Status` != 'ZTS'";
				
$tcOpClause = " Select 'TTSL-CDMA' as OperatorName,tc.`Site ID` as SiteId,tc.`Site Name` as SiteName,tc.`Circle Name` as CircleName,
					tc.`Billing Circle Name` as BillingCircleName,tc.`Billing State` as BillingState,
					SUBSTRING(tc.`UploadMonth`, 1,3) as periodMonth,
					tc.`TTSL-CDMA (Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` tc where tc.`Site ID` is not null and tc.`TTSL-CDMA (Energy Revenue)` is not null and tc.`Operational Status` != 'ZTS'";
				
$ideaOpClause = " Select 'IDEA' as OperatorName,i.`Site ID` as SiteId,i.`Site Name` as SiteName,i.`Circle Name` as CircleName,
					i.`Billing Circle Name` as BillingCircleName,i.`Billing State` as BillingState,
					 SUBSTRING(i.`UploadMonth`, 1,3) as periodMonth,
					i.`IDEA(Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` i where i.`Site ID` is not null and i.`IDEA(Energy Revenue)` and i.`Operational Status` != 'ZTS'";

$vodafoneOpClause = " Select 'Vodafone' as OperatorName,v.`Site ID` as SiteId,v.`Site Name` as SiteName,v.`Circle Name` as CircleName,
					v.`Billing Circle Name` as BillingCircleName,v.`Billing State` as BillingState,
					 SUBSTRING(v.`UploadMonth`, 1,3) as periodMonth,
					v.`Vodafone (Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` v where v.`Site ID` is not null and v.`Vodafone (Energy Revenue)` is not null and v.`Operational Status` != 'ZTS'";
					
$twOpClause = " Select 'TCL-Wimax' as OperatorName,tw.`Site ID` as SiteId,tw.`Site Name` as SiteName,tw.`Circle Name` as CircleName,
					tw.`Billing Circle Name` as BillingCircleName,tw.`Billing State` as BillingState,
					 SUBSTRING(tw.`UploadMonth`, 1,3) as periodMonth,
					tw.`TCL-Wimax(Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` tw where tw.`Site ID` is not null and tw.`TCL-Wimax(Energy Revenue)` is not null and tw.`Operational Status` != 'ZTS'";
				
$tnOpClause = " Select 'TCL-NLD' as OperatorName,tn.`Site ID` as SiteId,tn.`Site Name` as SiteName,tn.`Circle Name` as CircleName,
					tn.`Billing Circle Name` as BillingCircleName,tn.`Billing State` as BillingState,
					SUBSTRING(tn.`UploadMonth`, 1,3) as periodMonth,
					tn.`TCL-NLD (Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` tn where tn.`Site ID` is not null and tn.`TCL-NLD (Energy Revenue)` is not null and tn.`Operational Status` != 'ZTS'";
				
$tiOpClause = " Select 'TCL-IOT' as OperatorName,ti.`Site ID` as SiteId,ti.`Site Name` as SiteName,ti.`Circle Name` as CircleName,
					ti.`Billing Circle Name` as BillingCircleName,ti.`Billing State` as BillingState,
					SUBSTRING(ti.`UploadMonth`, 1,3) as periodMonth,
					ti.`TCL-IOT (Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` ti where ti.`Site ID` is not null and ti.`TCL-IOT (Energy Revenue)` is not null and ti.`Operational Status` != 'ZTS'";

$trOpClause = " Select 'TCL-Redwin' as OperatorName,tr.`Site ID` as SiteId,tr.`Site Name` as SiteName,tr.`Circle Name` as CircleName,
					tr.`Billing Circle Name` as BillingCircleName,tr.`Billing State` as BillingState,
					SUBSTRING(tr.`UploadMonth`, 1,3) as periodMonth,
					tr.`TCL-Redwin(Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` tr where tr.`Site ID` is not null and tr.`TCL-Redwin(Energy Revenue)` is not null and tr.`Operational Status` != 'ZTS'";
				
$sifyOpClause = " Select 'SIFY' as OperatorName,s.`Site ID` as SiteId,s.`Site Name` as SiteName,s.`Circle Name` as CircleName,
					s.`Billing Circle Name` as BillingCircleName,s.`Billing State` as BillingState,
					SUBSTRING(s.`UploadMonth`, 1,3) as periodMonth,
					s.`Sify(Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` s where s.`Site ID` is not null and s.`Sify(Energy Revenue)` is not null and s.`Operational Status` != 'ZTS'";

$pbOpClause = " Select 'PB(HFCL)' as OperatorName,pb.`Site ID` as SiteId,pb.`Site Name` as SiteName,pb.`Circle Name` as CircleName,
					pb.`Billing Circle Name` as BillingCircleName,pb.`Billing State` as BillingState,
					SUBSTRING(pb.`UploadMonth`, 1,3) as periodMonth,
					pb.`HFCL (Energy Revenue)` as EneryRevenue
					from `P&L Sitewise` pb where pb.`Site ID` is not null and pb.`HFCL (Energy Revenue)` is not null and pb.`Operational Status` != 'ZTS'";					
					

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
}
if($circleNameString != ""){
	$airtelOpClause .= " and a.`Circle Name` in ($circleNameString)";
	$bsnlOpClause .= " and b.`Circle Name` in ($circleNameString)";
	$rjioOpClause .= " and rj.`Circle Name` in ($circleNameString)";
	$tgOpClause .= " and tg.`Circle Name` in ($circleNameString)";
	$tcOpClause .= " and tc.`Circle Name` in ($circleNameString)";
	$ideaOpClause .= " and i.`Circle Name` in ($circleNameString)";
	$vodafoneOpClause .= " and v.`Circle Name` in ($circleNameString)";
	$twOpClause .= " and tw.`Circle Name` in ($circleNameString)";
	$tnOpClause .= " and tn.`Circle Name` in ($circleNameString)";
	$tiOpClause .= " and ti.`Circle Name` in ($circleNameString)";
	$trOpClause .= " and tr.`Circle Name` in ($circleNameString)";
	$sifyOpClause .= " and s.`Circle Name` in ($circleNameString)";
	$pbOpClause .= " and pb.`Circle Name` in ($circleNameString)";
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
if (strpos($operatorName, 'TTSL_CDMA') !== false) {
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
if (strpos($operatorName, 'PB(HFCL)') !== false) {
    if($operatorClause == ""){
		$operatorClause .= $pbOpClause;
	}
	else{
		$operatorClause .= $unionClause.$pbOpClause;
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
	
	$sql = $startClause.$operatorClause.$endClause;	
}
else{
	$sql = $startClause.$operatorClause.$endClause;	
}

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
header("Content-Disposition: attachment; filename=MissingBillingPeriodReport.xls");  
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
