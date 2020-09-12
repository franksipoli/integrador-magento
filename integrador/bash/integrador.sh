#!/bin/bash
time=3000 # segundos
server_local="2"
if [ $server_local = "1" ]; then
        dir_file="/var/www/html/projeto/frank/editorapositivo-ecommerce/Source/trunk/integrador/bash"
else
        dir_file="/var/www/html/projeto/frank/editorapositivo-ecommerce/Source/trunk/integrador/bash"
fi

cd $dir_file
count=0
microtime=0
microtimel=0
#while [ $count -eq 0 ]; do
        microtime=$(($(date +%s%N)/1000000))
        calc=`expr $microtime - $microtimel`
#        if [ $calc -gt $time ]; then
                #echo "ok $calc $time"
                microtimel="$microtime"
                $dir_file/run.php "massa"
#        fi

#done

