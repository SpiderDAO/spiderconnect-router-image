<?php

header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

if ($_SERVER['HTTP_HOST'] == "router.lan") {
	if (!file_exists("/tmp/lowspace")) {
		header('Location: http://' . file_get_contents("/brand/routerdomain.txt"), true, 302);
	} else {
		header('Location: http://' . file_get_contents("/brand/routerdomain.txt")."/extroot.php", true, 302);
	}
	die();
}


ignore_user_abort(true);

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


ini_set('display_errors', 0);
error_reporting(0);
session_start();
require_once('config/app.php');
require_once('library/libraries.php');
require_once('library/helper.php');

$exclude_login = ['login.php', 'activation.php', 'credentials.php', 'wan-setup.php'];
if (!in_array(basename($_SERVER['PHP_SELF']), $exclude_login) && (!isset($_SESSION['router_logged_in']) || $_SESSION['router_logged_in'] != 1)) {
	//non-cli?
	if (isset($_SERVER['REMOTE_ADDR'])) {
		redirect('/login.php');
	}
} elseif (basename($_SERVER['PHP_SELF']) === 'login.php' && (isset($_SESSION['router_logged_in']) && $_SESSION['router_logged_in'] == 1)) {
	//non-cli?
	if (isset($_SERVER['REMOTE_ADDR'])) {
		redirect('/index.php');
	}
}
get_version();
get_vpn_credentials();
check_activation();
check_credentials();
check_vpn_status();





