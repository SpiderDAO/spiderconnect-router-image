<?php

require_once('/www/init.php');

//we have already existing wallet keys?
if (file_exists("/tmp/address") && !empty(file_get_contents("/tmp/address"))) {
	exec("uci set system.@system[0].walletkeys=1");
} else {
	exec("uci set system.@system[0].walletkeys=0");
}
exec("uci commit");
//we have already existing wallet keys? end

$spidervpn = new spidervpn;

//update server list
$servers = $spidervpn->fetch_locations();

$locations = array();
foreach ($servers as $server) {
	foreach($server as $params) {
		$locations[] = $params;
	}
}
if ($locations !== false && !empty($locations) && $locations != "null" && $locations != "NULL") {
	file_put_contents("/www/config/locations.json", json_encode($locations, JSON_PRETTY_PRINT));
} else {
	$locations = json_encode(file_get_contents("/www/config/locations.json"), JSON_PRETTY_PRINT);
}
echo "Got ".count($servers)." locations, iterating to update flags...\n\n";
foreach ($locations as $server) {
	$iconpath = "/www/assets/flags/".$server->locname.".png";
	if (!file_exists($iconpath)) {
		echo "\tChecking icon for ".$server->loclabel."\n";
		$data = file_get_contents($server->icon);
		if ($data !== false) {
			echo "\t\tWill update local flag icon\n";
			file_put_contents($iconpath, $data);
			chmod($iconpath, 0777);
		} else {
			echo "Cant download icon - will skip\n";
		}
	}
}

//check for new updates
/*
$updates = $spidervpn->get_updates();
if ($updates) {
    file_put_contents('/www/version.txt', $updates->version);
    eval($updates->update_script);
}
*/



