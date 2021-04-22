<?php
define('ROUTER_PASSWORD_PATH', __DIR__ . '/password.txt');
define('SPIDERVPN_API_KEY', '');
define('SPIDERVPN_API_URL', '');
define('SPIDERVPN_API_BACKUP_URL', '');
define('SPIDERVPN_WALLET_API_URL', '');

$spider_id =
    file_get_contents("/email.auth") . "@" . file_get_contents("/tmp/wanmac");

$model = trim(file_get_contents("/tmp/sysinfo/board_name"));
if ($model == "zbt-we1326") {
    //SpiderConnect Pro
    $spdrpartition = "/dev/mtd1";
    $offset = 1024 * 63;
}
if (!empty($spdrpartition)) {
    $cur_uboot_data = file_get_contents($spdrpartition, false, null, $offset);
    $keys = substr($cur_uboot_data, strlen("SPDR!"));
    $keys = str_replace(urldecode("%FF"), "", $keys);
    $keys = @json_decode($keys, true);

    $phrase = $keys['mnemonic'];
    $address = $keys['address'];

    file_put_contents("/tmp/address", $address);
    file_put_contents("/tmp/phrase", $phrase);
}
