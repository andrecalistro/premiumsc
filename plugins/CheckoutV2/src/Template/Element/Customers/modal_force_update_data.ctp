<?php
/**
 * @var \App\View\AppView $this
 */
if ($_auth['force_update_data']) {
    $this->Html->script(['Checkout.sweetalert2.all.min.js', 'Checkout.jquery.mask.js', 'Checkout.alert.functions.js', 'Checkout.mask.functions.js', 'Checkout.customer.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
    $this->Html->scriptBlock('
    $(window).on(\'load\',function(){
        $(\'#modal-force-update-data\').modal(\'show\');
    });
    ', ['block' => 'scriptBottom']);
    echo $this->cell('Checkout.Customer::forceUpdateData');
}