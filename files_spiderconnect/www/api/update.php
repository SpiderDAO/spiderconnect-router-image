<?php
require_once('../init.php');
$cli = new cli();

error_reporting(E_ALL);
ini_set('display_errors', '1');


if(!empty($_FILES)) {
  if (move_uploaded_file($_FILES["file"]["tmp_name"], "/tmp/firmware.bin")) {
		
		#openwrt paths
		putenv('PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin');
		
		if (!empty($_POST['userparams']) && $_POST['userparams'] == "keep") {
			// wget -O /tmp/firmware.bin http://spidersupport:XogSNheA@setup.spidervpn.org/firmware/Latest%20Stable%20Firmware/Pro-SpiderVPN-2020-12-24_12.32.32-openwrt-19.07.5.bin
			file_put_contents("/etc/crontabs/root", "\n* * * * * /sbin/sysupgrade    /tmp/firmware.bin", FILE_APPEND);
		} else {
			file_put_contents("/etc/crontabs/root", "\n* * * * * /sbin/sysupgrade -n /tmp/firmware.bin", FILE_APPEND);
		}
		$cli->execute('killall ntpd');
		$cli->execute('date +%T -s "05:10:58"');
		$cli->execute('/etc/init.d/cron restart');
  } else {
		echo "Sorry, there was an error uploading your file...";
		die();
  }
} else {
	echo "No files was uploaded.";
	die();
}

redirect('/connection-updated.php');

?>
