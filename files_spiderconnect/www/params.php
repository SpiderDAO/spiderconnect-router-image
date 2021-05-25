<?php
require_once('layout/content.php');
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
                                <h3 data-i18n="lng.killswith">Kill Switch</h3>
                                <h4 data-i18n="lng.killswith2">With this enabled, it will automatically cut your connection from the internet if VPN fails. It protects your original IP from getting exposed.</h4>
                            </div>
                            <div class="remote-form-inn">
                                <form class="" action="/api/params.php" method="post">
                                    <div class="form-group">
                                        <select class="form-control placeholder-wh" name="killswitch">
											<option value="pass"  data-i18n="lng.disabled">Disabled</option>
											<option value="block" data-i18n="lng.on" <?php if (get_killswitch_status() == "block") { echo "selected"; } ?>>Enabled</option>
										</select>
                                    </div>
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
