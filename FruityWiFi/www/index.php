<? 
/*
	Copyright (C) 2013-2015  xtr4nge [_AT_] gmail.com

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
	
	<link rel="stylesheet" href="css/bootstrap.css" />
	<link rel="stylesheet" href="css/bootstrap-menu.css" />
	<link rel="stylesheet" href="css/bootstrap-switch.css" />
		  
	<script src="js/bootstrap.js"></script>
	<script src="js/bootstrap-switch.js"></script>
	<script src="js/highlight.js"></script>
	<script src="js/main.js"></script>	

	<link href="style.css" rel="stylesheet" type="text/css"/>
	<link rel="icon" type="image/x-icon" href="img/favicon.ico"/>

</head>
<body>

<div id="custom-bootstrap-menu" class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="http://www.fruitywifi.com" target="blank">FruityWiFi</a>
        </div>
    </div>
</div>

<br/>
<br/>
<br/>
<br/>

<div align="center">

<div class="rounded-top" align="center"> Login </div>
<div class="rounded-bottom" align="center">

    <form action="login.php" method="post" autocomplete="off">
        <br/>
        <table class="general">
            <tr>
                <td>
                    user: 
                </td>
                <td>
                    <input name="user" class="form-control input-sm" <? if (isset($_GET["error"]) and $_GET["error"] == 1) echo "value='Who are you?...'"?>/>
                </td>
            <tr>
                <td>
                    pass:
                </td>
                <td>    
                    <input name="pass" class="form-control input-sm" type="password" />
                </td>
            </tr>
                <td>
                </td>
                <td align="left">
                    <input type="submit" value="login" class="btn btn-default btn-sm"/><br/>
                </td>
            </tr>
        </table>
        
    </form>

</div>

</div>

</body>
</html>
