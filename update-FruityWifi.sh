#!/bin/bash

cp -a FruityWifi /usr/share/FruityWifi
ln -s /usr/share/FruityWifi/www /var/www/FruityWifi
ln -s /usr/share/FruityWifi/logs /var/www/FruityWifi/logs
mkdir /var/www/tmp
chown www-data.www-data /var/www/tmp
chmod 777 /var/www/tmp
chmod 755 /usr/share/FruityWifi/squid.inject/poison.pl
ln -s /usr/share/FruityWifi/www.site /var/www/site
chown -R www-data.www-data /usr/share/FruityWifi/www.site
chmod 777 /usr/share/FruityWifi/www.site/data.txt
chmod 777 /usr/share/FruityWifi/www.site/inject/data.txt

# BIN
cd /usr/share/FruityWifi/bin/
gcc danger.c -o danger
chmod 4755 danger

echo "FruityWifi updated ;)"
echo ""
