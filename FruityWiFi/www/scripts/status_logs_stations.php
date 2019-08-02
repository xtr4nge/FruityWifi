<?
include "../config/config.php";

exec("/sbin/iw dev $io_in_iface station dump |grep Stat", $stations);
for ($i=0; $i < count($stations); $i++) {
    $output[] = str_replace("Station", "", $stations[$i]);
}
/*
for ($i=0; $i < count($data); $i++) {
	$tmp = explode(" ", $data[$i]);
	$output[] = $tmp[2] . " " . $tmp[1] . " " . $tmp[3];
	//echo $tmp[2] . " " . $tmp[3] . " " . $tmp[4] . "<br>";
}
*/
//$output[0] = "a";
echo json_encode($output);
?>
