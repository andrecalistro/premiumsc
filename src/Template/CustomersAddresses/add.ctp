<?php
/**
 * @var App\View\AppView $this
 */
?>
<div id="content" class="pad-top-60 pad-bottom-95">
    <div class="container">

        <?= $this->Flash->render() ?>

        <div class="page-title mar-bottom-85">Minha Conta</div>

        <?= $this->element('Customers/menu') ?>

        <div class="col-md-8">
            <p class="title-conta">ADICIONAR ENDEREÇO</p>

            <?= $this->Form->create($customersAddress) ?>
            <?= $this->Form->control('zipcode', ['class' => 'form-control input-cep', 'label' => 'CEP', 'maxlength' => 9]) ?>

            <?= $this->Form->control('address', ['class' => 'form-control input-address', 'label' => 'Logradouro']) ?>

            <?= $this->Form->control('number', ['class' => 'form-control input-number', 'label' => 'Número']) ?>

            <?= $this->Form->control('complement', ['class' => 'form-control', 'label' => 'Complemento']) ?>

            <?= $this->Form->control('neighborhood', ['class' => 'form-control input-neighborhood', 'label' => 'Bairro']) ?>

            <?= $this->Form->control('city', ['class' => 'form-control input-city', 'label' => 'Cidade']) ?>

            <?= $this->Form->control('state', ['class' => 'form-control input-state', 'label' => 'Estado']) ?>

            <?= $this->Form->control('description', ['class' => 'form-control', 'label' => 'Descrição']) ?>

            <?= $this->Form->button('Salvar', ['type' => 'submit', 'class' => 'btn btn-default', 'div' => false, 'label' => false]) ?>
            <?= $this->Form->end() ?>
        </div>

    </div>
</div>

