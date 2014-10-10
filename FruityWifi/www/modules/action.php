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

if ($wait == "") {
	$wait = 1;
}
?>
<html>
<head>
    <meta http-equiv="refresh" content="1; url=./wait.php?page=<?=$page?>&wait=<?=$wait?>">
</head>
<body bgcolor="black" text="white">
<pre>
<?php
echo "Please wait...";
?>
</pre>
</body>
</html>
