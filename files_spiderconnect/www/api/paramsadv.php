<?php
require_once('/www/init.php');

$cli = new cli();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	if (trim($_POST['router_password']) == "") {
		@unlink("router_password");
	} else {
		file_put_contents("/router_password.auth", $_POST['router_password']);
	}
	
	if (trim($_POST['router_login']) == "") {
		@unlink("router_login");
	} else {
		file_put_contents("/router_login.auth", $_POST['router_login']);
	}
	
	if ($_POST['expertmode'] == "lucion") {
		$status = $cli->execute("sed -i '/\/cgi-bin\/luci/d' /etc/firewall.user");
	} else {
		$status = $cli->execute("echo 'iptables -I INPUT ! -s 127.0.0.1 -m string --algo bm --string \"/cgi-bin/luci\" -j REJECT' >> /etc/firewall.user");
	}

	$status = $cli->execute("uci commit firewall");
	$status = $cli->execute("/etc/init.d/firewall restart >/dev/null 2>&1 &");

}
redirect('/params.php?success');