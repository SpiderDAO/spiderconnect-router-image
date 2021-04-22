<?php 

require_once('init.php');
$_SESSION['router_logged_in'] = 1;
redirect('/index.php');
die();


require_once('layout/head.php'); 

echo '
<body class="overflow login-sc">
<div class="wapper-wb">

    <div class="main-container center-content">
        <div class="container">
            <div class="row">
                <div class="remote-network">
                    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                        <div class="remote-form">
                            <div class="remote-head">
                                <h3>Login</h3>
                            </div>
                            <div class="remote-form-inn">
                                <form class="" action="/api/login.php"  method="post">
                                    <div class="form-group">
                                        <input type="password" class="form-control placeholder-bl" name="password"
                                               placeholder="Enter Password">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default">Sign In</button>
                                        <a id="forgotpwd" class="forgotps" href="javascript:;" data-placement="top"
                                           data-toggle="popover" title="Forgot Password?"
                                           data-content="Press and hold the \'Reset\' button for 25 seconds, then release your finger. You will see LEDs flash in a pattern. Wait for VPN router to reboot and then start over.">Forgot
                                            Your Password?</a>
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
require_once('layout/content.php');
 echo '
</body>
</html>';
