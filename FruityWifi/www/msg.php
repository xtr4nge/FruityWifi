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
<link href="style.css" rel="stylesheet" type="text/css">
<? include "menu.php" ?>

<br><br>
<div class="box-msg" align="center">
<b>
<?
$msg = $_GET["msg"];

if ($msg = 1) {
    echo "check your input...";
} else {
    echo "general error...";
}
?>
</b>
</div>