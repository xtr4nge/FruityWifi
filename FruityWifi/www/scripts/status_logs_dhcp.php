<?
include "../config/config.php";

$filename = "$log_path/dhcp.leases";
$fh = fopen($filename, "r"); //or die("Could not open file.");
if ( 0 < filesize( $filename ) ) {
	$data = fread($fh, filesize($filename)); //or die("Could not read file.");
}
fclose($fh);
$data = explode("\n",$data);

for ($i=0; $i < count($data); $i++) {
	$tmp = explode(" ", $data[$i]);
	$output[] = $tmp[2] . " " . $tmp[1] . " " . $tmp[3];
	//echo $tmp[2] . " " . $tmp[3] . " " . $tmp[4] . "<br>";
}

echo json_encode($output);
?>
