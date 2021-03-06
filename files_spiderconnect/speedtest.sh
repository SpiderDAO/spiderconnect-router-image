#!/bin/sh
# Silly speed test just by downloading a file directly to /dev/null
# Useful on routers which only have busybox installed.
# B9 2016, 2018


dotest() {
    # $1 is which file to grab 100, 10, or 1 (megabytes).
    megabytes=$1

    wget=$(whichwget)

    bloburl=http://cachefly.cachefly.net/${megabytes}mb.test
    blobsize=$(($megabytes*1024*1024))

    #if which time >/dev/null 2>/dev/null; then
	#	totaltime=$(dotime $wget "$bloburl" -O /dev/null  )
    #else
		#start=$(date +%s)
		read up rest </proc/uptime; t1="${up%.*}${up#*.}"
		dotime $wget "$bloburl" -O /dev/null 2>&1 
		read up rest </proc/uptime; t2="${up%.*}${up#*.}"
		totaltime=$(( 10*(t2-t1) ))
		#stop=$(date +%s)
		#totaltime=$(( (stop-start) * 1000))
    #fi 

    echo Total time was $totaltime milliseconds for $blobsize bytes

    if [ $totaltime -ne 0 ]; then
		bps=$(((1000*blobsize*8)/totaltime))
		echo $((bps/1024/1024)) Mbit/s
		echo $((bps/1024)) Kbit/s
    else
		echo "Incalculable"
    fi
}

dotime() {
    # If we have the "time" program, use it for more precision
    # This is a wrapper since we want to return just
    # the number of milliseconds. Also, we handle different
    # formats for output from `time`. 
    output=$("$@")
	#output=$("time" "$@" | /usr/bin/tee /dev/tty)

    #if [ -z "$output" ]; then
	#	echo "Error: Is the time (`which time`) program broken?" >&2
	#	echo "Why was there no stderr?" >&2
	#	echo 0
	#	return
    #fi

    # time's output usually looks like this:
    # Connecting to cachefly.cachefly.net (205.234.175.175:80)
    # null       100% |*******************************|  1024k  0:00:00 ETA
    # real    0m 0.22s
    # user    0m 0.00s
    # sys     0m 0.08s

    real=$(echo "$output" | grep ^real)

    # We expect real="real	0m 0.22s", but double check
    if [ "$real" ]; then
		# Yup, we got what we expected.
		set - $real
		min=$2			# 0m
		min=${min%m}		# 0
		sec=$3			# 0.22s
		sec=${sec%s}		# 0.22
    else
		# Oops. This must be one of those machines where `time` returns
		# 0.00user 0.00system 0:00.22elapsed 1%CPU (0avgtext+0avgdata 1284maxresident)k
		real=$(echo "$output" | grep elapsed)
		#if [ -z "$real" ]; then
		#	echo "Error: Unknown format from the 'time' program:" >&2
		#	echo "$output" >&2
		#	echo 0
		#	return
		#fi

		# ...tem 0:00.22elapsed 1%cpu...
		real=${real%%elapsed*}		# ...tem 0:00.22
		real=${real##* }		# 0:00.22
		min=${real%%:*}			# 0
		sec=${real##*:}			#   00.22
    fi

    # Now we've got min=0 and sec=0.22, get rid of the decimal point
    ms=${sec#*.}		# 22
    while [ ${#ms} -lt 3 ]; do	# 220
		ms=${ms}0
    done
    sec=${sec%.*}

    # Bourne arithmetic in $(...) treats leading 0 as octal!
    min=$(nooctal $min)
    sec=$(nooctal $sec)
    ms=$(nooctal $ms)

    #echo "$min minutes, $sec seconds, $ms milliseconds" >&2

    # Now return the result as total number of milliseconds 
    #echo $((min*60*1000 + sec*1000 + ms))
}

nooctal() {
    # Given a string in $1, print without leading zeros.
    # "008" --> "8"
    x=$1
    y=${x#0}
    while [ "$x" != "$y" ]; do
		x=$y
		y=${x#0}
    done	

    if [ "$x" ]; then
		echo $x
    else
		echo 0
    fi
}

whichwget() {
    # On fancy machines, wget detects it is not on a tty and is too verbose.
    # On routers, wget doesn't understand the --progress flag.
    # Let's make everybody happy! :-)

    # Run a test and see how it dies.
    wget --progress=bar:force 0.0.0.1  2>/dev/null
    case $? in
	127) echo "Sorry this test requires wget (busybox or regular)." >&2
	     ;;
	4) # Yay! Fancy wget.
	    options="--quiet --show-progress --progress=bar:force --report-speed=bits"
	    ;;
	1) # Still Yay! Busybox wget or a veritable simulacrum.
	    ;;
	*) # Huh... um... yay?
	    echo Error: The shell or wget gave a mysterious error code. >&2
	    echo Error: This ought never happen. >&2
	    ;;
    esac
    echo wget $options
}



echo "======================================================================"
echo "ROUGH APPROXIMATION"
dotest 1
echo "======================================================================"
echo "DOING QUICK TEST"
dotest 10
echo "======================================================================"
echo "DOING NORMAL TEST"
dotest 100
echo "======================================================================"