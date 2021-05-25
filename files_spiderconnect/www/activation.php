<?php require_once('layout/content.php');
echo '
<style>
@media (max-width: 992px) {
	.col-sm-6 {
		-webkit-box-flex: 0;
		-ms-flex: 0 0 50%;
		flex: 0 0 50%;
		max-width: 50%;
	}
}
@media (max-width: 768px) {
	.col-sm-6 {
		-webkit-box-flex: 0;
		-ms-flex: 0 0 100%;
		flex: 0 0 100%;
		max-width: 100%;
	}
}
@media (max-width: 768px) {
	.remote-network {
		padding-top: 100px;
	}
}
</style>

<body class="overflow cr-account">
<div class="wapper-wb">
    <div class="main-container center-content system-activate" style="z-index: 100">
        <div class="container">
            <div class="row">
                <div class="remote-network">
                    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                        <div class="remote-form">
                            <div class="remote-head remote-head-1">
                                <h3><span data-i18n="lng.activate">Activate</span><br>
                                    '.file_get_contents("/brand/brand.txt").'
                                </h3>
                            </div>
                            <div class="remote-form-inn">
                                <form class="" action="/api/activation.php" method="post">
                                    <div class="form-group">
                                        <input type="email" class="form-control placeholder-wh" name="email" id="email"
                                               placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control placeholder-wh" name="password" id="password"
                                               data-i18n="[placeholder]lng.password" placeholder="Password" required>
                                    </div>
                                    ';
									if (isset($_GET['failed'])) {
										echo '
                                        <div class="form-group">
                                            <span class="error-pwd" data-i18n="lng.bad_email" >You entered an incorrect username or password.</span>
                                        </div>';
                                    }
                                    if (isset($_GET['noconnection'])) {
										echo '
                                        <div class="form-group">
                                            <span class="error-pwd" data-i18n="lng.no_internet">No Internet Connection.</span>
                                        </div>';
                                    }
                                    if (isset($_GET['wrong'])) {
										echo '
                                        <div class="form-group">
                                            <span class="error-pwd" data-i18n="lng.something_wrong">Something went wrong, please try again later.</span>
                                        </div>';
                                    }
                                    if (isset($_GET['invalid'])) {
										echo '<div class="form-group">
                                            <span class="error-pwd">'.$_GET['invalid'].'</span>
                                        </div>';
                                    }
									echo '
                                    <div class="form-group">
										<div style="width: 100%; text-align: center;">
											Create new account?
											<div>
												<a style="text-decoration: underline;" href="'.file_get_contents("/brand/reghere.txt").'" target="_blank" data-i18n="lng.reg_here">Register here</a>
											</div>
										</div>
                                        <table width="100%">
                                        <tbody>
                                        <tr>
                                            <td width="50%">
                                                <a href="/wan-setup.php">
                                                    <button type="button" class="btn btn-default mx-auto px-auto" style="background: black;font-size: 14px;width:95%;" data-i18n="lng.wan_setup">Setup WAN</button>
                                                </a>
                                            </td>
                                            <td width="50%">
                                                <button type="submit" class="btn btn-default mx-auto px-auto w-90 pull-left  text-center" style="text-align: center;" data-i18n="lng.activate">Activate</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    </div>
									
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
</html>
';

