<?php 
// <!--show proposal-->

echo '
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-md-6 d-flex justify-content-center align-items-center h-100">
        <div class="card text-center" id="showProposal" style="display: none">
            <div class="card-body">

                <h3 class="card-title">
                    <img class="walletmenu pull-left" src="assets/images/walletmenu.png" width="35px">
                    <a id="choosePropBack"><i class="fa fa-arrow-left pull-right" aria-hidden="true"></i></a>

                    <span>Choose Proposal <br></span>
                </h3>

                <div id="allProp" class="col-md-12" style="max-height: 300px;overflow-y: scroll;">

                </div>

            </div>
        </div>
    </div>
</div>
<!--end show proposal-->';
