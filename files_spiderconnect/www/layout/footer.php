<?php

$wan = get_wan_connection_info();
$lan = get_lan_connection_info();

echo '

</div>
<footer class="footer" style="display: none;"> © 2021 Spider vpn All Right Reserved.</footer>
<!-- End footer -->
</div>
<!-- End Page wrapper  -->
</div>
<!-- End Wrapper -->
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/js/lib/bootstrap/js/popper.min.js"></script>
<script src="assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="assets/js/jquery.slimscroll.js"></script>
<!--Menu sidebar -->
<script src="assets/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
<!--Custom JavaScript -->
<script src="assets/js/custom.min.js"></script>
<script src="assets/js/stats2.js"></script>
<script src="assets/js/custom.js"></script>

<div class="overlay-bg"></div>
<!-- Connection Modal -->
<div class="modal fade modal-conn" id="connection1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Connection Information</h4>
            </div>
            <div class="modal-body">
                <div id="div-wan-status">
                    <div class="subcontent" style="" id="sub-repeater">
                        <div><label>Lan Connection</label><span class="right"><label class="msg2"
                                                                                     id="msg-disconnect"></label></span>
                        </div>
                        <table style="white-space:pre">
                            <tbody>
                            <tr>
                                <td>IP Address</td>
                                <td>'.$lan->ip.'</td>
                            </tr>
                            <tr>
                                <td>Subnet Mask</td>
                                <td>'.$lan->subnet.'</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="div-wan-status">
                    <div class="subcontent" style="" id="sub-repeater">
                        <div><label>Cable Connection</label><span class="right"><label class="msg2"
                                                                                       id="msg-disconnect"></label></span>
                        </div>
                        <table style="white-space:pre">
                            <tbody>
                            <tr>
                                <td>IP Address</td>
                                <td>'.$wan->ip.'</td>
                            </tr>
                            <tr>
                                <td>Subnet Mask</td>
                                <td>'.$wan->subnet.'</td>
                            </tr>
                            <tr>
                                <td>Gateway</td>
                                <td>'.$wan->gateway.'</td>
                            </tr>
                            <tr>
                                <td>DNS</td>
                                <td>'.$wan->dns.'</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Password Modal -->
<div class="modal fade modal-pwd" id="conpwd" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Which Password?</h4>
            </div>
            <div class="modal-body">
                <ul class="mod-list-btn mod-list-blcok">
                    <li><a href="/system-password.php"><i class="fa fa-mobile" aria-hidden="true"></i> System
                            Password</a></li>
                    <li><a href="/rename-network.php"><i class="fa fa-wifi" aria-hidden="true"></i> Wifi Password</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


<div class="spinner-overlay">
    <div class="loading-animation"></div>
</div>


</div>


<div class="footer-con">
    <p>&nbsp;&nbsp;&nbsp;Version 0.1
    </p>

</div>

<script>


    $("#update_locations").click(function () {

        $("#update_locations").addClass("rotate");

        $.ajax({
            method: "GET",
            url: "/api/credentials.php?_=" + (new Date).getTime()
        }).done(function (data, textStatus, jqXHR) {

            $("#update_locations").removeClass("rotate");
            window.location.href = "/?show_locations_list=1";

        }).fail(function () {
            alert("Can\'t update list - try later.");
        });
    });

    function formatSpeedUnits(bytes) {
        if (bytes >= 1099511627776) {
            bytes = (bytes / 1099511627776).toFixed() + "Tbit";
        } else if (bytes >= 1073741824) {
            bytes = (bytes / 1073741824).toFixed() + "Gbit";
        } else if (bytes >= 1048576) {
            bytes = (bytes / 1048576).toFixed() + "Mbit";
        } else if (bytes >= 1024) {
            bytes = (bytes / 1024).toFixed() + "Kbit";
        } else if (bytes > 1) {
            bytes = bytes.toFixed() + "bites";
        } else if (bytes == 1) {
            bytes = bytes.toFixed() + "bit";
        } else {
            bytes = "0bit";
        }
        return bytes;
    }

    function formatSizeUnits(bytes, length) {
        if (bytes >= 1099511627776) {
            bytes = (bytes / 1099511627776).toFixed(length) + "TB";
        } else if (bytes >= 1073741824) {
            bytes = (bytes / 1073741824).toFixed(length) + "GB";
        } else if (bytes >= 1048576) {
            bytes = (bytes / 1048576).toFixed(length) + "MB";
        } else if (bytes >= 1024) {
            bytes = (bytes / 1024).toFixed(length) + "KB";
        } else if (bytes > 1) {
            bytes = bytes + "bytes";
        } else if (bytes == 1) {
            bytes = bytes + "byte";
        } else {
            bytes = "0byte";
        }
        return bytes;
    }

    function stats() {

        var timediff = (curchecktime - prevchecktime) / 1000;
        if (timediff > 0) {

            $(\'#stats\').html("<span class=\'smalltext\'>Current Down/Up Speed:</span><br/><i class=\'fa fa-long-arrow-down\'></i>&nbsp;" + formatSpeedUnits((downloaded1 - downloaded2) * 8 / ((curchecktime - prevchecktime) / 1000)) + "/s,&nbsp;<i class=\'fa fa-long-arrow-up\'></i>&nbsp;" + formatSpeedUnits((uploaded1 - uploaded2) * 8 / ((curchecktime - prevchecktime) / 1000)) + "<br/><span class=\'smalltext\'>Total Data Used with " + shortbrand + ":</span><br/><i class=\'fa fa-long-arrow-down\'></i>&nbsp;" + formatSizeUnits(downloaded1, 2) + ", &nbsp;<i class=\'fa fa-long-arrow-up\'></i>&nbsp;" + formatSizeUnits(uploaded1, 2));
        }
    }

    $(document).ready(function ($) {
        setInterval(function () {
            stats();
        }, 1000);
    })

    function ShowPassword() {
        var x = document.getElementById("router_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }


</script>
<!-- All Jquery -->

</body>

</html>';
