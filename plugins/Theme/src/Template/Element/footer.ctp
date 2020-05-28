<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['CheckoutV2.customer.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<footer class="footer-area pb-70">
    <div class="container">
        <div class="footer-border pt-100">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-4">
                    <a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">
                        <?= $this->Html->image($_store->icon_link) ?>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4">
                    <div class="footer-widget mb-30 ml-30">
                        <?= $this->cell('Theme.Menu::menuFooter', [
                            'title' => 'Sobre nós',
                            'slug' => 'footer-sobre-nos'
                        ]) ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4">
                    <div class="footer-widget mb-30 ml-50">
                        <?= $this->cell('Theme.Menu::menuFooter', [
                            'title' => 'Suporte',
                            'slug' => 'footer-suporte'
                        ]) ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-widget mb-30 ml-75">
                        <?= $this->cell('Theme.Menu::menuFooter', [
                            'title' => 'Redes sociais',
                            'slug' => 'footer-redes-sociais'
                        ]) ?>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="footer-widget mb-30 ml-70">
                        <div class="footer-title">
                            <h3>Nossas ofertas</h3>
                        </div>
                        <div class="subscribe-style">
                            <p>Receba nossas ofertas e novos produtos em seu e-mail</p>
                            <div class="subscribe-form">
                                <?= $this->Form->create('', ['id' => 'form-email-marketing']) ?>
                                    <div class="mc-form">
                                        <input class="email" type="email" required="" placeholder="Seu e-mail.." name="email" value="">
                                        <div class="clear">
                                            <input class="button" type="submit" name="subscribe" value="Inscrever">
                                        </div>
                                    </div>
                                <?= $this->Form->end() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>