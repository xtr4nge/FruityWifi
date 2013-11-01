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
<? include "config/config.php" ?>

<br>
<div class="rounded-top" align="center"> Squid Setup </div>
<div class="rounded-bottom">
    <?
    $issquidup = exec("ps auxww | grep squid3 | grep -v -e grep");
    if ($issquidup != "") {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;Squid  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_squid.php?service=squid&action=stop&page=module\"><b>stop</b></a><br />";
    } else { 
        echo "&nbsp;&nbsp;&nbsp;&nbsp;Squid  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_squid.php?service=squid&action=start&page=module\"><b>start</b></a><br />";
    }

    ?>
    <?

    //$exec = "/bin/grep '^url_rewrite_program' /usr/share/FruityWifi/conf/squid.conf";

    $isurlrewriteup = exec("/bin/grep '^url_rewrite_program' /usr/share/FruityWifi/conf/squid.conf");
    if ($isurlrewriteup != "") {    
        echo "&nbsp;&nbsp;&nbsp;Inject  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_squid.php?service=url_rewrite&action=stop\"><b>stop</b></a><br />";
    } else { 
        echo "&nbsp;&nbsp;&nbsp;Inject  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_squid.php?service=url_rewrite&action=start\"><b>start</b></a><br />";
    }

    ?>
    <?

    //$exec = "/bin/grep '^url_rewrite_program' /usr/share/FruityWifi/conf/squid.conf";

    $exec = "/sbin/iptables -nvL -t nat |grep -E 'REDIRECT.+3128'";
    $isiptablesup = exec("bin/danger \"" . $exec . "\"" );
    if ($isiptablesup != "") { 
        echo "&nbsp;Iptables  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_squid.php?service=iptables&action=stop\"><b>stop</b></a><br />";
    } else { 
        echo "&nbsp;Iptables  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_squid.php?service=iptables&action=start\"><b>start</b></a><br />";
    }

    ?>
</div>

<br>

<div class="rounded-top" align="center"> Inject Script </div>
<div class="rounded-bottom">
<?
//echo realpath(dirname(__FILE__));

$files = glob('/usr/share/FruityWifi/squid.inject/*.js');
print_r($a);

//$netxml = system("/bin/ls -l ../kismet/*.netxml |awk '{print $9}'");

for ($i = 0; $i < count($files); $i++) {
    $filename = str_replace(".js","",str_replace("/usr/share/FruityWifi/squid.inject/","",$files[$i]));
    //echo "<a href='scripts/sslstrip_output.php?file=".str_replace(".log","",str_replace("logs/sslstrip/","",$files[$i]))."&action=delete'>x</a> ";
    //echo $filename . " | ";
    if ($filename != "pasarela") {
        if ("$filename.js" == $url_rewrite_program) echo "+ ";
        echo "<a href=\"scripts/status_squid.php?service=js&action=$filename&page=module\">$filename</a>";
        //echo $filename;
        //echo "<a href='scripts/kismet_output.php?file=".str_replace(".log","",str_replace("logs/sslstrip/","",$logs[$i]))."'>view</a>";
        //echo "<a href='scripts/view_log.php?file=".str_replace(".log","",str_replace("logs/sslstrip/","",$files[$i]))."&module=sslstrip'>view</a>";
        echo "<br>";
    }
}
?>
</div>
