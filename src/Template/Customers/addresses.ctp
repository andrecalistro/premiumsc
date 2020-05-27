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
            <p class="title-conta">MEUS ENDEREÇOS</p>

            <?= $this->Form->create($customer) ?>
            <?= $this->Form->control('password', ['class' => 'form-control', 'label' => 'Nova senha']) ?>

            <?= $this->Form->control('password_confirm', ['class' => 'form-control', 'label' => 'Repita nova senha', 'type' => 'password']) ?>

            <?= $this->Form->button('Salvar', ['type' => 'submit', 'class' => 'btn btn-default', 'div' => false, 'label' => false]) ?>
            <?= $this->Form->end() ?>
        </div>

    </div>
</div>

