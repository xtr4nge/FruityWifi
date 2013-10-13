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

<div class="rounded-top" align="center"> sslstrip Setup </div>
<div class="rounded-bottom">
    <?
    $issslstripup = exec("ps auxww | grep sslstrip | grep -v -e grep");
    if ($issslstripup != "") {
        #echo "&nbsp;Wireless  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"page_status.php?service=wireless&action=stop\"><b>stop</b></a><br />";
        echo "&nbsp;sslstrip  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_sslstrip.php?service=sslstrip&action=stop&page=module\"><b>stop</b></a><br />";
    } else { 
        #echo "&nbsp;Wireless  <font color=\"red\"><b>disabled</b></font>. | <a href=\"page_status.php?service=wireless&action=start\"><b>start</b></a><br />"; 
        echo "&nbsp;sslstrip  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_sslstrip.php?service=sslstrip&action=start&page=module\"><b>start</b></a><br />"; 
    }
    ?>
</div>

<br>

<?
//echo realpath(dirname(__FILE__));

$logs = glob('logs/sslstrip/*.log');
print_r($a);

//$netxml = system("/bin/ls -l ../kismet/*.netxml |awk '{print $9}'");

for ($i = 0; $i < count($logs); $i++) {
    $filename = str_replace(".log","",str_replace("logs/sslstrip/","",$logs[$i]));
    echo "<a href='scripts/sslstrip_output.php?file=".str_replace(".log","",str_replace("logs/sslstrip/","",$logs[$i]))."&action=delete'><b>x</b></a> ";
    echo $filename . " | ";
    //echo "<a href='scripts/kismet_output.php?file=".str_replace(".log","",str_replace("logs/sslstrip/","",$logs[$i]))."'>view</a>";
    echo "<a href='scripts/view_log.php?file=".str_replace(".log","",str_replace("logs/sslstrip/","",$logs[$i]))."&module=sslstrip'><b>view</b></a>";
    echo "<br>";
}
?>
