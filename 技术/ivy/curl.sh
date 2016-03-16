#!/bin/bash

A="69 Web is good !"
DATE=`date +%Y-%m"-"%d" "%k":"%M`
IP=`ifconfig bond1 | grep "inet addr" | awk -F "[: ]+" '{print $4}'`
# 123   #IP=`ifconfig eth1 | grep "inet addr" | awk -F "[: ]+" '{print $4}'`
Code=`curl -I -s http://bbs.infinixmobility.com/phpinfo.php  | grep 200 | cut -d " " -f 2`
# 123   #Code=`curl -I -s http://123.56.100.227/phpinfo.php | grep 200 | cut -d " " -f 2`
nginx_pid=`ps -ef | grep  nginx |egrep "nginx" |awk -F " " '{print $2}'`
php_pid=`ps -ef |grep php |grep "php" |awk -F " " '{print $2}'`

if [ $Code = "200" ];then
  echo "Time: $DATE $A" >>/userdata/sh_work/curl_200/website69-error.`date +%F`.log
#  echo "69 Web is good !"
else
  kill -9 $nginx_pid
  /userdata/install/nginx/sbin/nginx
  kill -9 $php_pid 
  /userdata/install/php/sbin/php-fpm -c /userdata/install/php/lib/php.ini
  echo "Time: $DATE nginx and php-fpm is restart." >>/userdata/sh_work/curl_200/website69-error.`date +%F`.log  
  echo "nginx and php-fpm is restart." |mutt -s "69 server restart nginx and php-fpm" 709924618@qq.com < /userdata/sh_work/curl_200/nginx_php.txt
fi
