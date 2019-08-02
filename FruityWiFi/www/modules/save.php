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
//include "../_info_.php";
include "../config/config.php";
include "../functions.php";

//$bin_danger = "/usr/share/fruitywifi/bin/danger"; //DEPRECATED

// Checking POST & GET variables...
if ($regex == 1) {
	regex_standard($_POST['type'], "../msg.php", $regex_extra);
	regex_standard($_POST['action'], "../msg.php", $regex_extra);
	regex_standard($_POST['mod_name'], "../msg.php", $regex_extra);
}

$type = $_POST['type'];
$action = $_POST['action'];
$newdata = html_entity_decode(trim($_POST["newdata"]));
$newdata = base64_encode($newdata);

$mod_name = $_POST['mod_name'];

// ngrep options
if ($type == "save_show" and $mod_name != "") {
	
	if ($action != "checked") {
		$exec = "/bin/sed -i 's/^\\\$mod_panel=.*/\\\$mod_panel=\\\"show\\\";/g' $mod_name/_info_.php";
		//exec("$bin_danger \"" . $exec . "\"", $output); //DEPRECATED
		exec_fruitywifi($exec);
	} else {
		$exec = "/bin/sed -i 's/^\\\$mod_panel=.*/\\\$mod_panel=\\\"\\\";/g' $mod_name/_info_.php";
		//exec("$bin_danger \"" . $exec . "\"", $output); //DEPRECATED
		exec_fruitywifi($exec);
	}
}

header('Location: ../page_modules.php');
exit;

?>
