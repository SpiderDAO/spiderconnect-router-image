<?php 
// <!--import send & receive div-->

echo '
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-md-6 d-flex justify-content-center align-items-center h-100">
        <div id="sendDiv" class="card" style="display: none">
            <div class="card-body">

                <h2 class="card-title text-center">
                <a id="cancelSendBtn"><i class="fa fa-arrow-left pull-right" aria-hidden="true"></i></a>
                    Enter receiver\'s $SPDR Address

                </h2>
                <form id="sendForm" class="row ml-1 mr-1">
                    <div class="form-group col-md-12">
                        <label for="balance">Input $SPDR Address</label>
                        <input id="ecrAddress" type="text" class="form-control input-new" value="">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="balance">Amount</label>
                        <input id="sendValue" type="text" class="form-control input-new" value="">
                    </div>
                    <!--
                    <div class="form-group col-md-6">
                        <label class="btn btn-primary btn-block" id="cancelSendBtn"> Go back</label>
                    </div>
                    -->
                    <div class="form-group col">
                        <button class="btn btn-primary btn-block">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end  seed phrase-->';
