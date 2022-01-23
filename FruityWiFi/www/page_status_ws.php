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
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>FruityWifi</title>
</head>
<? include "login_check.php"; ?>
<? include "config/config.php" ?>

<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>

	<style>
			.div0 {
					width: 350px;
					margin-top: 2px;
			 }
			.div1 {
					width: 120px;
					display: inline-block;
					text-align: left;
					margin-right: 10px;
			}
			.divName {
					width: 200px;
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
			.divStartStopB {
					width: 34px;
			}
	</style>

<? include "menu.php" ?>

<style>
	/* Block Title*/
	.log-rounded-top {
		font-weight: bold;
		color: #111; /*#323C40*/
		border:0px solid;
		border-color: #576971; /* 576971 */
		w--idth:310px; /* 400 */
		
		min-width: 300px;
		width: 96%;
		max-width:580px;
		
		-moz-border-radius-topright: 2px; /* 10 */
		border-top-right-radius: 2px; /* 10 */
		-moz-border-radius-topleft: 2px; /* 10 */
		border-top-left-radius: 2px; /* 10 */
		
		text-align: left;
		padding: 0px;
		padding-top:2px;
		padding-bottom:2px;
		margin-left: 10px; /*10px*/
	}
	/* Block Body*/
	.log-rounded-bottom {
		text-align: left;
		background-color: 	#F8F8F8; /* #E01B46 */
		color: #111; /*#445257*/
		f--ont-size: 12px;
		border-top:1px solid;
		border-color: #BAC1C4; /* E01B46 */
		p--adding:5px;
		w--idth:300px; /* 390px */
		
		padding:0px;
		margin-bottom:10px;
		font-size:10px;
		
		min-width: 300px;
		width: 96%;
		max-width:576px;
		
		
		-moz-border-radius-bottomright: 5px; /* 10 */
		border-bottom-right-radius: 5px; /* 10 */
		-moz-border-radius-bottomleft: 5px; /* 10 */
		border-bottom-left-radius: 5px; /* 10 */
		margin-left: 10px; /*10px*/
	}
</style>

<script>

function stopInterval(id){
	clearInterval(id);
}

//setEnableDisabled("wireless");
//setEnableDisabled("supplicant");

function output(data){
	alert(data);
}

function setEnableDisable(operation, service, action) 
{
    //setInterval(function() {
    
        // Start loading....
        //$("#"+service).html( "" );
        //$("#"+service).css( "color","lime" );
        //$("#"+service).css( "font-weight","bold" );
        
        //$("#"+service).css( "text-align","center" );
        //$("#"+service).html( "<img src='img/loading.gif'>" )
        
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
						/*
                        $("#"+service).html( "" );
                        $("#"+service).css( "color","lime" );
                        $("#"+service).css( "font-weight","bold" );
                        
                        $("#"+service+"-stop").hide();
                        $("#"+service+"-start").css("visibility","hidden");
                        $("#"+service+"-stop").css("visibility","hidden");
                        
                        
                        $("#"+service).css( "text-align","center" );
                        $("#"+service).html( "<img src='img/loading.gif'>" );
                        */
                        setTimeout(function() {
                                //$("#"+service).css( "text-align","left" );
                                
                                //$("#"+service+"-stop").show();
                                //$("#"+service+"-stop").css("visibility","visible");
                                //$("#"+service+"-start").hide();
                                
                                //$("#"+service).html( "enabled" ); //removed
								
								//$('input[id="s-'+service+'"]').bootstrapSwitch('state', true, false);
								
                        }, 500); // Changed from 2000 to 500
                    }
                    else
                    {
						/*
                        $("#"+service).html( "" );
                        $("#"+service).css( "color","red" );
                        $("#"+service).css( "font-weight","bold" );
                        
                        //$("#"+service+"-stop").hide();
                        $("#"+service+"-start").hide();
                        $("#"+service+"-start").css("visibility","hidden");
                        $("#"+service+"-stop").css("visibility","hidden");
                        
                        $("#"+service).css( "text-align","center" );
                        $("#"+service).html( "<img src='img/loading.gif'>" );
						*/
                        setTimeout(function() {
                                //$("#"+service).css( "text-align","left" );
                                //$("#"+service+"-start").show();
                                //$("#"+service+"-start").css("visibility","visible");
                                //$("#"+service+"-stop").hide();
                                
                                //$("#"+service).html( "disabled" ); //removed
								
								//$('input[id="s-'+service+'"]').bootstrapSwitch('state', false, false);
								
                        }, 500); // Changed from 2000 to 500
                    }
                });
            }
        });
    //},5000);
}

function setStatusSwitch(service, state) {
	
	if ($('#status_'+service).html() != "") {
		
		// Stop setInterval
		id = $('#i_status_'+service).html();
		clearInterval(id);
		
		if (state == true) {
			setEnableDisable("", service, "start")
			$('#status_'+service).html("+"); 
		} else {
			setEnableDisable("", service, "stop")
			$('#status_'+service).html("-");
		}
		
		// Restart setInterval
		getStatus("", service);
		
	}
	
}

function getStatusSwitch(service, state) 
{
	service = service.replace("mod_","");
    
	setTimeout(function() {
		$.getJSON( "scripts/switch_status.php", { service: service } )
		.done(function( data ) {
			//console.log( "JSON Data: " + json.users[ 0 ].service );
			//console.log( data );
			if (data[0] === true) {
				$('#status_'+service).html("+");
			} else {
				$('#status_'+service).html("-");
			}
		})
		.fail(function( jqxhr, textStatus, error ) {
			var err = textStatus + ", " + error;
			console.log( "Request Failed: " + err );
		});
	},1000);

}

function switchAction(service){
	//alert(service);
	var status = "";
	status = getStatusSwitch(service);
	//alert(status)
	console.log("::" + JSON.stringify(status));
	if (status == "true") {
		//alert(true)
		setEnableDisable("", service, "stop") 
	} else {
		//setEnableDisable(operation, service, "start") 
	}
}

function getStatus(operation, service) 
{
	service = service.replace("mod_","");
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
                //console.log(data);
                $('#output').html('');
                $.each(data, function (index, value) {
                    if (value == "true") 
                    {
                        //if ( $("#"+service).html() == "disabled" ) {
						if ( $("#"+service).html() != "enabled" ) {
                          
							/*
                            $("#"+service).html( "" );
                            $("#"+service).css( "color","lime" );
                            $("#"+service).css( "font-weight","bold" );
                            
                            $("#"+service+"-start").hide();
                            $("#"+service+"-stop").hide();
                            $("#"+service+"-start").css("visibility","hidden");
                            $("#"+service+"-stop").css("visibility","hidden");
                            
                            $("#"+service).css( "text-align","center" );
                            */
							
                            setTimeout(function() {
                                    //$("#"+service).css( "text-align","left" );

                                    //$("#"+service+"-stop").show();
                                    //$("#"+service+"-stop").css("visibility","visible");
                    
                                    //$("#"+service).html( "enabled" ); //removed
									
                            }, 1000); // Changed from 0 to 500
                        }
						
						$('input[id="s-'+service+'"]').bootstrapSwitch('state', true, true);
						//$('#status_'+service).html("true");

                    }
                    else 
                    {
						if ( $("#"+service).html() != "disabled" ) {
							/*
                            $("#"+service).html( "" );
                            $("#"+service).css( "color","red" );
                            $("#"+service).css( "font-weight","bold" );
                            
                            $("#"+service+"-stop").hide();
                            $("#"+service+"-start").hide();
                            $("#"+service+"-stop").css("visibility","hidden");
							$("#"+service+"-start").css("visibility","hidden");
                            
                            $("#"+service).css( "text-align","center" );
							*/
                            
                            setTimeout(function() {
                                    //$("#"+service).css( "text-align","left" );
                                    
                                    //$("#"+service+"-start").show();
                                    //$("#"+service+"-start").css("visibility","visible");
                                    
                                    //$("#"+service).html( "disabled" ); //removed
									
									
                            }, 0);
                        }
						$('input[id="s-'+service+'"]').bootstrapSwitch('state', false, false);
						//$('#status_'+service).html("false");

                    }
                });
            }
        });
		//$('#i_status_'+service).html(refInterval);
		//console.log(service);
		//console.log(refInterval);
	},8000);
    $('#i_status_'+service).html(refInterval);
}


function getStatusInit(operation, service) 
{
	service = service.replace("mod_","");
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
						/*
                        $("#"+service).html( "" );
                        $("#"+service).css( "color","lime" );
                        $("#"+service).css( "font-weight","bold" );
                        
                        $("#"+service+"-start").hide();
                        $("#"+service+"-stop").hide();
                        $("#"+service+"-start").css("visibility","hidden");
                        $("#"+service+"-stop").css("visibility","hidden");
                        
                        $("#"+service).css( "text-align","center" );
						*/
                        
                        setTimeout(function() {
                                //$("#"+service).css( "text-align","left" );

                                //$("#"+service+"-stop").show();
                                //$("#"+service+"-stop").css("visibility","visible");
                
                                //$("#"+service).html( "enabled" ); //removed
								
								$('input[id="s-'+service+'"]').bootstrapSwitch('state', true, false);
								//$('#status_'+service).html("true");
                                
                        }, 500); // FIXED [delay loading START]
						//return true;
                    }
                    else
                    {
						/*
                        $("#"+service).html( "" );
                        $("#"+service).css( "color","red" );
                        $("#"+service).css( "font-weight","bold" );
                        
                        $("#"+service+"-stop").hide();
                        $("#"+service+"-start").hide();
                        $("#"+service+"-start").css("visibility","hidden");
                        $("#"+service+"-stop").css("visibility","hidden");
                        //$("#"+service+"-dummy").css("visibility","visible");
                        
                        $("#"+service).css( "text-align","center" );
						*/
                        
                        setTimeout(function() {
                                //$("#"+service).css( "text-align","left" );
                                
                                //$("#"+service+"-start").show();
                                //$("#"+service+"-start").css("visibility","visible");
                                
                                //$("#"+service).html( "disabled" ); //removed
								
								$('input[id="s-'+service+'"]').bootstrapSwitch('state', false, false);
								//$('#status_'+service).html("false");
                        }, 0);
						//return false;
                    }
                });
            }
        });
    //},5000);
}

</script>

<br>

<div style="b-order:1px dotted; w-idth: 410px; display:inline-block; vertical-align: top;">

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
    
	$name = str_replace("mod_","",$service);
	
    echo "
            <div style='text-align:left;'>
                <div style='border:0px solid red; display:inline-block; width:140px; text-align:left;'>$alias</div>
                
                <div id='$service-start' style='display:inline-block;font-weight:bold; width:0px; visibility:visible;'>
                    <a href='#' onclick=\"setEnableDisable('serviceAction','$service','start')\"></a>
                </div>
                <div id='$service-stop' style='display:inline-block;font-weight:bold; width:0px; visibility:visible;'>
                    <a href='#' onclick=\"setEnableDisable('serviceAction','$service','stop')\"></a>
                </div>
                
				<div style='display:inline-block;font-weight:bold; width:40px; visibility:visible; margin-top:2px'>
					<a href='$edit' class='btn btn-default btn-xs' role='button'>edit</a>
				</div>
				
				<div style='display:inline-block;font-weight:bold; width:36px; visibility:visible; margin-top:2px'>
					<input id='s-$name' type='checkbox' checked data-size='mini' data-on-color='success' data-on-text='&nbsp;' data-off-text='&nbsp;'>
				</div>
				
                <div id='$service-logOn' style='display:inline-block;$visibility; '>
					<button type='button' class='btn btn-default btn-xs' onclick=\"getLogs('$service', '$path')\" >log</button>
				</div>
                <div id='$service-logOff' style='display:none;visibility:hidden;'>
					<button type='button' class='btn btn-default btn-xs' onclick=\"removeLogs('$service')\" >off</button>
				</div>
				
				<div style='display:inline-block;visibility:hidden;display:none;' id='i_$service'></div>
                <div style='display:inline-block;visibility:hidden;display:none;' id='i_status_$name'></div>
				
                <script>
                    //getEnableDisabled('$service')
                    getStatusInit('getStatus','$service');
                    getStatus('getStatus','$service');
                </script>

                <script>
                $(function(){
                    //$('#$service-stop').hide();
                    //$('#$service-loading').hide();
                    //$('#i_$service').hide();
                    //$('#i_status_$service').hide();
					$('#$service-logOff').hide();
                });
                </script>
				
				<script>
						//$('#s-$name').bootstrapSwitch('state', false, false);
						
						
						$('input[id=\"s-$name\"]').on('switchChange.bootstrapSwitch', function(event, state) {
						//$('input[id=\"s-$name\"]').on('switchChange.bootstrapSwitch', function(event, state) {
							//console.log(this); // DOM element
							//console.log(event); // jQuery event
							//console.log('$name' + ':' + state); // true | false
							//console.log(getStatusSwitch('$service'));
							//setEnableDisable('', '$name', 'start');
							//status = $('#s-$name').bootstrapSwitch('state');
							setStatusSwitch('$name', state);
						});
						
						getStatusSwitch('$name');
						
						//$('input[id=\"s-$service\"]').on('switchChange.bootstrapSwitch', switchAction(\"$service\"));
						
				</script>
				
				<div style='display:inline-block;visibility:hidden;display:none;' id='status_$name'></div>
				
            </div>
        
        ";	
}

?>

<div class="rounded-top" align="center"> Services </div>
<div class="rounded-bottom">

<?
if (!file_exists("/usr/share/fruitywifi/www/modules/ap/")) {
    addDivs("s_wireless", "Wireless", "page_config_adv.php", "../logs/dnsmasq.log", "show");
}
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

</div>

<!-- SERVICE | MODULES END -->

<!-- IP DETAILS START -->

<div style="display:inline-block; vertical-align: top;">

	<div class="rounded-top" align="center"> Interfaces/IP </div>
	<div class="rounded-bottom">
	<?
		// Get interfaces name
		$ifaces = getIfaceNAME();
		for ($i = 0; $i < count($ifaces); $i++) {
			if (strpos($ifaces[$i], "mon") === false) {
				echo $ifaces[$i] . ": ";
				// Get interface IP
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

<!-- IP DETAILS END -->

<!-- LOGS START -->

<script>

function getLogs(service, path) {
    //$( "#output" ).appendTo( "#content" );
    //$("#content").append("<div align='center' id='"+service+"-log-title' class='rounded-top' style='b-order:1px solid; b-ackground-color:#222222; width:580px; p-adding:2px; '>Logs: "+service+"</div><div class='rounded-bottom' id='"+service+"-log' style='b-order:1px solid; width:576px; padding:2px; margin-bottom:10px; font-size:11px'>").append("<\div>");
	$("#content").append("<div align='center' id='"+service+"-log-title' class='log-rounded-top'>Logs: "+service+"</div><div class='log-rounded-bottom' id='"+service+"-log'>").append("<\div>");
    $("#"+service+"-logOn").hide();
    $("#"+service+"-logOff").show();
	$("#"+service+"-logOff").css('display','inline-block');
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
                //console.log(data);
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
                //console.log(data);
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
                //console.log(data);
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
                    //div.innerHTML = div.innerHTML + "<div class='div0'><div class='div1'>" + key + "</div><div class='divEnabled'>enabled</div><div class='divDivision'> | </div><div class='divAction'><a href='#' onclick=\"setModulesStatus('" + key + "',0)\">stop</a></div><a href='#' onclick=\"setModulesStatus('" + key + "',0)\" class='btn btn-success btn-xs divStartStopB' role='button'>On</a></div>";
					div.innerHTML = div.innerHTML + "<div class='div0'><div class='divName'>" + key + "</div><a href='#' onclick=\"setModulesStatus('" + key + "',0)\" class='btn btn-success btn-xs divStartStopB' role='button'>On</a></div>";
                } else {
                    //div.innerHTML = div.innerHTML + "<div class='div0'><div class='div1'>" + key + "</div><div class='divDisabled'>disabled</div><div class='divDivision'> | </div><div class='divAction'><a href='#' onclick=\"setModulesStatus('" + key + "',1)\">start</a></div><a href='#' onclick=\"setModulesStatus('" + key + "',1)\" class='btn btn-default btn-xs divStartStopB' role='button'>Off</a></div>";
					div.innerHTML = div.innerHTML + "<div class='div0'><div class='divName'>" + key + "</div><a href='#' onclick=\"setModulesStatus('" + key + "',1)\" class='btn btn-default btn-xs divStartStopB' role='button'>Off</a></div>";
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
                    //div.innerHTML = div.innerHTML + "<div class='div0'><div class='div1'>" + key + "</div><div class='divEnabled'>enabled</div><div class='divDivision'> | </div><div class='divAction'><a href='#' onclick=\"setPluginStatus('" + key + "',0)\">stop</a></div></div>";
					div.innerHTML = div.innerHTML + "<div class='div0'><div class='divName'>" + key + "</div><a href='#' onclick=\"setPluginStatus('" + key + "',0)\" class='btn btn-success btn-xs divStartStopB' role='button'>On</a></div>";
                } else {
                    //div.innerHTML = div.innerHTML + "<div class='div0'><div class='div1'>" + key + "</div><div class='divDisabled'>disabled</div><div class='divDivision'> | </div><div class='divAction'><a href='#' onclick=\"setPluginStatus('" + key + "',1)\">start</a></div></div>";
					div.innerHTML = div.innerHTML + "<div class='div0'><div class='divName'>" + key + "</div><a href='#' onclick=\"setPluginStatus('" + key + "',1)\" class='btn btn-default btn-xs divStartStopB' role='button'>Off</a></div>";
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

<div id="content" class="content"></div>

</div>

<!-- LOGS END -->

</html>
