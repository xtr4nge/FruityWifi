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

$service = $_GET["service"];

/*
if (isset($_GET["service"])) {
    $service = $_GET["service"];
} else {
    $service = $_POST["service"];
}
*/

$service = str_replace("mod_", "", $service);

//$service = "nessus";

if ($service == "s_wireless") {
    
    include "../config/config.php";
    
    if ($ap_mode == "1") { 
        $ismoduleup = exec("ps auxww | grep hostapd | grep -v -e grep");
    } else if ($ap_mode == "2") {
        $ismoduleup = exec("ps auxww | grep airbase | grep -v -e grep");
    } else if ($ap_mode == "3") {
        $ismoduleup = exec("ps auxww | grep hostapd | grep -v -e grep");
    } else if ($ap_mode == "4") {
        $ismoduleup = exec("ps auxww | grep hostapd | grep -v -e grep");
    }
    
} else if ($service == "s_phishing") {

    $ismoduleup = exec("grep 'FruityWifi-Phishing' /var/www/index.php");

} else {
    include "../modules/$service/_info_.php";
    $ismoduleup = exec("$mod_isup");   
}
    
if ($ismoduleup != "") {
    $output[0] = true;
} else {
    $output[0] = false;    
}
    
echo json_encode($output);
?>