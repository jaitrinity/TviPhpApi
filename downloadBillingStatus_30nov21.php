<?php
include("dbConfiguration.php");

$resquest = file_get_contents('php://input');
$resquestData=json_decode($resquest);
$month = $resquestData->month;

$explodeMonth = explode(",", $month);

$airtelFEMSql = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$airtelFEMSql .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$airtelFEMSql .= "from (SELECT 'Airtel(FEM)' as `Console`, `Period` FROM `airtel_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Billing nature` = 'FEM' GROUP by `Period`) t GROUP BY t.`Console`";

$airtelPassthroughSql = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$airtelPassthroughSql .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$airtelPassthroughSql .= "from (SELECT 'Airtel(Passthrough)' as `Console`, `Period` FROM `airtel_output_april` where 
Period in ('".implode("','", $explodeMonth)."') and `Billing nature` = 'Passthrough' GROUP by `Period`) t GROUP BY t.`Console`";

// ---AP---
$bsnlSqlAP = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlAP .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlAP .= "from (SELECT 'BSNL(AP)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'AP' GROUP by `Period`) t GROUP BY t.`Console`";

// ---BR---
$bsnlSqlBR = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlBR .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlBR .= "from (SELECT 'BSNL(BR)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'BR' GROUP by `Period`) t GROUP BY t.`Console`";

// ---CG---
$bsnlSqlCG = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlCG .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlCG .= "from (SELECT 'BSNL(CG)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'CG' GROUP by `Period`) t GROUP BY t.`Console`";

// ---CNN---
$bsnlSqlCNN = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlCNN .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlCNN .= "from (SELECT 'BSNL(CNN)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'CNN' GROUP by `Period`) t GROUP BY t.`Console`";

// ---DL---
$bsnlSqlDL = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlDL .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlDL .= "from (SELECT 'BSNL(DL)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'DL' GROUP by `Period`) t GROUP BY t.`Console`";

// ---HP---
$bsnlSqlHP = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlHP .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlHP .= "from (SELECT 'BSNL(HP)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'HP' GROUP by `Period`) t GROUP BY t.`Console`";

// ---JH---
$bsnlSqlJH = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlJH .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlJH .= "from (SELECT 'BSNL(JH)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'JH' GROUP by `Period`) t GROUP BY t.`Console`";

// ---Karnataka---
$bsnlSqlKarnataka = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlKarnataka .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlKarnataka .= "from (SELECT 'BSNL(Karnataka)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'Karnataka' GROUP by `Period`) t GROUP BY t.`Console`";

// ---Maharashtra---
$bsnlSqlMaharashtra = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlMaharashtra .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlMaharashtra .= "from (SELECT 'BSNL(Maharashtra)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'Maharashtra' GROUP by `Period`) t GROUP BY t.`Console`";

// ---MP---
$bsnlSqlMP = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlMP .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlMP .= "from (SELECT 'BSNL(MP)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'MP' GROUP by `Period`) t GROUP BY t.`Console`";

// ---Orissa---
$bsnlSqlOrissa = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlOrissa .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlOrissa .= "from (SELECT 'BSNL(Orissa)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'Orissa' GROUP by `Period`) t GROUP BY t.`Console`";

// ---RJ---
$bsnlSqlRJ = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlRJ .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlRJ .= "from (SELECT 'BSNL(RJ)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'RJ' GROUP by `Period`) t GROUP BY t.`Console`";

// ---TG---
$bsnlSqlTG = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlTG .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlTG .= "from (SELECT 'BSNL(TG)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'TG' GROUP by `Period`) t GROUP BY t.`Console`";

// ---Tamilnadu---
$bsnlSqlTamilnadu = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlTamilnadu .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlTamilnadu .= "from (SELECT 'BSNL(Tamilnadu)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'Tamilnadu' GROUP by `Period`) t GROUP BY t.`Console`";

// ---Uttarakhand---
$bsnlSqlUttarakhand = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlUttarakhand .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlUttarakhand .= "from (SELECT 'BSNL(Uttarakhand)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'Uttarakhand' GROUP by `Period`) t GROUP BY t.`Console`";

// ---UPE---
$bsnlSqlUPE = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlUPE .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlUPE .= "from (SELECT 'BSNL(UPE)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'UPE' GROUP by `Period`) t GROUP BY t.`Console`";

// ---UPW---
$bsnlSqlUPW = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlUPW .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlUPW .= "from (SELECT 'BSNL(UPW)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'UPW' GROUP by `Period`) t GROUP BY t.`Console`";

// ---KRL---
$bsnlSqlKRL = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlKRL .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlKRL .= "from (SELECT 'BSNL(KRL)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'KRL' GROUP by `Period`) t GROUP BY t.`Console`";

// ---GJ---
$bsnlSqlGJ = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlGJ .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlGJ .= "from (SELECT 'BSNL(GJ)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'GJ' GROUP by `Period`) t GROUP BY t.`Console`";

// ---JK---
$bsnlSqlJK = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlJK .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlJK .= "from (SELECT 'BSNL(JK)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'JK' GROUP by `Period`) t GROUP BY t.`Console`";

// ---Punjab---
$bsnlSqlPunjab = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlPunjab .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlPunjab .= "from (SELECT 'BSNL(Punjab)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'Punjab' GROUP by `Period`) t GROUP BY t.`Console`";

// ---HR---
$bsnlSqlHR = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlHR .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlHR .= "from (SELECT 'BSNL(HR)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'HR' GROUP by `Period`) t GROUP BY t.`Console`";

// ---KOL---
$bsnlSqlKOL = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlKOL .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlKOL .= "from (SELECT 'BSNL(KOL)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'KOL' GROUP by `Period`) t GROUP BY t.`Console`";

// ---WB---
$bsnlSqlWB = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$bsnlSqlWB .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$bsnlSqlWB .= "from (SELECT 'BSNL(WB)' as `Console`, `Period` FROM `bsnl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
and `Circle` = 'WB' GROUP by `Period`) t GROUP BY t.`Console`";

$pbhfclSql = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$pbhfclSql .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$pbhfclSql .= "from (SELECT 'PB(HFCL)' as `Console`, `Period` FROM `pbhfcl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
GROUP by `Period`) t GROUP BY t.`Console`";

$rjioSql = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$rjioSql .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$rjioSql .= "from (SELECT 'RJIO' as `Console`, `Period` FROM `rjio_output_april` where Period in ('".implode("','", $explodeMonth)."') 
GROUP by `Period`) t GROUP BY t.`Console`";

$tclSql = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$tclSql .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$tclSql .= "from (SELECT 'TCL' as `Console`, `Period` FROM `tcl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
GROUP by `Period`) t GROUP BY t.`Console`";

$ttslSql = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$ttslSql .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$ttslSql .= "from (SELECT 'TTSL' as `Console`, `Period` FROM `ttsl_output_april` where Period in ('".implode("','", $explodeMonth)."') 
GROUP by `Period`) t GROUP BY t.`Console`";

$vilSql = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$vilSql .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$vilSql .= "from (SELECT 'VIL' as `Console`, `BillCycleMonth` as `Period` FROM `vil_output_consol` where 
`BillCycleMonth` in ('".implode("','", $explodeMonth)."') GROUP by `BillCycleMonth`) t GROUP BY t.`Console`";

$energyCostSql = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$energyCostSql .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$energyCostSql .= "from (SELECT 'Energy_Cost' as `Console`, `Period` FROM `vil_site_energy_cost` where Period in ('".implode("','", $explodeMonth)."') 
GROUP by `Period`) t GROUP BY t.`Console`";

$siteMasterSql = "select t.`Console`";
for($i=0;$i<count($explodeMonth);$i++){
	$loopMonth = $explodeMonth[$i];
	$siteMasterSql .= ", max(case when t.`Period` = '".$loopMonth."' then 'Y' else NULL end) as `".$loopMonth."`";
}
$siteMasterSql .= "from (SELECT 'Site_Master' as `Console`, `Period` FROM `vil_site_master` where Period in ('".implode("','", $explodeMonth)."') 
GROUP by `Period`) t GROUP BY t.`Console`";

$sql =   	$airtelFEMSql." UNION ".
			$airtelPassthroughSql." UNION ".
			$bsnlSqlAP." UNION ".
			$bsnlSqlBR." UNION ".
			$bsnlSqlCG." UNION ".
			$bsnlSqlCNN." UNION ".
			$bsnlSqlDL." UNION ".
			$bsnlSqlHP." UNION ".
			$bsnlSqlJH." UNION ".
			$bsnlSqlKarnataka." UNION ".
			$bsnlSqlMaharashtra." UNION ".
			$bsnlSqlMP." UNION ".
			$bsnlSqlOrissa." UNION ".
			$bsnlSqlRJ." UNION ".
			$bsnlSqlTG." UNION ".
			$bsnlSqlTamilnadu." UNION ".
			$bsnlSqlUttarakhand." UNION ".
			$bsnlSqlUPE." UNION ".
			$bsnlSqlUPW." UNION ".
			$bsnlSqlKRL." UNION ".
			$bsnlSqlGJ." UNION ".
			$bsnlSqlJK." UNION ".
			$bsnlSqlPunjab." UNION ".
			$bsnlSqlHR." UNION ".
			$bsnlSqlKOL." UNION ".
			$bsnlSqlWB." UNION ".
			$pbhfclSql." UNION ".
			$rjioSql." UNION ".
			$tclSql ." UNION ".
			$ttslSql." UNION ".
			$vilSql." UNION ".
			$energyCostSql." UNION ".
			$siteMasterSql;

$result = mysqli_query($conn,$sql); 
$tableData = [];
while($roww = mysqli_fetch_assoc($result)){
	$jsonData = new stdClass();
	foreach ($roww as $key => $value) {
		// echo $key.'-------'.$value;
		$jsonData -> $key = $value;

	}
	array_push($tableData, $jsonData);
}


$tableColumn = 'Console,'.$month;
$tableColumnList = explode(",", $tableColumn);

$output = array('tableColumnList' => $tableColumnList, 'tableData' => $tableData, 'responseDesc' => 'SUCCESSFUL', 'responseCode' => '100000' );
echo json_encode($output);

?>