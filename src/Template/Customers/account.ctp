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
            <p class="title-conta">MEUS DADOS</p>

            <?= $this->Form->create($customer) ?>
                <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>

                <?= $this->Form->control('email', ['class' => 'form-control', 'label' => 'E-mail']) ?>

                <?= $this->Form->control('document', ['class' => 'form-control', 'label' => 'CPF']) ?>

                <?= $this->Form->control('telephone', ['class' => 'form-control', 'label' => 'Telefone']) ?>

                <?= $this->Form->control('cellphone', ['class' => 'form-control', 'label' => 'Celular']) ?>

                <?= $this->Form->button('Salvar', ['type' => 'submit', 'class' => 'btn btn-default', 'div' => false, 'label' => false]) ?>
            <?= $this->Form->end() ?>
        </div>

    </div>
</div>

