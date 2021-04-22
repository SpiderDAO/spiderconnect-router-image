<?php
require_once('../init.php');

$openvpn = new openvpn();
echo $openvpn->disconnect();

