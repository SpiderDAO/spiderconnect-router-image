<?php 
// <!--proposal div-->

echo '
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-md-6 d-flex justify-content-center align-items-center h-100">
        <div id="proposal" class="card text-center" style="display: none">
            <!--        <div id="proposal" class="card text-center"">-->
            <div class="card-body">

                <h3 class="card-title">
                 
                    <span >Balance <br></span>
                    <span>
					<span class="balance"> '.(int)file_get_contents("/tmp/lastbalance").' SPDR</span>
                </h3>
                <div class="col-md-12">
                    <a class="btn btn-primary btn-block mt-5" id="sendAndReceiveBtn">Send & Receive</a>
                </div>
                <div class="col-md-12">
                    <a class="btn btn-primary btn-block mt-2 mb-2" id="createPropBtn">Create a Proposal</a>
                </div>
                <div class="col-md-12">
                    <a class="btn btn-primary btn-block my-2" id="get_props2">Proposals</a>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-primary btn-block mt-2 mb-5" id="get_refs">Referendums</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!--end proposal-->';
