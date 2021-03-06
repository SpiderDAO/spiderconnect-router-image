<?php 
// <!--import send & receive div-->

echo '
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-md-6 d-flex justify-content-center align-items-center h-100">
        <div id="sendReceiveDiv" class="card text-center" style="display: none">
            <div class="card-body">

                <h2 class="card-title">
                <a id="sendrecvBack"><i class="fa fa-arrow-left pull-right" aria-hidden="true"></i></a>
                    <span data-i18n="lng.balance">Balance <br></span>
                    <span class="balance"> '.(int)file_get_contents("/tmp/lastbalance").' SPDR</span>
                </h2>
                <div class="row ml-1 mr-1">
                    <div class="form-group col-md-6">
                        <button class="btn btn-primary btn-block" id="sendBtn" data-i18n="lng.send"> Send</button>
                    </div>
                    <div class="form-group col-md-6">
                        <button class="btn btn-primary btn-block" id="receiveBtn" data-i18n="lng.receive"> Receive</button>
                    </div>
                    <div class="form-group col-md-12">
                        <button class="btn btn-primary btn-block" id="sendReceiveProposal" data-i18n="lng.proposals"> Proposal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end  seed phrase-->';
