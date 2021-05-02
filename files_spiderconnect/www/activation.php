<?php require_once('layout/content.php');
echo '
<body class="overflow cr-account">
<div class="wapper-wb">
    <div class="main-container center-content system-activate">
        <div class="container">
            <div class="row">
                <div class="remote-network">
                    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                        <div class="remote-form">
                            <div class="remote-head remote-head-1">
                                <h3>Activate<br>
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
                                        <input type="password" class="form-control placeholder-wh" name="password" id="email"
                                               placeholder="Password" required>
                                    </div>
                                    ';
									if (isset($_GET['failed'])) {
										echo '
                                        <div class="form-group">
                                            <span class="error-pwd">You entered an incorrect username or password.</span>
                                        </div>';
                                    }
                                    if (isset($_GET['noconnection'])) {
										echo '
                                        <div class="form-group">
                                            <span class="error-pwd">No Internet Connection.</span>
                                        </div>';
                                    }
                                    if (isset($_GET['wrong'])) {
										echo '
                                        <div class="form-group">
                                            <span class="error-pwd">Something went wrong, please try again later.</span>
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
												<a style="text-decoration: underline;" href="'.file_get_contents("/brand/reghere.txt").'" target="_blank">Register here</a>
											</div>
										</div>
                                        <table width="80%">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <a href="/wan-setup.php">
                                                    <button type="button" class="btn btn-default mx-auto px-auto" style="background: black;font-size: 14px;width:95%;">Setup WAN</button>
                                                </a>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-default mx-auto px-auto w-90 pull-left  text-center" style="text-align: center;">Activate</button>
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

