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
//header('Location: page_status.php');


?>

<link href="style.css" rel="stylesheet" type="text/css">
<link rel="icon" type="image/x-icon" href="img/favicon.ico"/>

<img src="img/logo.png">

<br><br>
<div align="center">

<div class="rounded-top" align="center"> Login </div>
<div class="rounded-bottom" align="center">

    <form action="login.php" method="post" autocomplete="off">
        <? 
        /*
        &nbsp;&nbsp;&nbsp;&nbsp;user: <input name="user" class="input"><br>
        &nbsp;&nbsp;&nbsp;&nbsp;pass: <input name="pass" type="password" class="input"><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="login" class="input"><br>
        */
        ?>
        <br>
        <table class="general">
            <tr>
                <td>
                    user: 
                </td>
                <td>
                    <input name="user" class="input" <? if ($_GET["error"] == 1) echo "value='Who are you?...'"?>><br>
                </td>
            <tr>
                <td>
                    pass:
                </td>
                <td>    
                    <input name="pass" type="password" class="input"><br>
                </td>
            </tr>
                <td>
                </td>
                <td>
                    <input type="submit" value="login" class="input"><br>
                </td>
            </tr>
        </table>
        
    </form>

</div>

</div>