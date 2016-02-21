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
<body>
<link href="style.css" rel="stylesheet" type="text/css">
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>

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
    regex_standard($_POST["io_out_iface"], "msg.php", $regex_extra);
    regex_standard($_POST["io_in_iface"], "msg.php", $regex_extra);
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
    //regex_standard($_POST["in_out_mode"], "msg.php", $regex_extra);
    regex_standard($_POST["api_token"], "msg.php", $regex_extra);
}
?>
<?
$filename = $_POST['filename'];
$newdata = $_POST['newdata'];
?>
<?

// -------------- IN | OUT ------------------
if ($_GET["service"] == "io_in") {
    if ($_GET["action"] == "start") {
        // START IFACE (io_in)
        start_iface($io_in_iface, $io_in_ip, $io_in_gw);
    } else {
        // STOP IFACE (io_in)
        stop_iface($io_in_iface, $io_in_ip, $io_in_gw);
    }
}

if ($_GET["service"] == "io_out") {
    if ($_GET["action"] == "start") {
        // START IFACE (io_in)
        start_iface($io_out_iface, $io_out_ip, $io_out_gw);
    } else {
        // STOP IFACE (io_in)
        stop_iface($io_out_iface, $io_out_ip, $io_out_gw);
    }
}

// -------------- INTERFACES ------------------
if(isset($_POST["iface"]) and $_POST["iface"] == "internet"){
    echo "internet:" . $_POST["io_out_iface"];
}

if(isset($_POST["iface"]) and $_POST["iface"] == "wifi"){
    echo "wifi:" . $_POST["io_in_iface"];
}

if(isset($_POST["iface"]) and $_POST["iface"] == "wifi_extra"){
    echo "wifi extra:" . $_POST["io_in_iface_extra"];
}

if(isset($_POST["iface"]) and $_POST["iface"] == "wifi_supplicant"){
    echo "wifi supplicant:" . $_POST["iface_supplicant"];
}

if ($_GET["service"] == "mon0") {
    if ($_GET["action"] == "start") {
        // START MONITOR MODE (mon0)
        start_monitor_mode($io_in_iface_extra);
    } else {
        // STOP MONITOR MODE (mon0)
        stop_monitor_mode($io_in_iface_extra);
    }
}

// -------------- WIRELESS ------------------

if(isset($_POST[newSSID])){
    
    $hostapd_ssid=$_POST[newSSID];
    
    $exec = "sed -i 's/hostapd_ssid=.*/hostapd_ssid=\\\"".$_POST[newSSID]."\\\";/g' ./config/config.php";
    exec_fruitywifi($exec);

    $exec = "/usr/sbin/karma-hostapd_cli -p /var/run/hostapd-phy0 karma_change_ssid $_POST[newSSID]";
    exec_fruitywifi($exec);
    
    // replace interface in hostapd.conf and hostapd-secure.conf
    $exec = "/bin/sed -i 's/^ssid=.*/ssid=".$_POST["newSSID"]."/g' /usr/share/fruitywifi/conf/hostapd.conf";
    exec_fruitywifi($exec);
    $exec = "/bin/sed -i 's/^ssid=.*/ssid=".$_POST["newSSID"]."/g' /usr/share/fruitywifi/conf/hostapd-secure.conf";
    exec_fruitywifi($exec);
}


if (isset($_POST['hostapd_secure'])) {
    $exec = "sed -i 's/hostapd_secure=.*/hostapd_secure=\\\"".$_POST["hostapd_secure"]."\\\";/g' ./config/config.php";
    exec_fruitywifi($exec);

    $hostapd_secure = $_POST["hostapd_secure"];
}

if (isset($_POST['hostapd_wpa_passphrase'])) {
    $exec = "sed -i 's/hostapd_wpa_passphrase=.*/hostapd_wpa_passphrase=\\\"".$_POST["hostapd_wpa_passphrase"]."\\\";/g' ./config/config.php";
    exec_fruitywifi($exec);
    
    $exec = "sed -i 's/wpa_passphrase=.*/wpa_passphrase=".$_POST["hostapd_wpa_passphrase"]."/g' ../conf/hostapd-secure.conf";
    exec_fruitywifi($exec);
    
    $hostapd_wpa_passphrase = $_POST["hostapd_wpa_passphrase"];
}

// -------------- SUPPLICANT ------------------
if(isset($_POST["supplicant_ssid"]) and isset($_POST["supplicant_psk"])) {
    $exec = "sed -i 's/supplicant_ssid=.*/supplicant_ssid=\\\"".$_POST["supplicant_ssid"]."\\\";/g' ./config/config.php";
    exec_fruitywifi($exec);
    
    $exec = "sed -i 's/supplicant_psk=.*/supplicant_psk=\\\"".$_POST["supplicant_psk"]."\\\";/g' ./config/config.php";
    exec_fruitywifi($exec);
    
    $supplicant_ssid = $_POST["supplicant_ssid"];
    $supplicant_psk = $_POST["supplicant_psk"];
}

// -------------- PASSWORD ------------------

if(isset($_POST["pass_old"]) and isset($_POST["pass_new"])) {
    include "users.php";
    if ( ($users["admin"] == md5($_POST["pass_old"])) and ($_POST["pass_new"] == $_POST["pass_new_repeat"])) {
        $exec = "sed -i 's/\\\=\\\"".md5($_POST["pass_old"])."\\\"/\\\=\\\"".md5($_POST["pass_new"])."\\\"/g' ./users.php";
        exec_fruitywifi($exec);
        
        $pass_msg = 1;
    } else {
        $pass_msg = 2;
    }
}


// -------------- TOKEN ------------------

if(isset($_POST["api_token"])) {
    $token = setToken();
    $exec = "sed -i 's/api_token=.*/api_token=\\\"".$token."\\\";/g' ./config/config.php";
    exec_fruitywifi($exec);
    $api_token = $token;
}

?>

<?
// Get all interfaces name
$ifaces = getIfaceNAME();
?>

<br>

<!-- SETUP IN|OUT -->

<div class="rounded-top" align="center"> IN | OUT </div>
<div class="rounded-bottom" style="padding-top: 6px; padding-bottom: 8px;">

<table cellpadding="0" CELLSPACING="0">
    <tr>
    <td width="200px">
        <form action="scripts/config_iface.php" method="post" style="margin:0px">
            Mode
            <select class="form-control input-sm" style="width:140px" onchange="this.form.submit()" name="io_mode">
                <option value="1" <? if ($io_mode == 1) echo "selected"?> >IN - OUT | [AP]</option>
                <option value="2" <? if ($io_mode == 2) echo "selected"?> >IN - --- | [AP]</option>
                <option value="3" <? if ($io_mode == 3) echo "selected"?> >IN - OUT</option>
                <option value="4" <? if ($io_mode == 4) echo "selected"?> >IN - ---</option>
                <option value="5" <? if ($io_mode == 5) echo "selected"?> >-- - OUT</option>
            </select>
        </form>
        
    </td>
    <td width="50%">
        
        <form action="scripts/config_iface.php" method="post" style="margin:0px">
            &nbsp;[AP]
            <select class="form-control input-sm" style="width:140px" onchange="this.form.submit()" name="ap_mode">
                <option value="1" <? if ($ap_mode == 1) echo "selected"?> >Hostapd</option>
                <? if (file_exists("/usr/share/fruitywifi/www/modules/mana/includes/hostapd")) { ?>
                <option value="3" <? if ($ap_mode == 3) echo "selected"?> >Hostapd-Mana</option>
                <? } ?>
                <? if (file_exists("/usr/share/fruitywifi/www/modules/karma/includes/hostapd")) { ?>
                <option value="4" <? if ($ap_mode == 4) echo "selected"?> >Hostapd-Karma</option>
                <? } ?>
                <option value="2" <? if ($ap_mode == 2) echo "selected"?> >Airmon-ng</option>
            </select>
        </form>
    </td>
    </tr>
</table>
<br>

<table cellpadding="0" CELLSPACING="0">
    <tr>
    <td valign="top">
        <!-- SUB IN  -->
        <div id="div_in" name="div_in" <? if($io_mode == 5) echo "style='visibility: hidden;'"?> >
        <table cellpadding="0" CELLSPACING="0">
            <tr>
            
            <td style="padding-right:10px" nowrap>
                IN
                <form action="scripts/config_iface.php" method="post" style="margin:0px">
                    <select class="form-control input-sm" onchange="this.form.submit()" name="io_in_iface">
                    <option>-</option>
                    <?
                    for ($i = 0; $i < count($ifaces); $i++) {
                        if (strpos($ifaces[$i], "mon") === false) {
                            if ($io_in_iface == $ifaces[$i]) $flag = "selected" ; else $flag = "";
                            echo "<option $flag>$ifaces[$i]</option>";
                        }
                    }
                    ?>
                    </select>
                </form>
            </td>
            </tr>
            <tr>

            <td style="padding-right:10px" nowrap>
                <form action="scripts/config_iface.php" method="post" style="margin:0px">
                    <select class="form-control input-sm" onchange="this.form.submit()" name="io_in_set">
                        <option value="1" <? if($io_in_set == "1") echo "selected" ?> >[Manual]</option>
                        <option value="0" <? if($io_in_set == "0") echo "selected" ?> >[Current]</option>
                    </select>
                </form>
                <?
                    if($io_in_set == "0") {                        
                        // Get interface IP
                        $tmp_ip = getIfaceIP($io_in_iface);
                        echo "<input class='form-control input-sm' placeholder='IP' style='width:140px' value='$tmp_ip' disabled>";
                    }
                ?>
            </td>
            </tr>
            <form action="scripts/config_iface.php" method="post" style="margin:0px">
            <tr <? if($io_in_set == "0") echo "style='display:none;'"?> >

            <td style="padding-right:10px"><input class="form-control input-sm" placeholder="IP" name="io_in_ip" style="width:140px" value="<?=$io_in_ip?>"></td>
            </tr>
            <tr <? if($io_in_set == "0") echo "style='display:none;'"?> >

            <td style="padding-right:10px"><input class="form-control input-sm" placeholder="MASK" name="io_in_mask" style="width:140px" value="<?=$io_in_mask?>"></td>
            </tr>
            <tr <? if($io_in_set == "0") echo "style='display:none;'"?> >

            <td style="padding-right:10px"><input class="form-control input-sm" placeholder="GW" name="io_in_gw" style="width:140px" value="<?=$io_in_gw?>"></td>
            </tr>
            <tr <? if($io_in_set == "0") echo "style='display:none;'"?> >

            <td style="padding-right:10px">
                <input class="btn btn-primary btn-sm" type="submit" value="Save">
                <?
                // Get interface IP
                $tmp_ip = getIfaceIP($io_in_iface);
                if (trim($tmp_ip) == trim($io_in_ip)) {
                echo "<a href='page_config_adv.php?service=io_in&action=stop'><b>stop</b></a> [<font color='lime'>on</font>]";
                } else {
                echo "<a href='page_config_adv.php?service=io_in&action=start'><b>start</b></a> [<font color='red'>-</font>]";
                }
                
                ?>
            </td>
            </tr>
            </form>
        </table>
        </div>
    </td>
    
    <td width="40px"></td>
    
    <td valign="top">
        <!-- SUB OUT -->
        <div <? if($io_mode == 2 or $io_mode == 4) echo "style='visibility: hidden;'"?> >
        <table cellpadding="0" CELLSPACING="0">
            <tr>

            <td style="padding-right:10px">
                OUT
                <form action="scripts/config_iface.php" method="post" style="margin:0px">
                    <select class="form-control input-sm" onchange="this.form.submit()" name="io_out_iface">
                        <option>-</option>
                        <?
                        for ($i = 0; $i < count($ifaces); $i++) {
                            if (strpos($ifaces[$i], "mon") === false) {
                                if ($io_out_iface == $ifaces[$i]) $flag = "selected" ; else $flag = "";
                                echo "<option $flag>$ifaces[$i]</option>";
                            }
                        }
                        ?>
                    </select>
                </form>
            </td>
            </tr>
            <tr>

            <td style="padding-right:10px" nowrap>
            <form action="scripts/config_iface.php" method="post" style="margin:0px">
                <select class="form-control input-sm" onchange="this.form.submit()" name="io_out_set">
                    <option value="1" <? if($io_out_set == "1") echo "selected" ?> >[Manual]</option>
                    <option value="0" <? if($io_out_set == "0") echo "selected" ?> >[Current]</option>
                </select>
            </form>
            <?
                if($io_out_set == "0") {
                    // Get interface IP
                    $tmp_ip = getIfaceIP($io_out_iface);
                    echo "<input class='form-control input-sm' placeholder='IP' style='width:140px' value='$tmp_ip' disabled>";
                }
            ?>
            </td>
            </tr>
            <form action="scripts/config_iface.php" method="post" style="margin:0px">
            <tr <? if($io_out_set == "0") echo "style='display:none;'"?> >

            <td style="padding-right:10px"><input class="form-control input-sm" placeholder="IP" name="io_out_ip" style="width:140px" value="<?=$io_out_ip?>"></td>
            </tr>
            <tr <? if($io_out_set == "0") echo "style='display:none;'"?> >

            <td style="padding-right:10px"><input class="form-control input-sm" placeholder="MASK" name="io_out_mask" style="width:140px" value="<?=$io_out_mask?>"></td>
            </tr>
            <tr <? if($io_out_set == "0") echo "style='display:none;'"?> >

            <td style="padding-right:10px"><input class="form-control input-sm" placeholder="GW" name="io_out_gw" style="width:140px" value="<?=$io_out_gw?>"></td>
            </tr>
            <tr <? if($io_out_set == "0") echo "style='display:none;'"?> >

            <td style="padding-right:10px">
                <input class="btn btn-primary btn-sm" type="submit" value="Save">
                <?
                // Get interface IP
                $tmp_ip = getIfaceIP($io_out_iface);
                if (trim($tmp_ip) == trim($io_out_ip)) {
                    echo "<a href='page_config_adv.php?service=io_out&action=stop'><b>stop</b></a> [<font color='lime'>on</font>]";
                } else {
                echo "<a href='page_config_adv.php?service=io_out&action=start'><b>start</b></a> [<font color='red'>-</font>]";
                }
                
                ?>
            </td>
            </tr>
            </form>
        </table>
        </div>
    </td>
    </tr>
</table>

<br>

<form action="scripts/config_iface.php" method="post" style="margin:0px" >
    + [sniff|inject]
    <?
        //if($ap_mode == "2") $set_action = "disabled" ;
    ?>
    <select class="form-control input-sm" style="width:140px" onchange="this.form.submit()" name="io_action" >
        <option value="at0" <? if ($io_action == "at0") echo "selected"?> >at0</option>
        <!-- <option value="wlan0" <? if ($io_action == "wlan0") echo "selected"?> >wlan0</option> -->
        <?
        for ($i = 0; $i < count($ifaces); $i++) {
            if (strpos($ifaces[$i], "mon") === false) {
                if ($io_action == $ifaces[$i]) $flag = "selected" ; else $flag = "";
                echo "<option value='".$ifaces[$i]."' $flag>$ifaces[$i]</option>";
            }
        }
        ?>
    </select> 
</form>

</div>

<!-- SETUP IN/OUT END -->

<br>

<!-- Monitor INTERFACE -->

<div class="rounded-top" align="center"> Monitor Interface </div>
<div class="rounded-bottom">

    <form action="scripts/config_iface.php" method="post" style="margin:0px">
    <? $iface_mon0 = exec("/sbin/ifconfig | grep mon0 "); ?>
    <select class="form-control input-sm" style="width: 140px; display:inline;" onchange="this.form.submit()" name="io_in_iface_extra" <? if ($iface_mon0 != "") echo "disabled" ?> >
        <option>-</option>
        <?
        for ($i = 0; $i < count($ifaces); $i++) {
            if (strpos($ifaces[$i], "mon") === false) {
                if ($io_in_iface_extra == str_replace("mon","",$ifaces[$i])) $flag = "selected" ; else $flag = "";
                echo "<option $flag>".str_replace("mon","",$ifaces[$i])."</option>";
            }
        }
        ?>
    </select> 
    <img src="img/glyphicons-195-circle-question-mark.png" title="Use this interface for extra features like Kismet, MDK3, etc..." width=14>
    <?
        if ($iface_mon0 == "") {
            echo "<b><a href='page_config_adv.php?service=mon0&action=start'>start</a></b> [<font color='red'>mon0</font>]";
        } else {
            echo "<b><a href='page_config_adv.php?service=mon0&action=stop'>stop</a></b>&nbsp; [<font color='lime'>mon0</font>]";
        }
        //echo "(kismet, mdk3, etc)";
    ?>
    <input type="hidden" name="iface" value="wifi_extra">
    </form>
    
</div>

<!-- Monitor INTERFACE END -->

<br>

<!-- WIRELESS SETUP -->

<div class="rounded-top" align="center"> Wireless Setup </div>
<div class="rounded-bottom">
    <form method="POST" style="margin:1px">
        Open <input type="radio" data-switch-no-init class="input" name="hostapd_secure" value="0" <? if ($hostapd_secure != 1) echo 'checked'; ?> onchange="this.form.submit()"> 
        Secure <input type="radio" data-switch-no-init class="input" name="hostapd_secure" value="1" <? if ($hostapd_secure == 1) echo 'checked'; ?> onchange="this.form.submit()">
    <!--</form>
    <form action="#" method="POST" autocomplete="off" style="margin:1px">-->
        <div class="form-group">
            <input class="form-control input-sm" s-tyle="width: 140px; display:inline;" name="newSSID" value="<?=$hostapd_ssid?>">
    <!--</form>
    <form action="#" method="POST" autocomplete="off" style="margin:1px">-->
            <input class="form-control input-sm" s-tyle="width: 140px; display:inline;" name="hostapd_wpa_passphrase" type="password" value="<?=$hostapd_wpa_passphrase?>">
            <input class="btn btn-primary btn-sm" type="submit" value="Save">
        </div>
        
    </form>
</div>

<br>

<!-- DOMAIN SETUP -->

<div class="rounded-top" align="center"> Domain Setup </div>
<div class="rounded-bottom">
    <form action="scripts/config_iface.php" method="POST" autocomplete="off" style="margin:1px">
        <input class="form-control input-sm" s-tyle="width: 140px; display:inline;" name="domain" value="<?=$dnsmasq_domain?>">    
        <input class="btn btn-primary btn-sm" type="submit" value="Save">
    </form>
</div>

<br>

<!-- PASSWORD -->

<div class="rounded-top" align="center"> Password </div>
<div class="rounded-bottom">
    <form action="<?=$_SERVER['PHP_SELF']?> " method="POST" autocomplete="off">
    <input type="password" class="form-control input-sm" placeholder="old pass" name="pass_old" value="">
    <input type="password" class="form-control input-sm" placeholder="new pass" name="pass_new" value="">
    <input type="password" class="form-control input-sm" placeholder="repeat new pass" name="pass_new_repeat" value="">
    <input class="btn btn-primary btn-sm" type="submit" value="Save">
    <?
        if ($pass_msg != "") {
        echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        if ($pass_msg == 1) echo "<font color='lime'>password changed</font>";
        if ($pass_msg == 2) echo "<font color='red'>password error</font>";
        }
    ?>
    </form>
</div>

<br>

<!-- TOKEN -->

<div class="rounded-top" align="center"> Token </div>
<div class="rounded-bottom">
    <form action="<?=$_SERVER['PHP_SELF']?> " method="POST" autocomplete="off">
    <input type="text" class="form-control input-sm" placeholder="token" name="api_token" value="<?=$api_token?>">
    <input class="btn btn-primary btn-sm" type="submit" value="Generate">
    </form>
</div>

</body>
</html>