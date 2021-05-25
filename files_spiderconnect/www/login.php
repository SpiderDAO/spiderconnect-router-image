<?php 

require_once('init.php');
$_SESSION['router_logged_in'] = 1;
redirect('/index.php');
die();