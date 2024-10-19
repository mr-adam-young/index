# adam.young@interversal.systems
# 2021-10-02
# wake_on_lan.py

# simple Python script to send a magic packet to my workstation, DARLING
# her MAC address is: 38-2C-4A-6D-5E-D7 (Ethernet using 10.0.0.10)

# https://pypi.org/project/wakeonlan/

from wakeonlan import send_magic_packet

mac_address = '38.2C.4A.6D.5E.D7'

send_magic_packet(mac_address)
print('Sent packet to physical address: ' + mac_address)