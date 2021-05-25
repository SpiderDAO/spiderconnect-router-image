<?php


if (!file_exists("/tmp/address") || empty(file_get_contents("/tmp/address"))) {

	echo '
	
<style>
#proposal {
	display: none !important;
}
</style>
	
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-md-6 d-flex justify-content-center align-items-center h-100">
        <div id="walletDiv" class="card text-center">
            <div class="card-body">
                <div class="col-md-12">
                    <a class="btn btn-primary btn-block mt-4 mb-2" id="createWallet" data-i18n="lng.createwallet">Create Wallet</a>
                </div>
                 <!-- 
				 <div class="col-md-12">
                    <a class="btn btn-primary btn-block my-4" id="importWalletBtn" data-i18n="lng.importwallet">Import Wallet</a>
                </div>
				-->
              <!--   <div class="col-md-12">
                    <a class="btn btn-primary btn-block my-4" id="showProposalDemo" data-i18n="lng.proposal">Proposal</a>
                </div> -->
            </div>
        </div>
    </div>
</div>
';

}
//<!--end creat or import wallet-->
