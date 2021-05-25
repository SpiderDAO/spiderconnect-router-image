<?php 
// <!--Create Wallet div-->

echo '
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-md-6 d-flex justify-content-center align-items-center h-100">
        <div id="createWalletDiv" class="card" style="display: none">
            <div class="card-body">

                <h3 class="card-title text-center">
                    <span>Wallet Created <br></span>
                    <span>Be sure to save all of the info below!</span>
                </h3>
                <div class="container px-3">
                    <div class="row mr-auto">
                        <div class="form-group col-md-12">

                            <label for="address" data-i18n="lng.address">Address</label>
                            <div class="input-group">
                                <input id="walletAddressText" readonly type="text" class="input-new-with-copy form-control"
                                       value=""
                                        data-i18n="[aria-label]lng.recipientaddress" aria-label="Recipient\'s username">
                                <div class="input-group-append">
                                    <button id="copyClipboard" class="btn btn-outline-secondary btn-copy" type="button">
                                        <li class="fa fa-clone"></li>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="balance" data-i18n="lng.balance">Balance</label>
                            <input id="walletBalanceText" type="text" class="form-control input-new" value="" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="balance" data-i18n="lng.mnemonic">Mnemonic</label>
                            <div class="input-group">
                                <input id="walletMnemonicText" class="form-control input-new-with-copy"
                                       id="walletBalanceText" readonly>
                                <div class="input-group-append">
                                    <button id="copyClipboard" class="btn btn-outline-secondary btn-copy" type="button">
                                        <li class="fa fa-clone"></li>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="balance">Public Key</label>
                            <div class="input-group">
                                <input id="walletPublicKeyText" class="form-control input-new-with-copy"
                                       id="walletBalanceText" readonly>
                                <div class="input-group-append">
                                    <button id="copyClipboard" class="btn btn-outline-secondary btn-copy" type="button">
                                        <li class="fa fa-clone"></li>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="balance" data-i18n="lng.privatekey">Private Key</label>
                            <div class="input-group">
                                <input id="walletPrivateKeyText" class="form-control input-new-with-copy"
                                       id="walletBalanceText" readonly>
                                <div class="input-group-append">
                                    <button id="copyClipboard" class="btn btn-outline-secondary btn-copy" type="button">
                                        <li class="fa fa-clone"></li>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                        <div style="background-color: red;font-size: 20px; font-color: white;" class="mb-2" data-i18n="lng.makesure">Make sure you saved the wallet info in a safe location</div>
                            <a class="btn btn-primary btn-block mb-4" id="goToProposalMain" data-i18n="lng.gotoproposals">Go to Proposals</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Create Wallet-->';
