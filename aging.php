<?php
include("cpDbConfig_db.php");
// $msg = "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>Audit - Macro Anchor</h2>";
// $msg .= "<table border=1 cellpadding=5 cellspacing=0 style='$fontFamily;font-size:12px'>
// 		<thead>
// 			<tr style='background-color:#2E57A7;color:white'>
// 				<th>SR_NUMBER</th>
// 				<th>Circle</th>
// 				<th>NB01</th>
// 				<th>NB02</th>
// 				<th>NB03</th>
// 				<th>NB04</th>
// 				<th>NB05</th>
// 				<th>NB08</th>
// 				<th>NB09</th>
// 				<th>NB103</th>
// 				<th>NB10</th>
// 				<th>NB11</th>
// 				<th>NBB12</th>
// 				<th>NB12</th>
// 				<th>NB015</th>
// 				<th>NB15</th>
// 				<th>NB16</th>
// 				<th>NB17</th>
// 				<th>NB18</th>
// 			</tr>
// 		</thead>
// 		<tbody>";
// $sql = "SELECT `SR_NUMBER`, `Circle`, `NB01`, `NB02`, `NB03`, `NB04`, `NB05`, `NB08`, `NB09`, `NB103`, `NB10`, `NB11`, `NBB12`, `NB12`, `NB015`, `NB15`, `NB16`, `NB17`, `NB18` FROM `Airtel_NBS_Audit`";
// $query = mysqli_query($conn,$sql);	
// while($row = mysqli_fetch_assoc($query)){
// 	$msg .= "<tr>
// 			<td $textAlign>".$row["SR_NUMBER"]."</td>
// 			<td $textAlign>".$row["Circle"]."</td>
// 			<td $textAlign>".$row["NB01"]."</td>
// 			<td $textAlign>".$row["NB02"]."</td>
// 			<td $textAlign>".$row["NB03"]."</td>
// 			<td $textAlign>".$row["NB04"]."</td>
// 			<td $textAlign>".$row["NB05"]."</td>
// 			<td $textAlign>".$row["NB08"]."</td>
// 			<td $textAlign>".$row["NB09"]."</td>
// 			<td $textAlign>".$row["NB103"]."</td>
// 			<td $textAlign>".$row["NB10"]."</td>
// 			<td $textAlign>".$row["NB11"]."</td>
// 			<td $textAlign>".$row["NBB12"]."</td>
// 			<td $textAlign>".$row["NB12"]."</td>
// 			<td $textAlign>".$row["NB015"]."</td>
// 			<td $textAlign>".$row["NB15"]."</td>
// 			<td $textAlign>".$row["NB16"]."</td>
// 			<td $textAlign>".$row["NB17"]."</td>
// 			<td $textAlign>".$row["NB18"]."</td>
// 		</tr>";
// }
// $msg .= "</tbody>
// </table>";
// echo $msg;

// $msg = "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>Audit - HPSC Anchor</h2>";
// $msg .= "<table border=1 cellpadding=5 cellspacing=0 style='$fontFamily;font-size:12px'>
// 		<thead>
// 			<tr style='background-color:#2E57A7;color:white'>
// 				<th>SR_NUMBER</th>
// 				<th>Circle</th>
// 				<th>NB01</th>
// 				<th>NB02</th>
// 				<th>NB03</th>
// 				<th>NB04</th>
// 				<th>NB05</th>
// 				<th>NB06</th>
// 				<th>NB08</th>
// 				<th>NB09</th>
// 				<th>NB103</th>
// 				<th>NB10</th>
// 				<th>NB11</th>
// 				<th>NBB12</th>
// 				<th>NB12</th>
// 				<th>NB15</th>
// 				<th>NB16</th>
// 				<th>NB17</th>
// 				<th>NB18</th>

// 			</tr>
// 		</thead>
// 		<tbody>";
// $sql = "SELECT `SR_NUMBER`, `Circle`, `NB01`, `NB02`, `NB03`, `NB04`, `NB05`, `NB06`, `NB08`, `NB09`, `NB103`, `NB10`, `NB11`, `NBB12`, `NB12`, `NB15`, `NB16`, `NB17`, `NB18` FROM `Airtel_HPSC_Audit`";
// $query = mysqli_query($conn,$sql);	
// while($row = mysqli_fetch_assoc($query)){
// 	$msg .= "<tr>
// 			<td $textAlign>".$row["SR_NUMBER"]."</td>
// 			<td $textAlign>".$row["Circle"]."</td>
// 			<td $textAlign>".$row["NB01"]."</td>
// 			<td $textAlign>".$row["NB02"]."</td>
// 			<td $textAlign>".$row["NB03"]."</td>
// 			<td $textAlign>".$row["NB04"]."</td>
// 			<td $textAlign>".$row["NB05"]."</td>
// 			<td $textAlign>".$row["NB06"]."</td>
// 			<td $textAlign>".$row["NB08"]."</td>
// 			<td $textAlign>".$row["NB09"]."</td>
// 			<td $textAlign>".$row["NB103"]."</td>
// 			<td $textAlign>".$row["NB10"]."</td>
// 			<td $textAlign>".$row["NB11"]."</td>
// 			<td $textAlign>".$row["NBB12"]."</td>
// 			<td $textAlign>".$row["NB12"]."</td>
// 			<td $textAlign>".$row["NB15"]."</td>
// 			<td $textAlign>".$row["NB16"]."</td>
// 			<td $textAlign>".$row["NB17"]."</td>
// 			<td $textAlign>".$row["NB18"]."</td>
// 		</tr>";
// }
// $msg .= "</tbody>
// </table>";
// echo $msg;

// $msg = "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>Audit - Site Upgrade</h2>";
// $msg .= "<table border=1 cellpadding=5 cellspacing=0 style='$fontFamily;font-size:12px'>
// 		<thead>
// 			<tr style='background-color:#2E57A7;color:white'>
// 				<th>SR_NUMBER</th>
// 				<th>Circle</th>
// 				<th>NB01</th>
// 				<th>NB02</th>
// 				<th>NB103</th>
// 				<th>NB03</th>
// 				<th>NB04</th>
// 				<th>NB05</th>
// 				<th>NB06</th>
// 				<th>NB07</th>
// 			</tr>
// 		</thead>
// 		<tbody>";
// $sql = "SELECT `SR_NUMBER`, `Circle`, `NB01`, `NB02`, `NB103`, `NB03`, `NB04`, `NB05`, `NB06`, `NB07` FROM `Airtel_SU_Audit`";
// $query = mysqli_query($conn,$sql);	
// while($row = mysqli_fetch_assoc($query)){
// 	$msg .= "<tr>
// 			<td $textAlign>".$row["SR_NUMBER"]."</td>
// 			<td $textAlign>".$row["Circle"]."</td>
// 			<td $textAlign>".$row["NB01"]."</td>
// 			<td $textAlign>".$row["NB02"]."</td>
// 			<td $textAlign>".$row["NB103"]."</td>
// 			<td $textAlign>".$row["NB03"]."</td>
// 			<td $textAlign>".$row["NB04"]."</td>
// 			<td $textAlign>".$row["NB05"]."</td>
// 			<td $textAlign>".$row["NB06"]."</td>
// 			<td $textAlign>".$row["NB07"]."</td>
// 		</tr>";
// }
// $msg .= "</tbody>
// </table>";
// echo $msg;

// $msg = "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>Audit - New Tenency</h2>";
// $msg .= "<table border=1 cellpadding=5 cellspacing=0 style='$fontFamily;font-size:12px'>
// 		<thead>
// 			<tr style='background-color:#2E57A7;color:white'>
// 				<th>SR_NUMBER</th>
// 				<th>Circle</th>
// 				<th>NB01</th>
// 				<th>NB02</th>
// 				<th>NB03</th>
// 				<th>NB04</th>
// 				<th>NB103</th>
// 				<th>NB05</th>
// 				<th>NB06</th>
// 				<th>NB07</th>
// 				<th>NB08</th>
// 				<th>NB09</th>
// 			</tr>
// 		</thead>
// 		<tbody>";
// $sql = "SELECT `SR_NUMBER`, `Circle`, `NB01`, `NB02`, `NB03`, `NB04`, `NB103`, `NB05`, `NB06`, `NB07`, `NB08`, `NB09` FROM `Airtel_NT_Audit`";
// $query = mysqli_query($conn,$sql);	
// while($row = mysqli_fetch_assoc($query)){
// 	$msg .= "<tr>
// 			<td $textAlign>".$row["SR_NUMBER"]."</td>
// 			<td $textAlign>".$row["Circle"]."</td>
// 			<td $textAlign>".$row["NB01"]."</td>
// 			<td $textAlign>".$row["NB02"]."</td>
// 			<td $textAlign>".$row["NB03"]."</td>
// 			<td $textAlign>".$row["NB04"]."</td>
// 			<td $textAlign>".$row["NB103"]."</td>
// 			<td $textAlign>".$row["NB05"]."</td>
// 			<td $textAlign>".$row["NB06"]."</td>
// 			<td $textAlign>".$row["NB07"]."</td>
// 			<td $textAlign>".$row["NB08"]."</td>
// 			<td $textAlign>".$row["NB09"]."</td>
// 		</tr>";
// }
// $msg .= "</tbody>
// </table>";
// echo $msg;

$msg = "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>Aging - Macro Anchor</h2>";
$msg .= "<table border=1 cellpadding=5 cellspacing=0 style='$fontFamily;font-size:12px'>
		<thead>
			<tr style='background-color:#2E57A7;color:white'>
				<th>Type</th>
				<th>NB02</th>
				<th>NB03</th>
				<th>NB04</th>
				<th>NB05</th>
				<th>NB08</th>
				<th>NB09</th>
				<th>NB103</th>
				<th>NB10</th>
				<th>NB11</th>
				<th>NBB12</th>
				<th>NB12</th>
				<th>NB015</th>
				<th>NB15</th>
				<th>NB16</th>
				<th>NB17</th>
				<th>NB18</th>
			</tr>
		</thead>
		<tbody>";
$sql = "SELECT `Type`, `NB02`, `NB03`, `NB04`, `NB05`, `NB08`, `NB09`, `NB103`, `NB10`, `NB11`, `NBB12`, `NB12`, `NB015`, `NB15`, `NB16`, `NB17`, `NB18` FROM `Airtel_NBS_Aging`";
$query = mysqli_query($conn,$sql);	
while($row = mysqli_fetch_assoc($query)){
	$msg .= "<tr>
			<td $textAlign>".$row["Type"]."</td>
			<td $textAlign>".$row["NB02"]."</td>
			<td $textAlign>".$row["NB03"]."</td>
			<td $textAlign>".$row["NB04"]."</td>
			<td $textAlign>".$row["NB05"]."</td>
			<td $textAlign>".$row["NB08"]."</td>
			<td $textAlign>".$row["NB09"]."</td>
			<td $textAlign>".$row["NB103"]."</td>
			<td $textAlign>".$row["NB10"]."</td>
			<td $textAlign>".$row["NB11"]."</td>
			<td $textAlign>".$row["NBB12"]."</td>
			<td $textAlign>".$row["NB12"]."</td>
			<td $textAlign>".$row["NB015"]."</td>
			<td $textAlign>".$row["NB15"]."</td>
			<td $textAlign>".$row["NB16"]."</td>
			<td $textAlign>".$row["NB17"]."</td>
			<td $textAlign>".$row["NB18"]."</td>
		</tr>";
}
$msg .= "</tbody>
</table>";

$msg .= "<br>";

$msg .= "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>Aging - HPSC Anchor</h2>";
$msg .= "<table border=1 cellpadding=5 cellspacing=0 style='$fontFamily;font-size:12px'>
		<thead>
			<tr style='background-color:#2E57A7;color:white'>
				<th>Type</th>
				<th>NB02</th>
				<th>NB03</th>
				<th>NB04</th>
				<th>NB05</th>
				<th>NB06</th>
				<th>NB08</th>
				<th>NB09</th>
				<th>NB103</th>
				<th>NB10</th>
				<th>NB11</th>
				<th>NBB12</th>
				<th>NB12</th>
				<th>NB15</th>
				<th>NB16</th>
				<th>NB17</th>
				<th>NB18</th>
			</tr>
		</thead>
		<tbody>";
$sql = "SELECT `Type`, `NB02`, `NB03`, `NB04`, `NB05`, `NB06`, `NB08`, `NB09`, `NB103`, `NB10`, `NB11`, `NBB12`, `NB12`, `NB15`, `NB16`, `NB17`, `NB18` FROM `Airtel_HPSC_Aging`";
$query = mysqli_query($conn,$sql);	
while($row = mysqli_fetch_assoc($query)){
	$msg .= "<tr>
			<td $textAlign>".$row["Type"]."</td>
			<td $textAlign>".$row["NB02"]."</td>
			<td $textAlign>".$row["NB03"]."</td>
			<td $textAlign>".$row["NB04"]."</td>
			<td $textAlign>".$row["NB05"]."</td>
			<td $textAlign>".$row["NB06"]."</td>
			<td $textAlign>".$row["NB08"]."</td>
			<td $textAlign>".$row["NB09"]."</td>
			<td $textAlign>".$row["NB103"]."</td>
			<td $textAlign>".$row["NB10"]."</td>
			<td $textAlign>".$row["NB11"]."</td>
			<td $textAlign>".$row["NBB12"]."</td>
			<td $textAlign>".$row["NB12"]."</td>
			<td $textAlign>".$row["NB15"]."</td>
			<td $textAlign>".$row["NB16"]."</td>
			<td $textAlign>".$row["NB17"]."</td>
			<td $textAlign>".$row["NB18"]."</td>
		</tr>";
}
$msg .= "</tbody>
</table>";

$msg .= "<br>";

$msg .= "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>Aging - Site Upgrade</h2>";
$msg .= "<table border=1 cellpadding=5 cellspacing=0 style='$fontFamily;font-size:12px'>
		<thead>
			<tr style='background-color:#2E57A7;color:white'>
				<th>Type</th>
				<th>NB02</th>
				<th>NB103</th>
				<th>NB03</th>
				<th>NB04</th>
				<th>NB05</th>
				<th>NB06</th>
				<th>NB07</th>
			</tr>
		</thead>
		<tbody>";
$sql = "SELECT `Type`, `NB02`, `NB103`, `NB03`, `NB04`, `NB05`, `NB06`, `NB07` FROM `Airtel_SU_Aging`";
$query = mysqli_query($conn,$sql);	
while($row = mysqli_fetch_assoc($query)){
	$msg .= "<tr>
			<td $textAlign>".$row["Type"]."</td>
			<td $textAlign>".$row["NB02"]."</td>
			<td $textAlign>".$row["NB103"]."</td>
			<td $textAlign>".$row["NB03"]."</td>
			<td $textAlign>".$row["NB04"]."</td>
			<td $textAlign>".$row["NB05"]."</td>
			<td $textAlign>".$row["NB06"]."</td>
			<td $textAlign>".$row["NB07"]."</td>
		</tr>";
}
$msg .= "</tbody>
</table>";

$msg .= "<br>";

$msg .= "<h2 style='$fontFamily;color:#2E57A7;text-decoration:underline'>Aging - New Tenency</h2>";
$msg .= "<table border=1 cellpadding=5 cellspacing=0 style='$fontFamily;font-size:12px'>
		<thead>
			<tr style='background-color:#2E57A7;color:white'>
				<th>Type</th>
				<th>NB02</th>
				<th>NB03</th>
				<th>NB04</th>
				<th>NB103</th>
				<th>NB05</th>
				<th>NB06</th>
				<th>NB07</th>
				<th>NB08</th>
				<th>NB09</th>
			</tr>
		</thead>
		<tbody>";
$sql = "SELECT `Type`, `NB02`, `NB03`, `NB04`, `NB103`, `NB05`, `NB06`, `NB07`, `NB08`, `NB09` FROM `Airtel_NT_Aging`";
$query = mysqli_query($conn,$sql);	
while($row = mysqli_fetch_assoc($query)){
	$msg .= "<tr>
			<td $textAlign>".$row["Type"]."</td>
			<td $textAlign>".$row["NB02"]."</td>
			<td $textAlign>".$row["NB03"]."</td>
			<td $textAlign>".$row["NB04"]."</td>
			<td $textAlign>".$row["NB103"]."</td>
			<td $textAlign>".$row["NB05"]."</td>
			<td $textAlign>".$row["NB06"]."</td>
			<td $textAlign>".$row["NB07"]."</td>
			<td $textAlign>".$row["NB08"]."</td>
			<td $textAlign>".$row["NB09"]."</td>
		</tr>";
}
$msg .= "</tbody>
</table>";
echo $msg;
?>