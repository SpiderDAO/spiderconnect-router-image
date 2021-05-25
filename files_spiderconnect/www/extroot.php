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
                    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                        <div id="goback"><a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                        </div>
                        <div class="remote-form">
                            <div class="remote-head remote-head-1">
                                '.(file_exists("/tmp/lowspace")?"<h3 data-i18n='lng.low_memory1'>Low Flash Memory! Please free up some space.</h3><h4 data-i18n='lng.low_memory2'>Please use a MicroSD card or a USB stick to extend memory.</h4>":"<h3 data-i18n='lng.routermemory'>Router Memory</h3>").'
                                <h4 id="status" data-i18n="lng.checkingstatus">Detecting status...</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	

<script>

	function formatSizeUnits(bytes, length){
			if      (bytes>=1099511627776) {bytes=(bytes/1099511627776).toFixed(length)+"TB";}
			else if (bytes>=1073741824)    {bytes=(bytes/1073741824).toFixed(length)+"GB";}
			else if (bytes>=1048576)       {bytes=(bytes/1048576).toFixed(length)+"MB";}
			else if (bytes>=1024)          {bytes=(bytes/1024).toFixed(length)+"KB";}
			else if (bytes>1)              {bytes=bytes+" bytes";}
			else if (bytes==1)             {bytes=bytes+" byte";}
			else                           {bytes="0 byte";}
			return bytes;
	}
	
	var formatting = 0;
	
	function extrootstatus()
	{
		
		
		$.ajax({
			url: "/config_api.php?extrootstatus=1&_"+ (new Date).getTime(),
			timeout: 60000 // sets timeout to 20 seconds
		}).done(function (e) {
			
			try {
				
				e=JSON.parse(e);
				
				$("#status").html("");
				
				if (formatting > 0) {
					formatting++;
					if (formatting > 50) {
						formatting=1;
					}
					var dots = new Array(formatting + 1).join( "." );
					$("#status").html(i18next.t("lng.formatting")+dots);
					
					return;
				}
				
				var status = "";
				if (e.boot == "internal") {
					status = i18next.t("lng.internalmemory")+"<br/>"+formatSizeUnits(e.space+e.rom, 2)+" "+i18next.t("lng.used")+", "+formatSizeUnits(e.freespace, 2)+" "+i18next.t("lng.free");
					if (!e.mmc && !e.sda) {
						status = status + i18next.t("lng.externalmemory0")
					}
				} else if (e.boot == "mmc") {
					status = i18next.t("lng.mmc")+formatSizeUnits(e.freespace, 2)+i18next.t("lng.freespace");
				} else if (e.boot == "usb") {
					status = i18next.t("lng.usb")+formatSizeUnits(e.freespace, 2)+i18next.t("lng.freespace");
				} else {
					status = i18next.t("lng.nonexpectedstatus");
				}
				
				var text1 = "";
				
				if (e.mmc) {
					text1 = i18next.t("lng.mmc1");
					text1 = text1 + " - " + i18next.t("lng.size") + formatSizeUnits(e.mmc.sectors*e.mmc.sectorsize, 2)+"<br/>";
					if (e.mmc.type != 2) {
						text1 = text1 + " - " + i18next.t("lng.notformattedfor") + " " + i18next.t("lng.shortbrand") + "<br/>";
						text1 = text1 + "<div style=\'text-align: center;\'>";
						text1 = text1 + "<button id=\'formatMMC\' class=\'btn btn-default\' style=\'background-color: red; color: white;\'>" + i18next.t("lng.format") + " " + i18next.t("lng.mmc0") + "</button>";
						text1 = text1 + "</div>";
					} else {
						if (e.boot == "mmc") {
							text1 = text1 + " - " + i18next.t("lng.formattedfor") + " " + i18next.t("lng.shortbrand") + " - " + i18next.t("lng.active") + "<br/>";
							text1 = text1 + "<div style=\'text-align: center;\'>";
							text1 = text1 + "<button id=\'removeMMC\' class=\'btn btn-default\' style=\'background-color: #007771; color: white;\'>" + i18next.t("lng.saferemove") + "</button>";
							text1 = text1 + "</div>";
						} else {
							text1 = text1 + " - " + i18next.t("lng.formattedfor") + " " + i18next.t("lng.shortbrand") + " - " + i18next.t("lng.reboottoactivate") + "<br/>";
							text1 = text1 + "<div style=\'text-align: center;\'>";
							text1 = text1 + "<button id=\'rebootMMC\'      class=\'btn btn-default\' style=\'background-color: #007771; color: white;\'>" + i18next.t("lng.rebootrouter") + "</button>";
							text1 = text1 + "</div>";
						}
					}
					
				}
				
				var text2 = "";
				
				if (e.sda) {
					text2 = i18next.t("lng.usb1");
					text2 = text2 + " - " + i18next.t("lng.size") + formatSizeUnits(e.sda.sectors*e.sda.sectorsize, 2)+"<br/>";
					if (e.sda.type != 2) {
						text2 = text2 +" - " + i18next.t("lng.notformattedfor") + " " + i18next.t("lng.shortbrand") + "<br/>";
						text2 = text2 + "<div style=\'text-align: center;\'>";
						text2 = text2 + "<button id=\'formatUSB\' class=\'btn btn-default\' style=\'background-color: red; color: white;\'>" + i18next.t("lng.format") + " " + i18next.t("lng.usb0") + "</button>";
						text2 = text2 + "</div>";
					} else {
						if (e.boot == "usb") {
							text2 = text2 + " - " + i18next.t("lng.formattedfor") + " " + i18next.t("lng.shortbrand") + " - " + i18next.t("lng.active") + "<br/>";
							text2 = text2 + "<div style=\'text-align: center;\'>";
							text2 = text2 + "<button id=\'removeUSB\' class=\'btn btn-default\' style=\'background-color: #007771; color: white;\'>" + i18next.t("lng.saferemove") + "</button>";
							text2 = text2 + "</div>";
						} else {
							text2 = text2 + " - " + i18next.t("lng.formattedfor") + " " + i18next.t("lng.shortbrand") + " - " + i18next.t("lng.reboottoactivate") + "<br/><br/>";
							text2 = text2 + "<div style=\'text-align: center;\'>";
							text2 = text2 + "<button id=\'rebootUSB\'   class=\'btn btn-default\' style=\'background-color: #007771; color: white;\'>" + i18next.t("lng.rebootrouter") + "</button>";
							text2 = text2 + "</div>";
						}
					}
					
				}
				
				var alltext = "";
				if (text1 != "") {
					alltext = "<pre style=\'text-align: left;\' >"+text1+"</pre>";
				}
				
				if (text2 != "") {
					alltext = alltext + "<pre style=\'text-align: left;\' >"+text2+"</pre>";
				}
				
				$("#status").html(status+alltext);
				
			} catch (e) {
				$("#status").html(i18next.t("lng.routerisnotaccessible"));
			};
		}).fail(function () {
			
			$("#status").html(i18next.t("lng.routerisnotaccessible"));
			
		}).always(function () {
			
			setTimeout(function(){
				extrootstatus();
			}, 1);
			
		});
	}
	
	$(document).ready(function($)
	{
		extrootstatus();
		
		document.addEventListener("click",function(e){
			if (e.target && e.target.id== "rebootUSB"){
				window.location.href = "/connection-rebooted.php?back=extroot.php";
				
			} else if (e.target && e.target.id== "rebootMMC"){
				window.location.href = "/connection-rebooted.php?back=extroot.php";
				
			} else if (e.target && e.target.id== "removeUSB"){
				var r = confirm(i18next.t("lng.routerwilloffnowmmc"));
				if (r == true) {
					$.ajax({
						url: "/config_api.php?halt=1",
						success: function(data){
							formatting = 0;
							//alert(data);
						},
						timeout: 3600000 //in milliseconds
					});
				}
				
			} else if (e.target && e.target.id== "removeMMC"){
				var r = confirm(i18next.t("lng.routerwilloffnowusb"));
				if (r == true) {
					$.ajax({
						url: "/config_api.php?halt=1",
						success: function(data){
							formatting = 0;
							//alert(data);
						},
						timeout: 3600000 //in milliseconds
					});
				}
				
			} else if (e.target && e.target.id== "formatMMC"){
				var r = confirm(i18next.t("lng.confirmformatmmc"));
				if (r == true) {
					formatting = 1;
					$.ajax({
						url: "/config_api.php?formatmmc=1",
						success: function(data){
							formatting = 0;
							//alert(data);
						},
						timeout: 3600000 //in milliseconds
					});
				}
				
			} else if (e.target && e.target.id== "formatUSB"){
				var r = confirm(i18next.t("lng.confirmformatusb"));
				if (r == true) {
					formatting = 1;
					$.ajax({
						url: "/config_api.php?formatusb=1",
						success: function(data){
							formatting = 0;
							//alert(data);
						},
						timeout: 3600000 //in milliseconds
					});
				}
			}
		 });
	})
	
</script>
	
    ';
require_once('layout/footer.php');
echo '
</body>
</html>
';