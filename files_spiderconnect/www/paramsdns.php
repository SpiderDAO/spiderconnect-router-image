<?php require_once('layout/content.php');
 echo '
<style>

div#goback a {
	padding: 0;
}

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
                                <h3 data-i18n="lng.dns_unblocker2">Update your VPN DNS Unblocker mode</h3>
                                <h4 data-i18n="lng.dns_unblocker3">DNS Unblocker feature</h4>
                            </div>
                            <div class="remote-form-inn">
                                <form class="" action="/api/paramsdns.php" method="post">
                                    <div class="form-group">
                                        <select class="form-control placeholder-wh" onchange="dnsToggle()" name="dnsunblocker" id="dnsunblocker">
											<option value="wireguard" data-i18n="lng.on">On</option>
											<option value="fromdhcp"  data-i18n="lng.off" '.(get_dnsunblocker_status() == "fromdhcp"?"selected":"").'>Off</option>
											<option value="custom"  data-i18n="lng.customdnsservers" '.(get_dnsunblocker_status() == "custom"?"selected":"").'>Custom DNS Servers</option>
										</select>
									</div>
									<div class="form-group" id="customdns" style="'.(get_dnsunblocker_status() != "custom"?"display: none;":"").'">
										<input type="text" class="form-control placeholder-wh" name="customdns" value="'.@explode(", ", exec("uci get network.wgclient.customdns"))[0].'" placeholder="1.1.1.1">
									</div>
									<div class="form-group" id="customdns2" style="'.(get_dnsunblocker_status() != "custom"?"display: none;":"").'">
										<input type="text" class="form-control placeholder-wh" name="customdns2" value="'.@explode(", ", exec("uci get network.wgclient.customdns"))[1].'" placeholder="8.8.8.8">
									</div>
									
									
									
									<script>

										function dnsToggle()
										{
											if ($("#dnsunblocker option:selected").val() != "custom") {
												$("#customdns").fadeOut();
												$("#customdns2").fadeOut();
											} else {
												$("#customdns").fadeIn();
												$("#customdns2").fadeIn();
											}
										}
										
									</script>
									
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default" data-i18n="lng.savechanges">Save Changes</button>
                                    </div>

                                    ';
}
echo '
                                </form>
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
</html>';
