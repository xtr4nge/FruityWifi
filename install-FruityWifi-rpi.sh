#!/bin/bash

# squid3
# dnsmasq
# nmcli (new version)
# network-manager (new version)
# karma-hostapd
# sslstrip
# dnsspoof
# urlsnarf

# ------ Raspberry-Pi -------
apt-get update
apt-get -y upgrade

update-rc.d ssh defaults
update-rc.d apache2 defaults
update-rc.d ntp defaults

apt-get -y install gcc-4.7
apt-get -y install g++-4.7
update-alternatives --install /usr/bin/gcc gcc /usr/bin/gcc-4.7 40 --slave /usr/bin/g++ g++ /usr/bin/g++-4.7

apt-get -y install php5
apt-get -y install network-manager
apt-get -y install hostapd
apt-get -y install squid3
apt-get -y install dsniff
apt-get -y install sslstrip
apt-get -y install subversion
apt-get -y install macchanger
# --------------------------


find FruityWifi -type d -exec chmod 755 {} \;
find FruityWifi -type f -exec chmod 644 {} \;

mkdir tmp-install
cd tmp-install

apt-get update

# DEP HOSTAPD-KARMA
apt-get -y install libnl1 
apt-get -y install libnl-dev 
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
#apt-get -y install libpackagekit-glib2-12
apt-get -y install libdbus-glib-1-dev
apt-get -y install libpackagekit-glib2-14
apt-get -y install libpackagekit-glib2-dev
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
#wget http://ftp.gnome.org/pub/GNOME/sources/NetworkManager/0.9/NetworkManager-0.9.8.4.tar.xz
#tar xvf NetworkManager-0.9.8.4.tar.xz
#cd NetworkManager-0.9.8.4

wget http://ftp.gnome.org/pub/GNOME/sources/NetworkManager/0.9/NetworkManager-0.9.8.8.tar.xz
tar xvf NetworkManager-0.9.8.8.tar.xz
cd NetworkManager-0.9.8.8

./configure
make
make install
#cp cli/src/nmcli /usr/bin/nmcli
cd ../


# KISMET 
apt-get -y install libncurses5-dev
apt-get -y install libpcap-dev

wget http://www.kismetwireless.net/code/kismet-2013-03-R1b.tar.xz
cd kismet-2013-03-R1b
./configure
make dep
make
make install
cd ../

cp /usr/local/bin/kismet /usr/bin/
cp /usr/local/bin/kismet_server /usr/bin/


# GISKismet
apt-get -y install libxml-libxml-perl 
apt-get -y install libdbi-perl 
apt-get -y install libdbd-sqlite3-perl

svn co https://my-svn.assembla.com/svn/giskismet/trunk giskismet
cd giskismet
perl Makefile.PL
make
make install
cd ../

cp /usr/local/bin/giskismet /usr/bin/


# APACHE2 SETUP
cd ../
cp -a FruityWifi /
ln -s /FruityWifi/www /var/www/FruityWifi
ln -s /FruityWifi/logs /var/www/FruityWifi/logs
mkdir /var/www/tmp
chown www-data.www-data /var/www/tmp
chmod  777 /var/www/tmp
chmod 755 /FruityWifi/squid.inject/poison.pl
cp -a /FruityWifi/www.site /var/www/site
chown -R www-data.www-data /var/www/site
chmod 777 /var/www/site/data.txt
chmod 777 /var/www/site/inject/data.txt

#mkdir /FruityWifi/logs/kismet
#mkdir /FruityWifi/logs/sslstrip

# BIN
cd /FruityWifi/www/bin/
gcc danger.c -o danger
chmod 4755 danger

/etc/init.d/apache2 start

update-rc.d -f squid3 remove
apt-get -y remove ifplugd

echo "ENJOY!"
echo ""

