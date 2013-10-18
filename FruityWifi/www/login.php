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

session_start();
session_regenerate_id(true);

include "users.php";

//$user = "admin";
//$pass = "test.123456";

$user = $_POST["user"];
$pass = $_POST["pass"];

//echo $users["admin"] . " : " . crypt($pass,$key);
//echo $users["admin"] . " : " . md5($pass);
//echo "<br>";

if ($users[$user] == md5($pass)) {
    $_SESSION["user_id"] = $user;
    //echo "welcome";
    header('Location: page_status.php');
} else {
    //echo "get out of here...";
    header('Location: index.php?error=1');
}
?>