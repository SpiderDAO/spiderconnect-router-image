<?php

error_reporting(0);
ini_set('display_errors', 0);

ignore_user_abort(true);
set_time_limit(0);

if (!headers_sent()) {
	header("Access-Control-Allow-Origin: *");
}

ini_set("memory_limit", -1);
if (php_sapi_name() != "cli" && php_sapi_name() != "cgi-fcgi") {
	ini_set('max_execution_time', 3600); //300 seconds = 5 minutes
}

if (isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] != "127.0.0.1" && $_SERVER['SERVER_ADDR'] != "::1") {
	if (file_exists("/router_login.auth") || file_exists("/router_password.auth")) {
		
		$exclude_password = ['login.php', 'factoryreset.php', 'activation.php', 'credentials.php'];
		
		if (!in_array(basename($_SERVER['PHP_SELF']), $exclude_password)) {
			if (!isset($_SERVER['PHP_AUTH_USER']) || 
			($_SERVER['PHP_AUTH_USER'] != file_get_contents("/router_login.auth") ||
			$_SERVER['PHP_AUTH_PW'] != file_get_contents("/router_password.auth"))) {
				header('WWW-Authenticate: Basic realm="'.file_get_contents("/brand/brand.txt").'"');
				header('HTTP/1.0 401 Unauthorized');
				echo 'Please enter valid '.file_get_contents("/brand/brand.txt").' Login and Password, of factory-reset router via http://10.11.0.1/factoryreset.php page';
				die();
			} else {
				//pass user in
			}
		}
		
	}
}

require_once('/www/config/app.php');

if (isset($_GET['lastbalance'])) {
	
	$data = json_decode(file_get_contents('php://input'), true)['data'];
	
	var_dump(strval ($data));
	
	//if ((float)$data > 0) {
		file_put_contents("/tmp/lastbalance", str_replace("SPDR", "", $data));
	//}
	
	die();
	
} else if (isset($_GET['freespace'])) {
	
	if (file_exists("/sbin/block")) {
		if (disk_free_space("/") > 0 && disk_free_space("/") < 1024*1024) {
			if (!file_exists("/tmp/lowspace")) {
				
				echo "To low space";
				
				exec('sh /addcaptive.sh');
				
				exec("/etc/init.d/dnsmasq restart");
				exec("/etc/init.d/network restart");
				
				touch("/tmp/lowspace");
				
			}
		} else {
			if (file_exists("/tmp/lowspace")) {
				
				echo "From low space";
				
				exec("sed -i '/\/10.11.0.1/d' /etc/dnsmasq.conf");
				
				exec("/etc/init.d/dnsmasq restart");
				exec("/etc/init.d/network restart");
				
				@unlink("/tmp/lowspace");
				
			}
		}
	}
	die();
	
} else if (isset($_GET['formatmmc'])) {
	
	
	if (!empty(glob("/dev/mmcblk?"))) {
		$mmc = glob("/dev/mmcblk?")[0];
		$mmc = explode("/", $mmc)[2];
		
		file_put_contents("/tmp/mmc", $mmc);
		file_put_contents("/tmp/mmcp1", $mmc."p1");
		file_put_contents("/tmp/mmcp2", $mmc."p2");
		
		exec("sh /extroot.sh");
		
	}
	
} else if (isset($_GET['formatusb'])) {
	
	if (!empty(glob("/dev/sd?")))
	{
		$sda = glob("/dev/sd?")[0];
		$sda = explode("/", $sda)[2];
		
		file_put_contents("/tmp/mmc", $sda);
		file_put_contents("/tmp/mmcp1", $sda."1");
		file_put_contents("/tmp/mmcp2", $sda."2");
		
		exec("sh /extroot.sh");
		
	}
	
} else if (isset($_GET['halt'])) {
	
	exec("sync");
	exec("halt");
	
} else if (isset($_GET['ping'])) {
	
	header("Content-type: text/plain");
	
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	$timeout = 1000;
	
	$hosts = array("wiki.org", "ya.ru", "1.1.1.1", "one.one.one.one", "spidervpn.org", "fsdfdsdfsfsdf.com");
	
	echo json_encode(bulkping($hosts, 4000, false), JSON_PRETTY_PRINT);
	
	die();
	
} else if (isset($_GET['savekeys']) || isset($_GET['deletekeys'])) {
	
	$out = array();
	
	if (empty($spdrpartition)) {
		
		$out['model'] = $model;
		$out['status'] = "unsupported";
		
		echo json_encode($out, JSON_PRETTY_PRINT);
		die();
		
	}
	
	if (isset($_GET['savekeys'])) {
		$origdata = json_decode(file_get_contents('php://input'), true)['data'];
		$data     = $origdata;
		//file_put_contents("/tmp/wallet.txt", json_encode($data, JSON_PRETTY_PRINT));
		
		$data = "SPDR!".json_encode($data, JSON_PRETTY_PRINT);
	} else {
		$data = "";
	}
	
	$uboot_env = file_get_contents($spdrpartition);
	$uboot_env_size = strlen($uboot_env);
	
	//double recheck that we will not delete non-our data
	$cur_uboot_data = str_replace(urldecode("%FF"), "", $cur_uboot_data);
	if (!empty($cur_uboot_data)) {
		if (strpos($cur_uboot_data, "SPDR!") !== 0) {
			$out['status'] = "I see non-our data in uboot-env partition - better i will not touch it, plz contact support team";
			echo json_encode($out, JSON_PRETTY_PRINT);
			die();
		}
	}
	//double recheck that we will not delete non-our data end
	
	$uboot_env = substr_replace($uboot_env, $data, $offset);
	$uboot_env = $uboot_env.str_repeat(urldecode("%FF"), $uboot_env_size-strlen($uboot_env));
	
	
	file_put_contents("/tmp/uboot_env", $uboot_env);
	exec('/sbin/insmod mtd-rw.ko i_want_a_brick=1');
	exec('cat /tmp/uboot_env | /sbin/mtd write - '.$spdrpartition);
	exec('sync');
	exec('/sbin/rmmod mtd-rw');
	
	@unlink("/tmp/uboot_env");
	
	if (isset($_GET['savekeys'])) {
		exec("uci set system.@system[0].walletkeys=1");
		file_put_contents("/tmp/address", $origdata['address']);
		file_put_contents("/tmp/phrase", $origdata['mnemonic']);
	} else {
		exec("uci set system.@system[0].walletkeys=0");
		@unlink("/tmp/address");
		@unlink("/tmp/phrase");
	}
	exec("uci commit");
	
	$out['status'] = "ok";
	
	echo json_encode($out, JSON_PRETTY_PRINT);
	
	die();
	
} else if (isset($_GET['walletstatus'])) {
	
	header("Content-type: text/plain");
	
	$out = array();
	$fw_env_config = "";
	
	if (empty($spdrpartition)) {
		
		$out['model'] = $model;
		$out['status'] = "unsupported";
		
		echo json_encode($out, JSON_PRETTY_PRINT);
		die();
		
	}
	
	$cur_data = file_get_contents($spdrpartition, FALSE, NULL, $offset);
	
	if (strpos($cur_data, "SPDR!") !== 0) {
		$out['status'] = "no_wallet";
		$out['data'] = urlencode($cur_data);
	} else {
		$out['status'] = "wallet_exist";
		$out['data'] = substr($cur_data, strlen("SPDR!"));
		$out['data'] = str_replace(urldecode("%FF"), "", $out['data']);
		$out['data'] = json_decode($out['data']);
	}
	
	echo json_encode($out, JSON_PRETTY_PRINT);
	
	die();
	
} else if (isset($_GET['extrootstatus'])) {
	
	header("Content-type: text/plain");
	
	$out = array();
	
	$mount = shell_exec("mount");
	if (strpos($mount, "/dev/mtdblock6 on /overlay")) {
		$out["boot"] = "internal";
	} else if (strpos($mount, "/dev/mmcblk0p2 on /overlay")) {
		$out["boot"] = "mmc";
	} else if (strpos($mount, "/dev/sda2 on /overlay")) {
		$out["boot"] = "usb";
	} else {
		$out["boot"] = "unknown";
	}
	
	$out["rom"]     = disk_total_space("/rom/");
	$out["space"]     = disk_total_space("/");
	$out["freespace"] = disk_free_space("/");
	
	//is mmc inserted?
	if (!empty(glob("/dev/mmcblk?")))
	{
		exec("blkid", $blkid);
		
		$mmc = glob("/dev/mmcblk?")[0];
		$mmc = explode("/", $mmc)[2];
		
		$out["mmc"]["sectors"] = trim(file_get_contents("/sys/block/".$mmc."/size"));
		$out["mmc"]["sectorsize"] = trim(file_get_contents("/sys/block/".$mmc."/queue/hw_sector_size"));
		$validpartitions = 0;
		foreach($blkid as $line) {
			if (strpos($line, "/dev/".$mmc."p1") !== false && strpos($line, "swap") !== false && strpos($line, "05d615b3-bef8-460b-9a23-52db8d09e000")) {
				$validpartitions++;
			} else if (strpos($line, "/dev/".$mmc."p2") !== false && strpos($line, "data") !== false && strpos($line, "05d615b3-bef8-460b-9a23-52db8d09e001")) {
				$validpartitions++;
			}
		}
		$out["mmc"]["type"] = $validpartitions;
	}
	
	if (!empty(glob("/dev/sd?")))
	{
		$sda = glob("/dev/sd?")[0];
		$sda = explode("/", $sda)[2];
		
		$out["sda"]["sectors"] = trim(file_get_contents("/sys/block/".$sda."/size"));
		$out["sda"]["sectorsize"] = trim(file_get_contents("/sys/block/".$sda."/queue/hw_sector_size"));
		if (empty($blkid)) {
			exec("blkid", $blkid);
		};
		$validpartitions = 0;
		foreach($blkid as $line) {
			if (strpos($line, "/dev/".$sda."1") !== false && strpos($line, "swap") !== false && strpos($line, "05d615b3-bef8-460b-9a23-52db8d09e000")) {
				$validpartitions++;
			} else if (strpos($line, "/dev/".$sda."2") !== false && strpos($line, "data") !== false && strpos($line, "05d615b3-bef8-460b-9a23-52db8d09e001")) {
				$validpartitions++;
			}
		}
		$out["sda"]["type"] = $validpartitions;
	}
	
	echo json_encode($out, JSON_PRETTY_PRINT);
	
	die();
	
} else if (isset($_GET['getstate'])) {
	
	if (!file_exists("/tmp/wan.port")) {
		$WAN = trim(exec("uci get network.wan.ifname"));
		file_put_contents("/tmp/wan.port", $WAN);
	} else {
		$WAN = file_get_contents("/tmp/wan.port");
	}
	
	if (!file_exists("/tmp/wan.swport")) {
		//smart WAN cable state detector
		$WANPORT = trim(exec("uci get network.@switch_vlan[1].ports"));
		$WANPORT = explode(" ", $WANPORT)[0];
		file_put_contents("/tmp/wan.swport", $WANPORT);
	} else {
		$WANPORT = file_get_contents("/tmp/wan.swport");
	}
	
	header("Content-type: text/plain");

	$out['rx']                        = (float)@file_get_contents("/sys/class/net/wg0/statistics/rx_bytes");
	$out['tx']                        = (float)@file_get_contents("/sys/class/net/wg0/statistics/tx_bytes");
	
	//spider pro and classic are supported
	$wan1cable = trim(exec("swconfig dev switch0 port ".$WANPORT." get link"));
	if (strpos($wan1cable, "link:down") === false || !empty(trim(exec("uci get network.wwan.proto")))) {
		$out['wan1cable'] = 1;
		
		$out['vpn1'] = is_active();
		$out['locselected'] = trim(exec("uci get network.wgclient.name 2>/dev/null"));
		
        $server_list = [];
		$servers = json_decode(file_get_contents("/www/config/locations.json"), true);
		foreach ($servers as $server) {
			$params = array($server['locname'] => $server);
			$server_list = array_merge($server_list, $params);
		}
		
		$out['loclabel'] = trim($server_list[$out['locselected']]['loclabel']);
		
		if ($out['vpn1'] != 1) {
			
			$dnshosts = array("spidervpn.org", "wiki.org", "one.one.one.one");
			$dnsping  = bulkping($dnshosts, 4000, true);
			
			$out['pingchecker_novpn']['dnsping'] = $dnsping;
			
			if (!isset($dnsping['good'])) {
				//no ping - dns problem? lets recheck
				$out['wan1'] = 0;
				
				$nondnshosts = array("1.1.1.1", "8.8.8.8");
				$nondnsping  = bulkping($dnshosts, 4000, true);
				
				$out['pingchecker_novpn']['nondnsping'] = $nondnsping;
				
				if (isset($nondnsping['good']))  {
					
					//without dns all working
					$dnsunblocker = trim(exec("uci get network.wgclient.dnsunblocker"));
					if (!empty($out['locselected']) && $dnsunblocker == "wireguard") {
						//our dns+problem
						$out['wan1'] = 4;
					} else {
						//peer dns + problem
						$out['wan1'] = 3;
					}
				}
			} else {
				// ping google ok
				$out['wan1'] = 1;
			}
			
		} else {
			
			$dnshosts = array("spidervpn.org", "wiki.org", "one.one.one.one");
			$dnsping = bulkping($dnshosts, 4000, true);
			
			$out['pingchecker_vpn']['dnsping'] = $dnsping;
			
			if (!isset($dnsping['good'])) {
				
				//no ping - dns problem? lets recheck
				
				$out['wan1'] = -1;
				$out['vpn1'] = -1;
				
				$nondnshosts = array("1.1.1.1", "8.8.8.8");
				$nondnsping  = bulkping($dnshosts, 4000, true);
				
				$out['pingchecker_vpn']['nondnsping'] = $nondnsping;
				
				if (!isset($nondnsping['good']))  {
					//even without dns no ping
					$out['vpn1'] = 4;
				} else {
					$out['vpn1'] = 3;
				}
			} else {
				$out['wan1'] = 1;
			}
		}
	} else {
		$out['wan1cable'] = 0;
		$out['vpn1'] = 0;
	}
	
	$out['wan_port'] = $WAN;
	
	//$out['wan1cable'] = trim(@file_get_contents("/sys/class/net/".$WAN."/carrier"));   //0: physical link is down, 1: physical link is up
	$out['wan1state'] = trim(@file_get_contents("/sys/class/net/".$WAN."/operstate")); //"unknown", "notpresent", "down", "lowerlayerdown", "testing", "dormant", "up".
	
	if (file_exists("/tmp/error.flag") && filesize("/tmp/error.flag") > 2) {
		$out['lasterror'] = @file_get_contents("/tmp/error.flag");
	} else {
		$out['lasterror'] = "";
	}

	flock($locker, LOCK_UN);

	echo json_encode($out, JSON_PRETTY_PRINT);
}

die();

function bulkping($hosts, $timeout = 1000, $quickest = false) {

	$status = array(); //good, bad, error
	$package = "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost";
	$counter = 0;
	
	foreach($hosts as $host) {
		
		$socket  = socket_create(AF_INET, SOCK_RAW, 1) or die("Unable to create socket\n");
		socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => $timeout, 'usec' => 0))or die("Unable to set socket_set_option on socket\n");
		if (@socket_connect($socket, $host, null) === false) {
			$status['error'][$host]['time'] = microtime(true) - $ts;
			$status['error'][$host]['error'] = socket_last_error();
			$status['error'][$host]['errorstr'] = socket_strerror($status['error'][$host]['error']);
			//echo $host." - "."false1 ".(microtime(true) - $ts)."\n";
		} else {
			socket_set_nonblock($socket) or die("Unable to set nonblock on socket\n");
			$ts = microtime(true);
			socket_send($socket, $package, strLen($package), 0) or die("Unable to socket_send\n");
			$socks[$counter] = $socket;
			$names[$counter] = $host;
			$counter++;
		}
	}
	
	do {
		if (count($socks)) {
			foreach ($socks as $k => $v) {
				// Check for new messages
				$string = '';
				if ($char = socket_read($v, 1024)) {
					$string .= $char;
				}
				// New string for a connection
				if (strpos($string, "PingHost") !== false) {
					$status['good'][$names[$k]]['time'] = microtime(true) - $ts;
					if ($quickest == true) {
						//return on first success;
						return $status;
					}
					unset($socks[$k]);
				}
				//echo ".";
			}
		}
		usleep( 1 * 1000 );

		if ((microtime(true) - $ts)*1000 > $timeout) {
			//echo "\nTimeout";
			return $status;
		}
	} while(!empty($socks));
	
	//all ended
	return $status;

}

function is_active() {

	$status = json_decode(shell_exec('ifstatus wg0'));
	$routes = exec('ip route | grep default');
	
	return ($status->up == false || strpos($routes, "wg0") === false) ? 0 : 1;

}



?>