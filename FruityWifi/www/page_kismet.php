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
<br>

<div class="rounded-top" align="center"> Kismet Setup </div>
<div class="rounded-bottom">
    <?
    $iskismetup = exec("ps auxww | grep kismet_server | grep -v -e grep");
    if ($iskismetup != "") {
        //echo "&nbsp;&nbsp;&nbsp;Kismet  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"page_status.php?service=kismet&action=stop\"><b>stop</b></a><br />";
        //echo "&nbsp;&nbsp;&nbsp;Kismet  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"action.php?service=kismet&action=stop\"><b>stop</b></a><br />";
        echo "&nbsp;&nbsp;&nbsp;Kismet  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_kismet.php?service=kismet&action=stop&page=module\"><b>stop</b></a><br />";
    } else { 
        //echo "&nbsp;&nbsp;&nbsp;Kismet  <font color=\"red\"><b>disabled</b></font>. | <a href=\"page_status.php?service=kismet&action=start\"><b>start</b></a><br/>"; 
        //echo "&nbsp;&nbsp;&nbsp;Kismet  <font color=\"red\"><b>disabled</b></font>. | <a href=\"action.php?service=kismet&action=start\"><b>start</b></a><br/>";
        echo "&nbsp;&nbsp;&nbsp;Kismet  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_kismet.php?service=kismet&action=start&page=module\"><b>start</b></a><br />";
    }
    ?>
    <?
    $isgpsdup = exec("ps auxww | grep gpsd | grep -v -e grep");
    if ($isgpsdup != "") {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GPSD  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_kismet.php?service=gpsd&action=stop&page=module\"><b>stop</b></a><br />";
    } else { 
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GPSD  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_kismet.php?service=gpsd&action=start&page=module\"><b>start</b></a><br />";
    }
    ?>
    <?
    //$isttyusbup = exec("ps auxww | grep gpsd | grep -v -e grep");
    $isttyusbup = exec("ls /dev/ttyUSB0");
    if ($isttyusbup == "/dev/ttyUSB0") {
        echo "&nbsp;&nbsp;ttyUSB0  <font color=\"lime\"><b>connected</b></font>.<br />";
    } else { 
        echo "&nbsp;&nbsp;ttyUSB0  <font color=\"red\"><b>disconnected</b></font>.<br />";
    }
    ?>
    
    
</div>

<br>
<a href="scripts/kismet_output.php?file=all">export all</a>
<br>

<?
//echo realpath(dirname(__FILE__));

$netxml = glob('logs/kismet/*.netxml');
//print_r($a);

//$netxml = system("/bin/ls -l ../kismet/*.netxml |awk '{print $9}'");

for ($i = 0; $i < count($netxml); $i++) {
    $filename = str_replace(".netxml","",str_replace("logs/kismet/","",$netxml[$i]));
    echo "<a href='scripts/kismet_output.php?file=".str_replace(".netxml","",str_replace("logs/kismet/","",$netxml[$i]))."&action=delete'><b>x</b></a> ";
    echo $filename . " | ";
    echo "<a href='scripts/kismet_output.php?file=".str_replace(".netxml","",str_replace("logs/kismet/","",$netxml[$i]))."'><b>export</b></a> | ";
    if (file_exists("logs/kismet/output_$filename.kml")) {
        echo "<a href='logs/kismet/output_$filename.kml'><b>download</b></a>";
    }
    echo "<br>";
}
?>
