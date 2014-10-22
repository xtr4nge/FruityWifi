#!/bin/bash

find FruityWifi -type d -exec chmod 755 {} \;
find FruityWifi -type f -exec chmod 644 {} \;

mkdir tmp-install
cd tmp-install

apt-get update

apt-get -y install gettext make intltool build-essential automake autoconf uuid uuid-dev php5-curl php5-cli dos2unix curl sudo

cmd=`gcc --version|grep "4.7"`
if [[ $cmd == "" ]]
then
    echo "--------------------------------"
    echo "Installing gcc 4.7"
    echo "--------------------------------"
    #exit;
	
    apt-get -y install gcc-4.7
    apt-get -y install g++-4.7
    update-alternatives --install /usr/bin/gcc gcc /usr/bin/gcc-4.7 40 --slave /usr/bin/g++ g++ /usr/bin/g++-4.7

else
    echo "--------------------------------"
    echo "gcc 4.7 already installed"
    echo "--------------------------------"
    echo
    echo
fi

echo

if [ ! -f "/usr/sbin/dnsmasq" ]
then
    echo "--------------------------------"
    echo "Installing dnsmasq"
    echo "--------------------------------"
    #exit;
	
    # INSTALL DNSMASQ
    apt-get -y install dnsmasq

else
    echo "--------------------------------"
    echo "dnsmasq already installed"
    echo "--------------------------------"
    echo
    echo
fi

echo

if [ ! -f "/usr/sbin/hostapd" ]
then
    echo "--------------------------------"
    echo "Installing hostapd"
    echo "--------------------------------"
    #exit;

    # INSTALL HOSTAPD
    apt-get -y install hostapd

else
    echo "--------------------------------"
    echo "hostapd already installed"
    echo "--------------------------------"
    echo
    echo
fi

echo

if [ ! -f "/usr/sbin/airmon-ng" ] &&  [ ! -f "/usr/local/sbin/airmon-ng" ]
then
    echo "--------------------------------"
    echo "Installing aircrack-ng"
    echo "--------------------------------"
    #exit;

    # INSTALL AIRCRACK-NG
    apt-get -y install libssl-dev
    wget http://download.aircrack-ng.org/aircrack-ng-1.2-beta1.tar.gz
    tar -zxvf aircrack-ng-1.2-beta1.tar.gz
    cd aircrack-ng-1.2-beta1
    make
    make install
    cd ../

else
    echo "--------------------------------"
    echo "aircrack-ng already installed"
    echo "--------------------------------"
    echo
    echo
fi

echo

# BACK TO ROOT-INSTALL FOLDER
cd ../

if [ ! -f "/usr/sbin/nginx" ]
then
    echo "--------------------------------"
    echo "Installing Nginx"
    echo "--------------------------------"
    #exit;

    # NGINX INSTALL
    apt-get -y install nginx php5-fpm

    # SSL
    echo "--------------------------------"
    echo "Create Nginx ssl certificate"
    echo "--------------------------------"
    mkdir /etc/nginx/ssl
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/nginx/ssl/nginx.key -out /etc/nginx/ssl/nginx.crt

    rm /etc/nginx/sites-enabled/default
    cp nginx-setup/FruityWifi /etc/nginx/sites-enabled/
    cp nginx-setup/fpm/*.conf /etc/php5/fpm/pool.d/
    echo "." >> /var/www/index.php

    /etc/init.d/apache2 stop
    /etc/init.d/nginx restart
    /etc/init.d/php5-fpm restart
    
else
    echo "--------------------------------"
    echo "Nginx already installed"
    echo "--------------------------------"
    echo
    echo
fi

echo

#if [ ! -f "/usr/sbin/apache2" ]
#then
#    echo "--------------------------------"
#    echo "Installing apache2"
#    echo "--------------------------------"
#    #exit;
#
#    # APACHE2 INSTALL
#    apt-get -y install apache2 php5 libapache2-mod-php5 php5-curl
#
#else
#    echo "--------------------------------"
#    echo "apache2 already installed"
#    echo "--------------------------------"
#    echo
#    echo
#fi

echo "--------------------------------"
echo "Setup: WWW"
echo "--------------------------------"
mkdir /var/www
cmd=`date +"%Y-%m-%d-%k-%M-%S"`
#cd ../
mv /usr/share/FruityWifi FruityWifi.BAK.$cmd
rm /var/www/FruityWifi
cp -a FruityWifi /usr/share/FruityWifi
ln -s /usr/share/FruityWifi/www /var/www/FruityWifi
ln -s /usr/share/FruityWifi/logs /var/www/FruityWifi/logs
mkdir /var/www/tmp
chown www-data.www-data /var/www/tmp
chmod  777 /var/www/tmp
chmod 755 /usr/share/FruityWifi/squid.inject/poison.pl
ln -s /usr/share/FruityWifi/www.site /var/www/site
chown -R www-data.www-data /usr/share/FruityWifi/www.site
chmod 777 /usr/share/FruityWifi/www.site/data.txt
chmod 777 /usr/share/FruityWifi/www.site/inject/data.txt


# BIN
cd /usr/share/FruityWifi/bin/
gcc danger.c -o danger
chmod 4755 danger

echo

# START/STOP SERVICES
echo "--------------------------------"
echo "Start Services"
echo "--------------------------------"
update-rc.d ssh defaults
update-rc.d nginx defaults
update-rc.d ntp defaults
update-rc.d -f apache2 remove

/etc/init.d/apache2 stop
/etc/init.d/nginx restart
/etc/init.d/php5-fpm restart


apt-get -y remove ifplugd

echo

echo "ENJOY!"
echo ""
