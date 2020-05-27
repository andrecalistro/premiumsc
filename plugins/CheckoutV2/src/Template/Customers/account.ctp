<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
$this->Html->script([
    'CheckoutV2.sweetalert2.all.min.js',
    'CheckoutV2.jquery.mask.js',
    'CheckoutV2.alert.functions.js',
    'CheckoutV2.mask.functions.js',
    'CheckoutV2.customer.functions.js'
], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<section class="main">

    <div class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Início</a></li>
                <li><?= $_pageTitle ?></li>
            </ul>
        </div>
    </div>

    <div class="user-profile">
        <div class="container">
            <div class="grid">
                <?= $this->element('Customers/menu') ?>
                <div class="col-md-8 col-lg-6 align-self-start">
                    <h2 class="profile-section-title">Dados cadastrais</h2>
                    <?= $this->Form->create($customer) ?>
                    <div class="grid form-grid">
                        <div class="col">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <?= $this->Form->control('email', [
                                    'class' => 'block',
                                    'type' => 'email',
                                    'label' => false,
                                    'placeholder' => 'Seu e-mail'
                                ]) ?>
                            </div>
                        </div>

                        <?= $this->element('CheckoutV2.Customers/form-block-person') ?>

                        <div class="col col-xs-6">
                            <div class="form-group">
                                <label for="birth_date">Data de Nascimento</label>
                                <?= $this->Form->control('birth_date', [
                                    'type' => 'text',
                                    'label' => false,
                                    'placeholder' => 'Ex.: 01/02/1987',
                                    'class' => 'block mask-date',
                                    'value' => $customer->birth_date->format('d/m/Y')
                                ]) ?>
                            </div>
                        </div>

                        <div class="col col-xs-6">
                            <div class="form-group">
                                <label for="sexo">Sexo</label>
                                <?= $this->Form->control('gender', [
                                    'type' => 'radio',
                                    'label' => false,
                                    'placeholder' => 'Sexo',
                                    'options' => $genders,
                                    'hiddenField' => false,
                                    'templates' => [
                                        'inputContainer' => '{{content}}',
                                        'nestingLabel' => '{{input}}<label{{attrs}}>{{text}}</label>'
                                    ]
                                ]) ?>
                            </div>
                        </div>
                        <div class="col text-center">
                            <?= $this->Form->button('Salvar Alterações', [
                                'type' => 'submit',
                                'class' => 'btn btn-success btn-lg mt-1'
                            ]) ?>
                        </div>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>

</section>