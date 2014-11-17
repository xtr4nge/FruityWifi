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
<? include "menu.php" ?>

<br>

<?

include "functions.php";

// ------------- External Modules --------------
exec("find ./modules -name '_info_.php' | sort",$output);
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
		echo "<div style='display:inline-block; width:80px; text-align:right;'>$mod_name</div>";
		echo "<div style='display:inline-block; width:30px; text-align:left; padding-left:10px;'>$mod_version</div>";
		echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:10px;'> | </div>";
		if ($mod_panel == "show") $checked = "checked"; else $checked = "";
		echo "	<div style='display:inline-block; width:30px; text-align:left; padding-left:10px;'>
					<form action='modules/save.php' style='margin:0px;' method='POST'>
						<input type='checkbox' onchange='this.form.submit()' $checked>
						<input type='hidden' name='type' value='save_show'>
						<input type='hidden' name='mod_name' value='$mod_name'>
						<input type='hidden' name='action' value='$checked'>
					</form>
				</div>";
		echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:10px;'> | </div>";
		echo "<div style='display:inline-block; width:30px; text-align:left; padding-left:10px;'><a href='$module_path'>View</a></div>";
		echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:10px;'> | </div>";
		if (isset($_GET["show"])) {
			echo "<div style='display:inline-block; width:50px; text-align:left; padding-left:10px;'><a href='scripts/modules_action.php?action=remove&module=$mod_name&show'>Remove</a></div>";
		} else {
			echo "<div style='display:inline-block; width:50px; text-align:left; padding-left:10px;'><a href='scripts/modules_action.php?action=remove&module=$mod_name'>Remove</a></div>";
		}
		echo "</div>";
		
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
    if (isset($_GET["show"])) {
        $external_ip = exec("curl ident.me");
        if ($external_ip != "" and isset($_GET["show"])) {
            $xml = simplexml_load_file($url);
        }
    }
    if (isset($_GET["show-deb"])) {
        $external_ip = exec("curl ident.me");
        if($external_ip != "" and isset($_GET["show-deb"])) {
            exec("apt-cache search fruitywifi-module",$outdeb);
            //print_r($outdeb);
        }
    }
    
    if (count($xml) > 0 and $xml != "" and isset($_GET["show"])) {
        for ($i=0;$i < count($xml); $i++) {
			
			echo "<div style='height:22px;'>";
			echo "<div style='display:inline-block; width:80px; text-align:right;'>".$xml->module[$i]->name."</div>";
			echo "<div style='display:inline-block; width:30px; text-align:left; padding-left:10px;'>".$xml->module[$i]->version."</div>";
			echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:6px;'> | </div>";
			//echo "<div style='display:inline-block; width:50px; text-align:left; padding-left:10px;'>".$xml->module[$i]->author."</div>";
			echo "<div style='display:inline-block; width:50px; text-align:left; padding-left:20px;'>".$xml->module[$i]->author."</div>";
			//echo "<div style='display:inline-block; width:138px; text-align:right; padding-left:2px;'>".$xml->module[$i]->d_escription."</div>";
			echo "<div style='display:inline-block; width:48px; text-align:right; padding-left:2px;'></div>";
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
			
        }
    } else if (!empty($outdeb) and isset($_GET["show-deb"])) {
        for ($i=0;$i < count($outdeb); $i++) {
            
			$deb_pkg = explode(" ",$outdeb[$i]);
            $deb_pkg_name = explode("-",$deb_pkg[0]);
            $deb_name = str_replace("fruitywifi-module-","",$deb_pkg[0]);
            
			echo "<div style='height:22px;'>";
			echo "<div style='display:inline-block; width:80px; text-align:right;'>".$deb_name."</div>";
			echo "<div style='display:inline-block; width:30px; text-align:left; padding-left:10px;'>".$deb_name2."</div>";
			echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:6px;'> | </div>";
			//echo "<div style='display:inline-block; width:50px; text-align:left; padding-left:10px;'>".$xml->module[$i]->author."</div>";
			echo "<div style='display:inline-block; width:50px; text-align:left; padding-left:20px;'>".$deb_name2."@xtr4nge</div>";
			//echo "<div style='display:inline-block; width:138px; text-align:right; padding-left:2px;'>".$xml->module[$i]->d_escription."</div>";
			echo "<div style='display:inline-block; width:48px; text-align:right; padding-left:2px;'></div>";
			echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:6px;'> | </div>";
			
			if (count($mod_installed) == 0) $mod_installed[0] = "";
			
			if (module_deb($deb_name) == 1) {
				echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:4px;'>installed</div>";
			} else if (module_deb($deb_name) == 2) {
				echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:4px;'><a href='scripts/modules_action.php?action=install-deb&module=".$deb_name."&show-deb'>install</a></div>";
            } else {
				echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:4px;'><a href='scripts/modules_action.php?action=install-deb&module=".$deb_name."&show-deb'>upgrade</a></div>";                
                /*
                if (str_replace("v","",$version) < $xml->module[$i]->required ) {
					echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:4px;'><a href='#' onclick='alert(\"FruityWifi v".$xml->module[$i]->required." is required\")'>install</a></div>";
				} else {
					echo "<div style='display:inline-block; width:10px; text-align:left; padding-left:4px;'><a href='scripts/modules_action.php?action=install&module=".$xml->module[$i]->name."&show'>install</a></div>";
				}
				*/
			}
			echo "</div>";
			
        }
        
    } else {
            echo "<a href='?show'>List available modules [tar.gz]</a> <br>";
            echo "This will establish a connection to github.com/xtr4nge";
            echo "<br><br>";
            echo "<a href='?show-deb'>List available modules [apt-get]</a> <br>";
            echo "Install from Debian/Kali repository if available.";
    }

    ?>

    </table>
</div>
