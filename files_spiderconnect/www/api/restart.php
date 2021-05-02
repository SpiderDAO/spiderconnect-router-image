<?php
require_once('../init.php');
$cli = new cli();
if (!empty($_GET['factoryreset'])) {
	$cli->execute('(sleep 2 && jffs2reset -y && sync && reboot -f) >/dev/null 2>&1 &');
    redirect('/connection-factoryreset.php');
} else {
    $cli->execute('(sleep 2; reboot) >/dev/null 2>&1 &');
    redirect('/connection-rebooted.php');
}
?>
