<?php

$scriptname = @basename($_SERVER["SCRIPT_FILENAME"]);
$page1 = ($scriptname=="activation.php"?true:false);
echo '

<style>

	.dot {
	  height: 12px;
	  width: 12px;
	  background-color: #bbb;
	  border-radius: 50%;
	  display: inline-block;
	}
	
	.green {
		background-color: #007771;
		border-radius: 50%;
		margin-right: 5px;
	}
	
	.grey {
		background-color: grey;
		border-radius: 50%;
	}
	
	.red {
		background-color: red;
		border-radius: 50%;
	}	
	
</style>

<script>

var brand      = "'.file_get_contents("/brand/brand.txt").'";
var shortbrand = "'.file_get_contents("/brand/shortbrand.txt").'";
var wannocable = "'.file_get_contents("/brand/wannocable.txt").'";
var wanunknown = "'.file_get_contents("/brand/wanunknown.txt").'";
var feedback   = "'.file_get_contents("/brand/feedback.txt").'";
var ipinfo     = "'.file_get_contents("/brand/ipinfo.txt").'";

</script>

            <div class="header-top" style="width: 75%; font-size: 16px; display:table;'.($page1?"padding: 10px;":"").'">
				

				<span style="color: white;  width: 40%; text-align: center; display:table-cell; vertical-align:middle;     padding-top: 5px;">
					<label>
						<span id="ping1" class="dot grey">
						</span>
						<span id="ping1label" style="position: relative; bottom: 1px;">
							Checking WAN state...
						<span>
					</label>
				</span>
				<span style="color: white;  width: 40%; text-align: center; display:table-cell; vertical-align:middle;     padding-top: 5px;">
					<label>
						<span id="ping2" class="dot grey">
						</span>
						<span id="ping2label" style="position: relative; bottom: 1px;">
							Checking VPN state...
						<span>
					</label>
				</span>
				
                <a id="refresh-btn" href="#" data-placement="bottom" 
                   title="Refresh" onclick="refresh()">
				   <i class="fa fa-refresh" aria-hidden="true">
				   </i></a>
            </div>


';












?>
