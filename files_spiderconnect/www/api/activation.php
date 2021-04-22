<?php

require_once('../init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $spidervpn = new spidervpn();
    $response = $spidervpn->check_credentials($email, $password);
	
    if ($response) {
        if (!empty($response->status) && $response->status === "error") {
            $cli = new cli;
            $cli->execute('rm /*.auth');
			
            $openvpn = new openvpn();
            $openvpn->disconnect();
			
            redirect('/activation.php?invalid=' . $response->message);
        } else if (!empty($response->access_token)) {
			
			exec("sed -i '/\/10.11.0.1/d' /etc/dnsmasq.conf");
			set_dns_servers();
			
			file_put_contents("/access_token.auth", $response->access_token);
			file_put_contents("/email.auth", $email);
			file_put_contents("/password.auth", $password);
			
			$_SESSION['router_logged_in'] = 1;
			
			//sync sync
			file_get_contents("http://127.0.0.1/api/credentials.php");
			
			redirect('/index.php');

        } else {
            redirect('/activation.php?wrong');
        }

    } else {
        redirect('/activation.php?noconnection');
    }

}
redirect('/activation.php');