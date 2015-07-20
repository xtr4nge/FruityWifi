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
<?
error_reporting(E_ALL ^ E_NOTICE);

//include "../../login_check.php";
include_once "/usr/share/fruitywifi/www/config/config.php";
?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="../../css/bootstrap.css" />
<link rel="stylesheet" href="../../css/bootstrap-menu.css" />
<link rel="stylesheet" href="../../css/bootstrap-switch.css" />

<s-cript src="../../js/jquery.js"></script>

<script src="../../js/bootstrap.js"></script>
<script src="../../js/bootstrap-switch.js"></script>
<script src="../../js/highlight.js"></script>
<script src="../../js/main.js"></script>

<link href="../../style.css" rel="stylesheet" type="text/css">
<link rel="icon" type="image/x-icon" href="../../img/favicon.ico"/>

<div id="custom-bootstrap-menu" class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="http://www.fruitywifi.com" target="blank">FruityWiFi</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-menubuilder"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse navbar-menubuilder">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="../../page_status.php">status</a>
                </li>
                <li><a href="../../page_status_ws.php">status-ws</a>
                </li>
                <li><a href="../../page_config_adv.php">config</a>
                </li>
                <li><a href="../../page_modules.php">modules</a>
                </li>
                <li><a href="../../page_logs.php">logs</a>
                </li>
                <li><a href="../../logout.php">logout</a>
                </li>
                 <li><a>| <?=$version?></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<br><br><br>
<script>
    $( document ).ready( function() {
    $('input[type="checkbox"]').bootstrapSwitch('destroy');
    $('input[type="radio"]').bootstrapSwitch('destroy');
    //$('input').bootstrapSwitch('destroy');
    //$('.bootstrap-switch').bootstrapSwitch('destroy');
    });
</script>
<style>
    input {
        color: #000000;
    }
    
    input[type="submit"] {
        color: #000000;
    }
</style>