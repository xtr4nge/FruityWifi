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
<? include "menu.php" ?>

<br>

<?
// ------------- External Modules --------------
exec("find ./modules -name '_info_.php'",$output);
//print count($output);
if (count($output) > 0) {
?>
<div class="rounded-top" align="center"> Installed Modules </div>
<div class="rounded-bottom">
    <table border=0 width='100%' cellspacing=0 cellpadding=0>
    <?
    //exec("find ./modules -name '_info_.php'",$output);
    //print_r($output[0]);

    for ($i=0; $i < count($output); $i++) {
        include $output[$i];
        $module_path = str_replace("_info_.php","",$output[$i]);

		echo "<div style='height:20px;'>";
		echo "<div style='display:inline-block; width:70px; text-align:right;'>$mod_name</div>";
		echo "<div style='display:inline-block; width:30px; text-align:left; padding-left:10px;'>$mod_version</div>";
		echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:10px;'> | </div>";
		echo "<div style='display:inline-block; width:30px; text-align:left; padding-left:10px;'><a href='$module_path'>View</a></div>";
		echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:10px;'> | </div>";
		if (isset($_GET["show"])) {
			echo "<div style='display:inline-block; width:50px; text-align:left; padding-left:10px;'><a href='scripts/modules_action.php?action=remove&module=$mod_name&show'>Remove</a></div>";
		} else {
			echo "<div style='display:inline-block; width:50px; text-align:left; padding-left:10px;'><a href='scripts/modules_action.php?action=remove&module=$mod_name'>Remove</a></div>";
		}
		echo "</div>";

		/*
        echo "<tr>";
            echo "<td align='right' style='padding-right:5px; padding-left:5px; padding-bottom:5px; width:10px'>$mod_name</td>";
            echo "<td align='right' style='padding-right:5px; padding-left:5px; width:10px'>$mod_version</td>";
            echo "<td align='left' style='padding-right:5px; padding-left:5px; width:10px'><a href='$module_path'>View</a><br></td>";
            if (isset($_GET["show"])) {
                echo "<td align='left' style='padding-right:5px; padding-left:28px;'><a href='scripts/modules_action.php?action=remove&module=$mod_name&show'>Remove</a></td>";
            } else {
                echo "<td align='left' style='padding-right:5px; padding-left:28px;'><a href='scripts/modules_action.php?action=remove&module=$mod_name'>Remove</a></td>";
            }
            
            //echo "<td align='right'><a href='$module_path'>$name.$version</a><br></td>";
            //echo "<td>View</td>";
        echo "</tr>";
		*/
		
        $mod_installed[$i] = $mod_name;
    }
    ?>
    </table>
</div>
<br>

<? } ?>

<div class="rounded-top" align="center"> Available Modules </div>
<div class="rounded-bottom">

    <table border=0 width='100%' cellspacing=0 cellpadding=0>
    
    <?
    $url = "https://raw.github.com/xtr4nge/FruityWifi/master/modules-FruityWifi.xml";

    // VERIFY INTERNET CONNECTION
    $external_ip = exec("curl ident.me");
    if ($external_ip != "" and isset($_GET["show"])) {
        $xml = simplexml_load_file($url);
    }

    if (count($xml) > 0 and $xml != "" and isset($_GET["show"])) {
        for ($i=0;$i < count($xml); $i++) {
			
			echo "<div style='height:22px;'>";
			echo "<div style='display:inline-block; width:70px; text-align:right;'>".$xml->module[$i]->name."</div>";
			echo "<div style='display:inline-block; width:20px; text-align:left; padding-left:10px;'>".$xml->module[$i]->version."</div>";
			echo "<div style='display:inline-block; width:50px; text-align:left; padding-left:10px;'>".$xml->module[$i]->author."</div>";
			echo "<div style='display:inline-block; width:138px; text-align:right; padding-left:2px;'>".$xml->module[$i]->description."</div>";
			echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:6px;'> | </div>";
			
			if (count($mod_installed) == 0) $mod_installed[0] = "";
			
			if (in_array($xml->module[$i]->name,$mod_installed)) {
				echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:4px;'>installed</div>";
			} else {
				if (str_replace("v","",$version) < $xml->module[$i]->required ) {
					echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:4px;'><a href='#' onclick='alert(\"FruityWifi v".$xml->module[$i]->required." is required\")'>install</a></div>";
				} else {
					echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:4px;'><a href='scripts/modules_action.php?action=install&module=".$xml->module[$i]->name."&show'>install</a></div>";
				}
			}
			echo "</div>";
			
			/*
            echo "<tr>";
                //echo $xml->module[$i]->name . "|";
                echo "<td align='right' style='padding-right:5px; padding-left:5px; padding-bottom:5px; width:10px'>".$xml->module[$i]->name."</td>";
                //echo $xml->module[$i]->version . "|";
                echo "<td align='center' style='padding-right:5px; padding-left:5px; width:10px'>".$xml->module[$i]->version."</td>";
                //echo $xml->module[$i]->author . "|";
                echo "<td align='right' style='padding-right:5px; padding-left:5px; width:10px'>".$xml->module[$i]->author."</td>";
                //echo $xml->module[$i]->description . "<br>";
                echo "<td align='right' style='padding-right:5px; padding-left:5px; width:150px'>".$xml->module[$i]->description."</td>";
                echo "<td align='right' style='padding-right:5px; padding-left:5px; width:2px'> | </td>";
				
				 
				
                if (in_array($xml->module[$i]->name,$mod_installed)) {
                    echo "<td align='right' style='padding-right:5px; padding-left:5px; width:10px'>installed</td>";
                } else {
                    if (str_replace("v","",$version) < $xml->module[$i]->required ) {
                        echo "<td align='right' style='padding-right:5px; padding-left:5px; width:10px'><a href='#' onclick='alert(\"FruityWifi v".$xml->module[$i]->required." is required\")'>install</a></td>";
                    } else {
                        echo "<td align='right' style='padding-right:5px; padding-left:5px; width:10px'><a href='scripts/modules_action.php?action=install&module=".$xml->module[$i]->name."&show'>install</a></td>";
                    }
                }
            echo "</tr>";
			*/
        }
    } else {
            echo "<a href='?show'>List available modules</a> <br>";
            echo "This will establish a connection to github.com/xtr4nge";
            echo "<br><br>";
    }

    ?>

    </table>
</div>
