<?php
require_once('/www/init.php');

$cli = new cli();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    exec("uci set network.wgclient.killswitch=\"".$_POST['killswitch']."\"");
	exec("uci commit");
	
	if (get_killswitch_status() == "block") {
		$status = $cli->execute("uci set firewall.@zone[1].masq=0");
	} else {
		$status = $cli->execute("uci set firewall.@zone[1].masq=1");
	}

	$status = $cli->execute("uci commit firewall");
	$status = $cli->execute("/etc/init.d/firewall restart >/dev/null 2>&1 &");

}
redirect('/params.php?success');