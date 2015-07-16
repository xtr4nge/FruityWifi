FruityWifi
==============

FruityWifi is a wireless network auditing tool. The application can be installed in any Debian based system adding the extra packages. Tested in Debian, Kali Linux, Kali Linux ARM (Raspberry Pi), Raspbian (Raspberry Pi), Pwnpi (Raspberry Pi), Bugtraq.


v2.2
----------------
- Wireless service has been replaced by AP module
- Mobile support has been added
- Bootstrap support has been added
- Token auth has been added
- minor fix


v2.1
----------------
- Hostapd Mana support has been added
- Phishing service has been replaced by phishing module
- Karma service has been replaced by karma module
- Sudo has been implemented (replacement for danger)
- Logs path can be changed
- Squid dependencies have been removed from FruityWifi installer
- Phishing dependencies have been removed from FruityWifi installer
- New AP options available: hostapd, hostapd-mana, hostapd-karma, airmon-ng
- Domain name can be changed from config panel
- New install options have been added to install-FruityWifi.sh
- Install/Remove have been updated


v2.0 (alpha)
----------------
- Web-Interface has been changed (new look and feel, new options).
- Nginx has replaced Apache2 as default webserver.
- Installation script has been updated.
- Config panel has been changed.
- Network interfaces structure has been changed and renamed.
- It is possible to use FruityWifi combining multiple networks and setups.
- Supplicant mode has been added as a module.
- 3G/4G Broadband Mobile has been added as a module.
- FruityWifi HTTP webinterface on port 8000
- FruityWifi HTTPS webinterface on port 8443


v1.9
----------------
- Service Karma has been replaced by Karma module
- Service Supplicant has been replaced by nmcli module
- Config page has been updated
- Supplicant config has been changed (nmcli module is required)
- dnspoof host file has been removed from config page (dnsspoof module is required)
- Logs page has been updated
- WSDL has been updated
- Hostapd/Karma has been removed from installer (replaced by Karma module)
- NetworkManager has been removed from installer (replaced by nmcli module)
- install-modules.py has been added (install all modules from console)


v1.8
----------------
- WSDL has been added
- new status page has been added
- logs can follow in realtime using the new status page (wsdl)


v1.6
----------------
- Dependencies can be installed from module windows
- minor fix


v1.5
----------------
- New functions has been added
- Source code has been changed (open file function)
- minor fix


v1.4
----------------
- New functions has been added (monitor mode)
- config page has been changed
- minor fix


v1.3
----------------
- Directory structure has been changed
- minor fix


v1.2
----------------
- Installation script has been updated
- SSLstrip fork (@xtr4nge) has been added (Inject + Tamperer options)
- minor fix


v1.1
----------------
- External modules can be installed from modules page
- minor fix


v1.0
----------------
- init
