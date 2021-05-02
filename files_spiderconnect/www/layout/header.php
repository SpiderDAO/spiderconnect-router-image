<?php
echo '<!-- header header  -->
<div class="header">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- Logo -->
        <div class="navbar-header">
            <a class="navbar-brand" href="index.html">
                <!-- Logo icon -->
                <!-- <b><img src="assets/images/logo-white.png" alt="homepage" class="dark-logo"/></b> -->
                <!--End Logo icon -->
                <!-- Logo text -->
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
                <!-- <li class="nav-item dropdown mega-menu"><a class="nav-link dropdown-toggle  " href="#"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false"><i class="m-r-5"></i> Menu</a>
                 </li>-->
                <!-- End Messages -->
            </ul>
            ';
			require_once('layout/status.php');
			echo '
        </div>
    </nav>
</div>';
