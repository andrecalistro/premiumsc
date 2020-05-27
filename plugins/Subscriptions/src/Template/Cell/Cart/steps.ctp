<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="container">
    <div class="status-pedido row">
        <div class="col text-center">
            <div class="marcador-status <?= $steps[1] ?>">
                <?= $this->Html->image('Checkout.icones/ico-status-identificacao.png') ?>
            </div>
            <p>Identificação</p>
        </div>
        <div class="col text-center">
            <div class="marcador-status <?= $steps[2] ?>">
                <?= $this->Html->image('Checkout.icones/ico-status-envio.png') ?>
            </div>
            <p>Envio</p>
        </div>
        <div class="col text-center">
            <div class="marcador-status <?= $steps[3] ?>">
                <?= $this->Html->image('Checkout.icones/ico-status-pagamento.png') ?>
            </div>
            <p>Pagamento</p>
        </div>
        <div class="col text-center">
            <div class="marcador-status border-zero  <?= $steps[4] ?>">
                <?= $this->Html->image('Checkout.icones/ico-status-confirmacao.png') ?>
            </div>
            <p>Confirmação</p>
        </div>
    </div>
</div>