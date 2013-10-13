#!/bin/bash

# squid3
# dnsmasq
# nmcli (new version)
# network-manager (new version)
# karma-hostapd
# sslstrip
# dnsspoof
# urlsnarf

find raspberry-wifi -type d -exec chmod 755 {} \;
find raspberry-wifi -type f -exec chmod 644 {} \;

mkdir tmp-install
cd tmp-install

apt-get update

# DEP HOSTAPD-KARMA
apt-get -y install libnl1 
#apt-get -y install libnl-dev 
apt-get -y install libssl-dev

# INSTALL HOSTAPD-KARMA
#wget http://www.digininja.org/files/hostapd-1.0-karma.patch.bz2
wget http://www.digininja.org/files/hostapd-1.0-karma.tar.bz2

bunzip2 hostapd-1.0-karma.tar.bz2
tar xvf hostapd-1.0-karma.tar
cd hostapd-1.0-karma/hostapd
make
cp hostapd /usr/sbin/karma-hostapd
cp hostapd_cli /usr/sbin/karma-hostapd_cli
cd ../../

# INSTALL DNSMASQ
apt-get -y install squid3

# INSTALL DNSMASQ
apt-get -y install dnsmasq

# INSTALL GPSD
apt-get -y install gpsd
apt-get -y install gpsd-clients


# DEP NETWORK-MANAGER
apt-get -y install wireless-tools
apt-get -y install libiw-dev
apt-get -y install libpackagekit-glib2-12
apt-get -y install libdbus-glib-1-dev
apt-get -y install libgudev-1.0-dev
#apt-get -y install libnl-dev
apt-get -y install uuid-dev
apt-get -y install uuid
apt-get -y install nss
apt-get -y install libnss-db
apt-get -y install libnss3-dev
apt-get -y install ppp-dev
apt-get -y install intltool
apt-get -y install libgudev-1.0-dev
apt-get -y install libnl-3-dev
apt-get -y install libnl-route-3-dev
apt-get -y install libnl-genl-3-dev
#apt-get -y install libnl1 libnl-dev


# INSTALL NTWORK-MANAGER 0.9.8.4
wget http://ftp.gnome.org/pub/GNOME/sources/NetworkManager/0.9/NetworkManager-0.9.8.4.tar.xz
tar xvf NetworkManager-0.9.8.4.tar.xz
cd NetworkManager-0.9.8.4
./configure
make
make install
cp cli/src/nmcli /usr/bin/nmcli
cd ../

# APACHE2 SETUP
cd ../
cp -a raspberry-wifi /
ln -s /raspberry-wifi/www /var/www/raspberry-wifi
ln -s /raspberry-wifi/logs /var/www/raspberry-wifi/logs
mkdir /var/www/tmp
chown www-data.www-data /var/www/tmp
chmod  777 /var/www/tmp
chmod 755 /raspberry-wifi/squid.inject/poison.pl

# BIN
cd /raspberry-wifi/www/bin/
gcc danger.c -o danger
chmod 4755 danger

/etc/init.d/apache2 start

echo "ENJOY!"
echo ""

