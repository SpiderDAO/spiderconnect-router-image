<?php require_once('layout/content.php');
 echo '

    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="home-upload-form">

                    <div class="home-upload"
                         id="first-screen" ';
						 if ($vpnconnected) { 
							echo 'style="display: none;"';
						 }
							echo '>
                        <div class="last-error" id="last-error" style="color: white; font-weight: bold;">
                        </div>
                        <img src="assets/images/greyFicon1.svg'."?_=".time().'" id="logooff" style="width:150px" data-toggle="tooltip" data-placement="top"
                             data-i18n="[title]lng.you_are_protected;" title="You are not protected"/>
                        <div class="upload-btn">
                            <a data-i18n="[title]lng.turn_on_title; lng.turn_on" title="Press to select VPN location" class="turn_on openloc" href="javascript:;">Turn On</a>
                        </div>
                        <div class="upload-list">
                            <a id="location" class="openloc" href="javascript:;" data-i18n="lng.select_location;">Select Location</a>
                        </div>
                    </div>
                    <div class="home-upload"
                         id="second-connect" '.($vpnconnected?'style="display: none;"':"").'>
                        <div class="last-error" id="last-error" style="color: white; font-weight: bold;">
                        </div>
                        <img src="assets/images/ficon1.svg'."?_=".time().'" id="logoon" style="width:150px" data-toggle="tooltip" data-placement="top"
                             data-i18n="[title]lng.connecting;" title="Connecting"/>
                        <div class="connect-sc">
                            <div class="upload-btn">
                                <a class="turn_connect" data-i18n="lng.connecting;"  href="javascript:;">Connecting</a>
                            </div>
                            <h4 class="hidden" data-i18n="lng.not_secure;" >Your connection is not secure</h4>
                        </div>
                    </div>

                    <div class="home-upload"
                         id="third-connect" '.($vpnconnected?'style="display: block !important;"':'').'>
                        <div class="last-error" id="last-error" style="color: white; font-weight: bold;">
                        </div>
                        <img src="assets/images/ficon1.svg'."?_=".time().'" style="width:150px" data-toggle="tooltip" data-placement="top" data-i18n="[title]lng.on;" title="On"/>
                        <div class="connect-sc">
                            <div class="upload-btn">
                                <a title="Press to disconnect" class="turn_finish" href="javascript:;" data-i18n="lng.connected;">Connected</a>
                            </div>

                            <div class="upload-list con-server-name">
								<table width="100%" border="0"  style="color: white;">
									<tr>
										<td style="text-align: center;">
											<img id="flag" class="vpnflag" src="/assets/flags/'.$vpnserverimage.'.png" />
											<span id="servername"  class="vpntext" >'.$vpnserver.'</span>
										</td>
									</tr>
									<tr>
										<td style="text-align: center;">
											<div style="white-space: nowrap; text-align: center;" id="stats"></div>
										</td>
									</tr>
									<tr>
										<td style="text-align: center;">
											<a id="location" class="openloc" href="javascript:;" data-i18n="lng.change_location;">Change Location</a>
										</td>
									</tr>
									<tr>
										<td style="text-align: center;">
											<a href="'.file_get_contents("/brand/ipinfo.txt").'" target="_blank" data-i18n="lng.check_my_ip;">Check My IP Address</a>
										</td>
									</tr>
								</table>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="home-screen-select '.(!empty($_GET['show_locations_list'])?"on":"").'">
                    <div class="container">
                        <div class="row">
                            <div class="view-screen-select">
                                <div class="viewopen0">
                                    <i id="viewopen" class="fa fa-times" aria-hidden="true"></i>
                                </div>
                                <div class="dropdown show">
									<table width="100%" class="btn">
										<tbody>
											<tr>
												<td>
													<a href="https://stats.spidervpn.org/" style="color: red;" target="_blank">
														
														<button type="button"
															style="border: none; text-decoration: underline; color: red; background-color: white;" 
															data-i18n="lng.check_servers_status;"
															>Click to check server status
														</button>
													</a>
												</td>
												<td>
													<style>
													i:active:after {
														content: none;
													}
													</style>
													<i id="update_locations" 
													data-i18n="[title]lng.update_locations_list;"
													title="Update Locations List"  style="padding-left: 10px; padding-right: 10px; color: red;" class="fa fa-refresh" aria-hidden="true">  </i>
												</td>
											</tr>
										</tbody>
									</table>
                                    <ul class="dropdown-menu">
                                        ';
										
										function loc_cmp($a, $b)
										{
											return strcmp($a["loclabel"], $b["loclabel"]);
										}
										
										$servers = get_servers_list();
										uasort($servers, "loc_cmp");
                                        foreach ($servers as $server => $params) {
                                            echo '<li><a href="javascript:;" data-server_id="'.$server.'"><span
                                                            class="sprites sp-icon-1"
                                                            style="background: url(\'/assets/flags/'.basename($params['locname']).'.png\');"></span>'.$params['loclabel'].'</a></li>';
                                        }
										echo '

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="moverlay"></div>
                </div>
            </div>
        </div>
    </div>


';
 echo '
<script src="assets/js/lib/webticker/jquery.webticker.min.js"></script>
<script src="assets/js/lib/peitychart/jquery.peity.min.js"></script>
<script src="assets/js/dashboard-1.js"></script>
</body>
</html>
';
require_once('layout/footer.php');
 echo '
</body>
</html>
';