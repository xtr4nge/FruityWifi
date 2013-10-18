<?php
$host = $_SERVER['HTTP_HOST'];


if (strpos($host, 'facebook') !== false) {
header('Status: 302 Found');
header('Location: http://www.facebook.com/site/1/');
break;
}

if (strpos($host, 'twitter') !== false) {
header('Status: 302 Found');
header('Location: http://www.twitter.com/site/2/');
break;
}

if (strpos($host, 'gmail') !== false) {
header('Status: 302 Found');
header('Location: http://www.gmail.com/site/3/');
break;
}

if (strpos($host, 'yahoo') !== false) {
header('Status: 302 Found');
header('Location: http://www.yahoo.com/site/4/');
break;
}

if (strpos($host, 'hotmail') !== false) {
header('Status: 302 Found');
header('Location: http://www.hotmail.com/site/5/');
break;
}

if (strpos($host, 'live') !== false) {
header('Status: 302 Found');
header('Location: http://www.live.com/site/5/');
break;
}


?>
