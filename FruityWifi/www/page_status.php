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
<? include "login_check.php"; ?>
<? include "config/config.php" ?>
<? include "menu.php" ?>
<meta name="viewport" content="initial-scale=0.50, width=device-width" />
<br>

<?
function addDivs($service, $alias, $edit, $path)
{
    echo "
        <div style='text-align:left;'>
            <div style='border:0px solid red; display:inline-block; width:80px; text-align:right;'>$alias</div>
    
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
	$iswlanup = exec("ps auxww | grep hostapd | grep -v -e grep");
}

//if ($iswlanup == "UP") {

echo "<div style='text-align:left;'>";
if ($iswlanup != "") {
    //echo "&nbsp;&nbsp;&nbsp;&nbsp;Wireless  <font color='lime'><b>enabled</b></font>.&nbsp; | <a href='scripts/status_wireless.php?service=wireless&action=stop' class='div-a'><b>stop</b></a><br />";

    echo "<div style='border:0px solid red; display:inline-block; width:84px; text-align:right;'>Wireless</div> ";
    echo "<div style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:lime;'>enabled.</div> ";
    echo "<div style='border:0px solid red; display:inline-block;'>|</div> ";
    
    echo "<div style='display:inline-block;font-weight:bold; width:36px; visibility:visible;'>
                <a href='scripts/status_wireless.php?service=wireless&action=stop' class='div-a'>stop</a>
            </div>";

} else { 
    //echo "&nbsp;&nbsp;&nbsp;&nbsp;Wireless  <font color='red'><b>disabled</b></font>. | <a href='scripts/status_wireless.php?service=wireless&action=start' class='div-a'><b>start</b></a><br />"; 
	
    echo "<div style='border:0px solid red; display:inline-block; width:84px; text-align:right;'>Wireless</div> ";
    echo "<div style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:red;'>disabled.</div> ";
    echo "<div style='border:0px solid red; display:inline-block;'>|</div> ";

    echo "<div style='display:inline-block;font-weight:bold; width:36px; visibility:visible;'>
                <a href='scripts/status_wireless.php?service=wireless&action=start' class='div-a'>start</a>
            </div>";

}
echo "</div>";
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
                        echo "<div style='border:0px solid red; display:inline-block; width:84px; text-align:right;'>$mod_alias</div> ";
                    } else {
                        //echo $mod_name;
                        echo "<div style='border:0px solid red; display:inline-block; width:84px; text-align:right;'>$mod_name</div> ";
                    }
                    //echo "</td>";
                    //echo "<td align='left' style='padding-right:5px; padding-left:5px; ' nowrap>";
                    if ($mod_panel == "show") {
                        $isModuleUp = exec($mod_isup);
                        if ($isModuleUp != "") {
                            //echo "<font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href='modules/$mod_name/includes/module_action.php?service=$mod_name&action=stop&page=status'><b>stop</b></a>";
                            //echo "&nbsp; | <a href='modules/$mod_name/'><b>view</b></a><br/>";
                            
                            echo "<div style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:lime;'>enabled.</div> ";
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

                            echo "<div style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:red;'>disabled.</div> ";
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
}
?>
</div>

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
			    echo "<div style='border:0px solid red; display:inline-block; width:84px; text-align:right;'>$mod_alias</div> ";
                        } else {
                            //echo $mod_name;
			    echo "<div style='border:0px solid red; display:inline-block; width:84px; text-align:right;'>$mod_name</div> ";
                        }
                        //echo "</td>";
                        //echo "<td align='left' style='padding-right:5px; padding-left:5px; ' nowrap>";
                        if ($mod_panel == "show") {
                            $isModuleUp = exec($mod_isup);
                            if ($isModuleUp != "") {
                                //echo "<font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href='modules/$mod_name/includes/module_action.php?service=$mod_name&action=stop&page=status'><b>stop</b></a>";
                                //echo "&nbsp; | <a href='modules/$mod_name/'><b>view</b></a><br/>";
				
				echo "<div style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:lime;'>enabled.</div> ";
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
				
				echo "<div style='border:0px solid red; display:inline-block; width:63px; font-weight:bold; color:red;'>disabled.</div> ";
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

<br>

<div class="rounded-top" align="center"> Interfaces/IP </div>
<div class="rounded-bottom">
    <?

    $ifaces = exec("/sbin/ifconfig -a | cut -c 1-8 | sort | uniq -u |grep -v lo|sed ':a;N;$!ba;s/\\n/|/g'");
    $ifaces = str_replace(" ","",$ifaces);
    $ifaces = explode("|", $ifaces);

    for ($i = 0; $i < count($ifaces); $i++) {
        if (strpos($ifaces[$i], "mon") === false) {
            echo $ifaces[$i] . ": ";
            $ip = exec("/sbin/ifconfig $ifaces[$i] | grep 'inet addr:' | cut -d: -f2 |awk '{print $1}'");
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

