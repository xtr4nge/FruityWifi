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
require_once "lib/nusoap.php";

$global_webserver = "http://localhost/FruityWifi";

function get_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }

    //return $ip;
    if ($ip != "" and $ip != "::1" and $ip != "127.0.0.1" and $ip != "localhost") {
        echo "You are not authorized.";
        exit;
    }
}

get_ip();

$server = new soap_server();

$server->configureWSDL("FruityWifi", "urn:FruityWifi");
 
$server->register("serviceAction",
    array("service" => "xsd:string", "action" => "xsd:string" ),
    array("return" => "xsd:string"),
    "urn:FruityWifi",
    "urn:FruityWifi#serviceAction",
    "rpc",
    "encoded",
    "Modules action");

$server->register("moduleAction",
    array("module" => "xsd:string", "action" => "xsd:string"),
	#array("action" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:FruityWifi",
    "urn:FruityWifi#moduleAction",
    "rpc",
    "encoded",
    "Modules action");

$server->register("getAllInterfaces",
    array("module" => "xsd:string", "action" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:FruityWifi",
    "urn:FruityWifi#getAllInterfaces",
    "rpc",
    "encoded",
    "Modules action");

$server->register("getInterface",
    array("module" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:FruityWifi",
    "urn:FruityWifi#getInterface",
    "rpc",
    "encoded",
    "Modules action");

$server->register("setInterface",
    array("config" => "xsd:string", "interface" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:FruityWifi",
    "urn:FruityWifi#setInterface",
    "rpc",
    "encoded",
    "Modules action");

$server->register("getModules",
    array("module" => "xsd:string", "action" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:FruityWifi",
    "urn:FruityWifi#getModules",
    "rpc",
    "encoded",
    "Modules action");

$server->register("getStatus",
    array("service" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:FruityWifi",
    "urn:FruityWifi#getStatus",
    "rpc",
    "encoded",
    "Service status");

$server->register("getModuleStatus",
    array("module" => "xsd:string", "action" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:FruityWifi",
    "urn:FruityWifi#getModuleStatus",
    "rpc",
    "encoded",
    "Modules action");

$server->register("getServiceStatus",
    array("module" => "xsd:string", "action" => "xsd:string"),
    array("return" => "xsd:string"),
    "urn:FruityWifi",
    "urn:FruityWifi#getServiceStatus",
    "rpc",
    "encoded",
    "Modules action");

//$server->service($HTTP_RAW_POST_DATA);

$POST_DATA = file_get_contents('php://input');
$server->service($POST_DATA);

function serviceAction($service, $action) {
	
    GLOBAL $global_webserver;
	
    if ($service == "s_wireless") {
        $url = "$global_webserver/scripts/status_wireless.php?service=wireless&action=$action";
        execCurl($url);
        return join(",", array("WIRELESS:$action"));
		
    } else if ($service == "s_karma") {
        $url = "$global_webserver/scripts/status_karma.php?service=karma&action=$action";
        execCurl($url);
        return join(",", array("KARMA:$action"));
		
    } else if ($service == "s_phishing") {
        $url = "$global_webserver/scripts/status_phishing.php?service=phishing&action=$action";
        execCurl($url);
        return join(",", array("PHISHING:$action"));
		
    } else {
        return "No services listed under that name";
    }
}

function moduleAction($module, $action) {
	
	GLOBAL $global_webserver;
	
	/*
	if ($module == "mod_ngrep") {
            $url = "$global_webserver/modules/ngrep/includes/module_action.php?service=ngrep&action=$action&page=status";
            execCurl($url);
            return join(",", array("NGREP:$action"));
		
        } else if ($module == "mod_sslstrip") {
            $url = "$global_webserver/modules/sslstrip/includes/module_action.php?service=sslstrip&action=$action&page=status";
            execCurl($url);
            return join(",", array("SSLSTRIP:$action"));
		
        } else if ($module == "mod_dnsspoof") {
	    $url = "$global_webserver/modules/dnsspoof/includes/module_action.php?service=dnsspoof&action=$action&page=status";
            execCurl($url);
	    return join(",", array("DNSSPOOF:$action"));
		
        } else if ($module == "mod_mdk3") {
            $url = "$global_webserver/modules/mdk3/includes/module_action.php?service=mdk3&action=$action&page=status";
            execCurl($url);
            return join(",", array("MDK:$action"));
		
        } else if ($module == "mod_squid3") {
            $url = "$global_webserver/modules/squid3/includes/module_action.php?service=squid3&action=$action&page=status";
            execCurl($url);
            return join(",", array("SQUID:$action"));
		
        } else if ($module == "mod_autostart") {
		$url = "$global_webserver/modules/autostart/includes/module_action.php?service=autostart&action=$action&page=status";
		execCurl($url);
                return join(",", array("AUTOSTART:$action"));
	
        } else if ($module == "mod_kismet") {
            $url = "$global_webserver/modules/kismet/includes/module_action.php?service=kismet&action=$action&page=status";
            execCurl($url);
            return join(",", array("KISMET:$action"));
    
        } else if ($module == "mod_captive") {
            $url = "$global_webserver/modules/captive/includes/module_action.php?service=captive&action=$action&page=status";
            execCurl($url);
            return join(",", array("CAPTIVE:$action"));
    
        } else if ($module == "mod_urlsnarf") {
            $url = "$global_webserver/modules/urlsnarf/includes/module_action.php?service=urlsnarf&action=$action&page=status";
            execCurl($url);
            return join(",", array("URLSNARF:$action"));
    
        } else if ($module == "mod_responder") {
            $url = "$global_webserver/modules/responder/includes/module_action.php?service=responder&action=$action&page=status";
            execCurl($url);
            return join(",", array("RESPONDER:$action"));
    
        } else if ($module == "mod_rpitwit") {
            $url = "$global_webserver/modules/rpitwit/includes/module_action.php?service=rpitwit&action=$action&page=status";
            execCurl($url);
            return join(",", array("RPITWIT:$action"));
    
        } else if ($module == "mod_whatsapp") {
            $url = "$global_webserver/modules/whatsapp/includes/module_action.php?service=whatsapp&action=$action&page=status";
            execCurl($url);
            return join(",", array("WHATSAPP:$action"));
	
        } else {
            return "No modules listed under that name";
	}

	*/

	exec("find ../modules -name '_info_.php'",$output);

	for ($i=0; $i < count($output); $i++) {
            include $output[$i];
            //$module_path = str_replace("_info_.php","",$output[$i]);
            //echo "<a href='$module_path'>$mod_name.$mod_version</a><br>";
            
            if ($module == "mod_$mod_name") {
                $url = "$global_webserver/modules/$mod_name/includes/module_action.php?service=$mod_name&action=$action&page=status";
                execCurl($url);
                return join(",", array(strtoupper($mod_name).":$action"));
            }
		
	}

}

function getAllInterfaces() {
	
    $ifaces = exec("/sbin/ifconfig -a | cut -c 1-8 | sort | uniq -u |grep -v lo|sed ':a;N;$!ba;s/\\n/|/g'");
    $ifaces = str_replace(" ","",$ifaces);
    //$ifaces = explode("|", $ifaces);

    return $ifaces;

}

function getInterface($v_config) {

    include "../config/config.php";
    
    if ($v_config == "i_internet") {
        return $io_out_iface;
    } else if ($v_config == "i_wireless") {
        return $io_in_iface;
    } else if ($v_config == "i_monitor") {
        return $io_in_iface_extra;
    } else {
        return "*error*";
    }
	
}

function setInterface($v_config, $v_inteface) {

    $bin_danger = "/usr/share/fruitywifi/bin/danger";

    //include "../config/config.php";
    
    if ($v_config == "i_internet") {
        $exec = "/bin/sed -i 's/io_out_iface=.*/io_out_iface=\\\"".$v_inteface."\\\";/g' ../config/config.php";
        exec("$bin_danger \"" . $exec . "\"" );
            
    } else if ($v_config == "i_wireless") {
        $exec = "/bin/sed -i 's/io_in_iface=.*/io_in_iface=\\\"".$v_inteface."\\\";/g' ../config/config.php";
        exec("$bin_danger \"" . $exec . "\"" );
 
        // replace interface in hostapd.conf and hostapd-secure.conf
        $exec = "/bin/sed -i 's/^interface=.*/interface=".$v_inteface."/g' /usr/share/fruitywifi/conf/hostapd.conf";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/bin/sed -i 's/^interface=.*/interface=".$v_inteface."/g' /usr/share/fruitywifi/conf/hostapd-secure.conf";
        exec("$bin_danger \"" . $exec . "\"" );
        
        $exec = "/bin/sed -i 's/interface=.*/interface=".$v_inteface."/g' /usr/share/fruitywifi/conf/dnsmasq.conf";
        exec("$bin_danger \"" . $exec . "\"" );
        
        //EXTRACT MACADDRESS
        $exec = "/sbin/ifconfig -a ".$v_inteface." |grep HWaddr";
        $output = exec("$bin_danger \"" . $exec . "\"" );
        $output = preg_replace('/\s+/', ' ',$output);
        $output = explode(" ",$output);
        
        $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' /usr/share/fruitywifi/conf/hostapd.conf";
        exec("$bin_danger \"" . $exec . "\"" );
        $exec = "/bin/sed -i 's/^bssid=.*/bssid=".$output[4]."/g' /usr/share/fruitywifi/conf/hostapd-secure.conf";
        exec("$bin_danger \"" . $exec . "\"" );
            
    } else if ($v_config == "i_monitor") {
        $exec = "/bin/sed -i 's/io_in_iface_extra=.*/io_in_iface_extra=\\\"".$v_inteface."\\\";/g' ../config/config.php";
        exec("$bin_danger \"" . $exec . "\"" );
            
    } else {
        return "*error*";
        exit;
    }
    
    //return $exec;
    return $v_config.":".$v_inteface;
	
}

function execCurl($url) {
    //$post_data = 'user=admin&pass=admin';
    $post_data = "";
    $agent = "Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1.7) Gecko/20100105 Shiretoko/3.5.7";
    $login_url = "$protocol://localhost$web_path/login.php";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    //curl_setopt($ch, CURLOPT_URL, $login_url );
    curl_setopt($ch, CURLOPT_PORT, $srv_port );
    curl_setopt($ch, CURLOPT_POST, 1 );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    #curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    
    //curl_exec($ch);
    
    //$url = "$protocol://localhost$web_path".$opt_responder[$tmp[$i]][3];
    curl_setopt($ch, CURLOPT_URL, $url);
    //print_r($ch);
    curl_exec($ch);
}

function getModules() {

    exec("find ../modules -name '_info_.php'",$output);
    if (count($output) > 0) {

        for ($i=0; $i < count($output); $i++) {
            include $output[$i];
            $module_path = str_replace("_info_.php","",$output[$i]);
            
            if ($mod_panel == "show") {
                    
                if ($mod_alias != "") { 
                        //echo $mod_alias;
                } else {
                        //echo $mod_name;
                }

                if ($mod_panel == "show") {
                    $isModuleUp = exec($mod_isup);
                    if ($isModuleUp != "") {
                            //echo $mod_name;
                    } else { 
                            //echo $mod_name;
                    }
                    
                    $m_temp = $m_temp . "|" . $mod_name;
                        
                $mod_panel = "";
                $mod_alias = "";
                }
             }
    
            $mod_installed[$i] = $mod_name;
        }
        return $m_temp;
    }

}

function getStatus($v_service) {
	
    include "../config/config.php";
    
    if ($v_service == "s_wireless") {
        //$status = exec("ps auxww | grep hostapd | grep -v -e grep");
        
        if ($ap_mode == "1") { 
            //$iswlanup = exec("ps auxww | grep hostapd | grep -v -e grep");
            $status = exec("ps auxww | grep hostapd | grep -v -e grep");
        } else if ($ap_mode == "2") {
            //$iswlanup = exec("ps auxww | grep airbase | grep -v -e grep");
            $status = exec("ps auxww | grep airbase | grep -v -e grep");
        }
        
        if ($status != "")
            return "Y";
        else
            return "N";
                    
    } else if ($v_service == "s_karma") {
        $exec = "/usr/sbin/karma-hostapd_cli -p /var/run/hostapd-phy0 karma_get_state | tail -1";
        $status = exec("/usr/share/fruitywifi/bin/danger \"" . $exec . "\"" );
        if ( $status == "ENABLED" ){
            $status = true;
        }

        if ($status == "ENABLED")
            return "Y";
        else
            return "N";
       
    } else if ($v_service == "s_phishing") {
        $status = exec("grep 'FruityWifi-Phishing' /var/www/index.php");
        if ($status != "")
            return "Y";
        else
            return "N";
            
    }
    /*
    else if ($v_service == "mod_ngrep") {
            include "../modules/ngrep/_info_.php";
            $status = exec($mod_isup);
            if ($status != "")
                    return "Y";
            else
                    return "N";
    } else if ($v_service == "mod_sslstrip") {
            include "../modules/sslstrip/_info_.php";
            $status = exec($mod_isup);
            if ($status != "")
                    return "Y";
            else
                    return "N";
    } else if ($v_service == "mod_dnsspoof") {
            include "../modules/dnsspoof/_info_.php";
            $status = exec($mod_isup);
            if ($status != "")
                    return "Y";
            else
                    return "N";
    } else if ($v_service == "mod_mdk3") {
            include "../modules/mdk3/_info_.php";
            $status = exec($mod_isup);
            if ($status != "")
                    return "Y";
            else
                    return "N";
    } else if ($v_service == "mod_squid3") {
            include "../modules/squid3/_info_.php";
            $status = exec($mod_isup);
            if ($status != "")
                    return "Y";
            else
                    return "N";
    } else if ($v_service == "mod_autostart") {
            include "../modules/autostart/_info_.php";
            $status = exec($mod_isup);
            if ($status != "")
                    return "Y";
            else
                    return "N";
    } else if ($v_service == "mod_kismet") {
            include "../modules/kismet/_info_.php";
            $status = exec($mod_isup);
            if ($status != "")
                    return "Y";
            else
                    return "N";
    } else if ($v_service == "mod_captive") {
            include "../modules/captive/_info_.php";
            $status = exec($mod_isup);
            if ($status != "")
                    return "Y";
            else
                    return "N";
    } else if ($v_service == "mod_urlsnarf") {
            include "../modules/urlsnarf/_info_.php";
            $status = exec($mod_isup);
            if ($status != "")
                    return "Y";
            else
                    return "N";
    } else if ($v_service == "mod_responder") {
            include "../modules/responder/_info_.php";
            $status = exec($mod_isup);
            if ($status != "")
                    return "Y";
            else
                    return "N";
    } else if ($v_service == "mod_rpitwit") {
            include "../modules/rpitwit/_info_.php";
            $status = exec($mod_isup);
            if ($status != "")
                    return "Y";
            else
                    return "N";
    } else if ($v_service == "mod_whatsapp") {
            include "../modules/whatsapp/_info_.php";
            $status = exec($mod_isup);
            if ($status != "")
                    return "Y";
            else
                    return "N";
    } else {
            return "No modules listed under that name";
    }

    */
    
    exec("find ../modules -name '_info_.php'",$output);

    for ($i=0; $i < count($output); $i++) {
        include $output[$i];
        //$module_path = str_replace("_info_.php","",$output[$i]);
        //echo "<a href='$module_path'>$mod_name.$mod_version</a><br>";

        if ($v_service == "mod_$mod_name") {
            include "../modules/$mod_name/_info_.php";
            $status = exec($mod_isup);
            if ($status != "") {
                return "Y";
            } else {
                return "N";
            }
        }            
    }

}

function getModuleStatus($v_module, $v_module2) {

    //exec("find ../modules -name '_info_.php'",$output);
    
    if ($v_module == "mod_ngrep") {
        include "../modules/ngrep/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
            
    } else if ($v_module == "mod_sslstrip") {
        include "../modules/sslstrip/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
            
    } else if ($v_module == "mod_dnsspoof") {
        include "../modules/dnsspoof/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
        
    } else if ($v_module == "mod_mdk3") {
        include "../modules/mdk3/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
            
    } else if ($v_module == "mod_squid3") {
        include "../modules/squid3/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
            
    } else if ($v_module == "mod_autostart") {
        include "../modules/autostart/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
            
    } else if ($v_module == "mod_kismet") {
        include "../modules/kismet/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
        
    } else if ($v_module == "mod_captive") {
        include "../modules/captive/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
                
    } else if ($v_module == "mod_urlsnarf") {
        include "../modules/urlsnarf/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
            
    } else if ($v_module == "mod_responder") {
        include "../modules/responder/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
            
    } else if ($v_module == "mod_rpitwit") {
        include "../modules/rpitwit/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
            
    } else if ($v_module == "mod_whatsapp") {
        include "../modules/whatsapp/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
    
    } else if ($v_module == "mod_nessus") {
        include "../modules/nessus/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
    
    } else if ($v_module == "mod_autossh") {
        include "../modules/autossh/_info_.php";
        $status = exec($mod_isup);
        if ($status != "")
            return "Y";
        else
            return "N";
    
    
    
    
            
    } else {
        return "No modules listed under that name";
    }

}

function getServiceStatus($v_service, $v_module2) {

	//exec("find ../modules -name '_info_.php'",$output);
	
	if ($v_service == "s_wireless") {
		$status = exec("ps auxww | grep hostapd | grep -v -e grep");
		if ($status != "")
			return "Y";
		else
			return "N";
			
	} else if ($v_service == "s_karma") {
		$exec = "/usr/sbin/karma-hostapd_cli -p /var/run/hostapd-phy0 karma_get_state | tail -1";
		$status = exec("/usr/share/fruitywifi/bin/danger \"" . $exec . "\"" );
		if ( $status == "ENABLED" ){
			$status = true;
		}

		if ($status == "ENABLED")
			return "Y";
		else
			return "N";
			
	} else if ($v_service == "s_phishing") {
		$status = exec("grep 'FruityWifi-Phishing' /var/www/index.php");
		if ($status != "")
			return "Y";
		else
			return "N";
			
	} else {
		return "No modules listed under that name";
	}

}

?>