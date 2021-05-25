<?php
$vpnconnected = false;
$vpnserver = '';
$vpnserverimage = '';
$vpnusername = false;
$vpnpassword = false;
$access_token = '';
$version = '-';

function get_version()
{
    global $version;
    $version = file_get_contents('/www/version.txt');
}

function check_vpn_status()
{
    global $vpnconnected, $vpnserver, $vpnserverimage;
    $openvpn = new openvpn();
    $status = $openvpn->is_active();
    if ($status === 1) {
        $vpnconnected = true;
        $vpnserver = get_server_detail()['loclabel'];
        $vpnserverimage = get_server_detail()['locname'];
    }
}

function get_server_detail()
{
    $openvpn = new openvpn();
    return $openvpn->get_server_detail();
}

function subnet($mask)
{
    $subnet_mask = [
        32 => '255.255.255.255',
        31 => '255.255.255.254',
        30 => '255.255.255.252',
        29 => '255.255.255.248',
        28 => '255.255.255.240',
        27 => '255.255.255.224',
        26 => '255.255.255.192',
        25 => '255.255.255.128',
        24 => '255.255.255.0',
        23 => '255.255.254.0',
        22 => '255.255.252.0',
        21 => '255.255.248.0',
        20 => '255.255.240.0',
        19 => '255.255.224.0',
        18 => '255.255.192.0',
        17 => '255.255.128.0',
        16 => '255.255.0.0',
        15 => '255.254.0.0',
        14 => '255.252.0.0',
        13 => '255.248.0.0',
        12 => '255.240.0.0',
        11 => '255.224.0.0',
        10 => '255.192.0.0',
        9 => '255.128.0.0',
        8 => '255.0.0.0',
        7 => '254.0.0.0',
        6 => '252.0.0.0',
        5 => '248.0.0.0',
        4 => '240.0.0.0',
        3 => '224.0.0.0',
        2 => '192.0.0.0',
        1 => '128.0.0.0',
        0 => '0.0.0.0'
    ];
    return $subnet_mask[$mask];
}

function get_advmode_status()
{
	
	if (strpos(file_get_contents("/etc/firewall.user"), "/cgi-bin/luci") === false) {
		return "lucion";
	} else {
		return "lucioff";
	}
	
}


function get_wifi_width5()
{
	
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		$value = trim(exec("uci get wireless.radio$GHZ5.htmode"));
		if ($value == "HT40" && exec("uci get wireless.radio$GHZ5.noscan") == 1) {
			$value = "HT40";
		} else if ($value == "VHT80" && exec("uci get wireless.radio0.noscan") == 1) {
			$value = "VHT80";
		} else {
			$value = "auto";
		}
		return $value;
		
	} else {
		#only 2 ghz
		return "";
	}
}


function get_wifi_width2()
{
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		$value = trim(exec("uci get wireless.radio$GHZ2.htmode"));
		if ($value == "HT40" && exec("uci get wireless.radio$GHZ2.noscan") == 1) {
			//$value = "HT40";
		} else if ($value == "HT20") {
			//$value = "HT20";
		} else {
			$value = "auto";
		}
		return $value;
		
	} else {
		#only 2 ghz
		$value = trim(exec("uci get wireless.radio0.htmode"));
		if ($value == "HT40" && exec("uci get wireless.radio0.noscan") == 1) {
			$value = "HT40";
		} else {
			$value = "auto";
		}
		return $value;
	}
}

function get_wifi_channel5()
{
	
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		return trim(exec("uci get wireless.radio$GHZ5.channel"));
		
	} else {
		#only 2 ghz
		return "";
	}
}


function get_wifi_channel2()
{
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		return trim(exec("uci get wireless.radio$GHZ2.channel"));
		
	} else {
		#only 2 ghz
		return trim(exec("uci get wireless.radio0.channel"));
	}
}

function get_wifi_isolation5()
{
	
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		return trim(exec("uci get wireless.default_radio$GHZ5.isolate"));
		
	} else {
		#only 2 ghz
		return "";
	}
}


function get_wifi_isolation2()
{
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		return trim(exec("uci get wireless.default_radio$GHZ2.isolate"));
		
	} else {
		#only 2 ghz
		return trim(exec("uci get wireless.default_radio0.isolate"));
	}
}

function get_router_login()
{
	return @file_get_contents("/router_login.auth");
}

function get_router_password()
{
	return @file_get_contents("/router_password.auth");
}

function get_wifi_enabled5()
{
	
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		return trim(exec("uci get wireless.@wifi-iface[$GHZ5].disabled"));
		
	} else {
		#only 2 ghz
		return "";
	}
}

function get_wifi_enabled2()
{
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		return trim(exec("uci get wireless.@wifi-iface[$GHZ2].disabled"));
		
	} else {
		#only 2 ghz
		return trim(exec("uci get wireless.@wifi-iface[0].disabled"));
	}
}


function get_wifi_ssid5()
{
	
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		return trim(exec("uci get wireless.@wifi-iface[$GHZ5].ssid"));
		
	} else {
		#only 2 ghz
		return "";
	}
}

function get_wifi_password5()
{
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		return trim(exec("uci get wireless.@wifi-iface[$GHZ5].key"));
		
	} else {
		#only 2 ghz
		return "";
	}
}

function get_wifi_ssid2()
{
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		return trim(exec("uci get wireless.@wifi-iface[$GHZ2].ssid"));
		
	} else {
		#only 2 ghz
		return trim(exec("uci get wireless.@wifi-iface[0].ssid"));
	}
}

function get_wifi_password2()
{
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		return trim(exec("uci get wireless.@wifi-iface[$GHZ2].key"));
		
	} else {
		#only 2 ghz
		return trim(exec("uci get wireless.@wifi-iface[0].key"));
	}
}

function get_killswitch_status()
{
    return trim(exec("uci get network.wgclient.killswitch"));
}

function get_dnsunblocker_status()
{
    return trim(exec("uci get network.wgclient.dnsunblocker"));
}

function get_server_name()
{
    return trim(exec("uci get network.wgclient.name"));
}

function get_location_keys($location)
{

	$curl = new curl();
	$wgprofile = $curl->execute(SPIDERVPN_API_URL . 'authentication/tunnel-details', 'POST', ['loc_name' => $location]);
	
	file_put_contents("/tmp/get_location_keys.flag", $wgprofile);
	
	$wgprofile = json_decode($wgprofile, true);
	if ($wgprofile !== false && !empty($wgprofile) && $wgprofile != "null" && $wgprofile != "NULL") {
		file_put_contents("/www/config/".$location.".json", json_encode($wgprofile, JSON_PRETTY_PRINT));
	} else {
		$curl2 = new curl();
		$wgprofile = $curl2->execute(SPIDERVPN_API_BACKUP_URL . 'authentication/tunnel-details', 'POST', ['loc_name' => $location]);
		$wgprofile = json_decode($wgprofile, true);
		if ($wgprofile === false || empty($wgprofile) || $wgprofile == "null" || $wgprofile == "NULL") {
			$wgprofile = json_decode(file_get_contents("/www/config/".$location.".json"), true);
		}
	}
	
	return $wgprofile;
	
}

function set_dns_servers($stop_wg0_first = false)
{

	$servers   = (array)(new spidervpn)->servers();
	$wgprofile = get_location_keys(get_server_name());

	if (get_dnsunblocker_status() == "wireguard" && !empty(get_server_name()) && !empty($wgprofile['Interface']['dns'])) {
		//set wereguard's dns servers

		$WG_DNS    = $wgprofile['Interface']['dns'];
		$status = exec("uci set network.wan.peerdns='0'");
		$status = exec("uci set network.wwan.peerdns='0'");
		$status = exec("uci delete network.wan.dns");
		$status = exec("uci delete network.wwan.dns");
		foreach ($WG_DNS as $dns) {
			if (!empty(trim($dns['ip']))) {
				$status = exec("uci add_list network.wan.dns='".$dns['ip']."'");
				$status = exec("uci add_list network.wwan.dns='".$dns['ip']."'");
			}
		}
	} else if (get_dnsunblocker_status() == "custom") {
		//custom dns servers
		$customdns = exec("uci get network.wgclient.customdns");
		
		$status = exec("uci set network.wan.peerdns='0'");
		$status = exec("uci set network.wwan.peerdns='0'");
		$status = exec("uci delete network.wan.dns");
		$status = exec("uci delete network.wwan.dns");
		foreach (explode(",", $customdns) as $dns) {
			if (!empty(trim($dns))) {
				exec("uci add_list network.wan.dns='".trim($dns)."'");
				exec("uci add_list network.wwan.dns='".trim($dns)."'");
			}
		}
	} else {
		//set default WAN dhcp dns
		$status = exec("uci set network.wan.peerdns='1'");
		$status = exec("uci set network.wwan.peerdns='1'");
	}
	
	$status = exec("uci commit network");
	
	exec("/etc/init.d/dnsmasq restart >/dev/null 2>&1 &");
	
	/*
	exec("ubus call network.interface.wan down; ");
	exec("ubus call network.interface.wan6 down; ");
	exec("ubus call network.interface.wan up; ");
	exec("ubus call network.interface.wan6 up;");
	*/
	
	$viatunnel = false;
	
	if ($_SERVER["REMOTE_ADDR"] == "127.0.0.1" || $_SERVER["REMOTE_ADDR"] == "::1") { 
		$viatunnel = true;
	}
	
	//exec("time sh -c \"while ubus call network.interface.wan status | grep -q '\\\"pending\\\": true'; do sleep 1; echo .; done\"");
	
	if (file_exists("/email.auth")) { //what for restart network if user just activating the router?
		exec("( \
		".($viatunnel?"":"killall ssh; killall ssh2;")." \
		sleep 1; ".($stop_wg0_first?"/bin/ubus call network.interface.wg0 down;":"")." \
		/bin/ubus call network.interface.wan down; \
		/bin/ubus call network.interface.wan6 down; \
		/bin/ubus call network reload; \
		/bin/ubus call network.interface.wan6 up; \
		/bin/ubus call network.interface.wan up;) >/dev/null 2>&1 &"
        );
    }
}

function redirect($url, $status_code = 302)
{
    header('Location: ' . $url, true, $status_code);
    die();
}


function get_servers_list()
{
    $spidervpn = new spidervpn;
    return $spidervpn->servers($protocol);
}

function check_activation()
{
    global $vpnusername, $vpnpassword;

    if (basename($_SERVER['PHP_SELF']) !== 'wanparams.php' && basename($_SERVER['PHP_SELF']) !== 'wan-setup.php' && basename($_SERVER['PHP_SELF']) !== 'activation.php' && (!$vpnusername || !$vpnpassword)) {
		redirect('/activation.php');
    } else {
        if (basename($_SERVER['PHP_SELF']) === 'activation.php' && $vpnusername && $vpnpassword) {
            redirect('/');
        }
    }


}


function get_vpn_credentials()
{
    global $vpnusername, $vpnpassword, $access_token;
    $vpnusername  = file_get_contents("/email.auth");
    $vpnpassword  = file_get_contents("/password.auth");
	$access_token = file_get_contents("/access_token.auth");
}


function check_credentials()
{
    global $vpnusername, $vpnpassword;
    if ($vpnusername && $vpnpassword) {
		
		//optimization - 1 time per 1 hour
		if (file_exists("/access_token.auth") && filesize("/access_token.auth") > 0) {
			if (time()-filemtime("/access_token.auth") < 1 * 3600) {
				return;
			}
		}
		
        $spidervpn = new spidervpn();
        $response = $spidervpn->check_credentials($vpnusername, $vpnpassword);
		
        if ($response->error === 1) {
            $openvpn = new openvpn();
            $openvpn->disconnect();
            $cli = new cli;
            $cli->execute('rm /*.auth');
            redirect('/activation.php?invalid=' . $response->message);
        } else {
			if (!empty($response->access_token)) {
				//echo "Updating access_token...\n";
				file_put_contents("/access_token.auth", $response->access_token);
			}
		}
    }


}


function execwithprogress($command, $closewhenuserclosepage = false) {
	
	set_time_limit(0);
	header("Content-type: text/plain");
	header("Content-Encoding: none");
	
	ob_start();
	ob_implicit_flush();
	
	if ($closewhenuserclosepage == true) {
		ignore_user_abort(true);
	}
	
	$cmd = $command;
	
	if (!headers_sent()) {
		// Disable gzip in PHP.
		ini_set('zlib.output_compression', 0);
		// Force disable compression in a header.
		// Required for flush in some cases (Apache + mod_proxy, nginx, php-fpm).
		header('Content-Encoding: none');
	}

	$descriptorspec = array(
		0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
		1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
		2 => array("pipe", "w")    // stderr is a pipe that the child will write to
	);
	
	//bugfix - chrome not show data if less that 1k O_o
	echo "Starting async operation...\r\n";
	echo str_pad(' ', 4 * 1024);
	echo "\r\n";
	
	do {
		$flushed = @ob_end_flush();
	} while ($flushed);
	@ob_flush();
	flush();
	
	$process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());
	
	@ob_flush();
	if (is_resource($process) && !feof($pipes[1]) && !feof($pipes[2]))  {
		//while ($s = fgets($pipes[1], 1024)) {
		while ($s = fgetsPending($pipes[1], 1)) {
			if (!empty(trim($s))) {
				echo trim($s)."\n";
			}
			echo "\xE2\x80\x8C";
			do {
				$flushed = @ob_end_flush();
			} while ($flushed);
			@ob_flush();
			flush();
			if (connection_aborted() == 1) {
				break;
			}
		}
	}
	
	//proc_terminate and proc_close not really work
	
	$status = proc_get_status($process);
	if($status['running'] == true) {
		//close all pipes that are still open
		fclose($pipes[1]); //stdout
		fclose($pipes[2]); //stderr
		//get the parent pid of the process we want to kill
		$ppid = $status['pid'];
		//use ps to get all the children of this process, and kill them
		$pids = preg_split('/\s+/', `ps -o pid --no-heading --ppid $ppid`);
		foreach($pids as $pid) {
			if(is_numeric($pid)) {
				echo "Killing $pid\n";
				posix_kill($pid, 9); //9 is the SIGKILL signal
			}
		}
	}
	
	@fclose($pipes[0]);
	@fclose($pipes[1]);
	@fclose($pipes[2]);
	@proc_terminate($process);
	
	
	echo "\r\n\r\nDone";
}

function fgetsPending(&$in, $tv_sec=1) {
	
	if ( stream_select($read = array($in), $write=NULL, $except=NULL, $tv_sec) ) {
		return fgets($in);
	} else {
		return " ";
	}
	
}


function ping($host, $timeout = 1) {
    /* ICMP ping packet with a pre-calculated checksum */
    $package = "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost";
    $socket  = socket_create(AF_INET, SOCK_RAW, 1);
    socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => $timeout, 'usec' => 0));
    socket_connect($socket, $host, null);
    $ts = microtime(true);
    socket_send($socket, $package, strLen($package), 0);
    if (socket_read($socket, 255)) {
        $result = microtime(true) - $ts;
    } else {
        $result = false;
    }
    socket_close($socket);
    return $result;
}
