#!/bin/bash

#builder v 1.3
#Petrunin Alex, 2020

files="files_spiderconnect"
profiles=( gl-mt300n-v2 zbt-we1326 zbt-wr8305rt zbt-wg3526-16M )
#profiles=( netgear-r8000 tplink_c50-v4 asus-rt-ac68u gl-ar750 netgear_r6350 linksys_wrt3200acm asus-rt-ac87u )
profiles=( zbt-we1326 )

project="SpiderConnect"
imagebuilder_path="/root/!/"
openwrtver="19.07.7"

shopt -s globstar

chmod 777 -R ./$files/

#pass Spider290

#removeppp="-ppp -ppp-mod-pppoe -ppp-mod-pppoe -ip6tables -ppp -kmod-pppoe -kmod-pppox -kmod-ppp -kmod-usb2 -logd -opkg"
removeppp=" -ip6tables -kmod-pppox -kmod-usb2 "
removeipv6="-ip6tables -odhcp6c -kmod-ip6tables -kmod-nf-ipt6 -kmod-nf-conntrack6 -kmod-ipv6 -ip6tables -odhcp6c -kmod-ipv6 -kmod-ip6tables -odhcpd-ipv6only"
removeusb="-kmod-usb-core -kmod-usb-ehci -kmod-usb-ohci -kmod-usb2"
#add_captureprobes="tcpdump-mini "
#add_capturesessions="softflowd "
#add_jsinject="luci-app-privoxy "
#add_debug="procps-ng-watch"

add="php7-mod-sockets iptables-mod-filter luci-proto-ppp uhttpd uhttpd-mod-ubus libiwinfo-lua sudo luci-base luci-app-firewall luci-mod-admin-full luci-theme-bootstrap luci-proto-wireguard php7-cgi php7-mod-curl php7-mod-json php7-mod-pcntl php7-mod-openssl php7-mod-session coreutils-timeout openssh-sftp-server"
add_modem="kmod-mppe kmod-usb-net kmod-usb-net-cdc-ether kmod-usb-net-rndis kmod-usb-net-qmi-wwan luci-proto-qmi" #Quectel  EC25
add_modem2="kmod-usb-serial kmod-usb-serial-option luci-compat comgt"
add_modem3="kmod-mppe kmod-usb-net kmod-usb-net-cdc-ether kmod-usb-net-rndis kmod-usb-net-qmi-wwan luci-proto-qmi kmod-usb-serial-ch341 kmod-usb-serial-ftdi" #fibocom 

add_extroot="blkid mount-utils swap-utils e2fsprogs fdisk kmod-fs-ext4 block-mount kmod-usb-storage"
add_shaper="kmod-tcp-bbr tc kmod-ifb"
add_uboot="kmod-mtd-rw uboot-envtools"

datetime=$(date +"%Y-%m-%d_%H.%M.%S")
scriptdir=$(pwd)
find . \( -name "*.bak" -o -name "*.trx" -o -name "*.chk" -o -name "*.img.gz" \) -type f -delete
rm -f *.bin
builded=false

for profile in ${profiles[*]};do
	for dir in $(find $imagebuilder_path -mindepth 1 -maxdepth 1 -type d -name "*imagebuilder-$openwrtver*"); do
		
		cd "$dir"
		
		if ! test -f "today_cleaned_"$(date +"%Y.%m.%d")".flag"; then
			make clean
			rm today_cleaned*
			touch "today_cleaned_"$(date +"%Y.%m.%d")".flag"
		fi
		
		find ./bin/ \( -name "*.bak" -o -name "*.bin" -o -name "*.trx" -o -name "*.chk" -o -name "*.img.gz" \) -type f -delete
		
		#old files?
		rm -rf "./$files"		

		#php obfuscator
		rm -rf /tmp/yakpro-po/
		echo $dir
		yakpro-po "$scriptdir/$files" -o /tmp
		mv "/tmp/yakpro-po/obfuscated/" "./$files"
		find "./$files/" -type f -name "*.php" | xargs sed -i -r ':a; s%(.*)/\*.*\*/%\1%; ta; /\/\*/ !b; N; ba'
		#php obfuscator end
		
		#uncomment next line if need raw
		#cp -r "$scriptdir/$files" .

		chmod 777 -R ./$files/
		
		if [ "$profile" == "zbt-wr8305rt" ]; then 
			#delete line 265 in ./include/image-commands.mk
			add_dynamic="$removeppp $removeipv6 $removeusb "
		elif [ "$profile" == "zbt-we1326" ]; then 
			add_dynamic="luci $add_extroot $add_uboot"
		elif [ "$profile" == "zbt-wg3526-16M" ]; then 
			add_dynamic="luci $add_modem $add_modem2 $add_modem3 $add_extroot $add_uboot"
		else
			add_dynamic="luci "
		fi
		
		make image PROFILE="$profile" PACKAGES="$add $add_shaper $add_dynamic $add_debug $add_captureprobes $add_capturesessions " FILES="$files" && builded=true
		if [ "$builded" == "false" ]; then
			make clean
		fi
		make image PROFILE="$profile" PACKAGES="$add $add_shaper $add_dynamic $add_debug $add_captureprobes $add_capturesessions " FILES="$files" && builded=true
		rm -r "./$files"
		
		fwfile=$(find ./bin/ -name "*-$profile-squashfs.trx")
		if [ "$fwfile" == "" ]; then 
			fwfile=$(find ./bin/ -name "*-$profile-squashfs-sysupgrade.*")
		fi
		
		fwextension="${fwfile##*.}"
		
		if [ "$fwfile" != "" ]; then 
			
			echo $fwfile;
			echo $fwextension;
			
			filename="$(basename -- $fwfile)"
			opewnrtbrand=$(echo $filename | cut -d'-' -f1)
			opewnrtver=$(echo $filename | cut -d'-' -f2)
			
			if [ "$profile" == "zbt-wr8305rt" ]; then 
				cp "$fwfile" "$scriptdir/Classic-$project-$datetime-$opewnrtbrand-$opewnrtver.bin"
			elif [ "$profile" == "zbt-we1326" ]; then 
				cp "$fwfile" "$scriptdir/Pro-$project-$datetime-$opewnrtbrand-$opewnrtver.bin"
			elif [ "$profile" == "zbt-wg3526-16M" ]; then 
				cp "$fwfile" "$scriptdir/ProPlus-$project-$datetime-$opewnrtbrand-$opewnrtver.bin"
			else
				cp "$fwfile" "$scriptdir/$project-$profile-$datetime-$opewnrtbrand-$opewnrtver.$fwextension"
			fi
			
		fi

		#whitelabel start
		find "$scriptdir/whitelabel" -mindepth 1 -maxdepth 1 -type d -print0 |
		while IFS= read -r -d '' resellerpath; do

			reseller=$(basename "$resellerpath")
			# cp -r "$scriptdir/$files" .
			#php obfuscator
			rm -rf /tmp/yakpro-po/
			echo $dir
			yakpro-po "$scriptdir/$files" -o /tmp
			mv "/tmp/yakpro-po/obfuscated/" "./$files"
			find "./$files/" -type f -name "*.php" | xargs sed -i -r ':a; s%(.*)/\*.*\*/%\1%; ta; /\/\*/ !b; N; ba'
			#php obfuscator end
			
			#uncomment next line if need raw
			#cp -r "$scriptdir/$files" .
			
			cd "$resellerpath"
			cp -r . "$dir/$files/"
			cd "$dir"
			chmod 777 -R ./$files/
			
			make image PROFILE="$profile" PACKAGES="$add $add_shaper $add_dynamic $add_debug $add_captureprobes $add_capturesessions " FILES="$files"
			make image PROFILE="$profile" PACKAGES="$add $add_shaper $add_dynamic $add_debug $add_captureprobes $add_capturesessions " FILES="$files"
			
			if [ "$fwfile" != "" ]; then 
				
				echo $fwfile;
				filename="$(basename -- $fwfile)"
				opewnrtbrand=$(echo $filename | cut -d'-' -f1)
				opewnrtver=$(echo $filename | cut -d'-' -f2)
				
				mv "$fwfile" "$scriptdir/$reseller-$profile-$datetime-$opewnrtbrand-$opewnrtver.$fwextension"
				
				find . -name *.bak -delete
				
			fi
			
			rm -r "./$files"
			
		done
		#whitelabel end
		
		if [ "$builded" == "true" ]; then
			break  
		fi
		
	done
	
	#download imagebuider if not exists
	if [ "$builded" == "false" ]; then
		echo "Searching for related imagebuilder for $profile ..."
		
		cd $imagebuilder_path
		echo $(pwd)
		mkdir -p index
		cd index
		if ! test -f "done.flag"; then
			wget -r -L -N https://downloads.openwrt.org/releases/$openwrtver/targets/ --accept="profiles.json"
			touch "done.flag"
		fi
		
		cd ..
		for profile in ${profiles[*]};do
			path=$(grep --with-filename -r "\"$profile\"" $imagebuilder_path/index/downloads.openwrt.org/)
			path=$(echo $path | cut -d ':' -f 1);
			echo $path #./downloads.openwrt.org/releases/19.07.4/targets/ar71xx/mikrotik/profiles.json
			
			target=$(echo $path | awk -F'/' '{print $(NF-2)}')
			echo $target
			subtarget=$(echo $path | awk -F'/' '{print $(NF-1)}')
			echo $subtarget
			
			imagebuilderfilename="openwrt-imagebuilder-$openwrtver-$target-$subtarget.Linux-x86_64.tar.xz"
			imagebuilderfoldername="${imagebuilderfilename%.*}"
			imagebuilderfoldername="${imagebuilderfoldername%.*}"
			imagebuilderurl="https://downloads.openwrt.org/releases/$openwrtver/targets/$target/$subtarget/$imagebuilderfilename"
			echo $imagebuilderurl
			echo $imagebuilderfoldername
			
			if ! test -f "$imagebuilderfoldername/unpacked.flag"; then
				wget --continue -O "$imagebuilder_path/index/$imagebuilderfilename" "$imagebuilderurl" && \
				tar -Jxvf "$imagebuilder_path/index/$imagebuilderfilename"  -C . && \
				touch "$imagebuilderfoldername/unpacked.flag"
				echo "$imagebuilderfoldername/unpacked.flag"
			fi
			
			imagebuilderfilename="openwrt-imagebuilder-$openwrtver-$target.Linux-x86_64.tar.xz"
			imagebuilderfoldername="${imagebuilderfilename%.*}"
			imagebuilderfoldername="${imagebuilderfoldername%.*}"
			imagebuilderurl="https://downloads.openwrt.org/releases/$openwrtver/targets/$target/$subtarget/$imagebuilderfilename"
			echo $imagebuilderurl
			echo $imagebuilderfoldername
			
			if ! test -f "$imagebuilderfoldername/unpacked.flag"; then
				wget --continue -O "$imagebuilder_path/index/$imagebuilderfilename" "$imagebuilderurl" && \
				tar -Jxvf "$imagebuilder_path/index/$imagebuilderfilename"  -C . && \
				touch "$imagebuilderfoldername/unpacked.flag"
				echo "$imagebuilderfoldername/unpacked.flag"
			fi
			
		done
		#wget -r -L -N https://downloads.openwrt.org/releases/$openwrtver/targets/
		
	fi
	
	builded=false
	
	
done
