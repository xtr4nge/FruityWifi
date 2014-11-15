<? 
/*
    Copyright (C) 2013-2014 xtr4nge [_AT_] gmail.com

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

$bin_danger = "/usr/share/fruitywifi/bin/danger";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["service"], "../msg.php", $regex_extra);
    regex_standard($_GET["action"], "../msg.php", $regex_extra);
    regex_standard($io_in_iface, "../msg.php", $regex_extra);
    regex_standard($io_out_iface, "../msg.php", $regex_extra);
}

#echo $io_out_iface;
#echo $io_in_iface;

$service = $_GET['service'];
$action = $_GET['action'];

$bin_danger = "/usr/share/fruitywifi/bin/danger";
$bin_killall = "/usr/bin/killall";

#sed -i 's/interface=.*/interface=wlan0/g' /usr/share/fruitywifi/conf/dnsmasq.conf

if($service == "wireless"  and $ap_mode == "1") {
    if ($action == "start") {

        //$internet_interface="eth0";
        //$ap_interface="wlan0";

	//Verifies if karma-hostapd is installed
	/*
	if (file_exists("/usr/sbin/karma-hostapd")) {
		$exec = "$bin_killall karma-hostapd";
	} else {
		$exec = "$bin_killall hostapd";			
	}
	*/
	if (file_exists("/usr/share/fruitywifi/www/modules/karma/includes/hostapd")) {
		$exec = "$bin_killall hostapd";
	} else {
		$exec = "$bin_killall hostapd";			
	}
	exec("$bin_danger \"" . $exec . "\"" );

        #$exec = "$bin_killall karma-hostapd";
        #exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/bin/rm /var/run/hostapd-phy0/$io_in_iface";
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "$bin_killall dnsmasq";
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "/sbin/ifconfig $io_in_iface up";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/ifconfig $io_in_iface up $io_in_ip netmask 255.255.255.0";
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "echo 'nameserver $io_in_ip\nnameserver 8.8.8.8' > /etc/resolv.conf ";
        exec("$bin_danger \"" . $exec . "\"" );

        //$exec = "/etc/init.d/dnsmasq restart";
        $exec = "/usr/sbin/dnsmasq -C /usr/share/fruitywifi/conf/dnsmasq.conf";
        exec("$bin_danger \"" . $exec . "\"" );
	
	//Verifies if karma-hostapd is installed
	if ($hostapd_secure == 1) {
	    /*
	    if (file_exists("/usr/sbin/karma-hostapd")) {
		$exec = "/usr/sbin/karma-hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd-secure.conf";
	    } else {
		$exec = "/usr/sbin/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd-secure.conf";
	    }
	    */
	    if (file_exists("/usr/share/fruitywifi/www/modules/karma/includes/hostapd")) {
		$exec = "/usr/share/fruitywifi/www/modules/karma/includes/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd-secure.conf";
	    } else {
		$exec = "/usr/sbin/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd-secure.conf";
	    }
		
        } else {
	    /*
	    if (file_exists("/usr/sbin/karma-hostapd")) {
		$exec = "/usr/sbin/karma-hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd.conf";
	    } else {
		$exec = "/usr/sbin/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd.conf";
	    }
	    */
	    if (file_exists("/usr/share/fruitywifi/www/modules/karma/includes/hostapd")) {
		$exec = "/usr/share/fruitywifi/www/modules/karma/includes/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd.conf";
	    } else {
		$exec = "/usr/sbin/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd.conf";
	    }
        }
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "/sbin/iptables -F";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -F";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t mangle -F";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -X";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -X";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t mangle -X";
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "/bin/echo 1 > /proc/sys/net/ipv4/ip_forward";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -A POSTROUTING -o $io_out_iface -j MASQUERADE";
        exec("$bin_danger \"" . $exec . "\"" );
        
        // CLEAN DHCP log
        $exec = "echo '' > /usr/share/fruitywifi/logs/dhcp.leases";
        exec("$bin_danger \"" . $exec . "\"" );

    } else if($action == "stop") {

	//Verifies if karma-hostapd is installed
	/*
	if (file_exists("/usr/sbin/karma-hostapd")) {
	    $exec = "$bin_killall karma-hostapd";
	} else {
	    $exec = "$bin_killall hostapd";			
	}
	*/
	if (file_exists("/usr/share/fruitywifi/www/modules/karma/includes/hostapd")) {
	    $exec = "$bin_killall hostapd";
	} else {
	    $exec = "$bin_killall hostapd";			
	}	
	exec("$bin_danger \"" . $exec . "\"" );

        #$exec = "$bin_killall karma-hostapd";
        #exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/bin/rm /var/run/hostapd-phy0/$io_in_iface";
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "$bin_killall dnsmasq";
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "ip addr flush dev $io_in_iface";
        exec("$bin_danger \"" . $exec . "\"" );
        
        $exec = "/sbin/ifconfig $io_in_iface down";
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "/sbin/iptables -F";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -F";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t mangle -F";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -X";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -X";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t mangle -X";
        exec("$bin_danger \"" . $exec . "\"" );

    }
}

if($service == "wireless" and $ap_mode == "2") { // AIRCRACK (airbase-ng)
    if ($action == "start") {

	$exec = "/usr/bin/sudo /usr/sbin/airmon-ng stop mon0";
	exec("$bin_danger \"" . $exec . "\"" );

	$exec = "$bin_killall airbase-ng";
	exec("$bin_danger \"" . $exec . "\"" );

        $exec = "$bin_killall dnsmasq";
        exec("$bin_danger \"" . $exec . "\"" );

	/*
        $exec = "/sbin/ifconfig $io_in_iface up";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/ifconfig $io_in_iface up $io_in_ip netmask 255.255.255.0";
        exec("$bin_danger \"" . $exec . "\"" );
	*/
		
	$exec = "echo 'nameserver $io_in_ip\nnameserver 8.8.8.8' > /etc/resolv.conf ";
        exec("$bin_danger \"" . $exec . "\"" );
		
	$exec = "/usr/bin/sudo /usr/sbin/airmon-ng start $io_in_iface";
	exec("$bin_danger \"" . $exec . "\"" );
	
	//$exec = "/usr/sbin/airbase-ng -e $hostapd_ssid -c 2 mon0 > /dev/null &"; //-P (all)
	$exec = "/usr/sbin/airbase-ng -e $hostapd_ssid -c 2 mon0 > /tmp/airbase.log &"; //-P (all)
        exec("$bin_danger \"" . $exec . "\"" );

	//$exec = "/sbin/ifconfig at0 up 10.0.0.1 netmask 255.255.255.0";
        //exec("$bin_danger \"" . $exec . "\"" );

	$exec = "sleep 1";
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "/sbin/ifconfig at0 up";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/ifconfig at0 up $io_in_ip netmask 255.255.255.0";
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "/usr/sbin/dnsmasq -C /usr/share/fruitywifi/conf/dnsmasq.conf";
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "/sbin/iptables -F";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -F";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t mangle -F";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -X";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -X";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t mangle -X";
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "/bin/echo 1 > /proc/sys/net/ipv4/ip_forward";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -A POSTROUTING -o $io_out_iface -j MASQUERADE";
        exec("$bin_danger \"" . $exec . "\"" );
        
        // CLEAN DHCP log
        $exec = "echo '' > /usr/share/fruitywifi/logs/dhcp.leases";
        exec("$bin_danger \"" . $exec . "\"" );

    } else if($action == "stop") {

	$exec = "$bin_killall airbase-ng";
	exec("$bin_danger \"" . $exec . "\"" );

        $exec = "$bin_killall dnsmasq";
        exec("$bin_danger \"" . $exec . "\"" );

	$exec = "/usr/bin/sudo /usr/sbin/airmon-ng stop mon0";
	exec("$bin_danger \"" . $exec . "\"" );

        $exec = "ip addr flush dev at0";
        exec("$bin_danger \"" . $exec . "\"" );
        
        $exec = "/sbin/ifconfig at0 down";
        exec("$bin_danger \"" . $exec . "\"" );

        $exec = "/sbin/iptables -F";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -F";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t mangle -F";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -X";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t nat -X";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/sbin/iptables -t mangle -X";
        exec("$bin_danger \"" . $exec . "\"" );

    }
}

header('Location: ../action.php');

?>
