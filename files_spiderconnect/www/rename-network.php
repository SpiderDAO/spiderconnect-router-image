<?php require_once('layout/content.php');
 echo '

<style>

div#goback a {
	padding: 0;
}

</style>

<div class="row">
    <div class="remote-network">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
			<div id="goback"><a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
			</div>
            <div class="remote-form">

                ';
if (isset($_GET['success'])) {
echo '
                    <div class="remote-head remote-head-1">
                        <h4>Network Name & Password has been successfully updated.</h4>
                    </div>
                ';
} else {
echo '
                    <div class="remote-head remote-head-1">
                        <h3>WiFi Setup</h3>
                        <h4>Personalize your WiFi Name and set an easy-to-remember password</h4>
                    </div>
                    <div class="remote-form-inn">
                        <form class="" action="/api/rename-network.php" method="post">
                            <table width="100%">
                                <tr>
                                    <td width="50%"
                                        style="vertical-align: top; '.(file_exists("/sys/class/net/wlan1/address") ? "" : "display: none;").'">
                                        <div style="text-align: center;">
                                            <h4 style="color: white;text-align:center">5.8 Ghz</h4>

                                            <select class="form-control placeholder-wh" name="channel58"
                                                    style="text-align-last:center; ">
                                                <option value="auto" '.(get_wifi_channel5() == "auto" ? "selected" : "").'>
                                                    Auto Channel
                                                </option>
                                                ';

                                                $GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
                                                if (!empty($GHZ5EXIST)) {
                                                    if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
                                                        $GHZ2 = 1;
                                                        $GHZ5 = 0;
                                                    } else {
                                                        $GHZ2 = 0;
                                                        $GHZ5 = 1;
                                                    }
                                                } else {
                                                    $GHZ2 = 0;
                                                }

                                                $activechannel = get_wifi_channel5();

                                                $availablechannels = array();
                                                exec("iw phy" . $GHZ5 . " info | grep dBm | grep -v -e 'no IR' | awk '{print $4}'", $availablechannels);
                                                foreach ($availablechannels as $channel) {
                                                    $channel = trim($channel, "[]");
                                                    echo '<option value="' . $channel . '" ' . ($activechannel == $channel ? "selected" : "") . '>Channel ' . $channel . '</option>' . "\n";
                                                }

                                                echo '
                                            </select>

                                            <select class="form-control placeholder-wh" name="width58"
                                                    style="text-align-last:center;  margin-top: 10px;">
                                                <option value="auto" '.(get_wifi_width5() == "auto" ? "selected" : "").'>
                                                    Auto Width
                                                </option>
                                                <option value="HT20" '.(get_wifi_width5() == "HT20" ? "selected" : "").'>
                                                    Width 20MHz
                                                </option>
                                                <option value="HT40" '.(get_wifi_width5() == "HT40" ? "selected" : "").'>
                                                    Width 40MHz
                                                </option>
                                                <option value="VHT80" '.(get_wifi_width5() == "VHT80" ? "selected" : "").'>
                                                    Width 80MHz
                                                </option>
                                            </select>

                                            <input type="checkbox" id="enable58"
                                                   name="enable58" '.(get_wifi_enabled5() ? "" : "checked").'>
                                            <label for="enable58" style="color: white; font-weight: 100;">Enable/Disable
                                                SSID</label>
                                        </div>
                                        <div style="text-align: center;">
                                            <input type="checkbox" id="isolation58"
                                                   name="isolation58" '.(get_wifi_isolation5() ? "checked" : "").'>
                                            <label title="Isolates wireless clients from each other" for="isolation58"
                                                   style="color: white; font-weight: 100;">WiFi Client Isolation</label>

                                            <input type="text" class="form-control placeholder-wh" name="ssid5"
                                                   value="'.get_wifi_ssid5().'"
                                                   placeholder="Name your network">
                                        </div>
										<div class="form-group">
										</div>
                                        <div class="form-group">
                                            <input type="text" class="form-control placeholder-wh" name="password5"
                                                   value="'.get_wifi_password5().'"
                                                   placeholder="Password">
                                        </div>
                                    </td>
                                    <td width="50%" style="">
                                        <div class="form-group">
                                            <h4 style="color: white;text-align:center;">2.4 Ghz</h4>

                                            <select class="form-control placeholder-wh" name="channel24"
                                                    style="text-align-last:center; ">
                                                <option value="auto" '.(get_wifi_channel2() == "auto" ? "selected" : "").'>
                                                    Auto Channel
                                                </option>
                                                ';
												
												

                                                $GHZ5EXIST = shell_exec("iw phy1 info | grep phy1");
                                                if (!empty($GHZ5EXIST)) {
                                                    if (!empty(shell_exec("iw phy1 info | grep 2437"))) {
                                                        $GHZ2 = 1;
                                                        $GHZ5 = 0;
                                                    } else {
                                                        $GHZ2 = 0;
                                                        $GHZ5 = 1;
                                                    }
                                                } else {
                                                    $GHZ2 = 0;
                                                }

                                                $activechannel = get_wifi_channel2();

                                                $availablechannels = array();
                                                exec("iw phy" . $GHZ2 . " info | grep dBm | grep -v -e 'no IR' | awk '{print $4}'", $availablechannels);
                                                foreach ($availablechannels as $channel) {
                                                    $channel = trim($channel, "[]");
                                                    echo '<option value="' . $channel . '" ' . ($activechannel == $channel ? "selected" : "") . '>Channel ' . $channel . '</option>' . "\n";
                                                }

                                                echo '
                                            </select>

                                            <select class="form-control placeholder-wh" name="width24"
                                                    style="text-align-last:center; margin-top: 10px;">
                                                <option value="auto" '.(get_wifi_width2() == "auto" ? "selected" : "").'>
                                                    Auto Width
                                                </option>
                                                <option value="HT20" '.(get_wifi_width2() == "HT20" ? "selected" : "").'>
                                                    Width 20MHz
                                                </option>
                                                <option value="HT40" '.(get_wifi_width2() == "HT40" ? "selected" : "").'>
                                                    Width 40MHz
                                                </option>
                                            </select>

                                            <div style="text-align: center;">
                                                <input type="checkbox" id="enable24"
                                                       name="enable24" '.(get_wifi_enabled2() ? "" : "checked").'>
                                                <label for="enable24" style="color: white; font-weight: 100;">Enable/Disable
                                                    SSID</label>
                                            </div>

                                            <div style="text-align: center;">
                                                <input type="checkbox" id="isolation24"
                                                       name="isolation24" '.(get_wifi_isolation2() ? "checked" : "").'>
                                                <label title="Isolates wireless clients from each other"
                                                       for="isolation24" style="color: white; font-weight: 100;">WiFi
                                                    Client Isolation</label>
                                            </div>

                                            <input type="text" class="form-control placeholder-wh" name="ssid2"
                                                   value="'.(get_wifi_ssid2()).'"
                                                   placeholder="Name your network">
												   
											<div class="form-group">
											</div>
											
											<div class="form-group">
												<input type="text" class="form-control placeholder-wh" name="password2"
													   value="'.get_wifi_password2().'"
													   placeholder="Password">
											</div>
												   
                                        </div>

                    </div>

                    </tr>
                    </table>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Save Changes</button>
                    </div>

                ';
}
echo '
                </form>
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