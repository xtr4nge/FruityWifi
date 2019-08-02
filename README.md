# FruityWiFi
###### Wireless network auditing tool http://www.fruitywifi.com/

## Important Note (Debian Buster): 
Please use Use **Debian Buster** based systems. The Installer has been updated for resolving issues with old version. 
<br><br>

FruityWiFi is an open source tool to audit wireless networks. It allows the user to deploy advanced attacks by directly using the web interface or by sending messages to it. 

Initialy the application was created to be used with the Raspberry-Pi, but it can be installed on any Debian based system. 

![Status](http://www.fruitywifi.com/img/001.png)

A more flexible control panel. Now it is possible to use FruityWifi combining multiple networks and setups: 

Within the new options on the control panel we can change the AP mode between Hostapd or Airmon-ng allowing to use more chipsets like Realtek. 

It is possible customize each one of the network interfaces which allows the user to keep the current setup or change it completely.

![Config](http://www.fruitywifi.com/img/002.png)

FruityWifi is based on modules making it more flexible. These modules can be installed from the control panel to provide FruityWifi with new functionalities. 

Within the available modules you can find URLsnarf, DNSspoof, Kismet, mdk3, ngrep, nmap, Squid3 y SSLstrip (code injection functionality), Captive Portal, AutoSSH, Meterpreter, Tcpdump and more. 

**Note**: New modules are being developed continuously and can be installed from the modules page.

## Install

Using the installation script all the required dependencies, scripts and setup can be installed.

On **Buster** based systems use: install-FruityWiFi.sh
<br><br>

### x86/x64 Version

- You need Debian (or based) installed (or a Live CD version) to use this script.
- Download the zip file from https://github.com/xtr4nge/FruityWifi/archive/master.zip
- Unzip the file and run **install-FruityWiFi.sh** (This script will install all the dependencies and setups)
- Done. 

Go to **http://localhost:8000** (for http) <br>
Go to **https://localhost:8443** (for https) 

user: admin<br>
pass: admin
<br><br>

### Kali Linux Version

**Note**: The Kali Linux version has not been updated in long time. I will try to work on this as soon as I can. For the moment use the GitHub installer for avoiding issues.

FruityWiFi is now part of Kali Linux repositories.
- `apt-get install fruitywifi`
- `/etc/init.d/fruitywifi start`
- `/etc/init.d/php5-fpm start`

Go to **http://localhost:8000** (for http) <br>
Go to **https://localhost:8443** (for https) 

user: admin<br>
pass: admin
<br>

Note: installing `fruitywifi` will install all modules. If you want to install only some modules, you can install  `fruitywifi-core` first and then each module, for example `fruitywifi-module-dnsspoof`. 
<br><br>

### ARM version (Raspberry Pi)

**Note**: The new installer has not been tested on Raspberry yet. I will try to work on this as soon as I can.

- You need a Raspbian, Pwnpi or Kali Linux version to use this script.
- Download the zip file from https://github.com/xtr4nge/FruityWifi/archive/master.zip
- Unzip the file and run **install-FruityWiFi.sh** (This script will install all the dependencies and setups)
- Done. 

Go to **http://localhost:8000** (for http) <br>
Go to **https://localhost:8443** (for https) 

user: admin<br>
pass: admin
<br><br>

### More information
[Wiki](https://github.com/xtr4nge/FruityWifi/wiki)
