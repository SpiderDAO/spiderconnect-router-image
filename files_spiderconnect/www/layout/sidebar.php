<?php 
echo '<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebar-menu">
                <li class="nav-devider"></li>

                <li><a href="/" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">&nbsp;Home </span></a>
                </li>
                <li><a href="rename-network.php" aria-expanded="false"><i class="fa fa-wifi"></i><span
                                class="hide-menu"> WiFi Setup </span></a>

                </li>
                <li><a href="wan-setup.php" aria-expanded="false"><i class="fa fa-retweet"></i><span class="hide-menu"> WAN Setup</span></a>

                </li>
                <li><a href="params.php" aria-expanded="false"><i class="fa fa-gear"></i><span class="hide-menu"> Kill Switch</span></a>

                </li>
                <li><a href="paramsdns.php" aria-expanded="false"><i class="fa fa-gear"></i><span class="hide-menu"> DNS Unblocker</span></a>

                </li>
                <li><a href="paramsadv.php" aria-expanded="false"><i class="fa fa-gear"></i><span class="hide-menu"> Expert Mode</span></a>

                </li>
                <li><a target="_blank" href="'.file_get_contents("/brand/ipinfo.txt").'" aria-expanded="false"><i
                                class="fa fa-connectdevelop"></i><span class="hide-menu"> Connection Info</span></a>

                </li>
                <!--                <li class="nav-label">Help & Support</li>-->
                <li><a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-columns"></i><span
                                class="hide-menu">&nbsp;Help & Support</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a target="_blank" href="'.file_get_contents("/brand/feedback.txt").'"><i
                                        class="fa fa-envelope-o"></i>&nbsp;&nbsp;Talk to Our Teem</a></li>
                        <li><a target="_blank" href="'.file_get_contents("/brand/myvpnaccount.txt").'"><i
                                        class="fa fa-user-o"></i>&nbsp;&nbsp;My VPN Account</a>
                        </li>
                        <li><a href="restart.php"><i
                                        class="fa fa-undo"></i>&nbsp;&nbsp;Restart</a></li>
                        <li><a href="factoryreset.php"><i
                                        class="fa fa-envelope"></i>&nbsp;&nbsp;Reset&nbsp;to&nbsp;factory&nbsp;defaults</a>
                        </li>
                        <li><a href="update.php"><i
                                        class="fa fa-upload"></i>&nbsp;&nbsp;Update to latest Software</a></li>
                        <li><a href="api/logout.php"><i
                                        class="fa fa-sign-out"></i>&nbsp;&nbsp;Logout</a></li>
                    </ul>
                </li>
                <li><a href="extroot.php" aria-expanded="false"><i class="fa fa-hdd-o"></i><span class="hide-menu"> Router Memory</span></a>

                </li>
                <li><a href="wallet.php" aria-expanded="false"><i class="fa fa-credit-card"></i><span class="hide-menu"> Wallet</span></a>

                </li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>
';