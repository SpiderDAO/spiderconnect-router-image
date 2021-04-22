<?php

require_once('init.php');

echo '
<!DOCTYPE html>
<html lang="en">

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
	
	<link href="assets/css/web-styles.css" rel="stylesheet">
	<link href="assets/css/web-styles-whitelabel.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
	<!-- All Jquery -->
	<script src="assets/js/lib/jquery/jquery.min.js"></script>
</head>

';