<?php 
// <!--import send & receive div-->

echo '
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-md-6 d-flex justify-content-center align-items-center h-100">
        <div id="sendReceiveDiv" class="card text-center" style="display: none">
            <div class="card-body">

                <h2 class="card-title">
                    <span>Balance <br></span>
                    <span class="balance"> '.(int)file_get_contents("/tmp/lastbalance").' SPDR</span>
                </h2>
                <div class="row ml-1 mr-1">
                    <div class="form-group col-md-6">
                        <button class="btn btn-primary btn-block" id="sendBtn"> Send</button>
                    </div>
                    <div class="form-group col-md-6">
                        <button class="btn btn-primary btn-block" id="receiveBtn"> Receive</button>
                    </div>
                    <div class="form-group col-md-12">
                        <button class="btn btn-primary btn-block" id="sendReceiveProposal"> Proposal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end  seed phrase-->';
