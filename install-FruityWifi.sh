#!/bin/bash


find FruityWifi -type d -exec chmod 755 {} \;
find FruityWifi -type f -exec chmod 644 {} \;

mkdir tmp-install
cd tmp-install

apt-get update

update-rc.d ssh defaults
update-rc.d apache2 defaults
update-rc.d ntp defaults

apt-get -y install gettext make intltool build-essential automake autoconf uuid uuid-dev php5-curl php5-cli dos2unix curl

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


if [ ! -f "/usr/sbin/karma-hostapd" ]
then

	echo "--------------------------------"
    echo "Installing hostapd (karma)"
	echo "--------------------------------"
    #exit;

    # DEP HOSTAPD-KARMA
	apt-get -y install hostapd
    apt-get -y install libnl1 libnl-dev libssl-dev

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

else
	echo "--------------------------------"
    echo "hostapd (karma) already installed"
	echo "--------------------------------"
	echo
	echo
fi


cmd=`NetworkManager --version`
if [[ $cmd != "0.9.8.8" ]]
then
	echo "--------------------------------"
    echo "Installing NetworkManager"
	echo "--------------------------------"
    #exit;

    # DEP NETWORK-MANAGER
	apt-get -y install network-manager
    apt-get -y install wireless-tools
	#apt-get -y install libpackagekit-glib2-12
    apt-get -y install libiw-dev libdbus-glib-1-dev libpackagekit-glib2-14 libpackagekit-glib2-dev libgudev-1.0-dev
    #apt-get -y install libnl-dev
    apt-get -y install uuid-dev uuid nss
    apt-get -y install libnss-db libnss3-dev
    apt-get -y install ppp-dev intltool
    apt-get -y install libgudev-1.0-dev libnl-3-dev libnl-route-3-dev libnl-genl-3-dev
    #apt-get -y install libnl1 libnl-dev

    wget http://ftp.gnome.org/pub/GNOME/sources/NetworkManager/0.9/NetworkManager-0.9.8.8.tar.xz
    tar xvf NetworkManager-0.9.8.8.tar.xz
    cd NetworkManager-0.9.8.8

    ./configure
    make
    make install
    #cp cli/src/nmcli /usr/bin/nmcli
    cd ../

else
	echo "--------------------------------"
    echo "NetworkManager already installed"
	echo "--------------------------------"
	echo
	echo

fi


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


if [ ! -f "/usr/sbin/apache2" ]
then
	echo "--------------------------------"
    echo "Installing apache2"
	echo "--------------------------------"
    #exit;

    # APACHE2 SETUP
    apt-get -y install apache2 php5 libapache2-mod-php5 php5-curl

else
	echo "--------------------------------"
    echo "apache2 already installed"
	echo "--------------------------------"
	echo
	echo
fi

cmd=`date +"%Y-%m-%d-%k-%M-%S"`
cd ../
mv /usr/share/FruityWifi FruityWifi.BAK.$cmd
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

#mkdir /FruityWifi/logs/kismet
#mkdir /FruityWifi/logs/sslstrip

# BIN
cd /usr/share/FruityWifi/bin/
gcc danger.c -o danger
chmod 4755 danger

/etc/init.d/apache2 start

###update-rc.d -f squid3 remove
apt-get -y remove ifplugd

echo "ENJOY!"
echo ""

