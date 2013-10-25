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

exec("find ./ -name '_info_.php'",$output);

for ($i=0; $i < count($output); $i++) {
    //echo $output[$i]."<br>";
    include $output[$i];
    $module_path = str_replace("_info_.php","",$output[$i]);
    //echo $module_path;
    //echo "$name - $version <br>";
    echo "<a href='$module_path'>$mod_name.$mod_version</a><br>";
}
?>