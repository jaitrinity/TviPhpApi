<?php
include("cpDbConfig_test.php");
$strDate = $_REQUEST["strDate"];

$sql = "SELECT DISTINCT t.Bill_Month from (SELECT *, STR_TO_DATE(concat('01-',Bill_Month),'%d-%M-%Y') as StrDate FROM `tblsitedetailbilling`) t where t.StrDate >= '$strDate'";
$result = mysqli_query($conn,$sql);
$html="<html>";
$html .= "<style>";
$html .= "
.countCol{
	text-align: right;
}
";
$html .= "</style>";
$html .= "<body>";
while($row=mysqli_fetch_assoc($result)){
	$billMonth = $row["Bill_Month"];
	$sql1 = "SELECT `BillingType`, count(`BillingType`) as `NoOfCount` FROM `tblsitedetailbilling` where `Bill_Month`='$billMonth' GROUP by `BillingType`";
	$result1 = mysqli_query($conn,$sql1);
	$html .= "<table border=1 cellspacing=0 cellpadding=2>";
	$html .= "<caption>$billMonth</caption>";
	$html .= "<tr>";
	$html .= "<th>Billing Type</th> <th class='countCol'> Count</th>";
	$html .= "</tr>";
	$totalCount = 0;
	while($row1=mysqli_fetch_assoc($result1)){
		$billingType = $row1["BillingType"];
		$count = $row1["NoOfCount"];
		$totalCount += intval($count);

		$html .= "<tr>";
		$html .= "<td>$billingType</td> <td class='countCol'>$count</td>";
		$html .= "</tr>";
	}
	$html .= "<tr>";
	$html .= "<th>Total Count</th> <th class='countCol'>$totalCount</th>";
	$html .= "</tr>";
	$html .= "</table>";
	$html .= "<br>";
}
$html .= "</body>";

header('Content-Type: text/html');
echo $html;
?>