<? 
/*
    Copyright (C) 2013-2016 xtr4nge [_AT_] gmail.com

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>FruityWifi</title>
</head>
<? include "login_check.php"; ?>
<? include "config/config.php" ?>
<? include "menu.php" ?>

<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>

<script>

//setEnableDisabled("wireless");
//setEnableDisabled("supplicant");

function setEnableDisable(operation, service, action) 
{
    //setInterval(function() {
    
        // Start loading....
        $("#"+service).html( "" );
        $("#"+service).css( "color","lime" );
        $("#"+service).css( "font-weight","bold" );
        
        $("#"+service).css( "text-align","center" );
        $("#"+service).html( "<img src='img/loading.gif'>" )
        
        $.ajax({
            type: 'POST',
            //url: 'wsdl/FruityWifi_client.php',
            url: 'scripts/module_init.php',
            //data: $(this).serialize(),
            data: 'operation='+operation+'&service='+service+'&action='+action,
            //data: 'operation=serviceAction&service=s_wireless&action=start',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#output').html('');
                $.each(data, function (index, value) {
                    if (value == "true") 
                    {
                        $("#"+service).html( "" );
                        $("#"+service).css( "color","lime" );
                        $("#"+service).css( "font-weight","bold" );
                        
                        //$("#"+service+"-start").hide();
                        $("#"+service+"-stop").hide();
                        $("#"+service+"-start").css("visibility","hidden");
                        $("#"+service+"-stop").css("visibility","hidden");
                        
                        //$("#"+service+"-loading").show();
                        
                        $("#"+service).css( "text-align","center" );
                        $("#"+service).html( "<img src='img/loading.gif'>" );
                        
                        //$("#"+service+"-stop").html("<img src='img/loading.gif'>");
                        setTimeout(function() {
                                $("#"+service).css( "text-align","left" );
                                //$("#"+service+"-loading").hide();
                                
                                $("#"+service+"-stop").show();
                                $("#"+service+"-stop").css("visibility","visible");
                                $("#"+service+"-start").hide();
                                
                                $("#"+service).html( "enabled" );
                        }, 2000); // Changed from 2000 to 500
                    }
                    else
                    {
                        $("#"+service).html( "" );
                        $("#"+service).css( "color","red" );
                        $("#"+service).css( "font-weight","bold" );
                        
                        //$("#"+service+"-stop").hide();
                        $("#"+service+"-start").hide();
                        $("#"+service+"-start").css("visibility","hidden");
                        $("#"+service+"-stop").css("visibility","hidden");
                        
                        //$("#"+service+"-dummy").show();
                        //$("#"+service+"-loading").show();
                        
                        $("#"+service).css( "text-align","center" );
                        $("#"+service).html( "<img src='img/loading.gif'>" );
                        
                        //$("#"+service+"-stop").html("<img src='img/loading.gif'>");
                        //setTimeout(function() {$("#"+service+"-start").html("start");}, 2000);
                        setTimeout(function() {
                                $("#"+service).css( "text-align","left" );
                                //$("#"+service+"-loading").hide();
                                $("#"+service+"-start").show();
                                $("#"+service+"-start").css("visibility","visible");
                                $("#"+service+"-stop").hide();
                                
                                $("#"+service).html( "disabled" );
                        }, 2000); // Changed from 2000 to 500
                    }
                });
            }
        });
    //},5000);
}


function getStatus(operation, service) 
{
    var refInterval = setInterval(function() {
        $.ajax({
            type: 'POST',
            //url: 'wsdl/FruityWifi_client.php',
            url: 'scripts/module_status.php',
            //data: $(this).serialize(),
            data: 'operation='+operation+'&service='+service,
            //data: 'operation=serviceAction&service=s_wireless&action=start',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#output').html('');
                $.each(data, function (index, value) {
                    if (value == "true") 
                    {
                        //if ( $("#"+service).html() == "disabled" ) {
						if ( $("#"+service).html() != "enabled" ) {
                          
                            $("#"+service).html( "" );
                            $("#"+service).css( "color","lime" );
                            $("#"+service).css( "font-weight","bold" );
                            
                            $("#"+service+"-start").hide();
                            $("#"+service+"-stop").hide();
                            $("#"+service+"-start").css("visibility","hidden");
                            $("#"+service+"-stop").css("visibility","hidden");
                            
                            $("#"+service).css( "text-align","center" );
                            ////$("#"+service).html( "<img src='img/loading.gif'>" );
                            
                            setTimeout(function() {
                                    $("#"+service).css( "text-align","left" );
                                    //$("#"+service+"-loading").hide();

                                    $("#"+service+"-stop").show();
                                    $("#"+service+"-stop").css("visibility","visible");
                    
                                    $("#"+service).html( "enabled" );
                            }, 1000); // Changed from 0 to 500
                        } 
                    }
                    else 
                    {
                        //if ( $("#"+service).html() == "enabled" ) {
						if ( $("#"+service).html() != "disabled" ) {
                            $("#"+service).html( "" );
                            $("#"+service).css( "color","red" );
                            $("#"+service).css( "font-weight","bold" );
                            
                            $("#"+service+"-stop").hide();
                            $("#"+service+"-start").hide();
                            $("#"+service+"-stop").css("visibility","hidden");
							$("#"+service+"-start").css("visibility","hidden");
                            //$("#"+service+"-dummy").css("visibility","visible");
                            
                            $("#"+service).css( "text-align","center" );
                            ////$("#"+service).html( "<img src='img/loading.gif'>" );
                            
                            setTimeout(function() {
                                    $("#"+service).css( "text-align","left" );
                                    //$("#"+service+"-loading").hide();
                                    
                                    $("#"+service+"-start").show();
                                    $("#"+service+"-start").css("visibility","visible");
                                    
                                    $("#"+service).html( "disabled" );
                            }, 0);
                        }
                    }
                });
            }
        });
    },8000);
    $('#i_status_'+service).html(refInterval);
}


function getStatusInit(operation, service) 
{	
    //setInterval(function() {
        $.ajax({
            type: 'POST',
            //url: 'wsdl/FruityWifi_client.php',
            url: 'scripts/module_status.php',
            //data: $(this).serialize(),
            data: 'operation='+operation+'&service='+service,
            //data: 'operation=serviceAction&service=s_wireless&action=start',
            dataType: 'json',
            success: function (data) {
                //console.log(data);
                $('#output').html('');
                $.each(data, function (index, value) {
                    if (value == "true") 
                    {
                        $("#"+service).html( "" );
                        $("#"+service).css( "color","lime" );
                        $("#"+service).css( "font-weight","bold" );
                        
                        $("#"+service+"-start").hide();
                        $("#"+service+"-stop").hide();
                        $("#"+service+"-start").css("visibility","hidden");
                        $("#"+service+"-stop").css("visibility","hidden");
                        
                        $("#"+service).css( "text-align","center" );
                        ////$("#"+service).html( "<img src='img/loading.gif'>" );
                        
                        setTimeout(function() {
                                $("#"+service).css( "text-align","left" );
                                //$("#"+service+"-loading").hide();

                                $("#"+service+"-stop").show();
                                $("#"+service+"-stop").css("visibility","visible");
                
                                $("#"+service).html( "enabled" );
                                
                        }, 500); // FIXED [delay loading START]
                    }
                    else
                    {
                        $("#"+service).html( "" );
                        $("#"+service).css( "color","red" );
                        $("#"+service).css( "font-weight","bold" );
                        
                        $("#"+service+"-stop").hide();
                        $("#"+service+"-start").hide();
                        $("#"+service+"-start").css("visibility","hidden");
                        $("#"+service+"-stop").css("visibility","hidden");
                        //$("#"+service+"-dummy").css("visibility","visible");
                        
                        $("#"+service).css( "text-align","center" );
                        ////$("#"+service).html( "<img src='img/loading.gif'>" );
                        
                        setTimeout(function() {
                                $("#"+service).css( "text-align","left" );
                                //$("#"+service+"-loading").hide();
                                
                                $("#"+service+"-start").show();
                                $("#"+service+"-start").css("visibility","visible");
                                
                                $("#"+service).html( "disabled" );
                        }, 0);
                    }
                });
            }
        });
    //},5000);
}

</script>

<br>

<div style="b-order:1px solid; width: 410px; display:inline-block; vertical-align: top;">

<?
include "functions.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET['service'], "msg.php", $regex_extra);
    regex_standard($_GET['action'], "msg.php", $regex_extra);
}
$service = $_GET['service'];
$action = $_GET['action'];

?>

<?

function addDivs($service, $alias, $edit, $path, $mod_logs_panel)
{
    if ($mod_logs_panel == "disabled") {
        $visibility = "visibility:hidden;";
    } else {
        $visibility = "";
    }
    
    echo "
            <div style='text-align:left;'>
                <div style='border:0px solid red; display:inline-block; width:116px; text-align:right;'>$alias</div>
        
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
                <div id='$service-logOn' style='display:inline-block;$visibility'><a href='#' onclick=\"getLogs('$service', '$path')\">log</a></div>
                <div id='$service-logOff' style='display:inline-block;visibility:hidden;'><a href='#' onclick=\"removeLogs('$service')\">off</a></div>
                <div style='display:inline-block;' id='i_$service'></div>
                <div style='display:inline-block;visibility:hidden;' id='i_status_$service'></div>
                
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
addDivs("s_wireless", "Wireless", "page_config_adv.php", "../logs/dnsmasq.log", "show");
?>

<?
exec("find ./modules -name '_info_.php' | sort", $output);
if (count($output) > 0) {
?>
    <table border=0 width='100%' cellspacing=0 cellpadding=0>
    <?
    for ($i=0; $i < count($output); $i++) {
	$mod_type = ""; // checks if module is a service
        include $output[$i];
        $module_path = str_replace("_info_.php","",$output[$i]);
        
        if ($mod_panel == "show" and $mod_type == "service") {
		
            addDivs("mod_$mod_name", "$mod_alias", "modules/$mod_name/", "$mod_logs", "$mod_logs_panel");
            
            $mod_panel = "";
            $mod_alias = "";
			
        }
    
        $mod_logs_panel = "";
        $mod_installed[$i] = $mod_name;
    }
    ?>
    </table>
<?
}
//unset($output); // Why not only output array?
?>
</div>

<br>

<?
// ------------- External Modules --------------
//exec("find ./modules -name '_info_.php' | sort", $output); // replaced with previous output array

//print count($output);
//if (count($output) > 0) {
?>
<div class="rounded-top" align="center"> Modules </div>
<div class="rounded-bottom">
<?
if (count($output) > 0) {
?>
    <table border=0 width='100%' cellspacing=0 cellpadding=0>
    <?
    //exec("find ./modules -name '_info_.php'",$output);
    //print_r($output[0]);

    for ($i=0; $i < count($output); $i++) {
	$mod_type = ""; // checks if module is a service
        include $output[$i];
        $module_path = str_replace("_info_.php","",$output[$i]);
        
        if ($mod_panel == "show" and $mod_type != "service") {
		
            addDivs("mod_$mod_name", "$mod_alias", "modules/$mod_name/", "$mod_logs", "$mod_logs_panel");
            
            $mod_panel = "";
            $mod_alias = "";
		
/*
        echo "<tr>";
            echo "<td align='right' style='padding-right:5px; padding-left:5px; padding-bottom:1px; width:10px' nowrap>";
            if ($mod_alias != "") { 
                echo $mod_alias;
            } else {
                echo $mod_name;
            }
            echo "</td>";
            echo "<td align='left' style='padding-right:5px; padding-left:5px; ' nowrap>";
            if ($mod_panel == "show") {
                $isModuleUp = exec($mod_isup);
                if ($isModuleUp != "") {
                    echo "<font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href='modules/$mod_name/includes/module_action.php?service=$mod_name&action=stop&page=status'><b>stop</b></a>";
                    echo "&nbsp; | <a href='modules/$mod_name/'><b>view</b></a><br/>"; 
                } else { 
                    echo "<font color=\"red\"><b>disabled</b></font>. | <a href='modules/$mod_name/includes/module_action.php?service=$mod_name&action=start&page=status'><b>start</b></a>"; 
                    echo " | <a href='modules/$mod_name/'><b>edit</b></a><br/>"; 
                }
            $mod_panel = "";
            $mod_alias = "";
            }
            echo "</td>";
        echo "</tr>";
*/
        }
        
        $mod_logs_panel = "";
        $mod_installed[$i] = $mod_name;
    }
    ?>
    </table>

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
	// Get interfaces name
	$ifaces = getIfaceNAME();

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
<div class="rounded-bottom" id="stations-log">
    <?
    //exec("/sbin/iw dev $io_in_iface station dump |grep Stat", $stations);
    //for ($i=0; $i < count($stations); $i++) echo str_replace("Station", "", $stations[$i]) . "<br>";
    ?>
</div>

<br>

<div class="rounded-top" align="center"> DHCP </div>
<div class="rounded-bottom" id="dhcp-log">

</div>

</div>

<!-- ################################# -->

<script>

function getLogs(service, path) {
    //$( "#output" ).appendTo( "#content" );
    $("#content").append("<div align='center' id='"+service+"-log-title' class='rounded-top' style='b-order:1px solid; b-ackground-color:#222222; width:580px; p-adding:2px; '>Logs: "+service+"</div><div class='rounded-bottom' id='"+service+"-log' style='b-order:1px solid; width:576px; padding:2px; margin-bottom:10px; font-size:11px'>").append("<\div>");
    $("#"+service+"-logOn").hide();
    $("#"+service+"-logOff").show();
    $("#"+service+"-logOn").css("visibility","hidden");
    $("#"+service+"-logOff").css("visibility","visible");
    $("#"+service+"-log").html(" <img src='img/loading.gif'>");
    var refInterval = setInterval(function() {
        //event.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'scripts/status_logs.php',
            //data: $(this).serialize(),
            data: 'service='+service+'&path='+path,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#'+service+'-log').html('');
                $.each(data, function (index, value) {
                    //$("#output").append("<div>").append( value ).append("\div");
                    //if (value != "") {
                        $("#"+service+"-log").append( value ).append("<br>");
                        //$("#output").append( value ).append("\n");
                    //}
                });
            }
        });
    },2000);
    $('#i_'+service).html(refInterval);
}

function removeLogs(service) {
    $("#"+service+"-logOn").show();
    $("#"+service+"-logOff").hide();
    $("#"+service+"-logOn").css("visibility","visible");
    $("#"+service+"-logOff").css("visibility","hidden");
    clearInterval($("#i_"+service).html());
    $("#"+service+"-log").remove();
    $("#"+service+"-log-title").remove();
}

function getLogsDHCP() {
    var refInterval = setInterval(function() {
        $.ajax({
            type: 'POST',
            url: 'scripts/status_logs_dhcp.php',
            data: 'service=&path=',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#dhcp-log').html('');
                $.each(data, function (index, value) {
                    $("#dhcp-log").append( value ).append("<br>");
                });
            }
        });
    },8000);
    $('#i_dhcp').html(refInterval);
}

function getLogsStations() {
    var refInterval = setInterval(function() {
        $.ajax({
            type: 'POST',
            url: 'scripts/status_logs_stations.php',
            data: 'service=&path=',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('#stations-log').html('');
                $.each(data, function (index, value) {
                    $("#stations-log").append( value ).append("<br>");
                });
            }
        });
    },8000);

}

getLogsDHCP();
getLogsStations();

</script>

<div id="content" style="b-order:1px solid; width:580px; padding:0px; display:inline-block; font-size: 12px"></div>

</div>

</html>
