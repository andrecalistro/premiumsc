<?php
/**
 * @var \App\View\AppView $this
 * @var \Subscriptions\Model\Entity\Plan $plan
 */
?>
<div class="page-title">
    <h2>Plano</h2>
</div>

<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <div class="row">
            <div class="col-md-1 col-xs-12">
                <?= $this->Html->image($plan->thumb_main_image, ['class' => 'img-responsive img-thumbnail']) ?>
            </div>
            <div class="col-md-3 col-xs-12">
                <p><strong>Nome</strong></p>
                <?= $plan->name ?>
            </div>
            <div class="col-md-3 col-xs-12">
                <p><strong>Cadastrado em</strong></p>
                <?= $plan->created->format('d/m/Y H:i') ?>
            </div>
            <div class="col-md-3 col-xs-12">
                <p><strong>Status</strong></p>
                <?= $plan->status_name ?>
            </div>

            <div class="col-md-2">
                <p><strong>Preço</strong></p>
                <?= $plan->price_format ?>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-3">
                <p><strong>Frequência de cobrança</strong></p>
                <?= $plan->plan_billing_frequency->name ?>
            </div>

            <div class="col-md-3">
                <p><strong>Frequência de envio</strong></p>
                <?= $plan->plan_delivery_frequency->name ?>
            </div>

            <div class="col-md-3">
                <p><strong>Requer envio</strong></p>
                <?= $plan->shipping_required ? 'Sim' : 'Não' ?>
            </div>

            <div class="col-md-3">
                <p><strong>Frete grátis</strong></p>
                <?= $plan->shipping_free ? 'Sim' : 'Não' ?>
            </div>
        </div>
        <hr>

        <div class="row">
            <?php if (isset($plan->plans_images)): ?>
                <?php foreach ($plan->plans_images as $key => $image): ?>
                    <div class="col-md-2 <?= $key == 0 ? 'col-md-offset-1' : '' ?>">
                        <div class="form-group">
                            <?= $this->Html->image($image->thumb_image_link, ['class' => 'img-responsive img-thumbnail']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <hr>

        <div class="form-group">
            <p><strong>Descrição</strong></p>
            <?= $plan->description ?>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-3">
                <p><strong>Peso (kg)</strong></p>
                <?= $plan->weight_format ?>
            </div>

            <div class="col-md-3">
                <p><strong>Comprimento (cm)</strong></p>
                <?= $plan->length_format ?>
            </div>

            <div class="col-md-3">
                <p><strong>Largura (cm)</strong></p>
                <?= $plan->width_format ?>
            </div>

            <div class="col-md-3">
                <p><strong>Altura (cm)</strong></p>
                <?= $plan->height_format ?>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-4">
                <p><strong>Url para SEO</strong></p>
                <?= $plan->seo_url ?>
            </div>

            <div class="col-md-4">
                <p><strong>Título para SEO</strong></p>
                <?= $plan->seo_title ?>
            </div>

            <div class="col-md-4">
                <p><strong>Descrição para SEO</strong></p>
                <?= $plan->seo_description ?>
            </div>
        </div>

        <p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
    </div>
</div>
