<? 
/*
	Copyright (C) 2013-2015 xtr4nge [_AT_] gmail.com
	
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 
?>
<? include "header.php"; ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<title>FruityWifi</title>
</head>
<script src="js/jquery.js"></script>
<? include "login_check.php"; ?>
<? include "menu.php" ?>
<?
include "config/config.php";
include "functions.php";

//$bin_danger = "/usr/share/fruitywifi/bin/danger"; //DEPRECATED

function showLog($filename, $path) {

	//$filename = "logs/dnsmasq.log";
	//$filename = $path;

	$fh = fopen($path, "r"); // or die("Could not open file.");
	if(filesize($path)) {
		$data = fread($fh, filesize($path)); // or die("Could not read file.");
		fclose($fh);
		$data_array = explode("\n", $data);
		$data = implode("\n",array_reverse($data_array));

		$data = htmlspecialchars($data);
	}
	echo "
		<br>
		<div class='rounded-top' align='left'> &nbsp; <b>$filename</b> </div>
		<textarea name='newdata' rows='10' cols='100' class='module-content' style='font-family: courier; overflow: auto; height:200px;'>$data</textarea>
		<br>
	";
}

$logs_path = "$log_path/";
$logs = glob($logs_path.'*');

for ($i = 0; $i < count($logs); $i++) {
	$filename = str_replace($logs_path,"",$logs[$i]);
	//echo "$filename<br>";
	if ($filename != "install.txt") showLog($filename, $logs[$i]);
}
?>
