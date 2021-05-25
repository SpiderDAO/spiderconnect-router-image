<?php 
// <!--import seed phrase div-->

echo '
<div class="row d-flex justify-content-center align-items-center h-100">
    <div class="col-md-6 d-flex justify-content-center align-items-center h-100">
        <div id="seedPhraseDiv" class="card text-center" style="display: none">
            <div class="card-body">

                <h2 class="card-title">
                    <span data-i18n="lng.seedphrase">SEED PHRASE</span>
                </h2>
                <div class="row ml-1 mr-1">
                    <div class="form-group col-md-12">
                        <textarea id="phraseValue" class="form-control input-new" style="height: 100px"></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <button class="btn btn-primary btn-block" id="importSeedPhraseBtn" data-i18n="lng.import"> Import</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end  seed phrase-->';
