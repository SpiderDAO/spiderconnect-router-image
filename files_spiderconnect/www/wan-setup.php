<?php 

require_once('init.php');

if (strpos($_SERVER['REQUEST_URI'], "scan_ssid") !== false) {
	$ssids = array();
	foreach (array(0, 1) as $iterator) {
		if (isset($_GET['scan_ssid'.$iterator])) {
			
			header("Content-type: text/plain");
			
			if (!file_exists("/tmp/scanssid".$iterator.".txt") && !file_exists("/tmp/tmp_ssid".$iterator.".txt")) {
				$result = shell_exec("iwinfo wlan".$iterator." scan");
			} else if (!file_exists("/tmp/scanssid".$iterator.".txt")) {
				//waiting for first scan results
			} else {
				//we got first scan results
				$result = file_get_contents("/tmp/scanssid".$iterator.".txt");
				@unlink("/tmp/scanssid".$iterator.".txt");
			}
			
			
			
			$result = explode(PHP_EOL.PHP_EOL, $result);
			$ssids['disconnect'] = "";
			//$ssids['status'] = "No wireless WAN is connected";
			$ssids['status'] = "nowwan";
			
			if (file_exists("/sys/class/net/wlan0-1/address") || file_exists("/sys/class/net/wlan1-1/address")) {
				//wireless WAN exists
				$route = shell_exec("ip route get 1.1.1.1");
				if (strpos($route, " wlan1 ") !== false || strpos($route, " wlan0 ") !== false) {
					//$ssids['status'] = "Wireless WAN is connected";
					$ssids['status'] = "wwanok";
				} else {
					//$ssids['status'] = "Wireless WAN is not connected";
					$ssids['status'] = "wwannotok";
				}
				$ssids['disconnect'] = " <i id='disconnect' style='color: black; cursor: pointer;' onclick='disconnect()' class='fa fa-close'></i>";
			}
			
			foreach($result as $line) {
				if (!empty($line)) {
					
					$line = explode(PHP_EOL, $line);
					
					$bssid = explode("Address: ", $line[0])[1];
					$bssid = explode(PHP_EOL, $bssid)[0];
					$ssids['scan'][$bssid]["bssid"] = $bssid;
					
					
					$ssid = explode("ESSID: ", $line[1])[1];
					$ssid = trim($ssid, "\"");
					$ssids['scan'][$bssid]["ssid"] = $ssid;
					
					$channel = explode("Channel: ", $line[2])[1];
					$ssids['scan'][$bssid]["channel"] = $channel;
					
					$signal = explode("Signal: ", $line[3])[1];
					$signal = explode(" ", $signal)[0];
					$ssids['scan'][$bssid]["signal"] = $signal;
					
					$quality = explode("Quality: ", $line[3])[1];
					$ssids['scan'][$bssid]["quality"] = $quality;
					
					$encryption = explode("Encryption: ", $line[4])[1];
					$ssids['scan'][$bssid]["encryption"] = $encryption;
				}
			}
			
		}
		
	}
	echo json_encode($ssids, JSON_PRETTY_PRINT);
}


$GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
if (!empty($GHZ5EXIST)) {
	if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
		$GHZ2=1;
		$GHZ5=0;
	} else {
		$GHZ2=0;
		$GHZ5=1;
	}
} else {
	$GHZ2=0;
}

if (isset($_GET['disconnectwwan'])) {
	
	exec("uci del network.wwan");
	exec("uci commit network");
	
	exec("uci del wireless.wifinet2");
	exec("uci commit wireless");
	
	exec("( 
		sleep 1; wifi reload; \
		/bin/ubus call network.interface.wan down; \
		/bin/ubus call network.interface.wan6 down; \
		/bin/ubus call network reload; \
		/bin/ubus call network.interface.wan6 up; \
		/bin/ubus call network.interface.wan up;) >/dev/null 2>&1 &");
		
	die();
	
} if (isset($_GET['connectwwan']) && isset($_GET['ssid']) && isset($_GET['band']) && isset($_GET['encryption']) && isset($_GET['channel']) && isset($_GET['password'])) {
	
	$band = (int)$_GET['band'];
	
	exec("uci set network.wwan=interface");
	exec("uci set network.wwan.proto='dhcp'");
	exec("uci set network.wwan.mtu='1280'");
	exec("uci commit network");
	
	exec("uci set wireless.wifinet2=wifi-iface");
	exec("uci set wireless.wifinet2.network='wwan'");
	exec("uci set wireless.wifinet2.ssid='".$_GET['ssid']."'");
	if ($_GET['band'] == 2) {
		exec("uci del wireless.default_radio".$GHZ2.".macaddr");
		exec("uci set wireless.wifinet2.device='radio".$GHZ2."'");
		exec("uci set wireless.@wifi-device[".$GHZ2."].channel='".$_GET['channel']."'");
	} else {
		exec("uci del wireless.default_radio".$GHZ5.".macaddr");
		exec("uci set wireless.wifinet2.device='radio".$GHZ5."'");
		exec("uci set wireless.@wifi-device[".$GHZ5."].channel='".$_GET['channel']."'");
	}
	
	exec("uci set wireless.wifinet2.mode='sta'");
	if ($_GET['encryption'] != "none") {
		//WPA2 PSK (CCMP)
		//mixed WPA/WPA2 PSK (TKIP, CCMP)
		if (strpos($_GET['encryption'], "WPA PSK") !== false) {
			exec("uci set wireless.wifinet2.encryption='psk'");
		} else {
			exec("uci set wireless.wifinet2.encryption='psk2'");
		}
		exec("uci set wireless.wifinet2.key='".$_GET['password']."'");
	} else {
		exec("uci set wireless.wifinet2.encryption='none'");
		exec("uci del wireless.wifinet2.key");
	}
	exec("uci commit wireless");
	exec("wifi reload");
	
	echo $GHZ2."-".$GHZ5."-".$_GET['band'];
	
	die();
}

#we making scan quicker
foreach (array(0, 1) as $iterator) {
	exec("(rm /tmp/scanssid".$iterator.".txt; iwinfo wlan".$iterator." scan > /tmp/tmp_ssid".$iterator.".txt && mv /tmp/tmp_ssid".$iterator.".txt /tmp/scanssid".$iterator.".txt) > /dev/null 2>&1 &");
}

$wanconnection = trim(exec("uci get network.wan.proto"));
require_once('layout/content.php');

echo '
<style>

div#goback a {
	padding: 0;
}

li {
	color: white;
}

nav ul{
	/*height:110px;*/
	overflow:hidden;
	overflow-y:scroll;
}

body {
	line-height: 0px;
}

li, p {
	line-height: 16px;
	margin-bottom: 0px;
}
#ssids li{
	display: flex!important;
   margin-left: 20px!important;
    margin-right: 10px!important;
    justify-content: space-between!important;
	margin-bottom:6px
}
.btn-join{
	background-color: #016c66;
    color: white!important;
    border: 1px solid;
    padding: 4px 10px;
	margin-right:10px;
border-radius: 15px;}


	
</style>
<body class="overflow">
<div class="wapper-wb">

    ';
require_once('layout/header.php');
echo '
    <div class="main-container center-content">
        <div class="container">
            <div class="row">
                <div class="remote-network">
                    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                        <div id="goback"><a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                        </div>
                        <div class="remote-form">

                            ';
if (isset($_GET['success'])) { 
echo '
                                <div class="remote-head remote-head-1">
                                    <h4 data-i18n="lng.paramsupdated">Parameters have been successfully updated.</h4>
                                </div>
                            ';
} else {
echo '
								<div class="remote-head remote-head-1">
									<h3 data-i18n="lng.setupcablewan">Setup Cable WAN Connection</h3>
									<div class="remote-form-inn">
									<form id="wanip" class="" action="/api/wanparams.php" method="post">
										<div class="form-group" id="wan-connection">
											<select class="form-control placeholder-wh" name="wan-connection">
												<option value="dhcp"   '.($wanconnection ==   "dhcp"?"selected":"").' >DHCP</option>
												<option value="static" '.($wanconnection == "static"?"selected":"").' data-i18n="lng.staticip">Static IP</option>
												<option value="pppoe"  '.($wanconnection ==  "pppoe"?"selected":"").' >PPPoE</option>
											</select>
										</div>
										<div id="static-params">
											<div class="form-group">
												<input type="text" class="form-control" name="static-ip"
													data-i18n="[placeholder]lng.ipv4placeholder"
													placeholder="IPv4 address - 192.168.1.2" value="'.trim(exec("uci get network.wan.ipaddr")).'">
											</div>
											<div class="form-group">
												<input type="text" class="form-control" name="netmask"
													data-i18n="[placeholder]lng.netmaskplaceholder"
													placeholder="IPv4 netmask - 255.255.255.0" value="'.trim(exec("uci get network.wan.netmask")).'">
											</div>
											<div class="form-group">
												<input type="text" class="form-control" name="gateway"
													data-i18n="[placeholder]lng.gatewayplaceholder"
													placeholder="IPv4 gateway - 192.168.1.1" value="'.trim(exec("uci get network.wan.gateway")).'">
											</div>
											<div class="form-group">
												<input type="text" class="form-control" name="dns"
													data-i18n="[placeholder]lng.dnsplaceholder"
													placeholder="DNS server - 8.8.8.8" value="'.trim(exec("uci get network.wan.dns")).'">
											</div>
										</div>
										<div id="pppoe-params">
											<div class="form-group">
												<input type="text" class="form-control" name="username"
													   placeholder="PPPoE PAP/CHAP username" value="'.trim(exec("uci get network.wan.username")).'">
											</div>
											<div class="form-group">
												<input type="text" class="form-control" name="password"
													   placeholder="PPPoE PAP/CHAP password" value="'.trim(exec("uci get network.wan.password")).'">
											</div>
											<div class="form-group">
												<input type="text" class="form-control" name="service"
													   placeholder="PPPoE Service Name" value="'.trim(exec("uci get network.wan.service")).'">
											</div>
											
										</div>
									</form>
									<h3 data-i18n="lng.setupwifiwan">Setup Wireless WAN Connection</h3>
									<h4 id="status" data-i18n="lng.detectingstatus">Detecting status...</h4>
									<nav>
										<ul id="ssids">
											<li class="fakessid">...<li>
											<li class="fakessid">...<li>
											<li class="fakessid">...<li>
											<li class="fakessid">...<li>
										</ul>
									</nav>
									<div class="form-group">
										<button id="submit" type="submit" class="btn btn-default" data-i18n="lng.savechanges">Save Changes</button>
									</div>

										';
}
echo '
									
									<script>
										
										$( "#submit" ).click(function() {
											$( "#wanip" ).submit();
										});
										
										var firstrun = 1;
										
										function sortList() {
										  var list, i, switching, b, shouldSwitch;
										  list = document.getElementById("ssids");
										  switching = true;
										  /* Make a loop that will continue until
										  no switching has been done: */
										  while (switching) {
											// Start by saying: no switching is done:
											switching = false;
											b = list.getElementsByTagName("LI");
											// Loop through all list items:
											for (i = 0; i < (b.length - 1); i++) {
											  // Start by saying there should be no switching:
											  shouldSwitch = false;
											  /* Check if the next item should
											  switch place with the current item: */
											  if (b[i].innerHTML.toLowerCase() > b[i + 1].innerHTML.toLowerCase()) {
												/* If next item is alphabetically lower than current item,
												mark as a switch and break the loop: */
												shouldSwitch = true;
												break;
											  }
											}
											if (shouldSwitch) {
											  /* If a switch has been marked, make the switch
											  and mark the switch as done: */
											  b[i].parentNode.insertBefore(b[i + 1], b[i]);
											  switching = true;
											}
										  }
										}
										
										function scan_ssid(band)
										{
											
											
											$.ajax({
												url: "/wan-setup.php?scan_ssid"+band+"=1&_"+ (new Date).getTime(),
												timeout: 60000 // sets timeout to 20 seconds
											}).done(function (e) {
												
												try {
													e=JSON.parse(e);
													
													
													$.each(e.scan, function(i, val) {
														
														var id = i+band;
														id = id.replace(/:/g, "");
														
														if ($("#"+id).length == 0 && id != 1 && id != 0) {  
															$("#ssids").append(\'<li id="\'+id+\'"><span>\'+val.ssid+\' <i class="fa fa-question-circle" title="\'+(band==\'.$GHZ2.\'?"2.4GHz":"5GHz")+\', \'+val.bssid+\', Encryption \'+val.encryption+\', Channel \'+val.channel+\', Signal \'+val.signal+\' dBm, Quality \'+val.quality+\'"></i></span> <button class="btn-join" onclick="connectwwan(\\\'\'+val.ssid+\'\\\', \'+(band==\'.$GHZ2.\'?"2":"5")+\', \\\'\'+val.encryption+\'\\\', \'+val.channel+\')" style="color: black;" data-i18n="lng.joinnetwork">Join network</button></li>\');
														}
														
													});
													
													
													sortList(); 
													
													var ssidcount = document.querySelectorAll("#ssids li").length
													
													if ($("#status").html() != e.status) {
														e.status = i18next.t("lng." + e.status);
														$("#status").html(e.status + e.disconnect + "<br/>" + ssidcount + " " + i18next.t("lng.ssidsdetected"));
													}
													
												} catch (e) {
												
													$("#status").html(i18next.t("lng.routerisnotaccessible"));
												
												};
											}).fail(function () {
												
												$("#status").html(i18next.t("lng.routerisnotaccessible"));
												
											}).always(function () {
												
												if (firstrun == 1) {
													$( "#ssids li" ).remove();
													firstrun = 0;
												}
												
												setTimeout(function(){
													scan_ssid(band);
												}, 1);
												
											});
										}
										
										function disconnect() {
											if (confirm(i18next.t("lng.confirmdisconnectwifiwan"))) {
												$.get( "/wan-setup.php?disconnectwwan=1", function( data ) {
													alert("Done");
												});
											}
										}
										
										function connectwwan(ssid, band, encryption, channel) {
											
											var password = "";
											if (encryption != "none") {
												password = prompt(i18next.t("lng.enterssidpassword"), "");
											}
											
											if (password == null) {
												return;
											}
											
											if (password.length < 8 || password.length > 63) {
												alert(i18next.t("lng.ssidpasswordlength"));
												return;
											}
											
											$.get( "/wan-setup.php?connectwwan=1&ssid="+encodeURI(ssid)+"&band="+band+"&encryption="+encodeURI(encryption)+"&channel="+channel+"&password="+encodeURI(password), function( data ) {
												alert("OK");
											});
											
										}
										
										$(document).ready(function($)
										{
											scan_ssid(0);
											scan_ssid(1);
										})
										
										$("#wan-connection").on("click", function () {
											var wan = $("#wan-connection option:selected").val();
											if (wan == "dhcp") {
												$("#pppoe-params").hide();
												$("#static-params").hide();
											} else if (wan == "static") {
												$("#pppoe-params").hide();
												$("#static-params").show();
											} else if (wan == "pppoe") {
												$("#pppoe-params").show();
												$("#static-params").hide();
											}
											
										})
										
										$("#wan-connection").trigger("click");
										
									</script>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    ';
require_once('layout/footer.php');
 echo '
</body>
</html>
';