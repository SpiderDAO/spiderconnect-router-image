<?php
echo '<!-- header header  -->
<div class="header">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- Logo -->
        <div class="navbar-header">
            <a class="navbar-brand" href="/index.php">
                <span><img src="assets/images/logo-white.png" alt="homepage" class="dark-logo"/></span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
        <!-- End Logo -->

        <div class="navbar-collapse">

           <ul class="navbar-nav mr-auto mt-md-0">
                <!-- This is  -->
                <li class="nav-item"><a class="nav-link toggle-nav hidden-md-up text-muted  " href="javascript:void(0)"><i
                                class="mdi mdi-menu"></i></a></li>
                <li class="nav-item m-l-10"><a class="nav-link sidebartoggle hidden-sm-down  "
                                               href="javascript:void(0)"><i class="ti-menu"></i></a></li>
                <!-- Messages -->
                <!-- End Messages -->
            </ul>
            ';
			require_once('layout/status.php');
			echo '
        </div>
    </nav>
</div>';
