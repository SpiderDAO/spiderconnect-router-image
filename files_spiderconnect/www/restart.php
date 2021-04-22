<?php require_once('layout/content.php');
 echo '
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
                            <div class="remote-head remote-head-1">
                                <h3>Restart <br>'.file_get_contents("/brand/brand.txt").'?</h3>
                            </div>
                            <div class="remote-form-inn">
                                <ul class="mod-list-btn mod-list-blcok">
                                    <li><a href="/api/restart.php">Restart Router</a></li>
                                    <li><a href="/">Cancel</a></li>
                                </ul>
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
