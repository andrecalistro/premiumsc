<?php
/**
 * @var \App\View\AppView $this
 */
?>
<section class="main">
    <div class="section-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li>Fale Conosco</li>
            </ul>
            <div class="separator"></div>
            <h2>Fale Conosco</h2>
        </div>
    </div>

    <div class="wrapper">
        <div class="product-list-block">
            <div class="container">
                <div class="grid">
                    <div class="col-lg-6 align-self-center">
                        <div class="contact-info">
                            <h3>SAC</h3>
                            <p class="telefone">0800 591 1583</p>
                            <h3>E-mail</h3>
                            <a href="#" class="email"><?= $_store->email_contact ?></a>
                            <h3>Quero ser um licenciado</h3>
                            <a href="mailto:licenciado@pure4u.com.br" class="email">licenciado@pure4u.com.br</a>
                            <ul class="social">
                                <li><a href="<?= $_store->facebook ?>" class="facebook"
                                       title="curta nossa página no facebook"><i></i></a></li>
                                <li><a href="<?= $_store->instagram ?>" class="instagram" title="siga-nos no instagram"><i></i></a>
                                </li>
                            </ul>
                            <span>Ou favor preencher o formulário a seguir que entraremos em contato (para consumidor ou interessado no licenciamento):</span>
                            <?= $this->Form->create('contact', ['class' => 'form-contato']) ?>
                            <div class="form-group mb">
                                <?= $this->Form->control('name', ['label' => false, 'class' => 'block', 'placeholder' => 'Nome']) ?>
                            </div>
                            <div class="form-group mb">
                                <?= $this->Form->control('email', ['label' => false, 'class' => 'block', 'placeholder' => 'E-mail']) ?>
                            </div>
                            <div class="form-group mb">
                                <?= $this->Form->control('telephone', ['label' => false, 'class' => 'block mask-telephone', 'placeholder' => 'telefone, ex: (xx) xxxx-xxxx']) ?>
                            </div>
                            <div class="form-group mb">
                                <?= $this->Form->control('subject', ['label' => false, 'class' => 'block', 'placeholder' => 'Assunto']) ?>
                            </div>
                            <div class="form-group mb">
                                <?= $this->Form->control('message', ['label' => false, 'class' => 'block', 'placeholder' => 'Mensagem', 'type' => 'textarea']) ?>
                            </div>
                            <div class="form-group mb">
                                <?= $this->Recaptcha->display() ?>
                            </div>
                            <button type="submit" name="envia" class="btn btn-block">Enviar contato</button>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>