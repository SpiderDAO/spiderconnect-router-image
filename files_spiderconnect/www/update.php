<?php require_once('layout/content.php'); 

set_time_limit(0);

echo '
<style>
	input, .actual-edit-overlay {
		-webkit-text-fill-color: #000 !important;
	}

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
							<form class="" action="/api/update.php" enctype="multipart/form-data" method="post">
								<div class="remote-head remote-head-1">

									<h3 data-i18n="lng.updatefirmware2">Update your '.file_get_contents("/brand/brand.txt").'<br>to Latest Software</h3>
								</div>
								<div style="text-align: center; margin: auto; ">
									<button type="button" onclick="document.getElementById(\'file\').click()" style="width:220px; height:30px;"  data-i18n="lng.updatefirmware3">Click to select firmware upgrade</button>
									<div id="selectedfw" style="color: white;"><br/>
									</div>
									<br/>
									<input type="file" id="file" onchange="fwFileSelected()"  name="file"
									style="text-align: left; margin: auto; color: white; display:none" />
									<div>
										<h3 style="color: white; font-size: 18px; font-weight: normal;" data-i18n="lng.updatefirmware4">Keep User Settings?</h3>
									</div>
								</div>
								<div class="remote-form-inn">
									<div class="form-group">
										<select class="form-control placeholder-wh" name="userparams">
											<option value="keep"   data-i18n="lng.keepsettings" >Keep settings</option>
											<option value="remove" data-i18n="lng.removesetting">Remove settings</option>
										</select>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-default" data-i18n="lng.submit">Submit</button>
									</div>
								</div>
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


	<script>
		
		document.getElementById(\'file\').onchange = function () {
			$("#selectedfw").text(this.value.replace(/.*[\\\\]/, \'\'));
		};
		
	</script>

    ';
require_once('layout/footer.php');
 echo '
</body>
</html>';
