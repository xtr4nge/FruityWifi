<? 
/*
    Copyright (C) 2013-2016 xtr4nge [_AT_] gmail.com

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

error_reporting(E_ALL ^ E_NOTICE);

include "../login_check.php";
include "../config/config.php";
include "../functions.php";

// Checking POST & GET variables [regex]...
if ($regex == 1) {
    regex_standard($_POST["iface"], "../msg.php", $regex_extra);
    regex_standard($_POST["io_out_iface"], "../msg.php", $regex_extra);
    regex_standard($_POST["io_in_iface"], "../msg.php", $regex_extra);
    regex_standard($_POST["io_in_iface_extra"], "../msg.php", $regex_extra);
    regex_standard($_POST["wifi_supplicant"], "../msg.php", $regex_extra);
    regex_standard($_POST["ap_mode"], "../msg.php", $regex_extra);
}

// ------------ IN | OUT (START) -------------
if(isset($_POST["io_mode"])){
    $exec = "/bin/sed -i 's/io_mode=.*/io_mode=\\\"".$_POST["io_mode"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST["ap_mode"])){
    $exec = "/bin/sed -i 's/ap_mode=.*/ap_mode=\\\"".$_POST["ap_mode"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
    
    if($_POST["ap_mode"] == "2") {
        $exec = "/bin/sed -i 's/io_action=.*/io_action=\\\"at0\\\";/g' ../config/config.php";
		exec_fruitywifi($exec);
        
        $exec = "/bin/sed -i 's/interface=.*/interface=at0/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
		exec_fruitywifi($exec);
    } else {
        $exec = "/bin/sed -i 's/io_action=.*/io_action=\\\"$io_in_iface\\\";/g' ../config/config.php";
		exec_fruitywifi($exec);
        
        $exec = "/bin/sed -i 's/interface=.*/interface=$io_in_iface/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
		exec_fruitywifi($exec);
    }
}

if(isset($_POST["io_action"])){
    $exec = "/bin/sed -i 's/io_action=.*/io_action=\\\"".$_POST["io_action"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST["io_in_iface"])){
    $exec = "/bin/sed -i 's/io_in_iface=.*/io_in_iface=\\\"".$_POST["io_in_iface"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
	
    // replace interface in hostapd.conf and hostapd-secure.conf
    $exec = "/bin/sed -i 's/^interface=.*/interface=".$_POST["io_in_iface"]."/g' /usr/share/fruitywifi/conf/hostapd.conf";
    exec_fruitywifi($exec);
    $exec = "/bin/sed -i 's/^interface=.*/interface=".$_POST["io_in_iface"]."/g' /usr/share/fruitywifi/conf/hostapd-secure.conf";
    exec_fruitywifi($exec);
    
    $exec = "/bin/sed -i 's/interface=.*/interface=".$_POST["io_in_iface"]."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
    exec_fruitywifi($exec);
    
    //EXTRACT MACADDRESS
	$output = getIfaceMAC($_POST["io_in_iface"]);
	
    $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output."/g' /usr/share/fruitywifi/conf/hostapd.conf";
    exec_fruitywifi($exec);
    $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output."/g' /usr/share/fruitywifi/conf/hostapd-secure.conf";
    exec_fruitywifi($exec);
    
    // IF AP_MODE IS AIRMON-NG KEEPS AT0 IN DNSMASQ    
    if($ap_mode == "2") {
        $exec = "/bin/sed -i 's/io_action=.*/io_action=\\\"at0\\\";/g' ../config/config.php";
		exec_fruitywifi($exec);
        
        $exec = "/bin/sed -i 's/interface=.*/interface=at0/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
		exec_fruitywifi($exec);
    } else {
        $exec = "/bin/sed -i 's/io_action=.*/io_action=\\\"".$_POST["io_in_iface"]."\\\";/g' ../config/config.php";
		exec_fruitywifi($exec);
        
        $exec = "/bin/sed -i 's/interface=.*/interface=".$_POST["io_in_iface"]."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
		exec_fruitywifi($exec);
    }
}

if(isset($_POST["io_in_set"])){
    $exec = "/bin/sed -i 's/io_in_set=.*/io_in_set=\\\"".$_POST["io_in_set"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST["io_in_ip"])){
    $exec = "/bin/sed -i 's/io_in_ip=.*/io_in_ip=\\\"".$_POST["io_in_ip"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
	
    // DNSMASQ (replace ip)
    $exec = "/bin/sed -i 's/server=.*/server=\/\#\/".$_POST["io_in_ip"]."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
    exec_fruitywifi($exec);
	
    $exec = "/bin/sed -i 's/listen-address=.*/listen-address=".$_POST["io_in_ip"]."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
    exec_fruitywifi($exec);
	
    $ip = explode(".",$_POST["io_in_ip"]);
    $sub = $ip[0] . "." . $ip[1] . "." . $ip[2];
    
    $exec = "/bin/sed -i 's/dhcp-range=.*/dhcp-range=".$sub.".50,".$sub.".100,12h/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
    exec_fruitywifi($exec);
}

if(isset($_POST["io_in_mask"])){
    $exec = "/bin/sed -i 's/io_in_mask=.*/io_in_mask=\\\"".$_POST["io_in_mask"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST["io_in_gw"])){
    $exec = "/bin/sed -i 's/io_in_gw=.*/io_in_gw=\\\"".$_POST["io_in_gw"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST["io_out_iface"])){
    $exec = "/bin/sed -i 's/io_out_iface=.*/io_out_iface=\\\"".$_POST["io_out_iface"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST["io_out_set"])){
    $exec = "/bin/sed -i 's/io_out_set=.*/io_out_set=\\\"".$_POST["io_out_set"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST["io_out_ip"])){
    $exec = "/bin/sed -i 's/io_out_ip=.*/io_out_ip=\\\"".$_POST["io_out_ip"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST["io_out_mask"])){
    $exec = "/bin/sed -i 's/io_out_mask=.*/io_out_mask=\\\"".$_POST["io_out_mask"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST["io_out_gw"])){
    $exec = "/bin/sed -i 's/io_out_gw=.*/io_out_gw=\\\"".$_POST["io_out_gw"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

// ------------ IN | OUT (END) -------------

if(isset($_POST["iface"]) and $_POST["iface"] == "internet"){
    $exec = "/bin/sed -i 's/io_out_iface=.*/io_out_iface=\\\"".$_POST["io_out_iface"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST["iface"]) and $_POST["iface"] == "wifi"){
    $exec = "/bin/sed -i 's/io_in_iface=.*/io_in_iface=\\\"".$_POST["io_in_iface"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
 
    // replace interface in hostapd.conf and hostapd-secure.conf
    $exec = "/bin/sed -i 's/^interface=.*/interface=".$_POST["io_in_iface"]."/g' /usr/share/fruitywifi/conf/hostapd.conf";
    exec_fruitywifi($exec);
    $exec = "/bin/sed -i 's/^interface=.*/interface=".$_POST["io_in_iface"]."/g' /usr/share/fruitywifi/conf/hostapd-secure.conf";
    exec_fruitywifi($exec);
    
    $exec = "/bin/sed -i 's/interface=.*/interface=".$_POST["io_in_iface"]."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
    exec_fruitywifi($exec);
    
    //EXTRACT MACADDRESS
	$output = getIfaceMAC($_POST["io_in_iface"]);
	
    $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output."/g' /usr/share/fruitywifi/conf/hostapd.conf";
    exec_fruitywifi($exec);
    $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output."/g' /usr/share/fruitywifi/conf/hostapd-secure.conf";
    exec_fruitywifi($exec);

}

if(isset($_POST["iface"]) and $_POST["iface"] == "wifi_extra"){
    $exec = "/bin/sed -i 's/io_in_iface_extra=.*/io_in_iface_extra=\\\"".$_POST["io_in_iface_extra"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST["iface"]) and $_POST["iface"] == "wifi_supplicant"){
    $exec = "/bin/sed -i 's/iface_supplicant=.*/iface_supplicant=\\\"".$_POST["iface_supplicant"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
}

if(isset($_POST["domain"])) {
    $exec = "/bin/sed -i 's/dnsmasq_domain=.*/dnsmasq_domain=\\\"".$_POST["domain"]."\\\";/g' ../config/config.php";
    exec_fruitywifi($exec);
    $exec = "/bin/sed -i 's/domain=.*/domain=".$_POST["domain"]."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
    exec_fruitywifi($exec);
}

header('Location: ../page_config_adv.php');
#header('Location: ../modules/action.php?page=../page_config_adv.php&wait=2');

?>
