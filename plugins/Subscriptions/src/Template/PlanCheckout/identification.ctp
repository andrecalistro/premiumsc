<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script(['Checkout.sweetalert2.all.min.js', 'Checkout.jquery.mask.js', 'Checkout.alert.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="garrula-checkout garrula-checkout-identification">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= $this->Url->build(['controller' => 'carts', 'action' => 'index'], ['fullBase' => true]) ?>">Meu carrinho</a></li>
                <li class="breadcrumb-item"><?= $_pageTitle ?></li>
            </ol>
        </nav>
    </div>

    <?= $this->cell('Subscriptions.Cart::steps', ['steps' => [1]]); ?>

    <div class="container text-center">
        <h3><?= $_pageTitle ?></h3>
    </div>
    <section class="container mt-5">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="bg-cor-3 py-4 pr-3 pl-3">
                    <p>Já tenho cadastro</p>
                    <hr>
                    <?= $this->Form->create('') ?>
                    <div class="form-group">
                        <?= $this->Form->control('login', ['label' => 'E-mail ou CPF:', 'required' => true, 'class' => 'form-control']) ?>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->control('password', ['label' => 'Senha:', 'required' => true, 'class' => 'form-control']) ?>
                        <p class="text-right">
                            <?= $this->Html->link('Esqueci minha senha', ['controller' => 'customers', 'action' => 'lost-password', 'plugin' => 'checkout']) ?>
                        </p>
                    </div>
                    <div class="container text-center">
                        <button class="btn btn-primary" type="submit">Entrar</button>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bg-cor-3 py-4 pr-3 pl-3">
                    <p>Não tenho cadastro</p>
                    <hr>
                    <?= $this->Form->create($customer, ['url' => ['_name' => 'planCheckRegister']]) ?>
                        <div class="form-group">
                            <?= $this->Form->control('name', ['div' => false, 'label' => 'Nome Completo:', 'class' => 'form-control', 'required' => true]) ?>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->control('email', ['div' => false, 'label' => 'E-mail:', 'class' => 'form-control', 'required' => true]) ?>
							<p>&nbsp;</p>
                        </div>
                        <div class="container text-center">
                            <button class="btn btn-primary" type="submit">Iniciar cadastro</button>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </section>
</div>