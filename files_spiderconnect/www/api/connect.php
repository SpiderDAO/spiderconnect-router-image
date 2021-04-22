<?php

require_once('../init.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['server_id'];
	$openvpn = new openvpn();
	echo $openvpn->change_server($id);
}
