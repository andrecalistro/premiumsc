<?php
/**
 * @var \Cake\View\View $this
 */
?>
<header>
    <div class="container">
        <div class="grid">
            <div class="col-3 col-md-2 align-self-center">
                <a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>" class="brand">
                    <?= $this->Html->image($_store->logo_link, ['style' => 'max-width: 150px;']) ?>
                </a>
            </div>
            <div class="col-6 col-md-8 align-self-center">
                <?php if(isset($_steps)): ?>
                    <div class="progress-steps">
                        <ul>
                            <li class="complete">
                                <a href="<?= $this->Url->build('/carrinho', ['fullBase' => true]) ?>">Carrinho de
                                    compras</a>
                            </li>
                            <li class="<?= $_steps['identification'] ?>">Identificação</li>
                            <li class="<?= $_steps['shipping_payment'] ?>">Entrega e pagamento</li>
                            <li class="<?= $_steps['done'] ?>">Confirmação</li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-3 col-md-2 align-self-center">
                <?= $this->Html->image('CheckoutV2.compra-segura.svg') ?>
            </div>
        </div>
    </div>
</header>