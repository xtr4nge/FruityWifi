<? 
/*
	Copyright (C) 2013  xtr4nge [_AT_] gmail.com

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
<link href="../style.css" rel="stylesheet" type="text/css">
<pre>
<?
include "../login_check.php";
include "../config/config.php";
include "../functions.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["module"], "../msg.php", $regex_extra);
    regex_standard($_GET["file"], "../msg.php", $regex_extra);
}

function load_file ($filename) {
    $fh = fopen($filename, "r") or die("Could not open file.");
    $data = fread($fh, filesize($filename)) or die("Could not read file.");
    fclose($fh);
    return $data;
}

$module = $_GET["module"];
$file = $_GET["file"];

if ($module == "sslstrip") {
    //echo $file.".log";
    $data = load_file("../logs/sslstrip/".$file.".log");
    echo $data;
}

?>
</pre>