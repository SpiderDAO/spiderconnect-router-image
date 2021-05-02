<?php

set_time_limit(0);
header("Content-type: text/plain");
header("Content-Encoding: none");

ob_start();
ob_implicit_flush();
set_time_limit(0);

if (!headers_sent()) {
	// Disable gzip in PHP.
	ini_set('zlib.output_compression', 0);
	// Force disable compression in a header.
	// Required for flush in some cases (Apache + mod_proxy, nginx, php-fpm).
	header('Content-Encoding: none');
}

require_once('library/helper.php');

execwithprogress("killall wget 2>/dev/null; sh /speedtest.sh ", true);

die();

?>