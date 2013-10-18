<?
//$getData = $_GET["v"];
$getData = $_POST["v"];

$myFile = "data.txt";
$fh = fopen($myFile, 'a') or die("can't open file");

$stringData = $getData . "\n";

fwrite($fh, $stringData);
fclose($fh);

?>