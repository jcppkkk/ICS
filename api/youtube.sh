#!bin/bash

DIR="data/$3"

temp=`grep fullscreenUrl data/$3/page/$1`
temp=`echo ${temp} | sed -n 's/ //gp'`
AVI_ID_1=`echo ${temp#*video_id=} | cut -d \& -f 1`
AVI_ID_2=`echo ${temp#*&t=} | cut -d \& -f 1`

wget -P ${DIR} http://www.youtube.com/get_video.php?video_id=${AVI_ID_1}"&t="${AVI_ID_2} -O $2".flv"

