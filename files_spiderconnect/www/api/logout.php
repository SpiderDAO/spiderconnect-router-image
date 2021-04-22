<?php
require_once('../init.php');

exec('echo "address=/com/10.11.0.1" >> /etc/dnsmasq.conf');
exec('echo "address=/net/10.11.0.1" >> /etc/dnsmasq.conf');
exec('echo "address=/cn/10.11.0.1" >> /etc/dnsmasq.conf');
set_dns_servers();

unlink("/access_token.auth");
unlink("/email.auth");
unlink("/password.auth");

$openvpn = new openvpn();
$openvpn->disconnect();

session_destroy();
redirect('/login.php');