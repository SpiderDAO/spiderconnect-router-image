<?php 
// <!--Create Wallet div-->

echo '
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-md-6 d-flex justify-content-center align-items-center h-100">
        <div id="receiveDiv" class="card" style="display: none">
            <div class="card-body">

                <h3 class="card-title text-center">
                <a id="cancelReceiveBtn"><i class="fa fa-arrow-left pull-right" aria-hidden="true"></i></a>
                    <span>Your Address<br></span>
                </h3>
                <div class="container px-3">
                    <div class="row mr-auto">
                        <div class="form-group col-md-12">

                            <label for="address">Address</label>
                            <div class="input-group">
                                <input id="userAddress" type="text" readonly class="input-new-with-copy form-control"
                                       value="'.$address.'">
                                <div class="input-group-append">
                                    <button id="copyClipboard" class="btn btn-outline-secondary btn-copy" type="button">
                                        <li class="fa fa-clone"></li>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="col-md-12">
                            <a class="btn btn-primary btn-block mb-4" id="cancelReceiveBtn">Go back </a>
                        </div>
                        -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Create Wallet-->';
