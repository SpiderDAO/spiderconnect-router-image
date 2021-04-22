<?php
require_once '/www/init.php';

$cli = new cli();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['wan-connection'] == "dhcp") {
        $cli->execute("uci set network.wan.proto='dhcp'");
        $cli->execute("uci delete network.wgclient.customdns");
    } elseif ($_POST['wan-connection'] == "static") {
        $cli->execute("uci set network.wan.proto='static'");
        $cli->execute(
            "uci set network.wan.ipaddr='" . $_POST['static-ip'] . "'"
        );
        $cli->execute(
            "uci set network.wan.netmask='" . $_POST['netmask'] . "'"
        );
        $cli->execute(
            "uci set network.wan.gateway='" . $_POST['gateway'] . "'"
        );
        $cli->execute("uci set network.wan.dns='" . $_POST['dns'] . "'");
        $cli->execute(
            "uci set network.wgclient.customdns='" . $_POST['dns'] . "'"
        );
    } elseif ($_POST['wan-connection'] == "pppoe") {
        $cli->execute("uci set network.wan.proto='pppoe'");
        $cli->execute(
            "uci set network.wan.username='" . $_POST['username'] . "'"
        );
        $cli->execute(
            "uci set network.wan.password='" . $_POST['password'] . "'"
        );
        $cli->execute(
            "uci set network.wan.service='" . $_POST['service'] . "'"
        );
    }

    $cli->execute("uci commit network");
    exec("(killall ssh; sleep 1; \
		ubus call network.interface.wan down; \
		ubus call network.interface.wan6 down; \
		ubus call network reload; \
		ubus call network.interface.wan6 up; \
		ubus call network.interface.wan up; ) >/dev/null 2>&1 &");
}
redirect('/wan-setup.php?success');
