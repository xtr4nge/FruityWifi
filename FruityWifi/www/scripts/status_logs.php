<? 
/*
	Copyright (C) 2013-2014  xtr4nge [_AT_] gmail.com

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
$service = $_POST["service"];
$path = $_POST["path"];

$exec = "tail -n 5 $path";
exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"", $output);

for ($i=0; $i < count($output); $i++)
{
	$output[$i] = htmlentities($output[$i], ENT_QUOTES, "UTF-8");
}

echo json_encode($output);
?>