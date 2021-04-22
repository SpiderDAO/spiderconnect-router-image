<?php
require_once('/www/init.php');

$cli = new cli();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	exec("uci set network.wgclient.dnsunblocker=\"".$_POST['dnsunblocker']."\"");
	
	if ($_POST['dnsunblocker'] == "custom") {
		exec("uci set network.wgclient.customdns=\"".$_POST['customdns'].", ".$_POST['customdns2']."\"");
	} else {
		exec("uci del network.wgclient.customdns");
	}
	
	exec("uci commit");
	
	set_dns_servers();
	
}
redirect('/paramsdns.php?success');