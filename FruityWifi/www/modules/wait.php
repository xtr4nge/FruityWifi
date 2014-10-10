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
<pre>
<?
echo "Loading fruit...<br>";
include "../wait_fruit.php";
exit;
?>
<font style="color:green">
       .~~.   .~~.
      '. \ ' ' / .' </font><font style="color:red">
       .~ .~~~..~.
      : .~.'~'.~. :
     ~ (   ) (   ) ~
    ( : '~'.~.'~' : )
     ~ .~ (   ) ~. ~
      (  : '~' :  ) </font><font style="color:white">Evil Pi</font><font style="color:red">
       '~ .~~~. ~'
           '~'
</font>

</pre>
</body>
</html>