<?php
/**
 * @var \App\View\AppView $this
 */
?>
<input name="shipment-cart" id="<?= $quote['code'] ?>" value="<?= $quote['code'] ?>" type="radio"
       class="btn-quote-choose"
       data-shipping-quote="<?= $quote['code'] ?>"
       data-shipping-quote-price="<?= $quote['cost'] ?>"
       data-shipping-title="<?= $quote['title'] ?>">
<label for="<?= $quote['code'] ?>"><strong><?= $quote['text'] ?></strong> <?= $quote['title'] ?></label>