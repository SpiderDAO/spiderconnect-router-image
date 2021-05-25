<?php require_once('layout/content.php');
echo '
<body class="overflow re-image">
<div class="wapper-wb">

    ';
require_once('layout/header.php');
echo '
    <div class="main-container center-content res-container">
        <div class="container">
            <div class="row">
                <div class="remote-network">
                    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">

                        <div class="remote-form">
                            <div class="remote-head-1">
                                <span style="color: black;" data-i18n="lng.updating">Updating VPN Router...</span>
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
    <script>

        $(".spinner-overlay").show();

        window.setTimeout(function () {
            var refreshIntervalId = window.setInterval(function () {
                $.ajax({
                    url: "/live.php"
                }).done(function () {
                    window.location.replace("/");
                    clearInterval(refreshIntervalId);
                }).fail(function () {

                });
            }, 2000)


        }, 5000)


    </script>

</body>
</html>';
