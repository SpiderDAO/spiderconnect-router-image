#!/bin/sh

PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin

#mmc="mmcblk0"
#mmcp1="mmcblk0p1"
#mmcp2="mmcblk0p2"

#mmc="sda"
#mmcp1="sda1"
#mmcp2="sda2"

mmc=$(cat /tmp/mmc)
mmcp1=$(cat /tmp/mmcp1)
mmcp2=$(cat /tmp/mmcp2)

swapUUID=05d615b3-bef8-460b-9a23-52db8d09e000
dataUUID=05d615b3-bef8-460b-9a23-52db8d09e001

if [ ! -f "/tmp/mmc" ] || [ ! -f "/tmp/mmcp1" ] || [ ! -f "/tmp/mmcp2" ]; then
	echo "Error, please contact Technical Support"
	exit 0;
fi


dd if=/dev/zero of=/dev/$mmc bs=1M count=1

sync
sleep 2

fdisk /dev/$mmc <<EOF
o
n
p


+512M
n
p



w
q
EOF

sleep 2

sync

until [ -e /dev/$mmcp2 ]
do
	echo "Waiting for partitions to show up in /dev"
	sleep 1
done



yes | mkswap    -L swap -U "$swapUUID" /dev/$mmcp1
yes | mkfs.ext4 -L data -U "$dataUUID" /dev/$mmcp2


mkdir -p /mnt
mount /dev/$mmcp2 /mnt
if mount | grep -q /dev/$mmcp2; then
	cp -f -a /overlay/. /mnt
	umount /mnt
fi

#touch /etc/config/fstab
#DEVICE="$(sed -n -e "/\s\/overlay\s.*$/s///p" /etc/mtab)"
#uci -q delete fstab.rwm
#uci set fstab.rwm="mount"
#uci set fstab.rwm.device="${DEVICE}"
#uci set fstab.rwm.target="/rwm"
#uci commit fstab

#DEVICE="/dev/mmcblk0p2"
#eval $(blkid | grep $DEVICE | grep -o -e " UUID=\S*")
#uci -q delete fstab.overlay
#uci set fstab.overlay="mount"
#uci set fstab.overlay.uuid="${UUID}"
#uci set fstab.overlay.target="/overlay"
#uci commit fstab

#reboot

