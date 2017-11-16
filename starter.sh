#!/bin/bash
#Starter AVNBota

function start
{

	if ! screen -list | grep -q "QC"; then
		screen -AdmS QC php thread.php
		echo -e 'QueryCore wystartowal'
	else
		echo -e 'QueryCore juz dziala'
	fi

}

function stop
{

	echo -e 'QueryCore zatrzymany'
	screen -X -S QC stuff "^C"

}

case "$1" in
	"start")
		start
	;;
	
	"stop")
		stop
	;;

	*)
		echo -e 'Uzyj start | stop'
	;;
esac
