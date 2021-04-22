<?php 
// <!--import send & receive div-->

echo '
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-md-6 d-flex justify-content-center align-items-center h-100">
        <div id="sendDiv" class="card" style="display: none">
            <div class="card-body">

                <h2 class="card-title text-center">
                    Enter receiver\'s ERC20 Address

                </h2>
                <form id="sendForm" class="row ml-1 mr-1">
                    <div class="form-group col-md-12">
                        <label for="balance">Input ERC20 Address</label>
                        <input id="ecrAddress" type="text" class="form-control input-new" value="">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="balance">Value</label>
                        <input id="sendValue" type="text" class="form-control input-new" value="">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="btn btn-primary btn-block" id="cancelSendBtn"> Go back</label>
                    </div>
                    <div class="form-group col-md-6">
                        <button class="btn btn-primary btn-block"> Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end  seed phrase-->';
