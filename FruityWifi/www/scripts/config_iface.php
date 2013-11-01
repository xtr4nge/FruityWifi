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
<?
include "../login_check.php";
include "../config/config.php";
include "../functions.php";

// Checking POST & GET variables [regex]...
if ($regex == 1) {
    regex_standard($_POST["iface"], "../msg.php", $regex_extra);
    regex_standard($_POST["iface_internet"], "../msg.php", $regex_extra);
    regex_standard($_POST["iface_wifi"], "../msg.php", $regex_extra);
    regex_standard($_POST["iface_wifi_extra"], "../msg.php", $regex_extra);
    regex_standard($_POST["wifi_supplicant"], "../msg.php", $regex_extra);
}

if(isset($_POST["iface"]) and $_POST["iface"] == "internet"){
    $exec = "/bin/sed -i 's/iface_internet=.*/iface_internet=\\\"".$_POST["iface_internet"]."\\\";/g' ../config/config.php";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
}

if(isset($_POST["iface"]) and $_POST["iface"] == "wifi"){
    $exec = "/bin/sed -i 's/iface_wifi=.*/iface_wifi=\\\"".$_POST["iface_wifi"]."\\\";/g' ../config/config.php";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
 
    // replace interface in hostapd.conf and hostapd-secure.conf
    $exec = "/bin/sed -i 's/^interface=.*/interface=".$_POST["iface_wifi"]."/g' /usr/share/FruityWifi/conf/hostapd.conf";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    $exec = "/bin/sed -i 's/^interface=.*/interface=".$_POST["iface_wifi"]."/g' /usr/share/FruityWifi/conf/hostapd-secure.conf";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    
    $exec = "/bin/sed -i 's/interface=.*/interface=".$_POST["iface_wifi"]."/g' /usr/share/FruityWifi/conf/dnsmasq.conf";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    
    //EXTRACT MACADDRESS
    $exec = "/sbin/ifconfig -a ".$_POST["iface_wifi"]." |grep HWaddr";
    $output = exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    $output = preg_replace('/\s+/', ' ',$output);
    $output = explode(" ",$output);
    
    $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' /usr/share/FruityWifi/conf/hostapd.conf";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' /usr/share/FruityWifi/conf/hostapd-secure.conf";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );

}

if(isset($_POST["iface"]) and $_POST["iface"] == "wifi_extra"){
    $exec = "/bin/sed -i 's/iface_wifi_extra=.*/iface_wifi_extra=\\\"".$_POST["iface_wifi_extra"]."\\\";/g' ../config/config.php";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
}

if(isset($_POST["iface"]) and $_POST["iface"] == "wifi_supplicant"){
    $exec = "/bin/sed -i 's/iface_supplicant=.*/iface_supplicant=\\\"".$_POST["iface_supplicant"]."\\\";/g' ../config/config.php";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
}

header('Location: ../page_config.php');

?>