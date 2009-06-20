#!/bin/sh
(mkdir  coretask ; chmod o+w coretask;) 2> /dev/null
(mkdir php/UIcache; chmod o+w php/UIcache; rm php/UIcache/*;) 2> /dev/null
for i in `ls api`; do
    (cd api/$i ;
    make clean;
    make;)
done

#crontab -l > tmp_1
#echo '
#PATH=/sbin:/bin:/usr/sbin:/usr/bin:/usr/games:/usr/local/sbin:/usr/local/bin
#ICSHOME=`pwd`/api
#ICSDATA=`pwd`/data
#* * * * * cd $ICSHOME/CORE; ./core' > tmp_2
