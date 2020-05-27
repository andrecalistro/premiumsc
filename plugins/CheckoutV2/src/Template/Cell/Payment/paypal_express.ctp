<?php
/**
 * @var \App\View\AppView $this
 */
?>
<a id="button-confirm" href="<?= $this->Url->build(['controller' => 'paypal-express', 'action' => 'transaction', 'plugin' => 'CheckoutV2'], ['fullBase' => true]) ?>"></a>
<script type="text/javascript"><!--
    window.paypalCheckoutReady = function () {
        paypal.checkout.setup('{{ username }}', {
            container: 'button-confirm',
            environment: 'sandbox'
        });
    };
    //--></script>
<script src="//www.paypalobjects.com/api/checkout.js" async></script>
