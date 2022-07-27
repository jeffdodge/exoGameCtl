#!/bin/sh
#
# exoGameCtl - Half-Life Control Panel
# Copyright (c)2002-2003 Jeff Dodge Technologies.  All Rights Reserved.
#
# Server Remote Start/Stop Shell Script
#
# $Id: exo_test.sh,v 2.7 2003/05/20 06:50:34 rwjd Exp $
#

user_home="/home/halflife"

#
# DO NOT MODIFY ANYTHING BELOW HERE
#

hlds_kpid=`ps x | grep "sh ./hlds_run" | awk '{print $1}' | head -1`

if [ -f $user_home/start.hlds ]
then
   rm -f $user_home/start.hlds
   $user_home/start_hlds.sh
fi

if [ -f $user_home/kill.hlds ]
then
   kill -9 $hlds_kpid
   killall -9 hlds
   rm -f $user_home/kill.hlds
fi
