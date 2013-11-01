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

// nmcli dev wifi connect 'iPhone' password 'test.123456' name nmcli_raspberry_wifi // CREATE

// nmcli -n d disconnect iface wlan0 // DISCONNECT

// nmcli --nocheck d |grep -iEe 'wlan0.+disconnected' // CHECK connection

include "../login_check.php";
include "../config/config.php";
include "../functions.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["service"], "../msg.php", $regex_extra);
    regex_standard($_GET["file"], "../msg.php", $regex_extra);
    regex_standard($_GET["action"], "../msg.php", $regex_extra);
    regex_standard($iface_supplicant, "../msg.php", $regex_extra);
    regex_standard($supplicant_ssid, "../msg.php", $regex_extra);
    regex_standard($supplicant_psk, "../msg.php", $regex_extra);
}

$service = $_GET['service'];
$action = $_GET['action'];
$page = $_GET['page'];

if($service == "supplicant") {
    if ($action == "start") {
        $exec = "/usr/bin/killall dhclient";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
        $exec = "/usr/bin/killall wpa_supplicant";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );

        $exec = "/sbin/ifconfig $iface_supplicant down";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
        $exec = "/usr/bin/macchanger -A $iface_supplicant";
        system("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/ifconfig $iface_supplicant up";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );

        #$exec = "/sbin/wpa_passphrase '$supplicant_ssid' '$supplicant_key' > /usr/share/FruityWifi/conf/wpa_supplicant.conf";
        #exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );

        $exec = "/bin/sed -i 's/ssid=.*/ssid=\\\"".$supplicant_ssid."\\\";/g' ../config/config.php";

        $exec = "/bin/sed -i 's/psk=.*/psk=\\\"".$supplicant_psk."\\\";/g' ../config/config.php";


        $exec = "/sbin/wpa_supplicant -B -D nl80211 -i $iface_supplicant -c /usr/share/FruityWifi/conf/wpa_supplicant.conf";
        #$exec = "/sbin/wpa_supplicant -B -D nl80211,wext -i $iface_supplicant -c /usr/share/FruityWifi/conf/wpa_supplicant.conf";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );

        #WEP
        #iwconfig wlan1 mode managed key your_key_here
        #iwconfig wlan1 essid "your access point name here"

        #OPEN
        #iwconfig wlan1 essid "your access point name here"

        $exec = "/bin/sleep 6";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );

        $exec = "/sbin/dhclient -r $iface_supplicant";
        #exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/dhclient $iface_supplicant";
        #exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    } else if($action == "stop") {
        $exec = "/usr/bin/killall dhclient";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
        $exec = "/usr/bin/killall wpa_supplicant";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    }
}

if ($page == "module") {
    header('Location: ../page_supplicant.php');
} else {
    header('Location: ../action.php');
}

?>