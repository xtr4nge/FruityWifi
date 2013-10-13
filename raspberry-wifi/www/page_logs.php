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
<? include "menu.php" ?>
<? include "login_check.php"; ?>
<?php
$filename = "logs/urlsnarf.log";

$fh = fopen($filename, "r") or die("Could not open file.");
$data = fread($fh, filesize($filename)) or die("Could not read file.");
fclose($fh);
?>

<br>
URLSnarf Log
<br>
<textarea name='newdata' class="input" rows='10' cols='100'><?=$data?></textarea>
<br>


<?php
$filename = "logs/dnsspoof.log";

$fh = fopen($filename, "r") or die("Could not open file.");
$data = fread($fh, filesize($filename)) or die("Could not read file.");
fclose($fh);
?>

<br>
DNS Spoof Log
<br>
<textarea name='newdata' class="input" rows='10' cols='100'><?=$data?></textarea>
<br>

<?php
$filename = "logs/dnsmasq.log";

$fh = fopen($filename, "r") or die("Could not open file.");
$data = fread($fh, filesize($filename)) or die("Could not read file.");
fclose($fh);
?>

<br>
DNSmasq Log
<br>
<textarea name='newdata' class="input" rows='10' cols='100'><?=$data?></textarea>
<br>
