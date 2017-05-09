#! /usr/bin/python

# -- Library --
import xmlrpclib
import sys
import ssl

# -- Data --
URL = 'https://0.0.0.0/xmlrpc.php'

# -- SSL --
ssl.__create_deafault_https_context = ssl.__create_unverified_context

# -- Session --
session = xmlrpclib.Serverproxy (URL)

# -- Info --
list_methods = session.system.listmethods() # 

