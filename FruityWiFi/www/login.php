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

session_start();
session_regenerate_id(true);

include "users.php";
include "config/config.php";

$user = $_POST["user"];
$pass = $_POST["pass"];
//$token = $_POST["token"];

switch($_SERVER['REQUEST_METHOD'])
{
	case 'GET': $token = $_GET["token"]; break;
	case 'POST': $token = $_POST["token"]; break;
	default: $token = "";
}

if ($users[$user] == md5($pass) or $token == $api_token) {
	
	if ($users[$user] != "") {
		$_SESSION["user_id"] = $user;
	} else if ($token != "") {
		$_SESSION["user_id"] = $token;
	}
	
    header('Location: page_status.php');

} else {
    header('Location: index.php?error=1');
}

?>