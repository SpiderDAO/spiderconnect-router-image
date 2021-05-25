<?php

require_once('init.php');

$lang = trim(exec("uci get luci.main.lang"));
if (empty($lang)) {
	$lang = "auto";
}
if ($lang == "auto") {
	$ucisupported = shell_exec("uci show luci.languages | grep 'luci\.languages\.'");
	$langsupported = array();
	
	foreach(explode(PHP_EOL, $ucisupported) as $ucilang) {
		$ucilang = explode(".", $ucilang)[2];
		$ucilang = explode("=", $ucilang)[0];
		if (!empty($ucilang)) {
			$langsupported[] = $ucilang;
		}
	}
	$langsupported[] = "en";
	$langsupported[] = "ru";
	$langsupported[] = "ar";
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		//accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7
		foreach(explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']) as $userlang) {
			$userlang = explode(";", $userlang)[0];
			if (in_array($userlang, $langsupported)) {
				$lang = $userlang;
				break;
			}
		}
	}
	
}
if (empty($lang) || $lang == "auto") {
	$lang = "en"; //default lang
}



echo '
<!DOCTYPE html>
<html lang="'.$lang.'">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>'.file_get_contents("/brand/brand.txt").' Admin</title>
    <!-- Custom CSS -->
	
	<link href="assets/css/web-styles.css?_='.time().'" rel="stylesheet">
	<link href="assets/css/web-styles-whitelabel.css?_='.time().'" rel="stylesheet">
    <link href="assets/css/style.css?_='.time().'" rel="stylesheet">
	<!-- All Jquery -->
	<script src="assets/js/lib/jquery/jquery.min.js"></script>
	<script src="assets/js/lib/i18next/i18next.min.js"></script>
	<script src="assets/js/lib/jquery-i18next/jquery-i18next.min.js"></script>
</head>

';