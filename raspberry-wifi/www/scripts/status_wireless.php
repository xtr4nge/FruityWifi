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

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["service"], "../msg.php", $regex_extra);
    regex_standard($_GET["action"], "../msg.php", $regex_extra);
    regex_standard($iface_wifi, "../msg.php", $regex_extra);
    regex_standard($iface_internet, "../msg.php", $regex_extra);
}

#echo $iface_internet;
#echo $iface_wifi;

$service = $_GET['service'];
$action = $_GET['action'];

#sed -i 's/interface=.*/interface=wlan0/g' /raspberry-wifi/conf/dnsmasq.conf

if($service == "wireless") {
    if ($action == "start") {

        //$internet_interface="eth0";
        //$ap_interface="wlan0";

        $exec = "/usr/bin/killall karma-hostapd";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/bin/rm /var/run/hostapd-phy0/$iface_wifi";
        exec("../bin/danger \"" . $exec . "\"" );

        $exec = "/sbin/ifconfig $iface_wifi up";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/ifconfig $iface_wifi up 10.0.0.1 netmask 255.255.255.0";
        exec("../bin/danger \"" . $exec . "\"" );

        $exec = "/usr/bin/killall dnsmasq";
        exec("../bin/danger \"" . $exec . "\"" );

        //$exec = "/etc/init.d/dnsmasq restart";
        $exec = "/usr/sbin/dnsmasq -C /raspberry-wifi/conf/dnsmasq.conf";
        exec("../bin/danger \"" . $exec . "\"" );
        
        if ($hostapd_secure == 1) {
            $exec = "/usr/sbin/karma-hostapd -P /var/run/hostapd-phy0 -B /raspberry-wifi/conf/hostapd-secure.conf";
            #$exec = "/usr/sbin/karma-hostapd -P /var/run/hostapd-phy0 -B /etc/hostapd/wifi-secure.conf -f /var/log/karma-hostapd.log -d";
        } else {
            $exec = "/usr/sbin/karma-hostapd -P /var/run/hostapd-phy0 -B /raspberry-wifi/conf/hostapd.conf";
            #$exec = "/usr/sbin/karma-hostapd -P /var/run/hostapd-phy0 -B /etc/hostapd/pineapple.conf -f /var/log/karma-hostapd.log -d";
        }
        exec("../bin/danger \"" . $exec . "\"" );

        $exec = "/sbin/iptables -F";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -F";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t mangle -F";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -X";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -X";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t mangle -X";
        exec("../bin/danger \"" . $exec . "\"" );

        $exec = "/bin/echo 1 > /proc/sys/net/ipv4/ip_forward";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -A POSTROUTING -o $iface_internet -j MASQUERADE";
        exec("../bin/danger \"" . $exec . "\"" );

    } else if($action == "stop") {

        $exec = "/usr/bin/killall karma-hostapd";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/bin/rm /var/run/hostapd-phy0/$iface_wifi";
        exec("../bin/danger \"" . $exec . "\"" );

        $exec = "/usr/bin/killall dnsmasq";
        exec("../bin/danger \"" . $exec . "\"" );

        $exec = "/sbin/ifconfig $iface_wifi down";
        exec("../bin/danger \"" . $exec . "\"" );

        $exec = "/sbin/iptables -F";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -F";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t mangle -F";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -X";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -X";
        exec("../bin/danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t mangle -X";
        exec("../bin/danger \"" . $exec . "\"" );

    }
}

header('Location: ../action.php');

?>
