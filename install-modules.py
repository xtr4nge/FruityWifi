#!/usr/bin/env python

#	Copyright (C) 2013-2015 xtr4nge [_AT_] gmail.com
#
#	This program is free software: you can redistribute it and/or modify
#	it under the terms of the GNU General Public License as published by
#	the Free Software Foundation, either version 3 of the License, or
#	(at your option) any later version.
#
#	This program is distributed in the hope that it will be useful,
#	but WITHOUT ANY WARRANTY; without even the implied warranty of
#	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#	GNU General Public License for more details.
#
#	You should have received a copy of the GNU General Public License
#	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 
import sys, getopt

import urllib2
from xml.dom.minidom import parse
from xml.dom import Node

from pprint import pprint

import subprocess, os

# get FruityWifi version
cmd = "cat /usr/share/fruitywifi/www/config/config.php |grep version"
f = os.popen(cmd)
output = f.read()
version = str(output).replace('\n','').replace('$version="v','').replace('";','')

url = urllib2.urlopen("https://raw.githubusercontent.com/xtr4nge/FruityWifi/master/modules-FruityWifi.xml")
dom = parse( url )

for modules in dom.getElementsByTagName('module'):
	
	info = {
			'name':         '',
			'version':      '',
			'author':       '',
			'description':  '',
			'url':          '',
			'required':     '',
		}
	
	for item in modules.childNodes:
		
		if item.nodeName == "name":
			info['name'] = item.childNodes[0].nodeValue
		
		if item.nodeName == "version":
			info['version'] = item.childNodes[0].nodeValue
			
		if item.nodeName == "author":
			info['author'] = item.childNodes[0].nodeValue
			
		if item.nodeName == "description":
			info['description'] = item.childNodes[0].nodeValue
			
		if item.nodeName == "url":
			info['url'] = item.childNodes[0].nodeValue
		
		if item.nodeName == "required":
			info['required'] = item.childNodes[0].nodeValue
	
	# Install module
	if (float(version.replace(".",""))) >= float(info['required'].replace(".","")):
		print info['name'] + " v" + info['version']
		cmd_install = "git clone https://github.com/xtr4nge/module_"+info['name']+".git /usr/share/fruitywifi/www/modules/"+info['name']
		print cmd_install
		os.system(cmd_install)
		cmd_install = "cd /usr/share/fruitywifi/www/modules/"+info['name']+"/includes/; chmod 755 install.sh; ./install.sh;"
		os.system(cmd_install)
		print
	else: 
		print "Module " + info['name'] + " requires FruityWifi >= v" + info['required']
