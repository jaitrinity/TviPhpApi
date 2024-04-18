<?php 
include("cpDbConfig_db.php");
include(dirname(__DIR__).'/PHPMailerAutoload.php');
$yesterdayDate = date('Y-m-d', strtotime('-1 day'));
$ddMmmYyyy = date('d-M-Y', strtotime($yesterdayDate));
$textAlign = "style='text-align:right'";
$fontFamily = 'font-family: "Times New Roman", Times, serif';

$msg = "Please find SR Dashboard of $ddMmmYyyy.";
$msg .= "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>Pending - Macro Anchor</h2>";
$msg .= "<table border=1 cellpadding=5 cellspacing=0 style='$fontFamily;font-size:12px'>
					<thead>
						<tr style='background-color:#2E57A7;color:white'>
							<th>Circle_Name</th>
							<th>Acquisition</th>
							<th>DEPLOYMENT</th>
							<th>HO_LEGAL</th>
							<th>HO_PROJECT_CIVIL</th>
							<th>HO_PROJECT_EB</th>
							<th>HO_RA</th>
							<th>HO_RF_PLANNING</th>
							<th>HO_S&M</th>
							<th>HO_SnM_AT</th>
							<th>HO_Technical</th>
							<th>OPCO</th>
							<th>RBH</th>
							<th>S&M</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>";

$pendingSql = "select t1.*, (IFNULL(t1.Acquisition,0) + IFNULL(t1.DEPLOYMENT,0) + IFNULL(t1.HO_LEGAL,0) + IFNULL(t1.HO_PROJECT_CIVIL,0) + IFNULL(t1.HO_PROJECT_EB,0) + IFNULL(t1.HO_RA,0) + IFNULL(t1.HO_RF_PLANNING,0) + IFNULL(t1.`HO_S&M`,0) + IFNULL(t1.HO_SnM_AT,0) + IFNULL(t1.HO_Technical,0) + IFNULL(t1.OPCO,0) + IFNULL(t1.RBH,0) + IFNULL(t1.`S&M`,0)) as `Total` from (Select t.Circle_Name, max(case when t.DESCRIPTION = 'Acquisition' then t.PendingCount end) as `Acquisition`, max(case when t.DESCRIPTION = 'DEPLOYMENT' then t.PendingCount end) as `DEPLOYMENT`, max(case when t.DESCRIPTION = 'HO_LEGAL' then t.PendingCount end) as `HO_LEGAL`, max(case when t.DESCRIPTION = 'HO_PROJECT_CIVIL' then t.PendingCount end) as `HO_PROJECT_CIVIL`, max(case when t.DESCRIPTION = 'HO_PROJECT_EB' then t.PendingCount end) as `HO_PROJECT_EB`, max(case when t.DESCRIPTION = 'HO_RA' then t.PendingCount end) as `HO_RA`, max(case when t.DESCRIPTION = 'HO_RF_PLANNING' then t.PendingCount end) as `HO_RF_PLANNING`, max(case when t.DESCRIPTION = 'HO_S&M' then t.PendingCount end) as `HO_S&M`, max(case when t.DESCRIPTION = 'HO_SnM_AT' then t.PendingCount end) as `HO_SnM_AT`, max(case when t.DESCRIPTION = 'HO_Technical' then t.PendingCount end) as `HO_Technical`, max(case when t.DESCRIPTION = 'OPCO' then t.PendingCount end) as `OPCO`, max(case when t.DESCRIPTION = 'RBH' then t.PendingCount end) as `RBH`, max(case when t.DESCRIPTION = 'S&M' then t.PendingCount end) as `S&M` from (SELECT h.Circle_Name, s.DESCRIPTION, count(s.DESCRIPTION) as PendingCount FROM NBS_MASTER_HDR h join NBS_STATUS s on h.STATUS = s.STATUS and h.TAB_NAME = s.TAB_NAME and h.TAB_NAME = 'CreateNBS' and s.DESCRIPTION not in ('Closed NBS') GROUP by s.DESCRIPTION, h.Circle_Name order by h.CIRCLE_NAME) t group by t.Circle_Name) t1
UNION
Select 'Total' as `Circle_Name`, sum(t.Acquisition) as `Acquisition`, sum(t.DEPLOYMENT) as `DEPLOYMENT`, sum(t.HO_LEGAL) as `HO_LEGAL`, sum(t.HO_PROJECT_CIVIL) as `HO_PROJECT_CIVIL`, sum(t.HO_PROJECT_EB) as `HO_PROJECT_EB`, sum(t.HO_RA) as `HO_RA`, sum(t.HO_RF_PLANNING) as `HO_RF_PLANNING`, sum(t.`HO_S&M`) as `HO_S&M`, sum(t.HO_SnM_AT) as `HO_SnM_AT`, sum(t.HO_Technical) as `HO_Technical`, sum(t.OPCO) as `OPCO`, sum(t.RBH) as `RBH`, sum(t.`S&M`) as `S&M`, '-' as `Total` from (Select t.Circle_Name, max(case when t.DESCRIPTION = 'Acquisition' then t.PendingCount end) as `Acquisition`, max(case when t.DESCRIPTION = 'DEPLOYMENT' then t.PendingCount end) as `DEPLOYMENT`, max(case when t.DESCRIPTION = 'HO_LEGAL' then t.PendingCount end) as `HO_LEGAL`, max(case when t.DESCRIPTION = 'HO_PROJECT_CIVIL' then t.PendingCount end) as `HO_PROJECT_CIVIL`, max(case when t.DESCRIPTION = 'HO_PROJECT_EB' then t.PendingCount end) as `HO_PROJECT_EB`, max(case when t.DESCRIPTION = 'HO_RA' then t.PendingCount end) as `HO_RA`, max(case when t.DESCRIPTION = 'HO_RF_PLANNING' then t.PendingCount end) as `HO_RF_PLANNING`, max(case when t.DESCRIPTION = 'HO_S&M' then t.PendingCount end) as `HO_S&M`, max(case when t.DESCRIPTION = 'HO_SnM_AT' then t.PendingCount end) as `HO_SnM_AT`, max(case when t.DESCRIPTION = 'HO_Technical' then t.PendingCount end) as `HO_Technical`, max(case when t.DESCRIPTION = 'OPCO' then t.PendingCount end) as `OPCO`, max(case when t.DESCRIPTION = 'RBH' then t.PendingCount end) as `RBH`, max(case when t.DESCRIPTION = 'S&M' then t.PendingCount end) as `S&M` from (SELECT h.Circle_Name, s.DESCRIPTION, count(s.DESCRIPTION) as PendingCount FROM NBS_MASTER_HDR h join NBS_STATUS s on h.STATUS = s.STATUS and h.TAB_NAME = s.TAB_NAME and h.TAB_NAME = 'CreateNBS' and s.DESCRIPTION not in ('Closed NBS') GROUP by s.DESCRIPTION, h.Circle_Name order by h.CIRCLE_NAME) t group by t.Circle_Name) t";
$pendingResult = mysqli_query($conn,$pendingSql);	
while($pendingRow = mysqli_fetch_assoc($pendingResult)){
	$circleName = $pendingRow["Circle_Name"];
	$grRowClass = $circleName == 'Total' ? "style='font-weight:bold'" : "";
	$msg .= "<tr $grRowClass>
				<td>".$pendingRow["Circle_Name"]."</td>
				<td $textAlign>".sendZero($pendingRow["Acquisition"])."</td>
				<td $textAlign>".sendZero($pendingRow["DEPLOYMENT"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_LEGAL"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_PROJECT_CIVIL"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_PROJECT_EB"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_RA"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_RF_PLANNING"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_S&M"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_SnM_AT"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_Technical"])."</td>
				<td $textAlign>".sendZero($pendingRow["OPCO"])."</td>
				<td $textAlign>".sendZero($pendingRow["RBH"])."</td>
				<td $textAlign>".sendZero($pendingRow["S&M"])."</td>
				<td style='text-align:right;font-weight:bold'>".sendZero($pendingRow["Total"])."</td>
			</tr>";
}
$msg .= "</tbody>
	</table>";
// $msg .= "<br>";

$msg .= "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>Pending - HPSC Anchor</h2>";
$msg .= "<table border=1 cellpadding=5 cellspacing=0 style='$fontFamily;font-size:12px'>
					<thead>
						<tr style='background-color:#2E57A7;color:white'>
							<th>Circle_Name</th>
							<th>Acquisition</th>
							<th>DEPLOYMENT</th>
							<th>HO_LEGAL</th>
							<th>HO_RA</th>
							<th>HO_RF_PLANNING</th>
							<th>HO_S&M</th>
							<th>HO_SnM_AT</th>
							<th>HO_Technical</th>
							<th>OPCO</th>
							<th>RBH</th>
							<th>S&M</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>";

$pendingSql = "Select t1.*, (IFNULL(t1.Acquisition,0) + IFNULL(t1.DEPLOYMENT,0) + IFNULL(t1.HO_LEGAL,0) + IFNULL(t1.HO_PROJECT_CIVIL,0) + IFNULL(t1.HO_PROJECT_EB,0) + IFNULL(t1.HO_PROJECT_HEAD,0) + IFNULL(t1.HO_RA,0) + IFNULL(t1.HO_RF_PLANNING,0) + IFNULL(t1.`HO_S&M`,0) + IFNULL(t1.HO_SnM_AT,0) + IFNULL(t1.HO_Technical,0) + IFNULL(t1.OPCO,0) + IFNULL(t1.RBH,0) + IFNULL(t1.`S&M`,0)) as `Total` from (Select t.Circle_Name, max(case when t.DESCRIPTION = 'Acquisition' then t.PendingCount end) as `Acquisition`, max(case when t.DESCRIPTION = 'DEPLOYMENT' then t.PendingCount end) as `DEPLOYMENT`, max(case when t.DESCRIPTION = 'HO_LEGAL' then t.PendingCount end) as `HO_LEGAL`, max(case when t.DESCRIPTION = 'HO_PROJECT_CIVIL' then t.PendingCount end) as `HO_PROJECT_CIVIL`, max(case when t.DESCRIPTION = 'HO_PROJECT_EB' then t.PendingCount end) as `HO_PROJECT_EB`, max(case when t.DESCRIPTION = 'HO_PROJECT_HEAD' then t.PendingCount end) as `HO_PROJECT_HEAD`, max(case when t.DESCRIPTION = 'HO_RA' then t.PendingCount end) as `HO_RA`, max(case when t.DESCRIPTION = 'HO_RF_PLANNING' then t.PendingCount end) as `HO_RF_PLANNING`, max(case when t.DESCRIPTION = 'HO_S&M' then t.PendingCount end) as `HO_S&M`, max(case when t.DESCRIPTION = 'HO_SnM_AT' then t.PendingCount end) as `HO_SnM_AT`, max(case when t.DESCRIPTION = 'HO_Technical' then t.PendingCount end) as `HO_Technical`, max(case when t.DESCRIPTION = 'OPCO' then t.PendingCount end) as `OPCO`, max(case when t.DESCRIPTION = 'RBH' then t.PendingCount end) as `RBH`, max(case when t.DESCRIPTION = 'S&M' then t.PendingCount end) as `S&M` from (SELECT h.Circle_Name, s.DESCRIPTION, count(s.DESCRIPTION) as PendingCount FROM NBS_MASTER_HDR h join NBS_STATUS s on h.STATUS = s.STATUS and h.TAB_NAME = s.TAB_NAME and h.TAB_NAME = 'HPSC' and s.DESCRIPTION not in ('Closed NBS') GROUP by s.DESCRIPTION, h.Circle_Name order by h.CIRCLE_NAME) t group by t.Circle_Name) t1
UNION
Select 'Total' as Circle_Name, sum(t1.Acquisition) as Acquisition, sum(t1.DEPLOYMENT) as DEPLOYMENT, sum(t1.HO_LEGAL) as HO_LEGAL, sum(t1.HO_PROJECT_CIVIL) as HO_PROJECT_CIVIL, sum(t1.HO_PROJECT_EB) as HO_PROJECT_EB, sum(t1.HO_PROJECT_HEAD) as HO_PROJECT_HEAD, sum(t1.HO_RA) as HO_RA, sum(t1.HO_RF_PLANNING) as HO_RF_PLANNING, sum(t1.`HO_S&M`) as `HO_S&M`, sum(t1.HO_SnM_AT) as HO_SnM_AT, sum(t1.HO_Technical) as HO_Technical, sum(t1.OPCO) as OPCO, sum(t1.RBH) as RBH, sum(t1.`S&M`) as `S&M`, '-' as `Total` from (Select t.Circle_Name, max(case when t.DESCRIPTION = 'Acquisition' then t.PendingCount end) as `Acquisition`, max(case when t.DESCRIPTION = 'DEPLOYMENT' then t.PendingCount end) as `DEPLOYMENT`, max(case when t.DESCRIPTION = 'HO_LEGAL' then t.PendingCount end) as `HO_LEGAL`, max(case when t.DESCRIPTION = 'HO_PROJECT_CIVIL' then t.PendingCount end) as `HO_PROJECT_CIVIL`, max(case when t.DESCRIPTION = 'HO_PROJECT_EB' then t.PendingCount end) as `HO_PROJECT_EB`, max(case when t.DESCRIPTION = 'HO_PROJECT_HEAD' then t.PendingCount end) as `HO_PROJECT_HEAD`, max(case when t.DESCRIPTION = 'HO_RA' then t.PendingCount end) as `HO_RA`, max(case when t.DESCRIPTION = 'HO_RF_PLANNING' then t.PendingCount end) as `HO_RF_PLANNING`, max(case when t.DESCRIPTION = 'HO_S&M' then t.PendingCount end) as `HO_S&M`, max(case when t.DESCRIPTION = 'HO_SnM_AT' then t.PendingCount end) as `HO_SnM_AT`, max(case when t.DESCRIPTION = 'HO_Technical' then t.PendingCount end) as `HO_Technical`, max(case when t.DESCRIPTION = 'OPCO' then t.PendingCount end) as `OPCO`, max(case when t.DESCRIPTION = 'RBH' then t.PendingCount end) as `RBH`, max(case when t.DESCRIPTION = 'S&M' then t.PendingCount end) as `S&M` from (SELECT h.Circle_Name, s.DESCRIPTION, count(s.DESCRIPTION) as PendingCount FROM NBS_MASTER_HDR h join NBS_STATUS s on h.STATUS = s.STATUS and h.TAB_NAME = s.TAB_NAME and h.TAB_NAME = 'HPSC' and s.DESCRIPTION not in ('Closed NBS') GROUP by s.DESCRIPTION, h.Circle_Name order by h.CIRCLE_NAME) t group by t.Circle_Name) t1";
$pendingResult = mysqli_query($conn,$pendingSql);	
while($pendingRow = mysqli_fetch_assoc($pendingResult)){
	$circleName = $pendingRow["Circle_Name"];
	$grRowClass = $circleName == 'Total' ? "style='font-weight:bold'" : "";
	$msg .= "<tr $grRowClass>
				<td>".$pendingRow["Circle_Name"]."</td>
				<td $textAlign>".sendZero($pendingRow["Acquisition"])."</td>
				<td $textAlign>".sendZero($pendingRow["DEPLOYMENT"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_LEGAL"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_RA"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_RF_PLANNING"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_S&M"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_SnM_AT"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_Technical"])."</td>
				<td $textAlign>".sendZero($pendingRow["OPCO"])."</td>
				<td $textAlign>".sendZero($pendingRow["RBH"])."</td>
				<td $textAlign>".sendZero($pendingRow["S&M"])."</td>
				<td style='text-align:right;font-weight:bold'>".sendZero($pendingRow["Total"])."</td>
			</tr>";
}
$msg .= "</tbody>
	</table>";
// $msg .= "<br>";

$msg .= "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>Pending - New Tenency</h2>";
$msg .= "<table border=1 cellpadding=5 cellspacing=0 style='$fontFamily;font-size:12px'>
					<thead>
						<tr style='background-color:#2E57A7;color:white'>
							<th>Circle_Name</th>
							<th>DEPLOYMENT</th>
							<th>HO_PROJECT_HEAD</th>
							<th>HO_RA</th>
							<th>HO_S&M</th>
							<th>HO_SnM_AT</th>
							<th>HO_Technical</th>
							<th>OPCO</th>
							<th>S&M</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>";

$pendingSql = "Select t1.*, (IFNULL(t1.DEPLOYMENT,0) + IFNULL(t1.HO_PROJECT_HEAD,0) + IFNULL(t1.HO_RA,0) + IFNULL(t1.`HO_S&M`,0) + IFNULL(t1.HO_SnM_AT,0) + IFNULL(t1.HO_Technical,0) + IFNULL(t1.OPCO,0) + IFNULL(t1.`S&M`,0)) as `Total` from (Select t.Circle_Name, max(case when t.DESCRIPTION = 'DEPLOYMENT' then t.PendingCount end) as `DEPLOYMENT`, max(case when t.DESCRIPTION = 'HO_PROJECT_HEAD' then t.PendingCount end) as `HO_PROJECT_HEAD`, max(case when t.DESCRIPTION = 'HO_RA' then t.PendingCount end) as `HO_RA`, max(case when t.DESCRIPTION = 'HO_S&M' then t.PendingCount end) as `HO_S&M`, max(case when t.DESCRIPTION = 'HO_SnM_AT' then t.PendingCount end) as `HO_SnM_AT`, max(case when t.DESCRIPTION = 'HO_Technical' then t.PendingCount end) as `HO_Technical`, max(case when t.DESCRIPTION = 'OPCO' then t.PendingCount end) as `OPCO`, max(case when t.DESCRIPTION = 'S&M' then t.PendingCount end) as `S&M` from (SELECT h.Circle_Name, s.DESCRIPTION, count(s.DESCRIPTION) as PendingCount FROM NBS_MASTER_HDR h join NBS_STATUS s on h.STATUS = s.STATUS and h.TAB_NAME = s.TAB_NAME and h.TAB_NAME = 'New_Tenency' and s.DESCRIPTION not in ('Closed NBS') GROUP by s.DESCRIPTION, h.Circle_Name order by h.CIRCLE_NAME) t group by t.Circle_Name) t1
UNION
Select 'Total' as `Circle_Name`, sum(t1.DEPLOYMENT) as `DEPLOYMENT`, sum(t1.HO_PROJECT_HEAD) as HO_PROJECT_HEAD, sum(t1.HO_RA) as HO_RA, sum(t1.`HO_S&M`) as `HO_S&M`, sum(t1.HO_SnM_AT) as `HO_SnM_AT`, sum(t1.HO_Technical) as HO_Technical, sum(t1.OPCO) as `OPCO`, sum(t1.`S&M`) as `S&M`, '-' as `Total` from (Select t.Circle_Name, max(case when t.DESCRIPTION = 'DEPLOYMENT' then t.PendingCount end) as `DEPLOYMENT`, max(case when t.DESCRIPTION = 'HO_PROJECT_HEAD' then t.PendingCount end) as `HO_PROJECT_HEAD`, max(case when t.DESCRIPTION = 'HO_RA' then t.PendingCount end) as `HO_RA`, max(case when t.DESCRIPTION = 'HO_S&M' then t.PendingCount end) as `HO_S&M`, max(case when t.DESCRIPTION = 'HO_SnM_AT' then t.PendingCount end) as `HO_SnM_AT`, max(case when t.DESCRIPTION = 'HO_Technical' then t.PendingCount end) as `HO_Technical`, max(case when t.DESCRIPTION = 'OPCO' then t.PendingCount end) as `OPCO`, max(case when t.DESCRIPTION = 'S&M' then t.PendingCount end) as `S&M` from (SELECT h.Circle_Name, s.DESCRIPTION, count(s.DESCRIPTION) as PendingCount FROM NBS_MASTER_HDR h join NBS_STATUS s on h.STATUS = s.STATUS and h.TAB_NAME = s.TAB_NAME and h.TAB_NAME = 'New_Tenency' and s.DESCRIPTION not in ('Closed NBS') GROUP by s.DESCRIPTION, h.Circle_Name order by h.CIRCLE_NAME) t group by t.Circle_Name) t1";
$pendingResult = mysqli_query($conn,$pendingSql);	
while($pendingRow = mysqli_fetch_assoc($pendingResult)){
	$circleName = $pendingRow["Circle_Name"];
	$grRowClass = $circleName == 'Total' ? "style='font-weight:bold'" : "";
	$msg .= "<tr $grRowClass>
				<td>".$pendingRow["Circle_Name"]."</td>
				<td $textAlign>".sendZero($pendingRow["DEPLOYMENT"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_PROJECT_HEAD"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_RA"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_S&M"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_SnM_AT"])."</td>
				<td $textAlign>".sendZero($pendingRow["HO_Technical"])."</td>
				<td $textAlign>".sendZero($pendingRow["OPCO"])."</td>
				<td $textAlign>".sendZero($pendingRow["S&M"])."</td>
				<td style='text-align:right;font-weight:bold'>".sendZero($pendingRow["Total"])."</td>
			</tr>";
}
$msg .= "</tbody>
	</table>";
// $msg .= "<br>";

$tableHdr = "<table border=1 cellpadding=5 cellspacing=0 style='$fontFamily;font-size:12px'>
			<thead>
				<tr style='background-color:#2E57A7;color:white'>
					<th>Circle_Name</th>
					<th>count_of_SR</th>
					<th>count_of_SP</th>
					<th>count_of_SO</th>
					<th>count_of_RFI</th>
					<th>count_of_RFI_Accepted</th>
					<th>count_of_RFS</th>
				</tr>
			</thead>
			<tbody>";

$msg .= "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>$ddMmmYyyy - Macro Anchor</h2>";
$msg .= $tableHdr;
$sql = "SELECT CIRCLE_NAME, sum(case when SR_DATE = '$yesterdayDate' then 1 else 0 end) count_of_SR, sum(case when SP_DATE = '$yesterdayDate' then 1 else 0 end) count_of_SP, sum(case when SO_DATE = '$yesterdayDate' then 1 else 0 end) count_of_SO, sum(case when RFI_DATE = '$yesterdayDate' then 1 else 0 end) count_of_RFI, sum(case when RFI_ACCEPTED_DATE = '$yesterdayDate' then 1 else 0 end) count_of_RFI_Accepted, sum(case when RFS_DATE = '$yesterdayDate' then 1 else 0 end) count_of_RFS FROM NBS_MASTER_HDR where TAB_NAME = 'CreateNBS' GROUP by CIRCLE_NAME
UNION
select 'Grand Total' as CIRCLE_NAME, sum(t.SR_Count) count_of_SR, sum(t.SP_Count) count_of_SP, sum(t.SO_Count) count_of_SO, sum(t.RFI_Count) count_of_RFI, 
		sum(t.RFI_Accepted_Count) count_of_RFI_Accepted, sum(t.RFS_Count) count_of_RFS from (SELECT CIRCLE_NAME, sum(case when SR_DATE = '$yesterdayDate' then 1 else 0 end) SR_Count, sum(case when SP_DATE = '$yesterdayDate' then 1 else 0 end) SP_Count, sum(case when SO_DATE = '$yesterdayDate' then 1 else 0 end) SO_Count, sum(case when RFI_DATE = '$yesterdayDate' then 1 else 0 end) RFI_Count, sum(case when RFI_ACCEPTED_DATE = '$yesterdayDate' then 1 else 0 end) RFI_Accepted_Count, sum(case when RFS_DATE = '$yesterdayDate' then 1 else 0 end) RFS_Count FROM NBS_MASTER_HDR where TAB_NAME = 'CreateNBS' GROUP by CIRCLE_NAME) t";
$result = mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	$circleName = $row["CIRCLE_NAME"];
	$srCount = $row["count_of_SR"];
	$spCount = $row["count_of_SP"];
	$soCount = $row["count_of_SO"];
	$rfiCount = $row["count_of_RFI"];
	$rfiAcceptedCount = $row["count_of_RFI_Accepted"];
	$rfsCount = $row["count_of_RFS"];

	$grRowClass = $circleName == 'Grand Total' ? "style='font-weight:bold'" : "";
	// $srClass = $srCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $spClass = $spCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $soClass = $soCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfiClass = $rfiCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfiAcceptedClass = $rfiAcceptedCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfsClass = $rfsCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";

	$msg .= "<tr $grRowClass>
				<td>".$row["CIRCLE_NAME"]."</td>
				<td $textAlign>".$row["count_of_SR"]."</td>
				<td $textAlign>".$row["count_of_SP"]."</td>
				<td $textAlign>".$row["count_of_SO"]."</td>
				<td $textAlign>".$row["count_of_RFI"]."</td>
				<td $textAlign>".$row["count_of_RFI_Accepted"]."</td>
				<td $textAlign>".$row["count_of_RFS"]."</td>
			</tr>";
}
$msg .= "</tbody>
	</table>";

// $msg .= "<br>";

$msg .= "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>$ddMmmYyyy - New Tenency</h2>";
$msg .= $tableHdr;
$sql = "SELECT CIRCLE_NAME, sum(case when SR_DATE = '$yesterdayDate' then 1 else 0 end) count_of_SR, sum(case when SP_DATE = '$yesterdayDate' then 1 else 0 end) count_of_SP, sum(case when SO_DATE = '$yesterdayDate' then 1 else 0 end) count_of_SO, sum(case when RFI_DATE = '$yesterdayDate' then 1 else 0 end) count_of_RFI, sum(case when RFI_ACCEPTED_DATE = '$yesterdayDate' then 1 else 0 end) count_of_RFI_Accepted, sum(case when RFS_DATE = '$yesterdayDate' then 1 else 0 end) count_of_RFS FROM NBS_MASTER_HDR where TAB_NAME = 'New_Tenency' GROUP by CIRCLE_NAME
UNION
select 'Grand Total' as CIRCLE_NAME, sum(t.SR_Count) count_of_SR, sum(t.SP_Count) count_of_SP, sum(t.SO_Count) count_of_SO, sum(t.RFI_Count) count_of_RFI, 
		sum(t.RFI_Accepted_Count) count_of_RFI_Accepted, sum(t.RFS_Count) count_of_RFS from (SELECT CIRCLE_NAME, sum(case when SR_DATE = '$yesterdayDate' then 1 else 0 end) SR_Count, sum(case when SP_DATE = '$yesterdayDate' then 1 else 0 end) SP_Count, sum(case when SO_DATE = '$yesterdayDate' then 1 else 0 end) SO_Count, sum(case when RFI_DATE = '$yesterdayDate' then 1 else 0 end) RFI_Count, sum(case when RFI_ACCEPTED_DATE = '$yesterdayDate' then 1 else 0 end) RFI_Accepted_Count, sum(case when RFS_DATE = '$yesterdayDate' then 1 else 0 end) RFS_Count FROM NBS_MASTER_HDR where TAB_NAME = 'New_Tenency' GROUP by CIRCLE_NAME) t";
$result = mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	$circleName = $row["CIRCLE_NAME"];
	$srCount = $row["count_of_SR"];
	$spCount = $row["count_of_SP"];
	$soCount = $row["count_of_SO"];
	$rfiCount = $row["count_of_RFI"];
	$rfiAcceptedCount = $row["count_of_RFI_Accepted"];
	$rfsCount = $row["count_of_RFS"];

	$grRowClass = $circleName == 'Grand Total' ? "style='font-weight:bold'" : "";
	// $srClass = $srCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $spClass = $spCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $soClass = $soCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfiClass = $rfiCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfiAcceptedClass = $rfiAcceptedCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfsClass = $rfsCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";

	$msg .= "<tr $grRowClass>
				<td>".$row["CIRCLE_NAME"]."</td>
				<td $textAlign>".$row["count_of_SR"]."</td>
				<td $textAlign>".$row["count_of_SP"]."</td>
				<td $textAlign>".$row["count_of_SO"]."</td>
				<td $textAlign>".$row["count_of_RFI"]."</td>
				<td $textAlign>".$row["count_of_RFI_Accepted"]."</td>
				<td $textAlign>".$row["count_of_RFS"]."</td>
			</tr>";
}
$msg .= "</tbody>
	</table>";

// $msg .= "<br>";

$msg .= "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>$ddMmmYyyy - Site Upgrade</h2>";
$msg .= $tableHdr;
$sql = "SELECT CIRCLE_NAME, sum(case when SR_DATE = '$yesterdayDate' then 1 else 0 end) count_of_SR, sum(case when SP_DATE = '$yesterdayDate' then 1 else 0 end) count_of_SP, sum(case when SO_DATE = '$yesterdayDate' then 1 else 0 end) count_of_SO, sum(case when RFI_DATE = '$yesterdayDate' then 1 else 0 end) count_of_RFI, sum(case when RFI_ACCEPTED_DATE = '$yesterdayDate' then 1 else 0 end) count_of_RFI_Accepted, sum(case when RFS_DATE = '$yesterdayDate' then 1 else 0 end) count_of_RFS FROM NBS_MASTER_HDR where TAB_NAME = 'Site_Upgrade' GROUP by CIRCLE_NAME
UNION
select 'Grand Total' as CIRCLE_NAME, sum(t.SR_Count) count_of_SR, sum(t.SP_Count) count_of_SP, sum(t.SO_Count) count_of_SO, sum(t.RFI_Count) count_of_RFI, 
		sum(t.RFI_Accepted_Count) count_of_RFI_Accepted, sum(t.RFS_Count) count_of_RFS from (SELECT CIRCLE_NAME, sum(case when SR_DATE = '$yesterdayDate' then 1 else 0 end) SR_Count, sum(case when SP_DATE = '$yesterdayDate' then 1 else 0 end) SP_Count, sum(case when SO_DATE = '$yesterdayDate' then 1 else 0 end) SO_Count, sum(case when RFI_DATE = '$yesterdayDate' then 1 else 0 end) RFI_Count, sum(case when RFI_ACCEPTED_DATE = '$yesterdayDate' then 1 else 0 end) RFI_Accepted_Count, sum(case when RFS_DATE = '$yesterdayDate' then 1 else 0 end) RFS_Count FROM NBS_MASTER_HDR where TAB_NAME = 'Site_Upgrade' GROUP by CIRCLE_NAME) t";
$result = mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	$circleName = $row["CIRCLE_NAME"];
	$srCount = $row["count_of_SR"];
	$spCount = $row["count_of_SP"];
	$soCount = $row["count_of_SO"];
	$rfiCount = $row["count_of_RFI"];
	$rfiAcceptedCount = $row["count_of_RFI_Accepted"];
	$rfsCount = $row["count_of_RFS"];

	$grRowClass = $circleName == 'Grand Total' ? "style='font-weight:bold'" : "";
	// $srClass = $srCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $spClass = $spCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $soClass = $soCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfiClass = $rfiCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfiAcceptedClass = $rfiAcceptedCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfsClass = $rfsCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";

	$msg .= "<tr $grRowClass>
				<td>".$row["CIRCLE_NAME"]."</td>
				<td $textAlign>".$row["count_of_SR"]."</td>
				<td $textAlign>".$row["count_of_SP"]."</td>
				<td $textAlign>".$row["count_of_SO"]."</td>
				<td $textAlign>".$row["count_of_RFI"]."</td>
				<td $textAlign>".$row["count_of_RFI_Accepted"]."</td>
				<td $textAlign>".$row["count_of_RFS"]."</td>
			</tr>";
}
$msg .= "</tbody>
	</table>";

// ----
$msg .= "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>All - Macro Anchor</h2>";
$msg .= $tableHdr;
$sql = "select t.CIRCLE_NAME, sum(t.sr_on) count_of_SR, sum(t.sp_on) count_of_SP, sum(t.so_on) count_of_SO, sum(t.rfi_on) count_of_RFI, sum(t.rfi_accepted_on) count_of_RFI_Accepted, sum(t.rfs_on) count_of_RFS from (SELECT CIRCLE_NAME, (case when SR_NUMBER is not null then 1 else 0 end) sr_on, (case when SP_NUMBER is not null then 1 else 0 end) sp_on, (case when SO_NUMBER is not null then 1 else 0 end) so_on, (case when RFI_DATE is not null then 1 else 0 end) rfi_on, (case when RFI_ACCEPTED_DATE is not null then 1 else 0 end) rfi_accepted_on, (case when RFS_DATE is not null then 1 else 0 end) rfs_on FROM `NBS_MASTER_HDR` where SR_NUMBER is not null and TAB_NAME = 'CreateNBS') t GROUP by t.CIRCLE_NAME
		UNION
		select 'Grand Total' as CIRCLE_NAME, sum(t1.sr_on) count_of_SR, sum(t1.sp_on) count_of_SP, sum(t1.so_on) count_of_SO, sum(t1.rfi_on) count_of_RFI, 
		sum(t1.rfi_accepted_on) count_of_RFI_Accepted, sum(t1.rfs_on) count_of_RFS from (select t.CIRCLE_NAME, sum(t.sr_on) as sr_on, sum(t.sp_on) as sp_on, 
		sum(t.so_on) as so_on, sum(t.rfi_on) as rfi_on, sum(t.rfi_accepted_on) as rfi_accepted_on, sum(t.rfs_on) as rfs_on from 
		(SELECT CIRCLE_NAME, (case when SR_NUMBER is not null then 1 else 0 end) sr_on, (case when SP_NUMBER is not null then 1 else 0 end) sp_on, 
		(case when SO_NUMBER is not null then 1 else 0 end) so_on, (case when RFI_DATE is not null then 1 else 0 end) rfi_on, 
		(case when RFI_ACCEPTED_DATE is not null then 1 else 0 end) rfi_accepted_on, (case when RFS_DATE is not null then 1 else 0 end) rfs_on 
		FROM `NBS_MASTER_HDR` where SR_NUMBER is not null and TAB_NAME = 'CreateNBS') 
		t GROUP by t.CIRCLE_NAME) t1";


$result = mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	$circleName = $row["CIRCLE_NAME"];
	$srCount = $row["count_of_SR"];
	$spCount = $row["count_of_SP"];
	$soCount = $row["count_of_SO"];
	$rfiCount = $row["count_of_RFI"];
	$rfiAcceptedCount = $row["count_of_RFI_Accepted"];
	$rfsCount = $row["count_of_RFS"];

	$grRowClass = $circleName == 'Grand Total' ? "style='font-weight:bold'" : "";
	// $srClass = $srCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $spClass = $spCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $soClass = $soCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfiClass = $rfiCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfiAcceptedClass = $rfiAcceptedCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfsClass = $rfsCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";

	$msg .= "<tr $grRowClass>
				<td>".$row["CIRCLE_NAME"]."</td>
				<td $textAlign>".$row["count_of_SR"]."</td>
				<td $textAlign>".$row["count_of_SP"]."</td>
				<td $textAlign>".$row["count_of_SO"]."</td>
				<td $textAlign>".$row["count_of_RFI"]."</td>
				<td $textAlign>".$row["count_of_RFI_Accepted"]."</td>
				<td $textAlign>".$row["count_of_RFS"]."</td>
			</tr>";
}
$msg .= "</tbody>
	</table>";

// $msg .= "<br>";

$msg .= "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>All - New Tenency</h2>";
$msg .= $tableHdr;
$sql = "select t.CIRCLE_NAME, sum(t.sr_on) count_of_SR, sum(t.sp_on) count_of_SP, sum(t.so_on) count_of_SO, sum(t.rfi_on) count_of_RFI, sum(t.rfi_accepted_on) count_of_RFI_Accepted, sum(t.rfs_on) count_of_RFS from (SELECT CIRCLE_NAME, (case when SR_NUMBER is not null then 1 else 0 end) sr_on, (case when SP_NUMBER is not null then 1 else 0 end) sp_on, (case when SO_NUMBER is not null then 1 else 0 end) so_on, (case when RFI_DATE is not null then 1 else 0 end) rfi_on, (case when RFI_ACCEPTED_DATE is not null then 1 else 0 end) rfi_accepted_on, (case when RFS_DATE is not null then 1 else 0 end) rfs_on FROM `NBS_MASTER_HDR` where SR_NUMBER is not null and TAB_NAME = 'New_Tenency') t GROUP by t.CIRCLE_NAME
		UNION
		select 'Grand Total' as CIRCLE_NAME, sum(t1.sr_on) count_of_SR, sum(t1.sp_on) count_of_SP, sum(t1.so_on) count_of_SO, sum(t1.rfi_on) count_of_RFI, 
		sum(t1.rfi_accepted_on) count_of_RFI_Accepted, sum(t1.rfs_on) count_of_RFS from (select t.CIRCLE_NAME, sum(t.sr_on) as sr_on, sum(t.sp_on) as sp_on, 
		sum(t.so_on) as so_on, sum(t.rfi_on) as rfi_on, sum(t.rfi_accepted_on) as rfi_accepted_on, sum(t.rfs_on) as rfs_on from 
		(SELECT CIRCLE_NAME, (case when SR_NUMBER is not null then 1 else 0 end) sr_on, (case when SP_NUMBER is not null then 1 else 0 end) sp_on, 
		(case when SO_NUMBER is not null then 1 else 0 end) so_on, (case when RFI_DATE is not null then 1 else 0 end) rfi_on, 
		(case when RFI_ACCEPTED_DATE is not null then 1 else 0 end) rfi_accepted_on, (case when RFS_DATE is not null then 1 else 0 end) rfs_on 
		FROM `NBS_MASTER_HDR` where SR_NUMBER is not null and TAB_NAME = 'New_Tenency') 
		t GROUP by t.CIRCLE_NAME) t1";
$result = mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	$circleName = $row["CIRCLE_NAME"];
	$srCount = $row["count_of_SR"];
	$spCount = $row["count_of_SP"];
	$soCount = $row["count_of_SO"];
	$rfiCount = $row["count_of_RFI"];
	$rfiAcceptedCount = $row["count_of_RFI_Accepted"];
	$rfsCount = $row["count_of_RFS"];

	$grRowClass = $circleName == 'Grand Total' ? "style='font-weight:bold'" : "";
	// $srClass = $srCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $spClass = $spCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $soClass = $soCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfiClass = $rfiCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfiAcceptedClass = $rfiAcceptedCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfsClass = $rfsCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";

	$msg .= "<tr $grRowClass>
				<td>".$row["CIRCLE_NAME"]."</td>
				<td $textAlign>".$row["count_of_SR"]."</td>
				<td $textAlign>".$row["count_of_SP"]."</td>
				<td $textAlign>".$row["count_of_SO"]."</td>
				<td $textAlign>".$row["count_of_RFI"]."</td>
				<td $textAlign>".$row["count_of_RFI_Accepted"]."</td>
				<td $textAlign>".$row["count_of_RFS"]."</td>
			</tr>";
}
$msg .= "</tbody>
	</table>";

// $msg .= "<br>";

$msg .= "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>All - Site Upgrade</h2>";
$msg .= $tableHdr;
$sql = "select t.CIRCLE_NAME, sum(t.sr_on) count_of_SR, sum(t.sp_on) count_of_SP, sum(t.so_on) count_of_SO, sum(t.rfi_on) count_of_RFI, sum(t.rfi_accepted_on) count_of_RFI_Accepted, sum(t.rfs_on) count_of_RFS from (SELECT CIRCLE_NAME, (case when SR_NUMBER is not null then 1 else 0 end) sr_on, (case when SP_NUMBER is not null then 1 else 0 end) sp_on, (case when SO_NUMBER is not null then 1 else 0 end) so_on, (case when RFI_DATE is not null then 1 else 0 end) rfi_on, (case when RFI_ACCEPTED_DATE is not null then 1 else 0 end) rfi_accepted_on, (case when RFS_DATE is not null then 1 else 0 end) rfs_on FROM `NBS_MASTER_HDR` where SR_NUMBER is not null and TAB_NAME = 'Site_Upgrade') t GROUP by t.CIRCLE_NAME
		UNION
		select 'Grand Total' as CIRCLE_NAME, sum(t1.sr_on) count_of_SR, sum(t1.sp_on) count_of_SP, sum(t1.so_on) count_of_SO, sum(t1.rfi_on) count_of_RFI, 
		sum(t1.rfi_accepted_on) count_of_RFI_Accepted, sum(t1.rfs_on) count_of_RFS from (select t.CIRCLE_NAME, sum(t.sr_on) as sr_on, sum(t.sp_on) as sp_on, 
		sum(t.so_on) as so_on, sum(t.rfi_on) as rfi_on, sum(t.rfi_accepted_on) as rfi_accepted_on, sum(t.rfs_on) as rfs_on from 
		(SELECT CIRCLE_NAME, (case when SR_NUMBER is not null then 1 else 0 end) sr_on, (case when SP_NUMBER is not null then 1 else 0 end) sp_on, 
		(case when SO_NUMBER is not null then 1 else 0 end) so_on, (case when RFI_DATE is not null then 1 else 0 end) rfi_on, 
		(case when RFI_ACCEPTED_DATE is not null then 1 else 0 end) rfi_accepted_on, (case when RFS_DATE is not null then 1 else 0 end) rfs_on 
		FROM `NBS_MASTER_HDR` where SR_NUMBER is not null and TAB_NAME = 'Site_Upgrade') 
		t GROUP by t.CIRCLE_NAME) t1";
$result = mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result)){
	$circleName = $row["CIRCLE_NAME"];
	$srCount = $row["count_of_SR"];
	$spCount = $row["count_of_SP"];
	$soCount = $row["count_of_SO"];
	$rfiCount = $row["count_of_RFI"];
	$rfiAcceptedCount = $row["count_of_RFI_Accepted"];
	$rfsCount = $row["count_of_RFS"];

	$grRowClass = $circleName == 'Grand Total' ? "style='font-weight:bold'" : "";
	// $srClass = $srCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $spClass = $spCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $soClass = $soCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfiClass = $rfiCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfiAcceptedClass = $rfiAcceptedCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";
	// $rfsClass = $rfsCount == 0 ? "style='background-color:#FA8072;color:white;text-align:right'" : "style='text-align:right'";

	$msg .= "<tr $grRowClass>
				<td>".$row["CIRCLE_NAME"]."</td>
				<td $textAlign>".$row["count_of_SR"]."</td>
				<td $textAlign>".$row["count_of_SP"]."</td>
				<td $textAlign>".$row["count_of_SO"]."</td>
				<td $textAlign>".$row["count_of_RFI"]."</td>
				<td $textAlign>".$row["count_of_RFI_Accepted"]."</td>
				<td $textAlign>".$row["count_of_RFS"]."</td>
			</tr>";
}
$msg .= "</tbody>
	</table>";

$msg .= "<br><br>";
$msg .= "<b>Regards";
$msg .= "<br>";
$msg .= "Trinity automation team.</b>";
$msg .= "<br><br>";
$msg .= "<b>Note</b> : This is auto generated, don't reply.";

// echo $msg;


$toMailId = 'jai.prakash@trinityapplab.co.in';
$subject = 'SR Dashboard of '.$ddMmmYyyy;
$response = sendMail($toMailId, $subject, $msg, "");
echo $response;
?>

<?php 
function sendMail($toMailId, $subject, $msg, $attachment){
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
    // $recipients = array('jai.prakash@trinityapplab.co.in','sudhakanta.mohanty@trinityapplab.co.in');
    
    // for($i=0;$i<count($recipients);$i++){
    // 	$mail->addAddress($recipients[$i]);
    // }
    // $mail->addAddress($toMailId);
    // $mail->addAddress("manishj@tower-vision.com");
    // $mail->addAddress("pushkar.tyagi@trinityapplab.co.in");

    $mail->setFrom("communication@trinityapplab.co.in","Trinity");
    // $mail->addAttachment($attachment);
    $mail->isHTML(true);   

    // CC mail's
    // $mail->addCC('pushkar.tyagi@trinityapplab.co.in');
    // $mail->addCC('anupama@nvgroup.co.in');
    
    // BCC mail's
    // $mail->addBCC("jai.prakash@trinityapplab.co.in");
    // $recipients = array('amitp@tower-vision.com', 'rajeshgarg@tower-vision.com', 'sandipanc@tower-vision.com', 'kevyag@tower-vision.com', 'vinays@tower-vision.com', 'rakeshp@tower-vision.com', 'nitinn@tower-vision.com', 'soumend@tower-vision.com', 'bishanc@tower-vision.com', 'mukeshd@tower-vision.com', 'johnt@tower-vision.com', 'rmnagappan@tower-vision.com', 'hiteshp@tower-vision.com', 'kuldeepk@tower-vision.com', 'sanjeevg@tower-vision.com', 'biplabd@tower-vision.com', 'sanjeevkumars@tower-vision.com', 'Vijayj@tower-vision.com', 'ajayjain@tower-vision.com', 'Praveensu@tower-vision.com', 'arutsivanb@tower-vision.com', 'manishj@tower-vision.com', 'rajivk@tower-vision.com', 'arijitd@tower-vision.com', 'manishk@tower-vision.com', 'jyotir@tower-vision.com');
    $recipients = array('amitp@tower-vision.com', 'rajeshgarg@tower-vision.com', 'sandipanc@tower-vision.com', 'kevyag@tower-vision.com', 'vinays@tower-vision.com', 'nitinn@tower-vision.com', 'soumend@tower-vision.com', 'bishanc@tower-vision.com', 'mukeshd@tower-vision.com', 'johnt@tower-vision.com', 'rmnagappan@tower-vision.com', 'hiteshp@tower-vision.com', 'sanjeevg@tower-vision.com', 'biplabd@tower-vision.com', 'Vijayj@tower-vision.com', 'Praveensu@tower-vision.com', 'manishj@tower-vision.com', 'rajivk@tower-vision.com', 'arijitd@tower-vision.com', 'manishk@tower-vision.com', 'jyotir@tower-vision.com');
    
    for($i=0;$i<count($recipients);$i++){
    	$mail->addBCC($recipients[$i]);
    }

    $mail->Subject = $subject;
    $mail->Body = "$message";
    
        
    if(!$mail->send())
    {
        // echo 'Mailer Error: ' . $mail->ErrorInfo;
        // echo"<br>Could not send";
        $status = false;
    }
    else{
        // echo "mail sent";
        $status = true;
    }

    return $status;

}
function sendZero($value){
	return $value == null ? 0 : $value;
}
?>