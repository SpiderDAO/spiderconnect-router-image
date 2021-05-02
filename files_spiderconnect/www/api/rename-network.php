<?php
require_once('/www/init.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
	if (!empty($GHZ5EXIST)) {
		if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
			$GHZ2=1;
			$GHZ5=0;
		} else {
			$GHZ2=0;
			$GHZ5=1;
		}
		
		exec("uci set wireless.@wifi-iface[$GHZ5].ssid='".$_POST['ssid5']."'");
		exec("uci set wireless.@wifi-iface[$GHZ5].key='".$_POST['password5']."'");
		
		if (isset($_POST['enable58']) && $_POST['enable58'] == "on") {
			exec("uci set wireless.@wifi-iface[$GHZ5].disabled='0'");
		} else {
			exec("uci set wireless.@wifi-iface[$GHZ5].disabled='1'");
		}
		
		if (isset($_POST['isolation58']) && $_POST['isolation58'] == "on") {
			exec("uci set wireless.default_radio$GHZ5.isolate='1'");
		} else {
			exec("uci set wireless.default_radio$GHZ5.isolate='0'");
		}
		
		exec("uci set wireless.@wifi-device[$GHZ5].channel='".$_POST['channel58']."'");
		
		if ($_POST['width58'] == "HT40") {
			exec("uci set wireless.radio$GHZ5.htmode='HT40'");
			exec("uci set wireless.radio$GHZ5.noscan='1'");
		} else if ($_POST['width58'] == "VHT80") {
			exec("uci set wireless.radio$GHZ5.htmode='VHT80'");
			exec("uci set wireless.radio$GHZ5.noscan='1'");
		} else if ($_POST['width58'] == "auto") {
			exec("uci set wireless.radio$GHZ5.htmode='VHT80'");
			exec("uci set wireless.radio$GHZ5.noscan='0'");
		} else {
			exec("uci set wireless.radio$GHZ5.htmode='".$_POST['width58']."'");
			exec("uci set wireless.radio$GHZ5.noscan='0'");
		}
		
		#####
		
		exec("uci set wireless.@wifi-iface[$GHZ2].ssid='".$_POST['ssid2']."'");
		exec("uci set wireless.@wifi-iface[$GHZ2].key='".$_POST['password2']."'");
		
		if (isset($_POST['enable24']) && $_POST['enable24'] == "on") {
			exec("uci set wireless.@wifi-iface[$GHZ2].disabled='0'");
		} else {
			exec("uci set wireless.@wifi-iface[$GHZ2].disabled='1'");
		}
		
		if (isset($_POST['isolation24']) && $_POST['isolation24'] == "on") {
			exec("uci set wireless.default_radio$GHZ2.isolate='1'");
		} else {
			exec("uci set wireless.default_radio$GHZ2.isolate='0'");
		}
		
		exec("uci set wireless.@wifi-device[$GHZ2].channel='".$_POST['channel24']."'");
		
		if ($_POST['width24'] == "HT40") {
			exec("uci set wireless.radio$GHZ2.htmode='HT40'");
			exec("uci set wireless.radio$GHZ2.noscan='1'");
		} else if ($_POST['width24'] == "auto") {
			exec("uci set wireless.radio$GHZ2.htmode='HT40'");
			exec("uci set wireless.radio$GHZ2.noscan='0'");
		} else {
			exec("uci set wireless.radio$GHZ2.htmode='".$_POST['width24']."'");
			exec("uci set wireless.radio$GHZ2.noscan='0'");
		}
		
	} else {
		#only 2 ghz
		exec("uci set wireless.@wifi-iface[0].ssid='".$_POST['ssid2']."'");
		exec("uci set wireless.@wifi-iface[0].key='".$_POST['password2']."'");
		
		if (isset($_POST['enable24']) && $_POST['enable24'] == "on") {
			exec("uci set wireless.@wifi-iface[0].disabled='0'");
		} else {
			exec("uci set wireless.@wifi-iface[0].disabled='1'");
		}
		
		if (isset($_POST['isolation24']) && $_POST['isolation24'] == "on") {
			exec("uci set wireless.default_radio0.isolate='1'");
		} else {
			exec("uci set wireless.default_radio0.isolate='0'");
		}
		
		exec("uci set wireless.@wifi-device[0].channel='".$_POST['channel24']."'");
		
		if ($_POST['width24'] == "HT40") {
			exec("uci set wireless.radio0.htmode='HT40'");
			exec("uci set wireless.radio0.noscan='1'");
		} else if ($_POST['width24'] == "auto") {
			exec("uci set wireless.radio0.htmode='HT40'");
			exec("uci set wireless.radio0.noscan='0'");
		} else {
			exec("uci set wireless.radio0.htmode='".$_POST['width24']."'");
			exec("uci set wireless.radio0.noscan='0'");
		}
	}
	
	exec("uci commit wireless");

	$cli = new cli();
    $cli->execute('wifi');

}
redirect('/rename-network.php?success');