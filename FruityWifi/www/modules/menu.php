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

include_once "/usr/share/FruityWifi/www/config/config.php";

//include "login_check.php";

//Set no caching
header("Expires: Mon, 1 Jan 1900 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<link href="../../style.css" rel="stylesheet" type="text/css">
<link rel="icon" type="image/x-icon" href="../../img/favicon.ico"/>

<div class="menu">
<img src="../../img/logo.png">
</div>
<div class="menu">
    <a href="../../page_status.php" class="menu">status</a> | 
    <a href="../../page_config.php">config</a> | 
    <!--
    <a href="../../page_kismet.php">kismet</a> | 
    <a href="../../page_squid.php">squid</a> | 
    <a href="../../page_sslstrip.php">sslstrip</a> | 
    --!>
    <a href="../../page_modules.php">modules</a> | 
    <a href="../../page_logs.php">logs</a> | 
    <a href="../../logout.php">logout</a> | <?=$version?>
</div>
<br>
