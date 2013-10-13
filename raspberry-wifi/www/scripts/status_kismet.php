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
    regex_standard($_GET["file"], "../msg.php", $regex_extra);
    regex_standard($_GET["action"], "../msg.php", $regex_extra);
    regex_standard($iface_wifi_extra, "../msg.php", $regex_extra);
}

$service = $_GET['service'];
$action = $_GET['action'];
$page = $_GET['page'];

if($service == "kismet") {
    if ($action == "start") {
        $exec = "/usr/bin/kismet_server -p ../logs/kismet/ -s --daemonize -c $iface_wifi_extra > /dev/null &";
        exec("../bin/danger \"" . $exec . "\"" );
    } else if($action == "stop") {
        $exec = "/usr/bin/killall kismet_server";
        exec("../bin/danger \"" . $exec . "\"" );
    }
    //header('Location: page_status.php');
    //echo "<script>window.location = './action.php'</script>";
}

if($service == "gpsd") {
    if ($action == "start") {
        $exec = "/usr/sbin/gpsd /dev/ttyUSB0 &";
        exec("../bin/danger \"" . $exec . "\"" );
    } else if($action == "stop") {
        $exec = "/usr/bin/killall gpsd";
        exec("../bin/danger \"" . $exec . "\"" );
    }
}

if ($page == "module") {
    header('Location: ../page_kismet.php');
} else {
    header('Location: ../action.php');
}

?>