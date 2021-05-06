<?php
require_once('/www/init.php');
require_once('layout/content.php');

echo '
<div class="overlay"></div>
<div class="spanner show">
    <h2 style="position: relative;top: 35%;left: 0">Please wait while your request is processing</h2>

    <div class="loader">

</div>
</div>';

require_once('template/views/wallet.php');
require_once('template/views/create_wallet.php');
require_once('template/views/import_wallet.php');
require_once('template/views/import_seed_phrase.php');
require_once('template/views/main_proposal.php');
require_once('template/views/referendum.php');

require_once('template/views/show_proposal.php');
require_once('template/views/create_proposal.php');
require_once('template/views/send_receive.php');
require_once('template/views/send.php');
require_once('template/views/receive.php');
require_once('template/views/confirmation_message.php');
require_once('template/views/error_message.php');
require_once('template/views/success_message.php');

echo '
<script>

    $(document).ready(function () {

    	checkPhrase="' . $phrase . '"
    	if(checkPhrase !=null){
			$("#proposal").show()
     	}
    	else
    	{
    		$("#walletDiv").show()

    	}
        // var phraseText = "tribe pond decorate tribe blur cat wall rare boss strategy wheat fan"
        $("#createWalletDiv").on("click", "#copyClipboard", function () {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).closest(".input-group").find("input").val()).select();
            document.execCommand("copy");
            $temp.remove();

        })
        $("#receiveDiv").on("click", "#copyClipboard", function () {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).closest(".input-group").find("input").val()).select();
            document.execCommand("copy");
            $temp.remove();

        })
        $("#goToProposalMain").click(function () {
            location.reload();
        });
        $("#receiveBtn").click(function () {
            $("#receiveDiv").show()
            $("#sendReceiveDiv").hide()
        });
        $("#sendBtn").click(function () {
            $("#sendReceiveDiv").hide()
            $("#sendDiv").show()
        });
        $("#sendReceiveProposal").click(function () {
            $("#sendReceiveDiv").hide()
            $("#proposal").show()
        });
        $("#cancelSendBtn").click(function () {
            $("#sendReceiveDiv").show()
            $("#sendDiv").hide()
            $("#receiveDiv").hide()
        });
        $("#cancelReceiveBtn").click(function () {
            $("#sendReceiveDiv").show()
            $("#receiveDiv").hide()
        });

        $("#sendAndReceiveBtn").click(function () {
            $("#sendReceiveDiv").show()
            $("#proposal").hide()
        });
        $("#showProposalDemo").click(function () {
            $("#walletDiv").hide()
            $("#proposal").show()

        })
        $("#importWalletBtn").click(function () {
            $("#walletDiv").hide()
            $("#importWallet").show()
        });
        $("#seedPhrase").click(function () {
            $("#importWallet").hide()
            $("#seedPhraseDiv").show()
        });

        function showOverlay() {
            $("div.spanner").addClass("show");
            $("div.overlay").addClass("show");
        }

        function hideOverlay() {
            $("div.spanner").removeClass("show");
            $("div.overlay").removeClass("show");
        }

        var allModules;
        $("#showReferendum").hide()
        $("#showProposal").hide()

        $("#referendumBack").click(function () {
            $("#showReferendum").hide()
            $("#proposal").show()
            $(".inside-card").remove()

        });
        $("#choosePropBack").click(function () {
            $("#showProposal").hide()
            $("#proposal").show()
            $(".inside-card").remove()

        });
        $("#createPropBack").click(function () {
            $("#createProposal").hide()
            $("#proposal").show()
            $(".modFun").remove()
            $(".funArg").remove()
            $("#createPropFormSelect").find("option").remove()
            $("#submitProp").remove()
        });
        $("#sendrecvBack").click(function () {
            $("#sendReceiveDiv").hide()
            $("#proposal").show()
        });
		';

echo '
        $("#get_refs").click(function () {
            showOverlay()
            $.ajax({
                method: "POST",
                url: "' . SPIDERVPN_WALLET_API_URL . '/get_ref",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    request_id: "get_refs",
                    spider_id: "' . $spider_id . '",
                    phrase: "' . $phrase . '",
                    ref_index: "-1"
                }),
                cache: false,
                timeout: 3600000 //in milliseconds
            }).done(function (data) {
                $("#proposal").hide()

                hideOverlay()
                console.log(data)
                hideOverlay()
				if (data == "No Referendums Available") {
					$(\'#allRef\').append(\'<div class="inside-card mb-3"><div class="ref-msg">\' + "No Referendums Available" + \'</div>\</div>\');
				} else {
					$.each(data, function (index, value) {
					if(value.status=="ended"){
						$(\'#allRef\').append(\'<div class="inside-card mb-3"><div class="ref-msg">\' + value.ref_msg + \'</div>\' +
							\'<input id="refIndex" type="hidden" value=\' + value.ref_idx + \'>\' +
							\'<button class="btn btn-inside-card w-100">Finished</button></div>\');
							}
							else{
							$(\'#allRef\').append(\'<div class="inside-card mb-3"><div class="ref-msg">\' + value.ref_msg + \'</div>\' +
							\'<input id="refIndex" type="hidden" value=\' + value.ref_idx + \'>\' +
							\'<button id="voteRef" class="btn btn-inside-card w-50">Vote Yes</button>\' +
							\'<input id="refIndexNo" type="hidden" value=\' + value.ref_idx + \'>\' +
							\'<button id="voteRefNo" class="btn btn-inside-card w-50">Vote No</button></div>\');
							}
					});
				}


                $("#showReferendum").show()


                processing = 0;
            }).fail(function (response) {
                console.log(response)
                processing = 0;
                alert("Error, please try later.");
            });
        });
        $("#get_props2").click(function () {
            showOverlay()
            $.ajax({
                method: "POST",
                url: "' . SPIDERVPN_WALLET_API_URL . '/get_props",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    request_id: "get_props",
                    spider_id: "' . $spider_id . '",
                    phrase:"' . $phrase . '"
                }),
                cache: false,
                timeout: 3600000 //in milliseconds
            }).done(function (data) {
                hideOverlay()
				if (data == "No Proposals Available") {
					$(\'#allProp\').append(\'<div class="inside-card mb-3"><div class="ref-msg">\' + "No Proposals Available" + \'</div></div>\');
				} else {
					$.each(data, function (index, value) {
						$(\'#allProp\').append(\'<div class="inside-card mb-3"><div class="ref-msg">\' + value.prop_msg + \'</div><input id="propIndex" type="hidden" value=\' + value.prop_idx + \'><button class="btn btn-block btn-inside-card" id="second">Second</button></div>\');

					});
				}

                $("#showProposal").show()
                $("#proposal").hide()


                processing = 0;
            }).fail(function (response) {
                console.log(response)
                processing = 0;
                alert("Error, please try later.");
            });
        });
        $("#createPropBtn").click(function () {
            showOverlay()
            $.ajax({
                method: "POST",
                url: "' . SPIDERVPN_WALLET_API_URL . '/get_chain_modules",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    request_id: "get_chain_modules",
                    spider_id: "' . $spider_id . '",
                    phrase: "' . $phrase . '"
                }),
                cache: false,
                timeout: 3600000 //in milliseconds
            }).done(function (data) {
                console.log(data)
                hideOverlay()
                $("#proposal").hide()
                $("#createProposal").show()
                var modules = Object.keys(data)

                allModules = data
                $.each(data, function (index, value) {
                    $(\'#createPropFormSelect\').append(\'<option value=\' + index + \'>\' + index + \'</option>\');
                });
                $.each(data[modules[0]], function (index, value) {
                    console.log(value.doc)
					//alert(index);
					var doc = value.doc;
					if (index == "transfer") {
						doc = "Here, you can propose to send funds to another member directly to his wallet from your own account. This transaction can be put as proposition to the community for their approval or disapproval.";
					} else if (index == "propose_bounty") {
						doc = "Here, you can create a custom proposal that will be presented to the community in the form of a referendum for their consideration. Your proposal will be voted on and the outcome will be decided after a set period of time. Custom proposals can include bounties awarded for a positive outcome.";
					}
                    $(\'#createPropForm\').append(\'<div class="form-group col-md-6 modFun"> <label class="form-control btn btn-block modFunbtn" tabindex="1" id=\' + index + \'>\' + value.display_name + \'</label><div class="hideDesc">\' + doc + \'</div></div>\');

                });
            }).fail(function () {

                alert("Error, please try later.");
            });
        });

        $("#createPropForm").on("click", "label", function () {

            $("modFunbtn").removeClass("selected");
            $(this).addClass("selected");
            $(".funArg").remove()
            $("#callID").val(this.id)
            moduleFunctionArg = allModules[$("#createPropFormSelect").val()][this.id]["args"]
            console.log(moduleFunctionArg)
            $.each(moduleFunctionArg, function (index, value) {
                $(\'#createPropForm\').append(\'<div class="form-group col-md-12 funArg"> <input type="text" class="form-control funArgInput " value="" name=\' + value.name + \' placeholder=\' + value.name + \' id=\' + value.name + \'></div>\');
            });
            $(\'#createPropForm\').append(\'<div class="form-group col-md-12 funArg"><input id="submitProp" type="submit" class="btn btn-primary btn-block" value="Propose"></div>\');

        });
        $("#createPropFormSelect").change(function () {
            $(".modFun").remove()
            $(".funArg").remove()
            $.each(allModules[this.value], function (index, value) {
				var doc = value.doc;
				//alert(index);
				if (index == "transfer") {
					doc = "Here, you can propose to send funds to another member directly to his wallet from your own account. This transaction can be put as proposition to the community for their approval or disapproval.";
				} else if (index == "propose_bounty") {
					doc = "Here, you can create a custom proposal that will be presented to the community in the form of a referendum for their consideration. Your proposal will be voted on and the outcome will be decided after a set period of time. Custom proposals can include bounties awarded for a positive outcome.";
				}
                $(\'#createPropForm\').append(\'<div class="form-group col-md-6 modFun"> <label class="form-control btn btn-block modFunbtn" tabindex="1" id=\' + index + \'>\' + value.display_name + \'</label><div class="hideDesc">\' + doc + \'</div></div>\');

            });
        });
       $("#createPropForm").submit(function (event) {
            var functionArg = {};
            var preimage_hash
            event.preventDefault();
            $.each($("#createPropForm :input[type=text]").serializeArray(), function (index, value) {
                functionArg[value.name] = value.value;
            });
            showOverlay()
            $.ajax({
                method: "POST",
                url: "' . SPIDERVPN_WALLET_API_URL . '/pre_propose",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    request_id: "pre_propose",
                    module_name: $("#createPropFormSelect").val(),
                    call_id: $("#callID").val(),
                    call_params: functionArg,
                    spider_id: "' . $spider_id . '",
                    phrase: "' . $phrase . '"
                }),
                cache: false,
                timeout: 3600000 //in milliseconds
            })
                .done(function (data) {
                console.log(data)
                if(data.error){

                    $("#createProposal").hide()
                    hideOverlay()
                    $("#errorDiv").show()
                    $("div#errorMessage").html("<h3>"+ data.error +"</h3>")
                    $("#backError").click(function(){
                        $("#errorDiv").hide()
                        $("div#errorMessage").html("")
                        $("#createProposal").show()
                    });
                    return false;
                }
                $("#createProposal").hide()
                hideOverlay()
                $("div#PropConfirmMessage").html("<h3>Storage fee is "+ data.storageFee +" SPDR</h3>")
                $("#confirmDiv").show();
                preimage_hash = data.preimage_hash

                $("#sendPropConfirm").click(function(){
                    showOverlay()
                    $.ajax(
                        {
                            method: "POST",
                            url: "' . SPIDERVPN_WALLET_API_URL . '/propose",
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            data: JSON.stringify({
                                request_id: "propose",
                                spider_id: "' . $spider_id . '",
                                phrase: "' . $phrase . '",
                                preimage_hash: preimage_hash
                            }),
                            cache: false,
                            timeout: 3600000 //in milliseconds
                        }).done(function (data) {
                        console.log(data)
                        $(".modFun").remove()
                        $(".funArg").remove()
                        $(".funArg").remove()
                        $("#submitProp").remove()
                        hideOverlay()
                        $("#confirmDiv").hide()
                        $("#get_props2").click();

                    }).fail(function () {
                        $("#showProposal").hide()
                        hideOverlay()
                        $("#errorDiv").show()
                        $("div#errorMessage").html("<h3>"+ data.error +"</h3>")
                        $("#backError").click(function(){
                            $("#errorDiv").hide()
                            $("div#errorMessage").html("")
                            $("#showProposal").show()
                        });
                        return false;
                    });
                });
                $("#cancelPropConfirm").click(function(){
                    $("#confirmDiv").hide();
                    $("div#PropConfirmMessage").html("")

                    $("#createProposal").show()
                });

                if (r == true) {

                    processing = 1;
                    updating();

                    $.ajax({
                        method: "POST",
                        url: "' . SPIDERVPN_WALLET_API_URL . '/propose",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        data: JSON.stringify({
                            request_id: "propose",
                            spider_id: "' . $spider_id . '",
                            phrase: "' . $phrase . '",
                            preimage_hash: $("#preimage_hash").html()
                        }),
                        cache: false,
                        timeout: 3600000 //in milliseconds
                    }).done(function (data) {
                        //updated(data);
                        //updated();
                        $("#preimage_hash").html("");
                        processing = 0;
                        $("#update_balance").click();
                    }).fail(function () {
                        processing = 0;
                        alert("Error, please try later.");
                    });
                } else {
                    //updated();
                    $("#update_balance").click();
                }

                processing = 0;

            })
                .fail(function () {
                    $("#createProposal").hide()
                    hideOverlay()
                    $("#errorDiv").show()
                    $("div#errorMessage").html("<h3>"+ data.error +"</h3>")
                    $("#backError").click(function(){
                        $("#errorDiv").hide()
                        $("div#errorMessage").html("")
                        $("#createProposal").show()
                    });
                    return false;
            });
        });
        $("#createWallet").click(function () {
            showOverlay()
            $.ajax({
                method: "POST",
                url: "' . SPIDERVPN_WALLET_API_URL . '/create_wallet",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    request_id: "create_wallet",
                    spider_id: "' . $spider_id . '"
                }),
                cache: false,
                timeout: 3600000 //in milliseconds
            }).done(function (data, textStatus, jqXHR) {
                console.log(data)
                //alert("Data Received: " +data.address);

                $("#walletAddressText").val(data.address)
                $("#walletBalanceText").val(data.balance)
                $("#walletMnemonicText").val(data.mnemonic)
                $("#walletPrivateKeyText").val(data.private_key)
                $("#walletPublicKeyText").val(data.public_key)
                hideOverlay()
                $("#createWalletDiv").show()
                $("#walletDiv").hide()
                processing = 0;
                $.ajax({
                    method: "POST",
                    url: "/config_api.php?savekeys=1&_" + (new Date).getTime(),
                    data: JSON.stringify({data: data}),
                }).done(function (data, textStatus, jqXHR) {
                    var data = JSON.parse(data);
                    if (data.status != "ok") {
                        alert(data.status);
                    } else {

                        if (e.target.id == "create_wallet3") {
                            alert("Done, please reload this page now");
                        }

                        $("#reload_page2").fadeIn();
                        $("#create_wallet2").hide();
                    }
                }).fail(function () {
                    alert("Can\'t save keys in router\'s flash memory.");
                    processing = 0;
                });
                 $.ajax({
                method: "POST",
                url: "/config_api.php?lastbalance=1&_" + (new Date).getTime(),
                data: JSON.stringify({data: "SPDR" +  data.balance}),
            }).done(function (data, textStatus, jqXHR) {
                //alert("save_keys feedback - "+data);
            }).fail(function () {
                alert("Can\'t save keys in router\'s flash memory.");
                processing = 0;
            });
            }).fail(function () {
                alert("Error, please try later.");
                processing = 0;
            });
        });
        $("#importSeedPhraseBtn").click(function () {
            showOverlay()

            $.ajax({
                method: "POST",
                url: "' . SPIDERVPN_WALLET_API_URL . '/import_wallet",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    request_id: "import_wallet",
                    spider_id: "' . $spider_id . '",
					phrase: checkPhrase
                    //phrase: $("#phraseValue").val().trim()
                }),
                cache: false,
                timeout: 3600000 //in milliseconds
            }).done(function (data, textStatus, jqXHR) {

				$( "#update_balance" ).click();

                //console.log(data)
                hideOverlay()
                //alert("Data Received: " +data.address);
                processing = 0;

				$(".balance").text(data.balance +" SPDR");

                $.ajax({
                    method: "POST",
                    url: "/config_api.php?savekeys=1&_" + (new Date).getTime(),
                    data: JSON.stringify({data: data}),
                }).done(function (data, textStatus, jqXHR) {
                    //alert("save_keys feedback - "+data);

                }).fail(function () {
                    alert("Can\'t save keys in router\'s flash memory.");
                    processing = 0;
                });

				$.ajax({
					method: "POST",
					url: "' . SPIDERVPN_WALLET_API_URL . '/get_balance",
					contentType: "application/json; charset=utf-8",
					dataType: "json",
					data: JSON.stringify({
						request_id: "get_balance",
						spider_id: "' . $spider_id . '",
						phrase: "' . $phrase . '",
						address: "' . $address . '"
					}),
					cache: false,
					timeout: 3600000 //in milliseconds
				}).done(function( data ) {
					//alert("Balance: "+data.balance);
					if (Number.isFinite(data.balance)) {
						var balance = data.balance/1000000000000;
						$(".balance").html(balance.toLocaleString("en-US", {minimumFractionDigits: 4})+" SPDR");
					} else {

					}

					$("#update_balance").removeClass("rotate");
					$.ajax({
						method: "POST",
						url: "/config_api.php?lastbalance=1&_"+ (new Date).getTime(),
						data: JSON.stringify({ data: "SPDR"+balance }),
					}).done(function( data, textStatus, jqXHR ) {
						//alert("save_keys feedback - "+data);
					}).fail(function () {
						alert("Can\'t save keys in router\'s flash memory.");
						processing = 0;
					});
				}).fail(function () {
					alert("Error, please try later.");
				});

            }).fail(function () {
                alert("Error, please try later.");
                processing = 0;
            });
        });
        $("#allRef").on("click", "#voteRef", function () {

            var ref_index = $(this).prev("input").val()

            showOverlay()
            $.ajax({
                method: "POST",
                url: "' . SPIDERVPN_WALLET_API_URL . '/vote",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    request_id: "vote",
                    ref_index: ref_index,
                    phrase: "' . $phrase . '",
					spider_id: "' . $spider_id . '",
                    vote: "yes"
                }),
                cache: false,
                timeout: 3600000 //in milliseconds
            }).done(function (data) {
                hideOverlay();
                console.log(data)
                if(data.error){
                  $("#showReferendum").hide()
                    hideOverlay()
                  $("#errorDiv").show()
        $("div#errorMessage").html("<h3>"+ data.error +"</h3>")
        $("#backError").click(function(){
        $("#errorDiv").hide()
         $("div#errorMessage").html("")
          $("#showReferendum").show()
        });
return false;
                }
                else{
                $("#showReferendum").hide()
                    hideOverlay()
                  $("#successDiv").show()
        $("div#successMessage").html("<h3>You have voted "+ data.vote+" on Referendum "+ data.ref_index +"</h3>")
        $("#backSuccess").click(function(){
        $("#successDiv").hide()
         $("div#successMessage").html("")
          $("#showReferendum").show()
        });
return false;
                }
                console.log(data);
            }).fail(function () {
                processing = 0;
                alert("Error, please try later.");
            });
        });
        $("#allRef").on("click", "#voteRefNo", function () {

            var ref_index = $(this).prev("input").val()

            showOverlay()
            $.ajax({
                method: "POST",
                url: "' . SPIDERVPN_WALLET_API_URL . '/vote",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    request_id: "vote",
                    ref_index: ref_index,
                    phrase: "' . $phrase . '",
					spider_id: "' . $spider_id . '",
                    vote: "no"
                }),
                cache: false,
                timeout: 3600000 //in milliseconds
            }).done(function (data) {
                hideOverlay();
                console.log(data);
                  if(data.error){
                  $("#showReferendum").hide()
                    hideOverlay()
                  $("#errorDiv").show()
        $("div#errorMessage").html("<h3>"+ data.error +"</h3>")
        $("#backError").click(function(){
        $("#errorDiv").hide()
         $("div#errorMessage").html("")
          $("#showReferendum").show()
        });
return false;
                }
                  else{
                $("#showReferendum").hide()
                    hideOverlay()
                  $("#successDiv").show()
        $("div#successMessage").html("<h3>You have voted "+ data.vote+" on Referendum "+ data.ref_index +"</h3>")
        $("#backSuccess").click(function(){
        $("#successDiv").hide()
         $("div#successMessage").html("")
          $("#showReferendum").show()
        });
return false;
                }
            }).fail(function () {
                processing = 0;
                alert("Error, please try later.");
            });
        });
        $(document).on("click", "#second", function () {
            showOverlay()
            $.ajax({
                method: "POST",
                url: "' . SPIDERVPN_WALLET_API_URL . '/second",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    request_id: "second",
                    spider_id: "' . $spider_id . '",
                    phrase: "' . $phrase . '",
                    prop_index: $(this).prev("input").val()
                }),
                cache: false,
                timeout: 3600000 //in milliseconds
            }).done(function (data) {
                hideOverlay();
                console.log(data);
                    if(data.error){
                  $("#showProposal").hide()
                    hideOverlay()
                  $("#errorDiv").show()
        $("div#errorMessage").html("<h3>"+ data.error +"</h3>")
        $("#backError").click(function(){
        $("#errorDiv").hide()
         $("div#errorMessage").html("")
          $("#showProposal").show()
        });
return false;
                }
                  else{
                $("#showProposal").hide()
                    hideOverlay()
                  $("#successDiv").show()
        $("div#successMessage").html("<h3> You Seconded Proposal "+ data.prop_index +"</h3>")
        $("#backSuccess").click(function(){
        $("#successDiv").hide()
         $("div#successMessage").html("")
          $("#showProposal").show()
        });
return false;
                }
            }).fail(function () {
                 $("#showProposal").hide()
                    hideOverlay()
                  $("#errorDiv").show()
        $("div#errorMessage").html("<h3>"+ data.error +"</h3>")
        $("#backError").click(function(){
        $("#errorDiv").hide()
         $("div#errorMessage").html("")
          $("#showProposal").show()
        });
return false;
            });
        });
        $("#sendForm").submit(function (event) {
            showOverlay()
            $("#sendMessage").remove()
            event.preventDefault()
            $.ajax({
                method: "POST",
                url: "' . SPIDERVPN_WALLET_API_URL . '/send_balance",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify({
                    request_id: "send_balance",
                    spider_id: "' . $spider_id . '",
                    phrase: "' . $phrase . '",
                    address: $("#ecrAddress").val(),
                    value: $("#sendValue").val()
                }),
                cache: false,
                timeout: 3600000 //in milliseconds
            }).done(function (data) {
                hideOverlay()
                if (data.success)
                    $(\'<div id="sendMessage" class="col-md-12 badge badge-dark" style="font-size: 15px; word-wrap: break-word;white-space: normal !important;">\' + data.success + \'</div>\').insertAfter(\'#sendValue\')
                if (data.error)
                    $(\'<div id="sendMessage" class="col-md-12 badge badge-danger" style="font-size: 15px;word-wrap: break-word;white-space: normal !important;">\' + data.error + \'</div>\').insertAfter(\'#sendValue\')

                console.log(data)

            }).fail(function (response) {
                console.log(response)
                processing = 0;
                alert("Error, please try later.");
            });
        });


		$("#importSeedPhraseBtn").click();
    });

</script>
';

require_once('layout/footer.php');
echo '
</body>
</html>
';
