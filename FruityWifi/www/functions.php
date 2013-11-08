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
# [Verifica characteres -> [a-z0-9-_. ] ]

function regex_standard($var, $url, $regex_extra) {
    
    $regex_extra = implode("\\", str_split($regex_extra));
    

    $regex = "/(?i)(^[a-z0-9 $regex_extra]{1,20})|(^$)/";
    //$regex = "/(?i)(^[a-z0-9]{1,20}$)|(^$)/";


    //$referer = $_SERVER['HTTP_REFERER'];



    if (preg_match($regex, $var) == 0) {

        //header("Location: ".$referer."?error=1");
        //echo "<script>window.location = '$url?msg=1';</script>";
        echo "<script>window.location = '$url?msg=1&debug=$var&regex=$regex&extra=$regex_extra';</script>";

        exit;

    } 

}


function start_monitor_mode($iface) {

    // START MONITOR MODE (mon0)
    $iface_mon0 = exec("/sbin/ifconfig |grep mon0");
    if ($iface_mon0 == "") {
        $exec = "/usr/bin/sudo /usr/sbin/airmon-ng start $iface";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"", $output);
     }

}

function stop_monitor_mode($iface) {

    // START MONITOR MODE (mon0)
    $iface_mon0 = exec("/sbin/ifconfig |grep mon0");
    if ($iface_mon0 != "") {
        $exec = "/usr/bin/sudo /usr/sbin/airmon-ng stop mon0";
        exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"", $output);
    }

}

function open_file($filename) {

    if ( file_exists($filename) ) {
        if ( 0 < filesize( $filename ) ) {
            $fh = fopen($filename, "r"); // or die("Could not open file.");
            $data = fread($fh, filesize($filename)); // or die("Could not read file.");
            fclose($fh);
            return $data;
        }
    }

}

?>