<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script([
    'CheckoutV2.sweetalert2.all.min.js',
    'CheckoutV2.alert.functions.js',
    'CheckoutV2.cart.functions.js'], ['fullBase' => true, 'block' => 'scriptBottom']);
?>
<section class="main">
    <?= $this->cell(\Cake\Core\Configure::read('Theme') . '.Banner::display', ['slug' => 'slider']) ?>

    <?= $this->cell(\Cake\Core\Configure::read('Theme') . '.Product::home') ?>

    <?= $this->cell(\Cake\Core\Configure::read('Theme') . '.Collection::get') ?>

</section>
