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
<? include "menu.php"; ?>
<? 
include "login_check.php";
include "config/config.php";
?>
<?
include "functions.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_POST["filename"], "msg.php", $regex_extra);
    regex_standard($_POST["newdata"], "msg.php", $regex_extra);
    regex_standard($_POST["iface"], "msg.php", $regex_extra);
    regex_standard($_POST["iface_internet"], "msg.php", $regex_extra);
    regex_standard($_POST["iface_wifi"], "msg.php", $regex_extra);
    regex_standard($_POST["iface_supplicant"], "msg.php", $regex_extra);
    regex_standard($_POST["newSSID"], "msg.php", $regex_extra);
    regex_standard($_POST["hostapd_secure"], "msg.php", $regex_extra);
    regex_standard($_POST["hostapd_wpa_passphrase"], "msg.php", $regex_extra);
    regex_standard($_POST["supplicant_ssid"], "msg.php", $regex_extra);
    regex_standard($_POST["supplicant_psk"], "msg.php", $regex_extra);
    regex_standard($_POST["pass_old"], "msg.php", $regex_extra);
    regex_standard($_POST["pass_new"], "msg.php", $regex_extra);
    regex_standard($_POST["pass_new_repeat"], "msg.php", $regex_extra);
    regex_standard($_GET["service"], "msg.php", $regex_extra);
    regex_standard($_GET["action"], "msg.php", $regex_extra);
}
?>
<?
$filename = $_POST['filename'];
$newdata = $_POST['newdata'];
/*
if ($newdata != "") { $newdata = ereg_replace(13,  "", $newdata);
    $fw = fopen($filename, 'w') or die('Could not open file.');
    $fb = fwrite($fw,stripslashes($newdata)) or die('Could not write to file');
    fclose($fw);
    $fileMessage = $strings["config-updated"]." " . $filename . "<br /><br />";
} 
*/
?>


<?

// -------------- INTERFACES ------------------
if(isset($_POST["iface"]) and $_POST["iface"] == "internet"){
    echo "internet:" . $_POST["iface_internet"];
}

if(isset($_POST["iface"]) and $_POST["iface"] == "wifi"){
    echo "wifi:" . $_POST["iface_wifi"];
    //$exec = "sed -i 's/iface_wifi=.*/iface_wifi=\\\"".$_POST["iface_wifi"]."\\\";/g' ./config/config.php";
    //echo $exec;    
    //exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
}

if(isset($_POST["iface"]) and $_POST["iface"] == "wifi_extra"){
    echo "wifi extra:" . $_POST["iface_wifi_extra"];
    //$exec = "sed -i 's/iface_wifi_extra=.*/iface_wifi_extra=\\\"".$_POST["iface_wifi_extra"]."\\\";/g' ./config/config.php";
    //echo $exec;    
    //exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
}

if(isset($_POST["iface"]) and $_POST["iface"] == "wifi_supplicant"){
    echo "wifi supplicant:" . $_POST["iface_supplicant"];
    //$exec = "sed -i 's/iface_wifi_extra=.*/iface_wifi_extra=\\\"".$_POST["iface_wifi_extra"]."\\\";/g' ./config/config.php";
    //echo $exec;    
    //exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
}

if ($_GET["service"] == "mon0") {
    if ($_GET["action"] == "start") {
        // START MONITOR MODE (mon0)
        start_monitor_mode($iface_wifi_extra);
    } else {
        // STOP MONITOR MODE (mon0)
        stop_monitor_mode($iface_wifi_extra);
    }
}

// -------------- WIRELESS ------------------

if(isset($_POST[newSSID])){
    
    $hostapd_ssid=$_POST[newSSID];
    
    $exec = "sed -i 's/hostapd_ssid=.*/hostapd_ssid=\\\"".$_POST[newSSID]."\\\";/g' ./config/config.php";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );

    $exec = "/usr/sbin/karma-hostapd_cli -p /var/run/hostapd-phy0 karma_change_ssid $_POST[newSSID]";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    //system("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    
    // replace interface in hostapd.conf and hostapd-secure.conf
    $exec = "/bin/sed -i 's/^ssid=.*/ssid=".$_POST["newSSID"]."/g' /usr/share/FruityWifi/conf/hostapd.conf";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    $exec = "/bin/sed -i 's/^ssid=.*/ssid=".$_POST["newSSID"]."/g' /usr/share/FruityWifi/conf/hostapd-secure.conf";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );

}


if (isset($_POST['hostapd_secure'])) {
    $exec = "sed -i 's/hostapd_secure=.*/hostapd_secure=\\\"".$_POST["hostapd_secure"]."\\\";/g' ./config/config.php";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );

    $hostapd_secure = $_POST["hostapd_secure"];
}

if (isset($_POST['hostapd_wpa_passphrase'])) {
    $exec = "sed -i 's/hostapd_wpa_passphrase=.*/hostapd_wpa_passphrase=\\\"".$_POST["hostapd_wpa_passphrase"]."\\\";/g' ./config/config.php";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    $exec = "sed -i 's/wpa_passphrase=.*/wpa_passphrase=".$_POST["hostapd_wpa_passphrase"]."/g' ../conf/hostapd-secure.conf";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );

    $hostapd_wpa_passphrase = $_POST["hostapd_wpa_passphrase"];
}

// -------------- SUPPLICANT ------------------
if(isset($_POST["supplicant_ssid"]) and isset($_POST["supplicant_psk"])) {
    //echo "supplicant_ssid:" . $_POST["supplicant_ssid"];
    //echo "<br>";
    //echo "supplicant_psk:" . $_POST["supplicant_psk"];
    $exec = "sed -i 's/supplicant_ssid=.*/supplicant_ssid=\\\"".$_POST["supplicant_ssid"]."\\\";/g' ./config/config.php";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    $exec = "sed -i 's/supplicant_psk=.*/supplicant_psk=\\\"".$_POST["supplicant_psk"]."\\\";/g' ./config/config.php";
    exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    //$exec = "sed -i 's/iface_wifi_extra=.*/iface_wifi_extra=\\\"".$_POST["iface_wifi_extra"]."\\\";/g' ./config/config.php";
    //echo $exec;    
    //exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    
    $supplicant_ssid = $_POST["supplicant_ssid"];
    $supplicant_psk = $_POST["supplicant_psk"];
}

// -------------- PASSWORD ------------------

if(isset($_POST["pass_old"]) and isset($_POST["pass_new"])) {
	include "users.php";
	if ( ($users["admin"] == md5($_POST["pass_old"])) and ($_POST["pass_new"] == $_POST["pass_new_repeat"])) {
		$exec = "sed -i 's/\\\=\\\"".md5($_POST["pass_old"])."\\\"/\\\=\\\"".md5($_POST["pass_new"])."\\\"/g' ./users.php";
		//echo $exec;
		//exit;
    	exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"" );
    	$pass_msg = 1;
	} else {
		$pass_msg = 2;
	}
}

?>

<?
#echo $iface_internet;
#echo $iface_wifi;

$ifaces = exec("/sbin/ifconfig -a | cut -c 1-8 | sort | uniq -u |grep -v lo|sed ':a;N;$!ba;s/\\n/|/g'");
$ifaces = str_replace(" ","",$ifaces);
$ifaces = explode("|", $ifaces);
?>

<br>

<div class="rounded-top" align="center"> Interfaces </div>
<div class="rounded-bottom">
    <form action="scripts/config_iface.php" method="post" style="margin:0px">
    &nbsp;&nbsp;Internet 
    <select class="input" onchange="this.form.submit()" name="iface_internet">
        <option>-</option>
        <?
        for ($i = 0; $i < count($ifaces); $i++) {
        	if (strpos($ifaces[$i], "mon") === false) {
            	if ($iface_internet == $ifaces[$i]) $flag = "selected" ; else $flag = "";
            	echo "<option $flag>$ifaces[$i]</option>";
            }
        }
        ?>
    </select>
    <img src="img/help-browser.png" title="Use this interface to connect to the internet" width=14>
    <input type="hidden" name="iface" value="internet">
    </form>

    <form action="scripts/config_iface.php" method="post" style="margin:0px">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Wifi 
    <select class="input" onchange="this.form.submit()" name="iface_wifi">
        <option>-</option>
        <?
        for ($i = 0; $i < count($ifaces); $i++) {
        	if (strpos($ifaces[$i], "mon") === false) {
            	if ($iface_wifi == $ifaces[$i]) $flag = "selected" ; else $flag = "";
            	echo "<option $flag>$ifaces[$i]</option>";
            }
        }
        ?>
    </select>
    <img src="img/help-browser.png" title="Use this interface as access point (Hostapd/Karma)" width=14>
    <input type="hidden" name="iface" value="wifi">
    </form>

    <form action="scripts/config_iface.php" method="post" style="margin:0px">
    &nbsp;&nbsp;&nbsp;Monitor 
    <? $iface_mon0 = exec("/sbin/ifconfig |grep mon0"); ?>
    <select class="input" onchange="this.form.submit()" name="iface_wifi_extra" <? if ($iface_mon0 != "") echo "disabled" ?> >
        <option>-</option>
        <?
        for ($i = 0; $i < count($ifaces); $i++) {
        	if (strpos($ifaces[$i], "mon") === false) {
            	if ($iface_wifi_extra == $ifaces[$i]) $flag = "selected" ; else $flag = "";
            	echo "<option $flag>$ifaces[$i]</option>";
            }
        }
        ?>
    </select> 
    <img src="img/help-browser.png" title="Use this interface for extra features like Kismet, MDK3, etc..." width=14>
    <?
        if ($iface_mon0 == "") {
            echo "<b><a href='page_config.php?service=mon0&action=start'>start</a></b> [<font color='red'>mon0</font>]";
        } else {
            echo "<b><a href='page_config.php?service=mon0&action=stop'>stop</a></b>&nbsp; [<font color='lime'>mon0</font>]";
        }
        //echo "(kismet, mdk3, etc)";
    ?>
    <input type="hidden" name="iface" value="wifi_extra">
    </form>
    
    <form action="scripts/config_iface.php" method="post" style="margin:0px">
    Supplicant 
    <select class="input" onchange="this.form.submit()" name="iface_supplicant">
        <option>-</option>
        <?
        for ($i = 0; $i < count($ifaces); $i++) {
        	if (strpos($ifaces[$i], "mon") === false) {
            	if ($iface_supplicant == $ifaces[$i]) $flag = "selected" ; else $flag = "";
            	echo "<option $flag>$ifaces[$i]</option>";
            }
        }
        ?>
    </select>
    <img src="img/help-browser.png" title="Use this interface to connect internet through wireless" width=14>
    <input type="hidden" name="iface" value="wifi_supplicant">
    </form>
</div>

<br>

<div class="rounded-top" align="center"> Wireless Setup </div>
<div class="rounded-bottom">
    <form method="POST" style="margin:1px">
        Open <input type="radio" class="input" name="hostapd_secure" value="0" <? if ($hostapd_secure != 1) echo 'checked'; ?> onchange="this.form.submit()"> 
        Secure <input type="radio" class="input" name="hostapd_secure" value="1" <? if ($hostapd_secure == 1) echo 'checked'; ?> onchange="this.form.submit()">
    </form
    <br>
    <form action="#" method="POST" autocomplete="off" style="margin:1px">
    <input class="input" name="newSSID" value="<?=$hostapd_ssid?>">    
    <input class="input" type="submit" value="change SSID">
    </form>
    <form action="#" method="POST" autocomplete="off" style="margin:1px">
    <input class="input" name="hostapd_wpa_passphrase" type="password" value="<?=$hostapd_wpa_passphrase?>">    
    <input class="input" type="submit" value="passphrase">
    </form>
</div>

<br>

<div class="rounded-top" align="center"> WPA Supplicant </div>
<div class="rounded-bottom">
    <form action="#" method="POST" autocomplete="off">
    supplicant_ssid <input class="input" name="supplicant_ssid" value="<?=$supplicant_ssid?>"><br>
    &nbspsupplicant_psk <input class="input" type="password" name="supplicant_psk" value="<?=$supplicant_psk?>"> 
    <input class="input" type="submit" value="Set">
    </form>
</div>

<br>

<?
/*
if ($newdata != "") { $newdata = ereg_replace(13,  "", $newdata);
    $fw = fopen($filename, 'w') or die('Could not open file.');
    $fb = fwrite($fw,stripslashes($newdata)) or die('Could not write to file');
    fclose($fw);
    $fileMessage = $strings["config-updated"]." " . "/usr/share/FruityWifi/conf/" . $filename . "<br /><br />";
} 
*/
if ($newdata != "") { 
    //$newdata = ereg_replace(13,  "", $newdata);
    $exec = "/bin/echo '$newdata' > /usr/share/FruityWifi/conf/spoofhost.conf";
	exec("/usr/share/FruityWifi/bin/danger \"" . $exec . "\"", $output);
}

$filename = "/usr/share/FruityWifi/conf/spoofhost.conf";

$fh = fopen($filename, "r") or die("Could not open file.");
$data = fread($fh, filesize($filename)) or die("Could not read file.");
fclose($fh);
?>

<div class="rounded-top" align="center"> DNS Spoof Config </div>
<div class="rounded-bottom">
    <form action="<?=$_SERVER[php_self]?> " method="POST" autocomplete="off">
        <textarea class="input" name='newdata' rows='5' cols='52'><?=$data?></textarea>
        <br>
        <input type='hidden' name='filename' value='spoofhost.conf'>
        <input class="input" type="submit" value="Update Spoofhost">
    </form>
</div>

<br>

<div class="rounded-top" align="center"> Password </div>
<div class="rounded-bottom">
	<form action="<?=$_SERVER[php_self]?> " method="POST" autocomplete="off">
		Old Pass: <input type="password" class="input" name="pass_old" value=""><br>
		New Pass: <input type="password" class="input" name="pass_new" value=""><br>
		&nbsp;&nbsp;Repeat: <input type="password" class="input" name="pass_new_repeat" value="">
		<input class="input" type="submit" value="Change">
		<?
			if ($pass_msg != "") {
				echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				if ($pass_msg == 1) echo "<font color='lime'>password changed</font>";
				if ($pass_msg == 2) echo "<font color='red'>password error</font>";
			}
		?>
	</form>
</div>
