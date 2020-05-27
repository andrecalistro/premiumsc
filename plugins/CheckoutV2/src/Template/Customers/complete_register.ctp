<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
$this->Html->script([
    'CheckoutV2.sweetalert2.all.min.js',
    'CheckoutV2.jquery.mask.js',
    'CheckoutV2.alert.functions.js',
    'CheckoutV2.mask.functions.js',
    'CheckoutV2.customer.functions.js'
], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<section class="main">

    <div class="checkout-block">
        <h2 class="page-title text-center">Cadastro</h2>
        <?= $this->Form->create($customer) ?>
        <h4>Dados Pessoais</h4>
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
            <div class="col col-xs-6">
                <div class="form-group">
                    <label for="password">Senha</label>
                    <?= $this->Form->control('password', [
                        'label' => false,
                        'placeholder' => 'Digite sua senha',
                        'class' => 'block'
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-6">
                <div class="form-group">
                    <label for="password_confirm">Confirmar Senha</label>
                    <?= $this->Form->control('password_confirm', [
                        'label' => false,
                        'placeholder' => 'Confirmar Senha',
                        'type' => 'password',
                        'class' => 'block'])
                    ?>
                </div>
            </div>
            <?php if ($company_register): ?>
                <div class="col">
                    <div class="form-group">
                        <label for="tipo_cadastro">Tipo de Cadastro</label>
                        <?= $this->Form->control('customers_types_id', [
                            'type' => 'radio',
                            'options' => $customersTypes,
                            'label' => false,
                            'required' => true,
                            'hiddenField' => false,
                            'class' => 'input-type-customer',
                            'templates' => [
                                'inputContainer' => '{{content}}',
                                'nestingLabel' => '{{input}}<label{{attrs}}>{{text}}</label>'
                            ]
                        ]) ?>
                    </div>
                </div>
                <?= $this->element('CheckoutV2.Customers/form-block-person') ?>
                <?= $this->element('CheckoutV2.Customers/form-block-company') ?>
            <?php else: ?>
                <?= $this->element('CheckoutV2.Customers/form-block-person') ?>
            <?php endif; ?>

            <div class="col col-xs-6">
                <div class="form-group">
                    <label for="birth_date">Data de Nascimento</label>
                    <?= $this->Form->control('birth_date', [
                        'type' => 'text',
                        'label' => false,
                        'placeholder' => 'Ex.: 01/02/1987',
                        'class' => 'block mask-date'
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

        </div>
        <h4 class="divide-block">Endereço de Entrega</h4>
        <?= $this->Form->control('customers_addresses.0.description', ['label' => false, 'value' => '', 'type' => 'hidden']) ?>
        <div class="grid form-grid">
            <div class="col">
                <div class="form-group">
                    <label for="customers-addresses-0-zipcode">CEP</label>
                    <?= $this->Form->control('customers_addresses.0.zipcode', [
                        'label' => false,
                        'placeholder' => 'Ex.: 12345-678',
                        'class' => 'block input-zipcode mask-zipcode',
                        'value' => $this->request->getSession()->read('zipcode')
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-9">
                <div class="form-group">
                    <label for="customers-addresses-0-address">Endereço</label>
                    <?= $this->Form->control('customers_addresses.0.address', [
                        'label' => false,
                        'placeholder' => '',
                        'class' => 'block input-address'
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-3">
                <div class="form-group">
                    <label for="customers-addresses-0-number">Número</label>
                    <?= $this->Form->control('customers_addresses.0.number', [
                        'label' => false,
                        'placeholder' => 'Número',
                        'class' => 'block input-number'
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-6">
                <div class="form-group">
                    <label for="customers-addresses-0-complement">Complemento</label>
                    <?= $this->Form->control('customers_addresses.0.complement', [
                        'label' => false,
                        'placeholder' => 'Ex.: Bloco 02 - Ap 123',
                        'class' => 'block input-complement'
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-6">
                <div class="form-group">
                    <label for="customers-addresses-0-neighborhood">Bairro</label>
                    <?= $this->Form->control('customers_addresses.0.neighborhood', [
                        'label' => false,
                        'placeholder' => 'Bairro',
                        'class' => 'block input-neighborhood'
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-6">
                <div class="form-group select">
                    <label for="customers-addresses-0-city">Cidade</label>
                    <?= $this->Form->control('customers_addresses.0.city', [
                        'label' => false,
                        'placeholder' => 'Cidade',
                        'class' => 'block input-city'
                    ]) ?>
                </div>
            </div>
            <div class="col col-xs-6">
                <div class="form-group select">
                    <label for="customers-addresses-0-state">Estado</label>
                    <?= $this->Form->control('customers_addresses.0.state', [
                        'label' => false,
                        'placeholder' => 'Estado',
                        'class' => 'block input-state'
                    ]) ?>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    Ao se cadastrar, você concorda com nossos <a href="<?= $_link_page_terms ?>"
                                                                 target="_blank">termos
                        de uso, condições e política de privacidade</a>.
                </div>
            </div>
            <div class="col text-center">

                <?= $this->Form->button('Criar Cadastro', [
                    'type' => 'submit',
                    'label' => false,
                    'class' => 'btn btn-success btn-lg mt-2'
                ]) ?>

                <p><?= $this->Html->link('Voltar', '/minha-conta/acesso-cadastro') ?></p>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>

</section>