<?php
/**
 * @var App\View\AppView $this
 */
?>
<div id="content">

    <div class="bg-login">
        <div class="container">
            <?= $this->Flash->render() ?>
            <div class="formulario">

                <div class="cadastrado">
                    <div class="box text-white">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="title">Entrar com o Facebook</p>
                                <p>Acesse o OQVestir de forma mais rápida e prática usando o seu login do facebook
                                    </p>
                                <div class="btn-facebook text-center mar-bottom-30"><a href="#"><i
                                                class="fa fa-facebook" aria-hidden="true"></i> <span>|</span> Entrar com
                                        o Facebook</a></div>
                            </div>
                            <div class="col-md-6">
                                <p class="title">Já sou cliente</p>
                                <?= $this->Form->create(null, ['url' => ['action' => 'login']]) ?>
                                    <?= $this->Form->control('login', ['div' => false, 'label' => false, 'placeholder' => 'E-mail ou CPF', 'required' => true]) ?>
                                    <?= $this->Form->control('password', ['div' => false, 'label' => false, 'placeholder' => 'Senha', 'required' => true]) ?>
                                    <p><a href="#">Esqueceu sua senha ou e-mail?</a></p>
                                    <?= $this->Form->control('Entrar', ['type' => 'submit', 'value' => 'Entrar', 'div' => false, 'label' => false]) ?>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cadastrar">
                    <div class="box text-white">
                        <p class="title">Não sou cliente</p>

                        <?= $this->Form->create($customer, ['url' => ['action' => 'register']]) ?>
                            <?= $this->Form->control('name', ['div' => false, 'label' => false, 'placeholder' => 'Nome Completo']) ?>
                            <?= $this->Form->control('email', ['div' => false, 'label' => false, 'placeholder' => 'E-mail']) ?>
                            <?= $this->Form->control('document', ['div' => false, 'label' => false, 'placeholder' => 'CPF']) ?>
                            <?= $this->Form->control('password', ['div' => false, 'label' => false, 'placeholder' => 'Senha']) ?>
                            <?= $this->Form->control('password_confirm', ['div' => false, 'label' => false, 'placeholder' => 'Repita a senha', 'type' => 'password']) ?>
                            <?= $this->Form->control('Cadastrar', ['type' => 'submit', 'value' => 'Entrar', 'div' => false, 'label' => false]) ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
                <div class="clr"></div>
            </div>

        </div>
    </div>

</div>