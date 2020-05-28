<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
    <?php if($quote['image']): ?>
        <div class="col-md-2">
            <?= $this->Html->image($quote['image']) ?>
        </div>
        <div class="col-md-4">
            <?= $quote['title'] ?>
        </div>
    <?php else: ?>
        <div class="col-md-6">
            <?= $quote['title'] ?>
        </div>
    <?php endif; ?>
    <div class="col-md-2">
        <?= $quote['text'] ?>
    </div>
    <div class="col-md-2">
        <?= $this->Html->link("<i class=\"fa fa-check\" aria-hidden=\"true\"></i>", '', ['escape' => false, 'class' => 'btn btn-sm btn-accent btn-quote-choose', 'data-shipping-quote' => $quote['code'], 'data-shipping-quote-price' => $quote['cost'], 'data-shipping-title' => $quote['title']]) ?>
    </div>
</div>