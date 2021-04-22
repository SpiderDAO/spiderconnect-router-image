<?php

class openvpn
{
    private $cli;
    private $path = '/etc/init.d/openvpn';

    public function __construct()
    {
        $this->cli = new cli();
    }

    public function change_server($server)
    {
        ignore_user_abort(true);

        touch('/tmp/lic.locker');

        $wgprofile = get_location_keys($server);

        touch('/tmp/lic.locker');
        chmod("/tmp/lic.locker", 0777);
        $locker = fopen('/tmp/lic.locker', 'r+');

        @unlink("/tmp/error.flag");

        if (isset($wgprofile['message'])) {
            file_put_contents("/tmp/error.flag", $wgprofile['message']);

            //we must send error message to user
            return json_encode(
                [
                    'name' => $this->get_server_detail()['name'],
                    'waited' => $waited,
                    'flag' => $this->get_server_detail()['name'],
                ],
                JSON_PRETTY_PRINT
            );
        } elseif (
            $wgprofile !== false &&
            !empty($wgprofile) &&
            $wgprofile != "null"
        ) {
            $servers = (array) (new spidervpn())->servers();
            $params = $servers[$server];

            $WG_IF = "wg0";
            $WG_ADDR = $wgprofile['Interface']['Address'];
            $WG_KEY = $wgprofile['Interface']['PrivateKey'];
            $WG_PORT = $wgprofile['Interface']['ListenPort'];
            $WG_DNS = $wgprofile['Interface']['dns'];

            $WG_PUB = $wgprofile['Peer']['PublicKey'];
            $WG_PSK = $wgprofile['Peer']['PresharedKey'];
            $WG_ALLOWED = $wgprofile['Peer']['AllowedIPs'];
            $WG_ENDPOINT_HOST = explode(":", $wgprofile['Peer']['Endpoint'])[0];
            $WG_ENDPOINT_PORT = @explode(
                ":",
                $wgprofile['Peer']['Endpoint']
            )[1];

            $cli = new cli();

            # To prevent traffic leakage outside the VPN-tunnel
            if (get_killswitch_status() == "block") {
                $status = $this->cli->execute(
                    "uci set firewall.@zone[1].masq=0"
                );
            } else {
                $status = $this->cli->execute(
                    "uci set firewall.@zone[1].masq=1"
                );
            }
            $status = $this->cli->execute("uci commit firewall");
            $status = $this->cli->execute(
                "(sleep 3; /etc/init.d/firewall restart) >/dev/null 2>&1 &"
            );

            # Configure network
            $status = $cli->execute("uci -q delete network.$WG_IF");
            $status = $cli->execute("uci set network.$WG_IF=\"interface\"");
            $status = $cli->execute(
                "uci set network.$WG_IF.proto=\"wireguard\""
            );
            $status = $cli->execute(
                "uci set network.$WG_IF.private_key=\"$WG_KEY\""
            );
            $status = $cli->execute(
                "uci set network.$WG_IF.listen_port=\"$WG_PORT\""
            );
            $status = $cli->execute(
                "uci add_list network.$WG_IF.addresses=\"$WG_ADDR\""
            );
            $status = $cli->execute("uci set network.$WG_IF.mtu=\"1300\"");
            $status = $cli->execute("uci commit network");

            # Add VPN peers
            $killswitch = trim(
                $cli->execute("uci get network.wgclient.killswitch")
            );
            $dnsunblocker = trim(
                $cli->execute("uci get network.wgclient.dnsunblocker")
            );
            $customdns = trim(
                $cli->execute("uci get network.wgclient.customdns")
            );

            $status = $cli->execute("uci -q delete network.wgclient");
            $status = $cli->execute(
                "uci set network.wgclient=\"wireguard_$WG_IF\""
            );
            $status = $cli->execute(
                "uci set network.wgclient.public_key=\"$WG_PUB\""
            );
            $status = $cli->execute(
                "uci set network.wgclient.preshared_key=\"$WG_PSK\""
            );
            $status = $cli->execute(
                "uci set network.wgclient.name=\"$server\""
            );
            $status = $cli->execute(
                "uci set network.wgclient.endpoint_host=\"$WG_ENDPOINT_HOST\""
            );
            $status = $cli->execute(
                "uci set network.wgclient.endpoint_port=\"$WG_ENDPOINT_PORT\""
            );
            $status = $cli->execute(
                "uci add_list network.wgclient.allowed_ips=\"$WG_ALLOWED\""
            );
            $status = $cli->execute(
                "uci set network.wgclient.persistent_keepalive=\"25\""
            );
            $status = $cli->execute(
                "uci set network.wgclient.route_allowed_ips=\"1\""
            );
            $status = $cli->execute(
                "uci set network.wgclient.killswitch=\"" . $killswitch . "\""
            );
            $status = $cli->execute(
                "uci set network.wgclient.dnsunblocker=\"" .
                    $dnsunblocker .
                    "\""
            );
            if (trim($customdns) !== "") {
                $status = $cli->execute(
                    "uci set network.wgclient.customdns=\"" . $customdns . "\""
                );
            }
            $status = $cli->execute("uci commit network");

            $this->enable();
            set_dns_servers();

            $waited = $this->get_status();

            @flock($locker, LOCK_UN);

            file_put_contents(
                "/tmp/vpnstatus.flag",
                $this->get_server_detail()['name']
            );

            return json_encode(
                [
                    'name' => $this->get_server_detail()['name'],
                    'waited' => $waited,
                    'flag' => $this->get_server_detail()['name'],
                ],
                JSON_PRETTY_PRINT
            );
        } else {
            file_put_contents(
                "/tmp/error.flag",
                "Last error: Cant get VPN key for location.
<br/><br/>
Step 1) Log in to spidervpn.org then click on services, and check if your service is activated, canceled, or terminated.
<br/><br/>
Step 2) Change your password by clicking <a href='https://spidervpn.org/clientarea/index.php/user/password' style='color: white;' target='_blank'>here</a> - remove special characters from your password.
<br/><br/>
Step 3) Factory reset your router by clicking <a href='/factoryreset.php' style='color: white;'>here</a>, and then reactivate your router."
            );

            //we must send error message to user
            return json_encode(
                [
                    'name' => $this->get_server_detail()['name'],
                    'waited' => $waited,
                    'flag' => $this->get_server_detail()['name'],
                ],
                JSON_PRETTY_PRINT
            );
        }
    }

    public function get_server_detail()
    {
        $servers = (array) (new spidervpn())->servers();

        $cli = new cli();
        $name = trim($cli->execute("uci get network.wgclient.name"));

        return $servers[$name];
    }

    public function disconnect()
    {
        ignore_user_abort(true);

        if (get_killswitch_status() == "block") {
            $status = $this->cli->execute("uci set firewall.@zone[1].masq=0");
        } else {
            $status = $this->cli->execute("uci set firewall.@zone[1].masq=1");
        }
        $status = $this->cli->execute("uci commit firewall");
        $status = $this->cli->execute(
            "(sleep 3; /etc/init.d/firewall restart) >/dev/null 2>&1 &"
        );

        exec("uci set network.wgclient.name=\"\"");
        exec("uci commit network");

        set_dns_servers(true);

        $this->disable();
        $this->stop();

        return 1;
    }

    public function is_active()
    {
        $cli = new cli();

        $status = json_decode($cli->execute('ifstatus wg0'));
        $routes = $cli->execute('ip route | grep default');

        return $status->up == false || strpos($routes, "wg0") === false ? 0 : 1;
    }

    public function get_status()
    {
        $timeout = 15;

        $seconds = 0;
        $cli = new cli();
        do {
            sleep(1);
            $seconds++;
        } while (
            (json_decode($cli->execute('ifstatus wg0')) == false ||
                strpos($cli->execute('ip route | grep default'), "wg0") ===
                    false) &&
            $seconds < $timeout
        );

        if ($seconds >= $timeout) {
            $this->restart();
        }

        return $seconds;
    }

    private function stop()
    {
        $this->command('ubus call network.interface.wg0  down;');
    }

    private function enable()
    {
        $this->command(
            "uci set network.wg0.disabled=\"0\"; uci commit network;"
        );
    }

    private function disable()
    {
        $this->command(
            "uci set network.wg0.disabled=\"1\"; uci commit network;"
        );
    }

    public function restart()
    {
        $this->command(
            '(ubus call network.interface.wg0 down; ubus call network.interface.wan down; ubus call network.interface.wan up; ubus call network.interface.wg0 up;)  >/dev/null 2>&1 &'
        );
    }

    public function start()
    {
        $this->command('ubus call network.interface.wg0 up');
    }

    private function command($command)
    {
        $this->cli->execute($command);
    }
}
