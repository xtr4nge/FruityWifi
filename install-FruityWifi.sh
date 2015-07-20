#!/bin/bash

# CONFIG
# --------------------------------------------------------
# Setup 'sudo' or 'danger' (root exec).
# --------------------------------------------------------
fruitywifi_exec_mode="sudo"
# --------------------------------------------------------
# Setup log path. default=/usr/share/fruitywifi/logs
# --------------------------------------------------------
fruitywifi_log_path="/usr/share/fruitywifi/logs"
# --------------------------------------------------------
# danger: 'enable' or 'disabled' (Backward compatibility)
# --------------------------------------------------------
fruitywifi_danger="enabled"
# --------------------------------------------------------
# 'all' option installs nginx webserver on ports 80 | 443,
# and it also installs FruityWifi on ports 8000 | 8443.
# If 'all' is not specified then only installs 8000 | 8443
# --------------------------------------------------------
fruitywifi_webserver="all" 
# --------------------------------------------------------

find FruityWifi -type d -exec chmod 755 {} \;
find FruityWifi -type f -exec chmod 644 {} \;

root_path=`pwd`

mkdir tmp-install
cd tmp-install

apt-get update

echo "--------------------------------"
echo "Creates user fruitywifi"
echo "--------------------------------"
adduser --disabled-password --quiet --system --home /var/run/fruitywifi --no-create-home --gecos "FruityWifi" --group fruitywifi

echo "[fruitywifi user has been created]"
echo

apt-get -y install gettext make intltool build-essential automake autoconf uuid uuid-dev php5-curl php5-cli dos2unix curl sudo unzip lsb-release

cmd=`gcc --version|grep "4.7"`
if [[ $cmd == "" ]]
then
    echo "--------------------------------"
    echo "Installing gcc 4.7"
    echo "--------------------------------"
	
    apt-get -y install gcc-4.7
    apt-get -y install g++-4.7
    update-alternatives --install /usr/bin/gcc gcc /usr/bin/gcc-4.7 40 --slave /usr/bin/g++ g++ /usr/bin/g++-4.7
    
    echo "[gcc setup completed]"

else
    echo "--------------------------------"
    echo "gcc 4.7 already installed"
    echo "--------------------------------"
    echo
fi

echo

if [ ! -f "/usr/sbin/dnsmasq" ]
then
    echo "--------------------------------"
    echo "Installing dnsmasq"
    echo "--------------------------------"
	
    # INSTALL DNSMASQ
    apt-get -y install dnsmasq
    
    echo "[dnsmasq setup completed]"

else
    echo "--------------------------------"
    echo "dnsmasq already installed"
    echo "--------------------------------"
    echo
fi

echo

if [ ! -f "/usr/sbin/hostapd" ]
then
    echo "--------------------------------"
    echo "Installing hostapd"
    echo "--------------------------------"

    # INSTALL HOSTAPD
    apt-get -y install hostapd
    
    echo "[hostapd setup completed]"

else
    echo "--------------------------------"
    echo "hostapd already installed"
    echo "--------------------------------"
    echo
fi

echo

if [ ! -f "/usr/sbin/airmon-ng" ] &&  [ ! -f "/usr/local/sbin/airmon-ng" ]
then
    echo "--------------------------------"
    echo "Installing aircrack-ng"
    echo "--------------------------------"

    # INSTALL AIRCRACK-NG
    apt-get -y install libssl-dev wireless-tools iw
    wget http://download.aircrack-ng.org/aircrack-ng-1.2-beta1.tar.gz
    tar -zxvf aircrack-ng-1.2-beta1.tar.gz
    cd aircrack-ng-1.2-beta1
    make
    make install
    ln -s /usr/local/sbin/airmon-ng /usr/sbin/airmon-ng
    ln -s /usr/local/sbin/airbase-ng /usr/sbin/airbase-ng
    cd ../
    
    echo "[aircrack-ng setup completed]"

else
    echo "--------------------------------"
    echo "aircrack-ng already installed"
    echo "--------------------------------"
    echo
fi

echo

# BACK TO ROOT-INSTALL FOLDER
cd $root_path

echo "--------------------------------"
echo "Installing Nginx"
echo "--------------------------------"

# NGINX INSTALL
apt-get -y install nginx php5-fpm
echo

# SSL
echo "--------------------------------"
echo "Create Nginx ssl certificate"
echo "--------------------------------"
cd $root_path
mkdir /etc/nginx/ssl
openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/nginx/ssl/nginx.key -out /etc/nginx/ssl/nginx.crt

rm /etc/nginx/sites-enabled/default

cp nginx-setup/nginx.conf /etc/nginx/
cp nginx-setup/FruityWifi /etc/nginx/sites-enabled/
cp nginx-setup/fpm/8000.conf /etc/php5/fpm/pool.d/
cp nginx-setup/fpm/8443.conf /etc/php5/fpm/pool.d/

if [ $fruitywifi_webserver == "all" ]
then
    mkdir /var/www/
    echo "." >> /var/www/index.php 
    chown -R fruitywifi:fruitywifi /var/www/
    #cp nginx-setup/default /etc/nginx/sites-enabled/
    cp nginx-setup/fpm/80.conf /etc/php5/fpm/pool.d/
    cp nginx-setup/fpm/443.conf /etc/php5/fpm/pool.d/
fi

# RESTAR NGINX + PHP5-FPM
/etc/init.d/nginx restart
/etc/init.d/php5-fpm restart

echo "[nginx setup completed]"
echo

echo "--------------------------------"
echo "BACKUP"
echo "--------------------------------"
cmd=`date +"%Y-%m-%d-%k-%M-%S"`
mv /usr/share/fruitywifi fruitywifi.BAK.$cmd
echo

echo "--------------------------------"
echo "Setup FruityWifi"
echo "--------------------------------"
cd $root_path

echo "--------------------------------"
echo "Config log path"
echo "--------------------------------"

mkdir $fruitywifi_log_path
EXEC="s,^\$log_path=.*,\$log_path=\""$fruitywifi_log_path"\";,g"
sed -i $EXEC FruityWifi/www/config/config.php
EXEC="s,^log-facility=.*,log-facility="$fruitywifi_log_path"/dnsmasq.log,g"
sed -i $EXEC FruityWifi/conf/dnsmasq.conf
EXEC="s,^dhcp-leasefile=.*,dhcp-leasefile="$fruitywifi_log_path"/dhcp.leases,g"
sed -i $EXEC FruityWifi/conf/dnsmasq.conf
EXEC="s,^Defaults logfile =.*,Defaults logfile = "$fruitywifi_log_path"/sudo.log,g"
sed -i $EXEC sudo-setup/fruitywifi

echo "[logs setup completed]"
echo

echo "--------------------------------"
echo "Setup Sudo"
echo "--------------------------------"
cd $root_path
cp -a sudo-setup/fruitywifi /etc/sudoers.d/

echo "[sudo setup completed]"
echo

cmd=`lsb_release -c |grep "jessie"`
if [[ ! -z $cmd ]]
then
    echo "--------------------------------"
    echo "Setup DNSMASQ"
    echo "--------------------------------"
	
    EXEC="s,^server=,#server=,g"
    sed -i $EXEC FruityWifi/conf/dnsmasq.conf
    
    echo "[dnsmasq setup completed]"
    echo

fi

cp -a FruityWifi /usr/share/fruitywifi
ln -s $fruitywifi_log_path /usr/share/fruitywifi/www/logs
ln -s /usr/share/fruitywifi/ /usr/share/FruityWifi

#if [ $fruitywifi_exec_mode == "danger" ]
if [ $fruitywifi_danger == "enabled" ]
then
    echo "--------------------------------"
    echo "Installing danger"
    echo "--------------------------------"
    
    cd /usr/share/fruitywifi/bin/
    gcc danger.c -o danger
    chgrp fruitywifi /usr/share/fruitywifi/bin/danger
    chmod 4750 /usr/share/fruitywifi/bin/danger
fi

echo

# START/STOP SERVICES
echo "--------------------------------"
echo "Start Services"
echo "--------------------------------"
update-rc.d ssh defaults
update-rc.d nginx defaults
update-rc.d php5-fpm defaults
update-rc.d ntp defaults

/etc/init.d/nginx restart
/etc/init.d/php5-fpm restart


apt-get -y remove ifplugd

echo

echo "GitHub: https://github.com/xtr4nge/FruityWifi"
echo "Twitter: @xtr4nge, @FruityWifi"
echo "ENJOY!"
echo ""
