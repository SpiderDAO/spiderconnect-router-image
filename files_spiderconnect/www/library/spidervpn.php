<?php

class spidervpn
{
    public function check_credentials($email, $password)
    {
        $response = $this->signin($email, $password);
        return $response;
    }

    private function signin($email, $password)
    {
        $curl = new curl();
        $response = $curl->execute(SPIDERVPN_API_URL . 'auth/login', 'POST', [
            'email' => $email,
            'password' => $password,
        ]);

        file_put_contents(
            "/tmp/signin.flag",
            $wgprofile . "\n" . $email . "\n" . $password
        );

        return json_decode($response);
    }

    public function get_updates()
    {
        $version = file_get_contents('/www/version.txt');
        $curl = new curl();
        $response = $curl->execute(
            SPIDERVPN_API_URL . "get-router-updates",
            'POST',
            ['version' => $version, 'key' => FASTESTVPN_API_KEY]
        );
        $response = json_decode($response);
        if ($response) {
            if ($response->update === 1) {
                return (object) [
                    'version' => $response->version,
                    'update_script' => $response->script,
                ];
            }
        }
        return false;
    }

    public function servers()
    {
        $server_list = [];
        $servers = json_decode(
            file_get_contents("/www/config/locations.json"),
            true
        );
        foreach ($servers as $server) {
            $params = [$server['locname'] => $server];
            $server_list = array_merge($server_list, $params);
        }

        ksort($server_list);
        return $server_list;
    }

    public function fetch_locations()
    {
        $curl = new curl();
        $response = $curl->execute(
            SPIDERVPN_API_URL . 'authentication/locations',
            'GET',
            [
                'Content-Type' => "application/json",
                'X-Requested-With' => "XMLHttpRequest",
            ]
        );
        $response = json_decode($response);
        if ($response->error === 0) {
            return $response->servers;
        } else {
            return $response;
        }
    }
}
