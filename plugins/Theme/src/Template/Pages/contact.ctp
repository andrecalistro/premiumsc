<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script([
    'CheckoutV2.sweetalert2.all.min.js',
    'CheckoutV2.alert.functions.js'
], ['fullBase' => true, 'block' => 'scriptBottom']);
?>
<div class="breadcrumb-area pt-35 pb-35 bg-gray-3">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a>
                </li>
                <li class="active">Fale Conosco</li>
            </ul>
        </div>
    </div>
</div>
<div class="contact-area pt-100 pb-100">
    <div class="container">
        <div class="custom-row-2">
            <div class="col-lg-4 col-md-5">
                <div class="contact-info-wrap">
                    <div class="single-contact-info">
                        <div class="contact-icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="contact-info-dec">
                            <p><?= $_store->telephone ?></p>
                            <p><?= $_store->cellphone ?></p>
                        </div>
                    </div>
                    <div class="single-contact-info">
                        <div class="contact-icon">
                            <i class="fa fa-globe"></i>
                        </div>
                        <div class="contact-info-dec">
                            <p><a href="mailto:<?= $_store->email_contact ?>"><?= $_store->email_contact ?></a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="contact-form">
                    <div class="contact-title mb-30">
                        <h2>Envie sua mensagem</h2>
                    </div>
                    <?= $this->Form->create('contact', ['class' => 'contact-form-style']) ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <?= $this->Form->control('name', ['label' => false, 'placeholder' => 'Nome']) ?>
                            </div>
                            <div class="col-lg-6">
                                <?= $this->Form->control('email', ['label' => false, 'placeholder' => 'E-mail']) ?>
                            </div>
                            <div class="col-lg-6">
                                <?= $this->Form->control('telephone', ['label' => false, 'class' => 'mask-telephone', 'placeholder' => 'telefone, ex: (xx) xxxx-xxxx']) ?>
                            </div>
                            <div class="col-lg-6">
                                <?= $this->Form->control('subject', ['label' => false, 'placeholder' => 'Assunto']) ?>
                            </div>
                            <div class="col-lg-12">
                                <?= $this->Form->control('message', ['label' => false, 'placeholder' => 'Mensagem', 'type' => 'textarea']) ?>
                                <?= $this->Recaptcha->display() ?>
                                <button class="submit" type="submit">Enviar</button>
                            </div>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>