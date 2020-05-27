<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="grid form-grid">
    <div class="col" id="ppplus" style="height: 510px;">
    </div>
    <div class="col text-center">
        <button class='btn btn-success btn-lg mt-2' type="button" onclick="ppp.doContinue(); return false;">Confirmar Pagamento
        </button>
        <p class="continue">ou <?= $this->Html->link('Alterar forma de pagamento', [
                'controller' => 'checkout',
                'action' => 'choose-payment'
            ]) ?></p>
    </div>
</div>

<script type="text/javascript">
    var paypalscript = document.createElement('script');

    paypalscript.src = "https://www.paypalobjects.com/webstatic/ppplusdcc/ppplusdcc.min.js";
    paypalscript.onload = function () {
        window.ppp = PAYPAL.apps.PPP({
            "approvalUrl": "<?= $approval_url ?>",
            "placeholder": "ppplus",
            "mode": '<?= $mode ?>',
            'payerEmail': '<?= $email ?>',
            'payerFirstName': '<?= $first_name ?>',
            'payerLastName': '<?= $last_name ?>',
            'payerTaxId': '<?= $customer['document'] ?>',
            'onContinue': responseContinue,
            'onError': responseError,
            'language': 'pt_BR',
            'country': 'BR'
        });
    };
    document.body.appendChild(paypalscript);

    function responseContinue(rememberedCardsToken, payerId, token) {
        $.ajax({
            type: "POST",
            url: base_url + "finalizar-compra/paypal-plus/execute.json",
            data: {rememberedCardsToken: rememberedCardsToken, payerId: payerId, token: token},
            dataType: 'json',
            beforeSend: function () {
                loading('Processando pagamento');
            },
            complete: function () {
            },
            success: function (result) {
                if (result.data.status) {
                    window.location = result.data.redirect;
                } else {
                    loadingClose();
                    alertDialog(result.data.message, 'error');
                }
            }
        });
    }

    function responseError(a) {

    }
</script>

