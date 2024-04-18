<?php 
include("cpDbConfig.php");

$sql = "SELECT * FROM `BBU_AutoPopUp`";
$result = mysqli_query($conn,$sql);
$bbuPopUpList = array();
while($row = mysqli_fetch_assoc($result)){
	$json = array('make' => $row["Make"], 'model' => $row["Model"], 'ratedPowerConsumption' => $row["Rated_Power_Consumption"]);
	array_push($bbuPopUpList, $json);
}

$rfAntennaPopUpList = array();
$sql = "SELECT * FROM `RFAntenna_AutoPopUp`";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
	$json = array('height' => $row["Height"], 'weight' => $row["Weight"], 'azimuth' => $row["Azimuth"], 'model' => $row["Model"], 'gain' => $row["Gain"], 'band' => $row["Band"]);
	array_push($rfAntennaPopUpList, $json);
}

$rruPopUpList = array();
$sql = "SELECT * FROM `RRU_AutoPopUp`";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
	$json = array('make' => $row["Make"], 'model' => $row["Model"], 'frequencyBand' => $row["Frequency_Band"], 'ratedPower' => $row["Rated_Power"]);
	array_push($rruPopUpList, $json);
}

$mwPopUpList = array();
$sql = "SELECT * FROM `MW_AutoPopUp`";
$result = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
	$json = array('make' => $row["Make"], 'model' => $row["Model"], 'height' => $row["Height"], 'dia' => $row["Dia"], 'azimuth' => $row["Azimuth"]);
	array_push($mwPopUpList, $json);
}


$output = array('bbuPopUpList' => $bbuPopUpList, 'rfAntennaPopUpList' => $rfAntennaPopUpList, 'rruPopUpList' => $rruPopUpList, 'mwPopUpList' => $mwPopUpList);
echo json_encode($output);

?>