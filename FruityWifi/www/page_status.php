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
<? include "header.php"; ?>
<? include "login_check.php"; ?>
<? include "config/config.php" ?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>FruityWifi</title>
	<script src="js/jquery.js"></script>

	<style>
			.div0 {
					width: 350px;
			 }
			.div1 {
					width: 120px;
					display: inline-block;
					text-align: left;
					margin-right: 10px;
			}
			.divEnabled {
					width: 63px;
					color: lime;
					display: inline-block;
					font-weight: bold;
			}
			.divDisabled {
					width: 63px;
					color: red;
					display: inline-block;
					font-weight: bold;
			}
			.divAction {
					width: 80px;
					display: inline-block;
					font-weight: bold;
			}
			.divDivision {
					width: 16px;
					display: inline-block;
			}
	</style>

</head>
<body>

<? include "menu.php" ?>

<br>

<?
function addDivs($service, $alias, $edit, $path)
{
    echo "
        <div style='text-align:left;'>
            <div style='border:0px solid red; display:inline-block; width:120px; text-align:left;'>$alias</div>
    
            <div name='$service' id='$service' style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:red;'>disabled.</div>
            <div style='border:0px solid red; display:inline-block;'>|</div>
            
            <div id='$service-start' style='display:inline-block;font-weight:bold; width:36px; visibility:visible;'>
                    <a href='#' onclick=\"setEnableDisable('serviceAction','$service','start')\">start</a>
            </div>
            <div id='$service-stop' style='display:inline-block;font-weight:bold; width:36px; visibility:visible;'>
                    <a href='#' onclick=\"setEnableDisable('serviceAction','$service','stop')\">stop</a>
            </div>
            
            <div id='$service-loading' style='display:inline-block;'>
                    <img src='img/loading.gif'>
            </div>
            
            <div style='border:0px solid red; display:inline-block;'>|</div>
            <div id='$service-stop' style='display:inline-block;font-weight:bold; width:36px;'>
                    <a href='$edit'>edit</a>
            </div>
            
            <div style='border:0px solid red; display:inline-block;'>|</div>
            <div id='$service-logOn' style='display:inline-block;'><a href='#' onclick=\"getLogs('$service', '$path')\">log</a></div>
            <div id='$service-logOff' style='display:inline-block;visibility:hidden;'><a href='#' onclick=\"removeLogs('$service')\">off</a></div>
            <div style='display:inline-block;' id='i_$service'></div>
            <div style='display:inline-block;' id='i_status_$service'></div>
            
            
            <script>
                            //getEnableDisabled('$service')
                            getStatusInit('getStatus','$service');
                            getStatus('getStatus','$service');
            </script>

            <script>
            $(function(){
                    $('#$service-stop').hide();
                    $('#$service-loading').hide();
                    $('#i_$service').hide();
                    $('#i_status_$service').hide();
            });
            </script>
        </div>
        
        ";	
}
?>

<!-- SERVICES | MODULES START -->

<div style="display:inline-block; vertical-align: top; margin-bottom: 10px;">
	
	<div class="rounded-top" align="center"> Services </div>
	<div class="rounded-bottom">
	<?
	include "functions.php";
	
	//addDivs("s_wireless", "Wireless", "page_config.php", "../logs/dnsmasq.log");
	
	// Checking POST & GET variables...
	if ($regex == 1) {
		regex_standard($_GET['service'], "msg.php", $regex_extra);
		regex_standard($_GET['action'], "msg.php", $regex_extra);
	}
	$service = $_GET['service'];
	$action = $_GET['action'];
	
	?>
	
	<?
	//$iswlanup = exec("/sbin/ifconfig wlan0 | grep UP | awk '{print $1}'");
	
	if ($ap_mode == "1") { 
		$iswlanup = exec("ps auxww | grep hostapd | grep -v -e grep");
	} else if ($ap_mode == "2") {
		$iswlanup = exec("ps auxww | grep airbase | grep -v -e grep");
	} else if ($ap_mode == "3") {
		$iswlanup = exec("ps auxww | grep hostapd | grep -v -e grep");
	} else if ($ap_mode == "4") {
		$iswlanup = exec("ps auxww | grep hostapd|airbase | grep -v -e grep");
	}
	
	// IF MODULE [AP] DOES NOT EXISTS
	if (!file_exists("/usr/share/fruitywifi/www/modules/ap/")) {
		echo "<div style='text-align:left;'>";
		if ($iswlanup != "") {	
			echo "<div style='border:0px solid red; display:inline-block; width:116px; text-align:left;'>Wireless</div> ";
			echo "<div style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:lime;'>enabled</div> ";
			echo "<div style='border:0px solid red; display:inline-block;'>|</div> ";
			
			echo "<div style='display:inline-block;font-weight:bold; width:36px; visibility:visible;'>
						<a href='scripts/status_wireless.php?service=wireless&action=stop' class='div-a'>stop</a>
					</div>";	
		} else { 
			echo "<div style='border:0px solid red; display:inline-block; width:116px; text-align:left;'>Wireless</div> ";
			echo "<div style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:red;'>disabled</div> ";
			echo "<div style='border:0px solid red; display:inline-block;'>|</div> ";
		
			echo "<div style='display:inline-block;font-weight:bold; width:36px; visibility:visible;'>
						<a href='scripts/status_wireless.php?service=wireless&action=start' class='div-a'>start</a>
					</div>";
		}
		echo "</div>";
	}
	?>
	
	<?
	exec("find ./modules -name '_info_.php' | sort",$output);
	if (count($output) > 0) {
		?>
		<t-able border=0 width='100%' cellspacing=0 cellpadding=0>
		<?
		
		for ($i=0; $i < count($output); $i++) {
			echo "<div style='text-align:left;'>";
			
				$mod_type = "";
				if ($output[$i] != "") {
					include $output[$i];
					$module_path = str_replace("_info_.php","",$output[$i]);
					
					if ($mod_panel == "show" and $mod_type == "service") {
					//echo "<tr>";
						//echo "<td class='rounded-bottom-body' align='right' s-tyle='padding-right:5px; padding-left:5px; padding-bottom:1px; width:10px; color: #445257;' nowrap>";
						if ($mod_alias != "") { 
							//echo $mod_alias;
							echo "<div style='border:0px solid red; display:inline-block; width:116px; text-align:left;'>$mod_alias</div> ";
						} else {
							//echo $mod_name;
							echo "<div style='border:0px solid red; display:inline-block; width:116px; text-align:left;'>$mod_name</div> ";
						}
						//echo "</td>";
						//echo "<td align='left' style='padding-right:5px; padding-left:5px; ' nowrap>";
						if ($mod_panel == "show") {
							$isModuleUp = exec($mod_isup);
							if ($isModuleUp != "") {
								//echo "<font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href='modules/$mod_name/includes/module_action.php?service=$mod_name&action=stop&page=status'><b>stop</b></a>";
								//echo "&nbsp; | <a href='modules/$mod_name/'><b>view</b></a><br/>";
								
								echo "<div style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:lime;'>enabled</div> ";
								echo "<div style='border:0px solid red; display:inline-block;'>|</div> ";
								echo "<div style='display:inline-block;font-weight:bold; width:36px; visibility:visible;'>
											<a href='modules/$mod_name/includes/module_action.php?service=$mod_name&action=stop&page=status'>stop</a>
										</div>";
										
								echo "<div style='border:0px solid red; display:inline-block;'>|</div>
										<div style='display:inline-block;font-weight:bold; width:36px;'>
											<a href='modules/$mod_name/'>view</a>
										</div>";
									
							} else { 
								//echo "<font color=\"red\"><b>disabled</b></font>. | <a href='modules/$mod_name/includes/module_action.php?service=$mod_name&action=start&page=status'><b>start</b></a>"; 
								//echo " | <a href='modules/$mod_name/'><b>edit</b></a><br/>"; 
	
								echo "<div style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:red;'>disabled</div> ";
								echo "<div style='border:0px solid red; display:inline-block;'>|</div> ";
								echo "<div style='display:inline-block;font-weight:bold; width:36px; visibility:visible;'>
											<a href='modules/$mod_name/includes/module_action.php?service=$mod_name&action=start&page=status'>start</a>
										</div>";
										
								echo "<div style='border:0px solid red; display:inline-block; padding-left:0px'>|</div>
										<div style='display:inline-block;font-weight:bold; width:36px;'>
											<a href='modules/$mod_name/'>edit</a>
										</div>";
							}
							$mod_panel = "";
							$mod_alias = "";
						}
						//echo "</td>";
						//echo "</tr>";
					}
					$mod_installed[$i] = $mod_name;
				}
			echo "</div>";
		}
		
		?>
		</t-able>
	<?
	}
	?>
	</div>
	
	<?
	// IF MODULE FRUITYPROXY EXISTS
	if (file_exists("/usr/share/fruitywifi/www/modules/fruityproxy/")) {
	?>
	<br>
	
	<div class="rounded-top" align="center"> FruityProxy (mitmproxy) </div>
	<div class="rounded-bottom" id="mitmproxy_plugins">
	
	</div>
    <? } ?>
	<?
	// IF MODULE MITMF EXISTS
	if (file_exists("/usr/share/fruitywifi/www/modules/mitmf/")) {
	?>
	<br>
	
	<div class="rounded-top" align="center"> MITMf Plugins </div>
	<div class="rounded-bottom" id="mitmf_plugins">
		
	</div>
	<? } ?>
	
	<br>
	<?
	// ------------- External Modules --------------
	//exec("find ./modules -name '_info_.php' | sort",$output); // replaced with previous output array
	
	//print count($output);
	//if (count($output) > 0) {
	?>
	<div class="rounded-top" align="center"> Modules </div>
	<div class="rounded-bottom">
		
		<?
		if (count($output) > 0) {
		?>
			<t-able border=0 width='100%' cellspacing=0 cellpadding=0>
			<?
			//exec("find ./modules -name '_info_.php'",$output);
			//print_r($output[0]);
		
			for ($i=0; $i < count($output); $i++) {
			echo "<div style='text-align:left;'>";
					$mod_type = "";
					if ($output[$i] != "") {
						include $output[$i];
						$module_path = str_replace("_info_.php","",$output[$i]);
						
						if ($mod_panel == "show" and $mod_type != "service") {
						//echo "<tr>";
							//echo "<td class='rounded-bottom-body' align='right' s-tyle='padding-right:5px; padding-left:5px; padding-bottom:1px; width:10px; color: #445257;' nowrap>";
							if ($mod_alias != "") { 
							//    echo $mod_alias;
					echo "<div style='border:0px solid red; display:inline-block; width:116px; text-align:left;'>$mod_alias</div> ";
							} else {
								//echo $mod_name;
					echo "<div style='border:0px solid red; display:inline-block; width:116px; text-align:left;'>$mod_name</div> ";
							}
							//echo "</td>";
							//echo "<td align='left' style='padding-right:5px; padding-left:5px; ' nowrap>";
							if ($mod_panel == "show") {
								$isModuleUp = exec($mod_isup);
								if ($isModuleUp != "") {
									//echo "<font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href='modules/$mod_name/includes/module_action.php?service=$mod_name&action=stop&page=status'><b>stop</b></a>";
									//echo "&nbsp; | <a href='modules/$mod_name/'><b>view</b></a><br/>";
					
					echo "<div style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:lime;'>enabled</div> ";
					echo "<div style='border:0px solid red; display:inline-block;'>|</div> ";
					echo "<div style='display:inline-block;font-weight:bold; width:36px; visibility:visible;'>
							<a href='modules/$mod_name/includes/module_action.php?service=$mod_name&action=stop&page=status'>stop</a>
						</div>";
						
					echo "<div style='border:0px solid red; display:inline-block;'>|</div>
						<div style='display:inline-block;font-weight:bold; width:36px;'>
							<a href='modules/$mod_name/'>view</a>
						</div>";
					
								} else { 
									//echo "<font color=\"red\"><b>disabled</b></font>. | <a href='modules/$mod_name/includes/module_action.php?service=$mod_name&action=start&page=status'><b>start</b></a>"; 
									//echo " | <a href='modules/$mod_name/'><b>edit</b></a><br/>";
					
					echo "<div style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:red;'>disabled</div> ";
					echo "<div style='border:0px solid red; display:inline-block;'>|</div> ";
					echo "<div style='display:inline-block;font-weight:bold; width:36px; visibility:visible;'>
							<a href='modules/$mod_name/includes/module_action.php?service=$mod_name&action=start&page=status'>start</a>
						</div>";
						
					echo "<div style='border:0px solid red; display:inline-block;'>|</div>
						<div style='display:inline-block;font-weight:bold; width:36px;'>
							<a href='modules/$mod_name/'>edit</a>
						</div>";
					
								}
							$mod_panel = "";
							$mod_alias = "";
							}
							//echo "</td>";
						//echo "</tr>";
						}        
						$mod_installed[$i] = $mod_name;
					}
			echo "</div>";
				}
			?>
			</t-able>
		<? 
		} else {
			echo "<div>No modules have been installed.<br>Install them from the <a href='page_modules.php'><b>Available Modules</b></a> list.</div>";
		}
		?>
	
	</div>

</div>

<!-- SERVICES | MODULES END -->


<!-- IP DETAILS -->

<div style="display: inline-block; vertical-align: top;">
	
	<div class="rounded-top" align="center"> Interfaces/IP </div>
	<div class="rounded-bottom">
		<?
		// Get interfaces name
		$ifaces = getIfaceNAME();
	
		for ($i = 0; $i < count($ifaces); $i++) {
			if (strpos($ifaces[$i], "mon") === false) {
				echo $ifaces[$i] . ": ";
				$ip = getIfaceIP($ifaces[$i]);
				echo $ip . "<br>";
			}
		}
	
		if ($_GET['reveal_public_ip'] == 1) {
			echo "public: " . exec("curl ident.me");
		} else {
			echo "public: <a href='page_status.php?reveal_public_ip=1'>reveal ip</a>";
		}
		
		?>
	</div>
	
	<br>
	
	<div class="rounded-top" align="center"> Stations </div>
	<div class="rounded-bottom">
		<?
		exec("/sbin/iw dev $io_in_iface station dump |grep Stat", $stations);
		for ($i=0; $i < count($stations); $i++) echo str_replace("Station", "", $stations[$i]) . "<br>";
		?>
	</div>
	
	<br>
	
	<div class="rounded-top" align="center"> DHCP </div>
	<div class="rounded-bottom">
		<?
		$filename = "/usr/share/fruitywifi/logs/dhcp.leases";
		$fh = fopen($filename, "r"); //or die("Could not open file.");
		if ( 0 < filesize( $filename ) ) {
			$data = fread($fh, filesize($filename)); //or die("Could not read file.");
		}
		fclose($fh);
		$data = explode("\n",$data);
		
		for ($i=0; $i < count($data); $i++) {
			$tmp = explode(" ", $data[$i]);
			echo $tmp[2] . " " . $tmp[1] . " " . $tmp[3] . "<br>";
		}
		?>
	</div>

</div>

<script type='text/javascript'>
function sortObject(object) {
    return Object.keys(object).sort().reduce(function (result, key) {
        result[key] = object[key];
        return result;
    }, {});
}
</script>

<?
// IF MODULE FRUITYPROXY EXISTS
if (file_exists("/usr/share/fruitywifi/www/modules/fruityproxy/")) {
?>
<script type='text/javascript'>
function loadPlugins()
{
    $(document).ready(function() { 
        $.getJSON('modules/fruityproxy/includes/ws_action.php?method=getModulesStatusAll', function(data) {
            var div = document.getElementById('mitmproxy_plugins');
            div.innerHTML = ""
            console.log(data);
            data = sortObject(data)
            $.each(data, function(key, val) {
                if (val == "enabled") {
                    div.innerHTML = div.innerHTML + "<div class='div0'><div class='div1'>" + key + "</div><div class='divEnabled'>enabled</div><div class='divDivision'> | </div><div class='divAction'><a href='#' onclick=\"setModulesStatus('" + key + "',0)\">stop</a></div></div>";
                } else {
                    div.innerHTML = div.innerHTML + "<div class='div0'><div class='div1'>" + key + "</div><div class='divDisabled'>disabled</div><div class='divDivision'> | </div><div class='divAction'><a href='#' onclick=\"setModulesStatus('" + key + "',1)\">start</a></div></div>";
                }
                    
            });
        });    
    
    });
}
loadPlugins()

function setModulesStatus(module, action) {
    $(document).ready(function() { 
        $.getJSON('modules/fruityproxy/includes/ws_action.php?method=setModulesStatus&module=' + module + '&action=' + action, function(data) {
        });
        /*
        $.postJSON = function(url, data, func)
        {
            $.post(url, data, func, 'json');
        }
        */
    });
    setTimeout(loadPlugins, 500);
}
</script>
<? } ?>

<?
// IF MODULE MITMF EXISTS
if (file_exists("/usr/share/fruitywifi/www/modules/mitmf/")) {
?>
<script type='text/javascript'>
function loadMITMfPlugins()
{
    $(document).ready(function() { 
        $.getJSON('modules/mitmf/includes/ws_action.php?method=getPlugins', function(data) {
            var div = document.getElementById('mitmf_plugins');
            div.innerHTML = ""
            console.log(data);
            data = sortObject(data)
            $.each(data, function(key, val) {
                if (val == true) {
                    div.innerHTML = div.innerHTML + "<div class='div0'><div class='div1'>" + key + "</div><div class='divEnabled'>enabled</div><div class='divDivision'> | </div><div class='divAction'><a href='#' onclick=\"setPluginStatus('" + key + "',0)\">stop</a></div></div>";
                } else {
                    div.innerHTML = div.innerHTML + "<div class='div0'><div class='div1'>" + key + "</div><div class='divDisabled'>disabled</div><div class='divDivision'> | </div><div class='divAction'><a href='#' onclick=\"setPluginStatus('" + key + "',1)\">start</a></div></div>";
                }
                    
            });
        });    
    
    });
}
loadMITMfPlugins()

function setPluginStatus(plugin, action) {
    $(document).ready(function() { 
        $.getJSON('modules/mitmf/includes/ws_action.php?method=setPluginStatus&plugin=' + plugin + '&action=' + action, function(data) {
        });
        /*
        $.postJSON = function(url, data, func)
        {
            $.post(url, data, func, 'json');
        }
        */
    });
    setTimeout(loadMITMfPlugins, 500);
}

</script>
<? } ?>

</body>
</html>
