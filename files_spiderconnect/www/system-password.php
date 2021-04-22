<?php require_once('layout/content.php');
 echo '
<body class="overflow wh">
<div class="wapper-wb">

    ';
require_once('layout/header.php');
echo '
         <div class="main-container center-content system-update">
            <div class="container">
               <div class="row">
                  <div class="remote-network">
                     <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                        <div id="goback"> <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></div>
                        <div class="remote-form">
                           <div class="remote-head">
                              <h3>System Password</h3>
                              <h4>Let\'s set a system password. This will make sure only you can make changes to WiFi settings. Make it memorable, if you forget you have to reset</h4>
                           </div>
                           <div class="remote-form-inn">
                              <form class="" action="/api/system-password.php" method="post">
                                 <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password">
                                 </div>
                                 <div class="form-group">
                                    <button type="submit" class="btn btn-default">Set Password</button>
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
</html>';
