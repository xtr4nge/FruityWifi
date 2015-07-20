<? 
/*
    Copyright (C) 2013-2015 xtr4nge [_AT_] gmail.com

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
    regex_standard($_POST["service"], "../msg.php", $regex_extra);
    regex_standard($_POST["action"], "../msg.php", $regex_extra);
    regex_standard($_POST["page"], "../msg.php", $regex_extra);
}

$service = $_POST["service"];
$service = str_replace("mod_", "", $service);
$action = $_POST["action"];
$page = $_POST["page"];

/*
function execCurl($url) {
    $post_data = 'user=admin&pass=admin';
    $post_data = "";
    $agent = "Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.1.7) Gecko/20100105 Shiretoko/3.5.7";
    //$login_url = "$protocol://localhost$web_path/login.php";
    $login_url = "$protocol://localhost:8000/login.php";
    
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


$global_webserver = "http://localhost:".$_SERVER["SERVER_PORT"];
*/


require("ws.php");

//$ws = new WebService("admin", "admin");

$ws = new WebService($api_token);

if ($service == "s_wireless") {
    //$url = "$global_webserver/scripts/status_wireless.php?service=wireless&action=$action";
    //execCurl($url);
    
    $url = "scripts/status_wireless.php?service=wireless&action=$action";
    $ws->setGetRequest($url);
    
              
} else if ($service == "s_phishing") {
    //$url = "$global_webserver/scripts/status_phishing.php?service=phishing&action=$action";
    //execCurl($url);
    
    $url = "scripts/status_phishing.php?service=phishing&action=$action";
    $ws->setGetRequest($url);
            
} else {
    //$url = "$global_webserver/modules/$service/includes/module_action.php?service=$service&action=$action&page=$page";
    //execCurl($url);
    
    $url = "modules/$service/includes/module_action.php?service=$service&action=$action&page=$page";
    $ws->setGetRequest($url);
    
}


if ($action == "start") {
    $output[0] = "true";
} else {
    $output[0] = "false";    
}
echo json_encode($output);

?>