<?php
/**
 * @var \App\View\AppView $this
 * @var \Theme\Model\Entity\Page $page
 */
?>
<section class="main">
    <div class="section-header">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li>Seja um Licenciado</li>
            </ul>
            <div class="separator"></div>
            <h2>Seja um Licenciado</h2>
        </div>
    </div>

    <?= $page->content ?>

    <div class="formulario-parceiro">
        <div class="container">
            <div class="grid">
                <div class="col-md-6 align-self-center">
                    <form>
                        <div class="form-group mb">
                            <input type="text" name="nome" placeholder="Nome do Representante" class="block">
                        </div>
                        <div class="form-group mb">
                            <input type="tel" name="cnpj" placeholder="CNPJ da Empresa" class="block">
                        </div>
                        <div class="form-group mb">
                            <input type="email" name="email" placeholder="E-mail" class="block">
                        </div>
                        <div class="form-group mb">
                            <input type="tel" name="telefone" placeholder="Telefone" class="block">
                        </div>
                        <div class="form-group mb">
                            <textarea class="block" rows="4" cols="3" placeholder="Mensagem"></textarea>
                        </div>
                        <button type="submit" name="envia" class="btn btn-block">Envia Contato</button>
                    </form>
                </div>
                <div class="col-md-6 align-self-center">
                    <?= $this->Html->image('Theme.seja-um-parceiro-form-img.jpg') ?>
                </div>
            </div>
        </div>
    </div>

</section>
