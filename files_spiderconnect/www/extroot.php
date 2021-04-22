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
                    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                        <div id="goback"><a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                        </div>
                        <div class="remote-form">
                            <div class="remote-head remote-head-1">
                                '.(file_exists("/tmp/lowspace")?"<h3>Low Memory! Please free up some space.</h3><h4>Please use a MicroSD card or a USB stick to extend memory.</h4>":"<h3>Router Memory</h3>").'
                                <h4 id="status">Detecting status...</h4>
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
					$("#status").html("Formatting"+dots);
					
					return;
				}
				
				var status = "";
				if (e.boot == "internal") {
					status = "Internal Flash Memory<br/>"+formatSizeUnits(e.space+e.rom, 2)+" used, "+formatSizeUnits(e.freespace, 2)+" free";
					if (!e.mmc && !e.sda) {
						status = status + "<br/><br/>External USB Flash Memory - 0MB Free<br/><br/>Insert USB to Access External Memory"
					}
				} else if (e.boot == "mmc") {
					status = "Router booted from MicroSD,<br/> and have "+formatSizeUnits(e.freespace, 2)+" free space<br/><br/>";
				} else if (e.boot == "usb") {
					status = "Router booted from USB Pendrive,<br/> and have "+formatSizeUnits(e.freespace, 2)+" free space<br/><br/>";
				} else {
					status = "Router is in non-expected status.<br/> Please reboot<br/><br/>";
				}
				
				var text1 = "";
				
				if (e.mmc) {
					text1 = "MicroSD card inserted<br/>";
					text1 = text1 + " - size "+formatSizeUnits(e.mmc.sectors*e.mmc.sectorsize, 2)+"<br/>";
					if (e.mmc.type != 2) {
						text1 = text1 + " - not formatted for spider<br/>";
						text1 = text1 + "<div style=\'text-align: center;\'>";
						text1 = text1 + "<button id=\'formatMMC\' class=\'btn btn-default\' style=\'background-color: red; color: white;\'>Format MicroSD</button>";
						text1 = text1 + "</div>";
					} else {
						if (e.boot == "mmc") {
							text1 = text1 + " - formatted for spider - active<br/>";
							text1 = text1 + "<div style=\'text-align: center;\'>";
							text1 = text1 + "<button id=\'removeMMC\' class=\'btn btn-default\' style=\'background-color: #007771; color: white;\'>Safe Remove</button>";
							text1 = text1 + "</div>";
						} else {
							text1 = text1 + " - formatted for spider - reboot to activate<br/>";
							text1 = text1 + "<div style=\'text-align: center;\'>";
							text1 = text1 + "<button id=\'rebootMMC\'      class=\'btn btn-default\' style=\'background-color: #007771; color: white;\'>Reboot router</button>";
							text1 = text1 + "</div>";
						}
					}
					
				}
				
				var text2 = "";
				
				if (e.sda) {
					text2 = "USB flash drive inserted<br/>";
					text2 = text2 +" - size "+formatSizeUnits(e.sda.sectors*e.sda.sectorsize, 2)+"<br/>";
					if (e.sda.type != 2) {
						text2 = text2 +" - not formatted for spider<br/>";
						text2 = text2 + "<div style=\'text-align: center;\'>";
						text2 = text2 + "<button id=\'formatUSB\' class=\'btn btn-default\' style=\'background-color: red; color: white;\'>Format Pendrive</button>";
						text2 = text2 + "</div>";
					} else {
						if (e.boot == "usb") {
							text2 = text2 + " - formatted for spider - active<br/>";
							text2 = text2 + "<div style=\'text-align: center;\'>";
							text2 = text2 + "<button id=\'removeUSB\' class=\'btn btn-default\' style=\'background-color: #007771; color: white;\'>Safe Remove</button>";
							text2 = text2 + "</div>";
						} else {
							text2 = text2 + " - formatted for spider - reboot to activate<br/><br/>";
							text2 = text2 + "<div style=\'text-align: center;\'>";
							text2 = text2 + "<button id=\'rebootUSB\'   class=\'btn btn-default\' style=\'background-color: #007771; color: white;\'>Reboot router</button>";
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
				$("#status").html("Router is not accessible now.");
			};
		}).fail(function () {
			
			$("#status").html("Router is not accessible now.");
			
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
				var r = confirm("Router will off now and you will can safety remove USB Pendrive. Remove and insert back router\"s power cable to start router again. Continue?");
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
				var r = confirm("Router will off now and you will can safety remove  MicroSD. Remove and insert back router\"s power cable to start router again. Continue?");
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
				var r = confirm("Are you sure you want to format inserted MicroSD? All data will be lost!");
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
				var r = confirm("Are you sure you want to format inserted USB Pendrive? All data will be lost!");
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