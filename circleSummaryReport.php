<?php

$period=$_REQUEST['period'];
//$period = "Apr2020";

$sql = "Select r.CircleName,r.OperationalTenancy,
		r.TotalCost as TotalCost,r.TotalRevenue as TotalRevenue,
		(r.TotalRevenue - r.TotalCost) as TotalMargin,
		(r.TotalCost/r.OperationalTenancy) as CostPerTenant,
		(r.TotalRevenue/r.OperationalTenancy) as RevenuePerTenant,
		(r.TotalRevenue - r.TotalCost)/r.OperationalTenancy as MarginPerTenant,
		((r.TotalRevenue - r.TotalCost)/r.TotalRevenue) *100 as MarginPercentage
		from

		(SELECT p.`Circle Name` as CircleName,
		sum(p.`No of Tenancy`) as OperationalTenancy,
		sum(p.`Total Energy Cost Share`) as TotalCost,
		sum(p.`Total Energy Revenue Share`) as TotalRevenue
		FROM 
		`P&L Sitewise` p where p.`Site ID` is  not null  and p.`Operational Status` not in ('ZTS') and p.`UploadMonth` = '$period'
		group by p.`Circle Name`
		 ) r";
//echo $sql."\n";		 

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
header("Content-Disposition: attachment; filename=circleSummaryReport.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character

//start of printing column names as names of MySQL fields
while ($fieldinfo = $result -> fetch_field()) {
	echo $fieldinfo -> name . "\t";
}
print "\n";

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
