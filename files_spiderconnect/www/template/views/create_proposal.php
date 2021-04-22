<?php 
// <!--Create Proposal-->

echo '
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-md-6 d-flex justify-content-center align-items-center h-100">
        <div class="card text-center" id="createProposal" style="display: none">
            <div class="card-body">

                <h3 class="card-title">
                    <img class="walletmenu pull-left" src="assets/images/walletmenu.png" width="35px">
                    <a id="createPropBack"><i class="fa fa-arrow-left pull-right" aria-hidden="true"></i></a>

                    <span>Create Proposal <br></span>
                </h3>

                <form id="createPropForm" class="row col-md-12 mr-auto" style="height: 100%">

                    <input id="callID" type="hidden" name="call_id" value="">
                    <div class="form-group col-md-12">
                        <select class="form-control select-form" name="module_name" id="createPropFormSelect"></select>

                    </div>


                </form>


            </div>
        </div>
    </div>
</div>
<!--end create Proposal-->';
