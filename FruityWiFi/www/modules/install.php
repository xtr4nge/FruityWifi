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
<!DOCTYPE html>
<?
include "../functions.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["module"], "../msg.php", $regex_extra);
}

$module = $_GET['module'];
?>
<m-eta http-equiv="refresh" content="1; url=install.php?module=<?=$module?>">
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="../style.css" />

<div class="rounded-top" align="left"> &nbsp; <b>Installing...</b> </div>
<div id="log" class="module-content" style="font-family: courier; overflow: auto; height:500px;"></div>
    
<script>
function getLogs(service, path) {
    var refInterval = setInterval(function() {
	$.ajax({
	    type: 'POST',
	    url: '../scripts/status_logs_install.php',
	    //data: $(this).serialize(),
	    data: 'service='+service+'&path='+path,
	    dataType: 'json',
	    success: function (data) {
		console.log(data);
		$('#log').html('');
		$.each(data, function (index, value) {
		    $("#log").append( value ).append("<br>");
		    if (value == "..DONE..") {
			setTimeout(function() {
			    window.location = "./<?=$module?>";
			}, 2000);
		    }
		});
	    }
	});
    },2000);
}
getLogs("", "")
</script>