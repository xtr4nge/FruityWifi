#!/usr/bin/env python

import os, sys
import getopt
import netifaces

def usage():
    print ("\nFruityWiFi utils v1.1 (@xtr4nge)")

    print ("Usage: network.py <options>\n")
    print ("Options:")
    print ("-t <type>, --type=<type>                 TYPE")
    print ("-i <iface>, --iface=<iface>              INTERFACE")
    print ("")
    print ("Author: @xtr4nge")
    print ("")

def parseOptions(argv):
    TYPE = ""
    IFACE = ""

    try:
        opts, args = getopt.getopt(argv, "ht:i:", 
                                   ["help", "type=", "iface="])

        for opt, arg in opts:
            if opt in ("-h", "--help"):
                usage()
                sys.exit()
            elif opt in ("-t", "--type"):
                TYPE = arg
            elif opt in ("-i", "--iface"):
                IFACE = arg

        if TYPE == "":
            usage()
            print
            print ("[Required] \n        -t (TYPE: getiface) \n")
            print

            sys.exit(1)

        return (TYPE, IFACE)

    except getopt.GetoptError:
        usage()
        sys.exit(2)

def getIface():
    for i in netifaces.interfaces():
        try: MAC = netifaces.ifaddresses(i)[netifaces.AF_LINK][0]["addr"]
        except: MAC = ""
        try: IP = netifaces.ifaddresses(i)[netifaces.AF_INET][0]["addr"]
        except: IP = ""
        print (str(i)+"|"+str(IP)+"|"+str(MAC))

def getIfaceNAME():
    for i in netifaces.interfaces():
        print (i)

def getIfaceIP(iface):
    try: IP = netifaces.ifaddresses(iface)[netifaces.AF_INET][0]["addr"]
    except: IP = ""
    print (IP)

def getIfaceMAC(iface):
    try: MAC = netifaces.ifaddresses(iface)[netifaces.AF_LINK][0]["addr"]
    except: MAC = ""
    print (MAC)

def main(argv):
    (TYPE, IFACE) = parseOptions(argv)

    if TYPE == "getiface":
        getIface()
    if TYPE == "getifacename":
        getIfaceNAME()
    if TYPE == "getifaceip" and IFACE != "":
        getIfaceIP(IFACE)
    if TYPE == "getifacemac" and IFACE != "":
        getIfaceMAC(IFACE)

if __name__ == "__main__":
    main(sys.argv[1:])
