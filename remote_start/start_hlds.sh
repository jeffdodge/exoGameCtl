#!/bin/sh
#
# exoGameCtl - Half-Life Control Panel
# Copyright (c)2002-2003 Jeff Dodge Technologies.  All Rights Reserved.
#
# Easy Server Start Script
#
# $Id: start_hlds.sh,v 2.7 2003/09/21 18:08:38 exodus Exp $
#

home="/home"
user=""
mod=""
ip=""
port="27015"
maxplayers=""
startmap=""

#
# DO NOT MODIFY ANYTHING BELOW HERE
#

case "`id`" in
uid=0\(root\)*)
echo "$0: This script cannot be run as root!"
exit 1
esac

killall -9 hlds_run > /dev/null
killall -9 hlds > /dev/null

export LD_LIBRARY_PATH=$home/$user/hlds_l:$LD_LIBRARY_PATH
cd $home/$user/hlds_l
./hlds_run -game $mod +ip $ip +port $port +maxplayers $maxplayers +map $startmap > /dev/null &
