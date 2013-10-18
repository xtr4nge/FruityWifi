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
<? include "login_check.php"; ?>
<? include "config/config.php" ?>
<? include "menu.php" ?>

<br>
<div class="rounded-top" align="center"> Services </div>
<div class="rounded-bottom">
<?
include "functions.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET['service'], "msg.php", $regex_extra);
    regex_standard($_GET['action'], "msg.php", $regex_extra);
}
$service = $_GET['service'];
$action = $_GET['action'];

?>

<?
//$iswlanup = exec("/sbin/ifconfig wlan0 | grep UP | awk '{print $1}'");
$iswlanup = exec("ps auxww | grep hostapd | grep -v -e grep");
//if ($iswlanup == "UP") {
if ($iswlanup != "") {
    #echo "&nbsp;Wireless  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"page_status.php?service=wireless&action=stop\"><b>stop</b></a><br />";
    echo "&nbsp;&nbsp;Wireless  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_wireless.php?service=wireless&action=stop\" class='div-a'><b>stop</b></a><br />";
} else { 
    #echo "&nbsp;Wireless  <font color=\"red\"><b>disabled</b></font>. | <a href=\"page_status.php?service=wireless&action=start\"><b>start</b></a><br />"; 
    echo "&nbsp;&nbsp;Wireless  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_wireless.php?service=wireless&action=start\" class='div-a'><b>start</b></a><br />"; 
}
?>

<?
/*
if ($iface_supplicant != "-") {
    $exec = "nmcli -n d |grep '^$iface_supplicant'";
    $output = exec("./bin/danger \"" . $exec . "\"" );
    $output = preg_replace('/\s+/', ' ',$output);
    $output = explode(" ",$output);
    //print_r($output);
    $issupplicantup = $output[2];
} else {
    $issupplicantup = "";
}
*/
$exec = "nmcli -n d |grep '^$iface_supplicant'";
$output = exec("./bin/danger \"" . $exec . "\"" );
$output = preg_replace('/\s+/', ' ',$output);
$output = explode(" ",$output);
//print_r($output);
$issupplicantup = $output[2];

if ($issupplicantup == "connected") {
    #echo "&nbsp;Wireless  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"page_status.php?service=wireless&action=stop\"><b>stop</b></a><br />";
    echo "Supplicant  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_nmcli.php?service=supplicant&action=stop\" class='div-a'><b>stop</b></a><br />";
} else { 
    #echo "&nbsp;Wireless  <font color=\"red\"><b>disabled</b></font>. | <a href=\"page_status.php?service=wireless&action=start\"><b>start</b></a><br />"; 
    echo "Supplicant  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_nmcli.php?service=supplicant&action=start\" class='div-a'><b>start</b></a>"; 
    echo " | <a href=\"page_config.php\"><b>edit</b></a><br/>";
}
?>

<?
$exec = "/usr/sbin/karma-hostapd_cli -p /var/run/hostapd-phy0 karma_get_state | tail -1";
$output = exec("./bin/danger \"" . $exec . "\"" );
if ( $output == "ENABLED" ){
    $iskarmaup = true;
}
if ($iskarmaup != "") {
    #echo "MK4 Karma  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"page_status.php?service=karma&action=stop\"><b>stop</b></a><br />";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Karma  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_karma.php?service=karma&action=stop\"><b>stop</b></a><br />";
} else { 
    #echo "MK4 Karma  <font color=\"red\"><b>disabled</b></font>. | <a href=\"page_status.php?service=karma&action=start\"><b>start</b></a> <br />"; 
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Karma  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_karma.php?service=karma&action=start\"><b>start</b></a> <br />"; 
}
?>

<?
$isurlsnarfup = exec("ps auxww | grep urlsnarf | grep -v -e grep");
if ($isurlsnarfup != "") {
    #echo "URL Snarf  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"page_status.php?service=urlsnarf&action=stop\"><b>stop</b></a><br />";
    echo "&nbsp;URL Snarf  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_urlsnarf.php?service=urlsnarf&action=stop\"><b>stop</b></a><br />";
} else { 
    #echo "URL Snarf  <font color=\"red\"><b>disabled</b></font>. | <a href=\"page_status.php?service=urlsnarf&action=start\"><b>start</b></a><br />"; 
    echo "&nbsp;URL Snarf  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_urlsnarf.php?service=urlsnarf&action=start\"><b>start</b></a><br />"; 
}
?>

<?
$isdnsspoofup = exec("ps auxww | grep dnsspoof | grep -v -e grep");
if ($isdnsspoofup != "") {
    #echo "DNS Spoof  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"page_status.php?service=dnsspoof&action=stop\"><b>stop</b></a><br />";
    echo "&nbsp;DNS Spoof  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_dnsspoof.php?service=dnsspoof&action=stop\"><b>stop</b></a><br />";
} else { 
    #echo "DNS Spoof  <font color=\"red\"><b>disabled</b></font>. | <a href=\"page_status.php?service=dnsspoof&action=start\"><b>start</b></a> | <a href=\"page_config.php?config#dnsspoof\"><b>edit</b></a><br/>"; 
    echo "&nbsp;DNS Spoof  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_dnsspoof.php?service=dnsspoof&action=start\"><b>start</b></a> | <a href=\"page_config.php?config#dnsspoof\"><b>edit</b></a><br/>"; 
}

?>


<?
$iskismetup = exec("ps auxww | grep kismet_server | grep -v -e grep");
if ($iskismetup != "") {
    //echo "&nbsp;&nbsp;&nbsp;Kismet  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"page_status.php?service=kismet&action=stop\"><b>stop</b></a><br />";
    //echo "&nbsp;&nbsp;&nbsp;Kismet  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"action.php?service=kismet&action=stop\"><b>stop</b></a><br />";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;Kismet  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_kismet.php?service=kismet&action=stop\"><b>stop</b></a><br />";
} else { 
    //echo "&nbsp;&nbsp;&nbsp;Kismet  <font color=\"red\"><b>disabled</b></font>. | <a href=\"page_status.php?service=kismet&action=start\"><b>start</b></a><br/>"; 
    //echo "&nbsp;&nbsp;&nbsp;Kismet  <font color=\"red\"><b>disabled</b></font>. | <a href=\"action.php?service=kismet&action=start\"><b>start</b></a><br/>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;Kismet  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_kismet.php?service=kismet&action=start\"><b>start</b></a>";
    echo " | <a href=\"page_kismet.php\"><b>edit</b></a><br/>";
}

?>

<?
$issquidup = exec("ps auxww | grep squid3 | grep -v -e grep");
if ($issquidup != "") {
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Squid  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_squid.php?service=squid&action=stop\"><b>stop</b></a><br />";
} else { 
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Squid  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_squid.php?service=squid&action=start\"><b>start</b></a>";
    echo " | <a href=\"page_squid.php\"><b>edit</b></a><br/>";
}

?>

<?
$issslstripup = exec("ps auxww | grep sslstrip | grep -v -e grep");
if ($issslstripup != "") {
    #echo "&nbsp;Wireless  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"page_status.php?service=wireless&action=stop\"><b>stop</b></a><br />";
    echo "&nbsp;&nbsp;sslstrip  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"scripts/status_sslstrip.php?service=sslstrip&action=stop\"><b>stop</b></a><br />";
} else { 
    #echo "&nbsp;Wireless  <font color=\"red\"><b>disabled</b></font>. | <a href=\"page_status.php?service=wireless&action=start\"><b>start</b></a><br />"; 
    echo "&nbsp;&nbsp;sslstrip  <font color=\"red\"><b>disabled</b></font>. | <a href=\"scripts/status_sslstrip.php?service=sslstrip&action=start\"><b>start</b></a>"; 
    echo " | <a href=\"page_sslstrip.php\"><b>edit</b></a><br/>";
}
?>
</div>

<br>

<div class="rounded-top" align="center"> Interfaces/IP </div>
<div class="rounded-bottom">
<?

$ifaces = exec("/sbin/ifconfig -a | cut -c 1-8 | sort | uniq -u |grep -v lo|sed ':a;N;$!ba;s/\\n/|/g'");
$ifaces = str_replace(" ","",$ifaces);
$ifaces = explode("|", $ifaces);

	for ($i = 0; $i < count($ifaces); $i++) {
        if (strpos($ifaces[$i], "mon") === false) {
            echo $ifaces[$i] . ": ";
            $ip = exec("/sbin/ifconfig $ifaces[$i] | grep 'inet addr:' | cut -d: -f2 |awk '{print $1}'");
            echo $ip . "<br>";
        }
	}

if ($_GET['reveal_public_ip'] == 1) {
	echo "public: " . exec("curl ident.me");
} else {
	echo "public: <a href='page_status.php?reveal_public_ip=1'>reveal ip</a>";
}

?>
</div>

<br>

<div class="rounded-top" align="center"> Stations </div>
<div class="rounded-bottom">
    <?
    //$stations = exec("/sbin/iw dev wlan0 station dump |grep Stat");
    $stations = exec("/sbin/iw dev $iface_wifi station dump |grep Stat");
    echo str_replace("Station", "", $stations) . "<br>";
    ?>
</div>

<br>

<div class="rounded-top" align="center"> DHCP </div>
<div class="rounded-bottom">
    <?
    $filename = "/FruityWifi/logs/dhcp.leases";
    $fh = fopen($filename, "r") or die("Could not open file.");
    $data = fread($fh, filesize($filename)) or die("Could not read file.");
    fclose($fh);
    $data = explode("\n",$data);
    
    for ($i=0; $i < count($data); $i++) {
        $tmp = explode(" ", $data[$i]);
        echo $tmp[2] . " " . $tmp[3] . " " . $tmp[4] . "<br>";
    }
    ?>
</div>

