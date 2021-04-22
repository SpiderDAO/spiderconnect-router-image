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
                             title="You are not protected"/>
                        <div class="upload-btn">
                            <a title="Press to select VPN location" class="turn_on openloc" href="javascript:;">Turn On</a>
                        </div>
                        <div class="upload-list">
                            <a id="location" class="openloc" href="javascript:;">Select Location</a>
                        </div>
                    </div>
                    <div class="home-upload"
                         id="second-connect" '.($vpnconnected?'style="display: none;"':"").'>
                        <div class="last-error" id="last-error" style="color: white; font-weight: bold;">
                        </div>
                        <img src="assets/images/ficon1.svg'."?_=".time().'" id="logoon" style="width:150px" data-toggle="tooltip" data-placement="top"
                             title="Connecting"/>
                        <div class="connect-sc">
                            <div class="upload-btn">
                                <a class="turn_connect" href="javascript:;">Connecting</a>
                            </div>
                            <h4 class="hidden">Your connection is not secure</h4>
                        </div>
                    </div>

                    <div class="home-upload"
                         id="third-connect" '.($vpnconnected?'style="display: block !important;"':'').'>
                        <div class="last-error" id="last-error" style="color: white; font-weight: bold;">
                        </div>
                        <img src="assets/images/ficon1.svg'."?_=".time().'" style="width:150px" data-toggle="tooltip" data-placement="top" title="On"/>
                        <div class="connect-sc">
                            <div class="upload-btn">
                                <a title="Press to disconnect" class="turn_finish" href="javascript:;">Connected</a>
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
											<a id="location" class="openloc" href="javascript:;">Change Location</a>
										</td>
									</tr>
									<tr>
										<td style="text-align: center;">
											<a href="'.file_get_contents("/brand/ipinfo.txt").'" target="_blank">Check My IP Address</a>
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
															style="border: none; text-decoration: underline; color: red; background-color: white;" >Click to check server status
														</button>
													</a>
												</td>
												<td>
													<style>
													i:active:after {
														content: none;
													}
													</style>
													<i id="update_locations" title="Update list"  style="padding-left: 10px; padding-right: 10px; color: red;" class="fa fa-refresh" aria-hidden="true">  </i>
												</td>
											</tr>
										</tbody>
									</table>
                                    <ul class="dropdown-menu">
                                        ';
										
										$servers = get_servers_list();
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
<!-- All Jquery -->
<script src="assets/js/lib/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/js/lib/bootstrap/js/popper.min.js"></script>
<script src="assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="assets/js/jquery.slimscroll.js"></script>
<!--Menu sidebar -->
<script src="assets/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<!--Custom JavaScript -->
<script src="assets/js/lib/webticker/jquery.webticker.min.js"></script>
<script src="assets/js/lib/peitychart/jquery.peity.min.js"></script>
<!-- scripit init-->
<script src="assets/js/custom.min.js"></script>
<script src="assets/js/dashboard-1.js"></script>
</body>
</html>
';
require_once('layout/footer.php');
 echo '
</body>
</html>
';