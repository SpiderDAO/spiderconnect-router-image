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
                    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                        <div id="goback"><a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                        </div>
                        <div class="remote-form">

                            ';
if (isset($_GET['success'])) { 
echo '
                                <div class="remote-head remote-head-1">
                                    <h4>Parameters have been successfully updated.</h4>
                                </div>
                            ';
} else {
echo '
                            <div class="remote-head remote-head-1">
                                <h3>Expert mode</h3>
                                <h4>The user is liable for any damage or issues that may occur when turning On expert mode.</h4>
                            </div>
                            <div class="remote-form-inn">
                                <form class="" action="/api/paramsadv.php" method="post">
                                    <div class="form-group">
                                        <select class="form-control placeholder-wh" name="expertmode">
											<option value="lucioff">Off</option>
											<option value="lucion"  '.(get_advmode_status()=="lucion"?"selected":"").' >On</option>
										</select>
									</div>
									<div class="form-group" >
										<div class="remote-head" style="padding-top: 0px;">
											<h4>Router Access<br/>Login & Password <i class="fa fa-question-circle" title="Set this password so whenever you access anything from the Spider Dashboard, it will prompt you for this password."></i></h4>
										</div>
										<table width="100%">
											<tr>
												<td width="50%">
													<input type="text" class="form-control placeholder-wh" name="router_login" id="router_login"
														   value="'.get_router_login().'"
														   placeholder="Set Router Login">
														
												</td>
												<td width="50%">
													<input type="password" class="form-control placeholder-wh" name="router_password" id="router_password"
														   value="'.get_router_password().'"
														   placeholder="Set Router Password">
												</td>
											</tr>
										</table>

											   
										<div style="text-align: center; color: white;">
											<input type="checkbox" onclick="ShowPassword()">&nbsp;Show Password
										</div>
											   
									</div>
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
            </div>
        </div>
    </div>
	
	
	
    ';
require_once('layout/footer.php');
 echo '
</body>
</html>
';