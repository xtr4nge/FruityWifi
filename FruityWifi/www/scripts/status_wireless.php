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

//$bin_danger = "/usr/share/fruitywifi/bin/danger"; //DEPRECATED

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

// HOSTAPD
if($service == "wireless"  and $ap_mode == "1") {
    if ($action == "start") {
        
        $exec = "$bin_killall hostapd";	
        exec_fruitywifi($exec);

        #$exec = "$bin_killall karma-hostapd";
        #exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        $exec = "/bin/rm /var/run/hostapd-phy0/$io_in_iface";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "$bin_killall dnsmasq";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "/sbin/ifconfig $io_in_iface up";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/ifconfig $io_in_iface up $io_in_ip netmask 255.255.255.0";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        
        $exec = "echo 'nameserver $io_in_ip\nnameserver 8.8.8.8' > /etc/resolv.conf ";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        
        //$exec = "/etc/init.d/dnsmasq restart";
        $exec = "/usr/sbin/dnsmasq -C /usr/share/fruitywifi/conf/dnsmasq.conf";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
	
        //Verifies if karma-hostapd is installed
        if ($hostapd_secure == 1) {
            /*
            if (file_exists("/usr/share/fruitywifi/www/modules/karma/includes/hostapd")) {
                $exec = "/usr/share/fruitywifi/www/modules/karma/includes/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd-secure.conf";
            } else {
                $exec = "/usr/sbin/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd-secure.conf";
            }
            */
            
            //REPLACE SSID
            $exec = "/bin/sed -i 's/^ssid=.*/ssid=".$hostapd_ssid."/g' /usr/share/fruitywificonf/hostapd-secure.conf";
            exec_fruitywifi($exec);
            
            //REPLACE IFACE                
            $exec = "/bin/sed -i 's/^interface=.*/interface=".$io_in_iface."/g' /usr/share/fruitywificonf/hostapd-secure.conf";
            exec_fruitywifi($exec);
            
            //REPLACE WPA_PASSPHRASE
            $exec = "sed -i 's/wpa_passphrase=.*/wpa_passphrase=".$hostapd_wpa_passphrase."/g' /usr/share/fruitywificonf/hostapd-secure.conf";
            exec_fruitywifi($exec);
            
            //EXTRACT MACADDRESS
            unset($output);
            $exec = "/sbin/ifconfig -a $io_in_iface |grep HWaddr";
            $output = exec_fruitywifi($exec);
            $output = preg_replace('/\s+/', ' ',$output[0]);
            $output = explode(" ",$output);
            
            //REPLACE MAC
            $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' /usr/share/fruitywifi/conf/hostapd-secure.conf";
            exec_fruitywifi($exec);
            
            $exec = "/usr/sbin/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd-secure.conf";
        } else {
            /*
            if (file_exists("/usr/share/fruitywifi/www/modules/karma/includes/hostapd")) {
                $exec = "/usr/share/fruitywifi/www/modules/karma/includes/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd.conf";
            } else {
                $exec = "/usr/sbin/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd.conf";
            }
            */
            
            //REPLACE SSID
            $exec = "/bin/sed -i 's/^ssid=.*/ssid=".$hostapd_ssid."/g' /usr/share/fruitywificonf/hostapd.conf";
            exec_fruitywifi($exec);
            
            //REPLACE IFACE                
            $exec = "/bin/sed -i 's/^interface=.*/interface=".$io_in_iface."/g' /usr/share/fruitywificonf/hostapd.conf";
            exec_fruitywifi($exec);
            
            //REPLACE WPA_PASSPHRASE
            $exec = "sed -i 's/wpa_passphrase=.*/wpa_passphrase=".$hostapd_wpa_passphrase."/g' /usr/share/fruitywificonf/hostapd.conf";
            exec_fruitywifi($exec);
            
            //EXTRACT MACADDRESS
            unset($output);
            $exec = "/sbin/ifconfig -a $io_in_iface |grep HWaddr";
            $output = exec_fruitywifi($exec);
            $output = preg_replace('/\s+/', ' ',$output[0]);
            $output = explode(" ",$output);
            
            //REPLACE BSSID
            $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' /usr/share/fruitywifi/conf/hostapd.conf";
            exec_fruitywifi($exec);
            
            $exec = "/usr/sbin/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd.conf";
        }
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "/sbin/iptables -F";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -F";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -F";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -X";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -X";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -X";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "/bin/echo 1 > /proc/sys/net/ipv4/ip_forward";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -A POSTROUTING -o $io_out_iface -j MASQUERADE";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        
        // CLEAN DHCP log
        $exec = "echo '' > /usr/share/fruitywifi/logs/dhcp.leases";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

    } else if($action == "stop") {

        if (file_exists("/usr/share/fruitywifi/www/modules/karma/includes/hostapd")) {
            $exec = "$bin_killall hostapd";
        } else {
            $exec = "$bin_killall hostapd";			
        }	
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        #exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        $exec = "/bin/rm /var/run/hostapd-phy0/$io_in_iface";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "$bin_killall dnsmasq";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "ip addr flush dev $io_in_iface";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        
        $exec = "/sbin/ifconfig $io_in_iface down";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "/sbin/iptables -F";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -F";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -F";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -X";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -X";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -X";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

    }
}

// AIRCRACK
if($service == "wireless" and $ap_mode == "2") { // AIRCRACK (airbase-ng)
    if ($action == "start") {

        $exec = "/usr/bin/sudo /usr/sbin/airmon-ng stop mon0";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
    
        $exec = "$bin_killall airbase-ng";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
    
        $exec = "$bin_killall dnsmasq";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
            
        $exec = "echo 'nameserver $io_in_ip\nnameserver 8.8.8.8' > /etc/resolv.conf ";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
            
        $exec = "/usr/bin/sudo /usr/sbin/airmon-ng start $io_in_iface";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        
        //$exec = "/usr/sbin/airbase-ng -e $hostapd_ssid -c 2 mon0 > /dev/null &"; //-P (all)
        $exec = "/usr/sbin/airbase-ng -e $hostapd_ssid -c 2 mon0 > /tmp/airbase.log &"; //-P (all)
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        //$exec = "/sbin/ifconfig at0 up 10.0.0.1 netmask 255.255.255.0";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED

        $exec = "sleep 1";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "/sbin/ifconfig at0 up";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/ifconfig at0 up $io_in_ip netmask 255.255.255.0";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "/usr/sbin/dnsmasq -C /usr/share/fruitywifi/conf/dnsmasq.conf";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "/sbin/iptables -F";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -F";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -F";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -X";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -X";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -X";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "/bin/echo 1 > /proc/sys/net/ipv4/ip_forward";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -A POSTROUTING -o $io_out_iface -j MASQUERADE";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        
        // CLEAN DHCP log
        $exec = "echo '' > /usr/share/fruitywifi/logs/dhcp.leases";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

    } else if($action == "stop") {

        $exec = "$bin_killall airbase-ng";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "$bin_killall dnsmasq";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "/usr/bin/sudo /usr/sbin/airmon-ng stop mon0";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "ip addr flush dev at0";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        
        $exec = "/sbin/ifconfig at0 down";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

        $exec = "/sbin/iptables -F";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -F";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -F";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -X";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -X";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -X";
        //exec("$bin_danger \"" . $exec . "\"" ); //DEPRECATED
        exec_fruitywifi($exec);

    }
}

// HOSTAPD MANA
if($service == "wireless"  and $ap_mode == "3") {
    if ($action == "start") {
        
        //unmanaged-devices=mac:<realmac>;interface-name:wlan2
        //macchanger --show wlan0 |grep "Permanent"
        
        $exec = "macchanger --show $io_in_iface |grep 'Permanent'";
        //$output = exec_fruitywifi($exec);
        exec($exec, $output);
        $mac = explode(" ", $output[0]);
        
        $exec = "grep '^unmanaged-devices' /etc/NetworkManager/NetworkManager.conf";
        $ispresent = exec($exec);
        
        $exec = "sed -i '/unmanaged/d' /etc/NetworkManager/NetworkManager.conf";
        exec_fruitywifi($exec);
        $exec = "sed -i '/\[keyfile\]/d' /etc/NetworkManager/NetworkManager.conf";
        exec_fruitywifi($exec);
        
        if ($ispresent == "") {
            $exec = "echo '[keyfile]' >> /etc/NetworkManager/NetworkManager.conf";
            exec_fruitywifi($exec);

            $exec = "echo 'unmanaged-devices=mac:".$mac[2].";interface-name:".$io_in_iface."' >> /etc/NetworkManager/NetworkManager.conf";
            exec_fruitywifi($exec);
        }
        
        $exec = "$bin_killall hostapd";
        exec_fruitywifi($exec);

        $exec = "/bin/rm /var/run/hostapd-phy0/$io_in_iface";
        exec_fruitywifi($exec);

        $exec = "$bin_killall dnsmasq";
        exec_fruitywifi($exec);

        $exec = "/sbin/ifconfig $io_in_iface up";
        exec_fruitywifi($exec);
        $exec = "/sbin/ifconfig $io_in_iface up $io_in_ip netmask 255.255.255.0";
        exec_fruitywifi($exec);
        
        $exec = "echo 'nameserver $io_in_ip\nnameserver 8.8.8.8' > /etc/resolv.conf ";
        exec_fruitywifi($exec);
        
        $exec = "/usr/sbin/dnsmasq -C /usr/share/fruitywifi/conf/dnsmasq.conf";
        exec_fruitywifi($exec);
	
        //Verifies if mana-hostapd is installed
        if ($hostapd_secure == 1) {
            
            if (file_exists("/usr/share/fruitywifi/www/modules/mana/includes/hostapd")) {
                include "/usr/share/fruitywifi/www/modules/mana/_info_.php";
                
                //REPLACE SSID
                $exec = "/bin/sed -i 's/^ssid=.*/ssid=".$hostapd_ssid."/g' $mod_path/includes/conf/hostapd-secure.conf";
                exec_fruitywifi($exec);
                
                //REPLACE IFACE                
                $exec = "/bin/sed -i 's/^interface=.*/interface=".$io_in_iface."/g' $mod_path/includes/conf/hostapd-secure.conf";
                exec_fruitywifi($exec);
                
                //REPLACE WPA_PASSPHRASE
                $exec = "sed -i 's/wpa_passphrase=.*/wpa_passphrase=".$hostapd_wpa_passphrase."/g' $mod_path/includes/conf/hostapd-secure.conf";
                exec_fruitywifi($exec);
                
                //EXTRACT MACADDRESS
                unset($output);
                $exec = "/sbin/ifconfig -a $io_in_iface |grep HWaddr";
                $output = exec_fruitywifi($exec);
                $output = preg_replace('/\s+/', ' ',$output[0]);
                $output = explode(" ",$output);
                
                //REPLACE MAC
                $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' $mod_path/includes/conf/hostapd-secure.conf";
                exec_fruitywifi($exec);
                
                $exec = "$bin_hostapd $mod_path/includes/conf/hostapd-secure.conf >> $mod_logs &";
            } else {
                $exec = "/usr/sbin/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd-secure.conf";
            }
            
        } else {
            
            if (file_exists("/usr/share/fruitywifi/www/modules/mana/includes/hostapd")) {
                include "/usr/share/fruitywifi/www/modules/mana/_info_.php";
                
                //REPLACE SSID
                $exec = "/bin/sed -i 's/^ssid=.*/ssid=".$hostapd_ssid."/g' $mod_path/includes/conf/hostapd.conf";
                exec_fruitywifi($exec);
                
                //REPLACE IFACE                
                $exec = "/bin/sed -i 's/^interface=.*/interface=".$io_in_iface."/g' $mod_path/includes/conf/hostapd.conf";
                exec_fruitywifi($exec);
                
                //EXTRACT MACADDRESS
                unset($output);
                $exec = "/sbin/ifconfig -a $io_in_iface |grep HWaddr";
                $output = exec_fruitywifi($exec);
                $output = preg_replace('/\s+/', ' ',$output[0]);
                $output = explode(" ",$output);
                
                //REPLACE MAC
                $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' $mod_path/includes/conf/hostapd.conf";
                exec_fruitywifi($exec);
                
                $exec = "$bin_hostapd $mod_path/includes/conf/hostapd.conf >> $mod_logs &";
            } else {
                $exec = "/usr/sbin/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd.conf";
            }
            
        }
        exec_fruitywifi($exec);

        $exec = "/sbin/iptables -F";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -F";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -F";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -X";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -X";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -X";
        exec_fruitywifi($exec);

        $exec = "/bin/echo 1 > /proc/sys/net/ipv4/ip_forward";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -A POSTROUTING -o $io_out_iface -j MASQUERADE";
        exec_fruitywifi($exec);
        
        // CLEAN DHCP log
        $exec = "echo '' > /usr/share/fruitywifi/logs/dhcp.leases";
        exec_fruitywifi($exec);

    } else if($action == "stop") {

        // REMOVE lines from NetworkManager
        $exec = "sed -i '/unmanaged/d' /etc/NetworkManager/NetworkManager.conf";
        exec_fruitywifi($exec);
        $exec = "sed -i '/\[keyfile\]/d' /etc/NetworkManager/NetworkManager.conf";
        exec_fruitywifi($exec);
    
        $exec = "$bin_killall hostapd";	
        exec_fruitywifi($exec);

        $exec = "/bin/rm /var/run/hostapd-phy0/$io_in_iface";
        exec_fruitywifi($exec);

        $exec = "$bin_killall dnsmasq";
        exec_fruitywifi($exec);

        $exec = "ip addr flush dev $io_in_iface";
        exec_fruitywifi($exec);
        
        $exec = "/sbin/ifconfig $io_in_iface down";
        exec_fruitywifi($exec);

        $exec = "/sbin/iptables -F";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -F";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -F";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -X";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -X";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -X";
        exec_fruitywifi($exec);

    }
}

// HOSTAPD KARMA
if($service == "wireless"  and $ap_mode == "4") {
    if ($action == "start") {
        
        //unmanaged-devices=mac:<realmac>;interface-name:wlan2
        //macchanger --show wlan0 |grep "Permanent"
        
        $exec = "macchanger --show eth0 |grep 'Permanent'";
        //$output = exec_fruitywifi($exec);
        exec($exec, $output);
        $mac = explode(" ", $output[0]);
        
        $exec = "grep '^unmanaged-devices' /etc/NetworkManager/NetworkManager.conf";
        $ispresent = exec($exec);
        
        $exec = "sed -i '/unmanaged/d' /etc/NetworkManager/NetworkManager.conf";
        exec_fruitywifi($exec);
        $exec = "sed -i '/[keyfile]/d' /etc/NetworkManager/NetworkManager.conf";
        exec_fruitywifi($exec);
        
        if ($ispresent == "") {
            $exec = "echo '[keyfile]' >> /etc/NetworkManager/NetworkManager.conf";
            exec_fruitywifi($exec);

            $exec = "echo 'unmanaged-devices=mac:".$mac[2].";interface-name:".$io_in_iface."' >> /etc/NetworkManager/NetworkManager.conf";
            exec_fruitywifi($exec);
        }
        
        $exec = "$bin_killall hostapd";
        exec_fruitywifi($exec);

        $exec = "/bin/rm /var/run/hostapd-phy0/$io_in_iface";
        exec_fruitywifi($exec);

        $exec = "$bin_killall dnsmasq";
        exec_fruitywifi($exec);

        $exec = "/sbin/ifconfig $io_in_iface up";
        exec_fruitywifi($exec);
        $exec = "/sbin/ifconfig $io_in_iface up $io_in_ip netmask 255.255.255.0";
        exec_fruitywifi($exec);
        
        $exec = "echo 'nameserver $io_in_ip\nnameserver 8.8.8.8' > /etc/resolv.conf ";
        exec_fruitywifi($exec);
        
        $exec = "/usr/sbin/dnsmasq -C /usr/share/fruitywifi/conf/dnsmasq.conf";
        exec_fruitywifi($exec);
	
        //Verifies if karma-hostapd is installed
        if ($hostapd_secure == 1) {
            
            if (file_exists("/usr/share/fruitywifi/www/modules/karma/includes/hostapd")) {
                include "/usr/share/fruitywifi/www/modules/karma/_info_.php";
                
                //REPLACE SSID
                $exec = "/bin/sed -i 's/^ssid=.*/ssid=".$hostapd_ssid."/g' $mod_path/includes/conf/hostapd-secure.conf";
                exec_fruitywifi($exec);
                
                //REPLACE IFACE                
                $exec = "/bin/sed -i 's/^interface=.*/interface=".$io_in_iface."/g' $mod_path/includes/conf/hostapd-secure.conf";
                exec_fruitywifi($exec);
                
                //REPLACE WPA_PASSPHRASE
                $exec = "sed -i 's/wpa_passphrase=.*/wpa_passphrase=".$hostapd_wpa_passphrase."/g' $mod_path/includes/conf/hostapd-secure.conf";
                exec_fruitywifi($exec);
                
                //EXTRACT MACADDRESS
                unset($output);
                $exec = "/sbin/ifconfig -a $io_in_iface |grep HWaddr";
                $output = exec_fruitywifi($exec);
                $output = preg_replace('/\s+/', ' ',$output[0]);
                $output = explode(" ",$output);
                
                //REPLACE MAC
                $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' $mod_path/includes/conf/hostapd-secure.conf";
                exec_fruitywifi($exec);
                
                $exec = "$bin_hostapd $mod_path/includes/conf/hostapd-secure.conf >> $mod_logs &";
            } else {
                $exec = "/usr/sbin/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd-secure.conf";
            }
            
        } else {
            
            if (file_exists("/usr/share/fruitywifi/www/modules/karma/includes/hostapd")) {
                include "/usr/share/fruitywifi/www/modules/karma/_info_.php";
                
                //REPLACE SSID
                $exec = "/bin/sed -i 's/^ssid=.*/ssid=".$hostapd_ssid."/g' $mod_path/includes/conf/hostapd.conf";
                exec_fruitywifi($exec);
                
                //REPLACE IFACE                
                $exec = "/bin/sed -i 's/^interface=.*/interface=".$io_in_iface."/g' $mod_path/includes/conf/hostapd.conf";
                exec_fruitywifi($exec);
                
                //EXTRACT MACADDRESS
                unset($output);
                $exec = "/sbin/ifconfig -a $io_in_iface |grep HWaddr";
                $output = exec_fruitywifi($exec);
                $output = preg_replace('/\s+/', ' ',$output[0]);
                $output = explode(" ",$output);
                
                //REPLACE MAC
                $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' $mod_path/includes/conf/hostapd.conf";
                exec_fruitywifi($exec);
                
                $exec = "$bin_hostapd $mod_path/includes/conf/hostapd.conf >> $mod_logs &";
            } else {
                $exec = "/usr/sbin/hostapd -P /var/run/hostapd-phy0 -B /usr/share/fruitywifi/conf/hostapd.conf";
            }
            
        }
        exec_fruitywifi($exec);

        $exec = "/sbin/iptables -F";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -F";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -F";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -X";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -X";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -X";
        exec_fruitywifi($exec);

        $exec = "/bin/echo 1 > /proc/sys/net/ipv4/ip_forward";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -A POSTROUTING -o $io_out_iface -j MASQUERADE";
        exec_fruitywifi($exec);
        
        // CLEAN DHCP log
        $exec = "echo '' > /usr/share/fruitywifi/logs/dhcp.leases";
        exec_fruitywifi($exec);

    } else if($action == "stop") {

        // REMOVE lines from NetworkManager
        $exec = "sed -i '/unmanaged/d' /etc/NetworkManager/NetworkManager.conf";
        exec_fruitywifi($exec);
        $exec = "sed -i '/[keyfile]/d' /etc/NetworkMxanager/NetworkManager.conf";
        exec_fruitywifi($exec);
    
        $exec = "$bin_killall hostapd";	
        exec_fruitywifi($exec);

        $exec = "/bin/rm /var/run/hostapd-phy0/$io_in_iface";
        exec_fruitywifi($exec);

        $exec = "$bin_killall dnsmasq";
        exec_fruitywifi($exec);

        $exec = "ip addr flush dev $io_in_iface";
        exec_fruitywifi($exec);
        
        $exec = "/sbin/ifconfig $io_in_iface down";
        exec_fruitywifi($exec);

        $exec = "/sbin/iptables -F";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -F";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -F";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -X";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t nat -X";
        exec_fruitywifi($exec);
        $exec = "/sbin/iptables -t mangle -X";
        exec_fruitywifi($exec);

    }
}

header('Location: ../action.php');

?>
