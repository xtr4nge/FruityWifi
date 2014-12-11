<?
include "../config/config.php";
include "../functions.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["page"], "../msg.php", $regex_extra);
    regex_standard($_GET["wait"], "../msg.php", $regex_extra);
}

$page = $_GET["page"];
$wait = $_GET["wait"];

if ($page == "") {
	$page = "../msg.php";
}

if ($wait == "") {
	$wait = 1;
}

?>
<html>
<head>
    <meta http-equiv="refresh" c-ontent="<?=$wait?>; url=./<?=$page?>/">
</head>
<body bgcolor="black" text="white">

<style>
body {
    background-color:#FCFCFC; /*#EFEFEF*/
    color: #000;
    font-family: monospace, courier;
    font-size: 12px;
    margin: 0px 0px;
}

.module {
    background-color:#F8F8F8; /* #090909 */
    -moz-border-radius: 4px;
    border-radius: 4px;
    border:1px solid;
    border-color:#BAC1C4; /* #E01B46 */
    margin: 10px;
    padding: 10px;
}

</style>

<div align="" class="module">
<table width="300px">
<tr>
<td>

<pre>
<?
echo "Loading fruit...<br>";
include "../wait_fruit.php";
exit;
?>
</pre>

</td>
</tr>
</table>
</div>
</div>
</body>
</html>