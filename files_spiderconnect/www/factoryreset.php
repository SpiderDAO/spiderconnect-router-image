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
                    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                        <div id="goback"><a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                        </div>
                        <div class="remote-form">
                            <div class="remote-head remote-head-1">
                                <h3><span data-i18n="lng.factoryreset2">Factory Reset</span> <br>'.file_get_contents("/brand/brand.txt").'?</h3>
                            </div>
                            <div class="remote-form-inn">
                                <ul class="mod-list-btn mod-list-blcok">
                                    <li><a onclick="return ConfirmFactoryReset()" href="/api/restart.php?factoryreset=1" data-i18n="lng.factoryreset2">Factory Reset</a></li>
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
