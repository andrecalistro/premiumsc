<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div id="content">
    <div class="container">
        <div class="main-content">
            <div class="content-inner produtos-para">
                <div class="bg-white pad-top-35 pad-bottom-90">
                    <div class="content-product">
                        <div class="tp-breadcrumbs">
                            <?= $filter->filters_group->name ?>
                            <i class="fa fa-angle-right"></i> <?= $filter->name ?>
                        </div>
                        <div class="divider mar-bottom-30"></div>

                        <?php if(!empty($filter->description)): ?>
                            <div class="row">
                                <div class="col-md-12 pad-bottom-50 text-justify">
                                    <div class="home-title"><?= $filter->name ?></div>
                                    <?= $filter->description ?>
                                </div>

                                <div class="col-md-12">
                                    <div class="home-title">Produtos</div>
                                </div>

                            </div>
                        <?php endif; ?>

                        <div class="row no-space equal_height">
                            <?php foreach($products as $product): ?>
                                <div class="col-md-4 col-sm-6">
                                    <?= $this->element('product_home', ['product' => $product]) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="paginator text-center">
                            <ul class="pagination">
                                <?= $this->Paginator->prev('&laquo; ' . __('Anterior'), ['escape' => false]) ?>
                                <?= $this->Paginator->numbers(['escape' => false]) ?>
                                <?= $this->Paginator->next(__('Próxima') . ' &raquo;', ['escape' => false]) ?>
                            </ul>
                            <p><?= $this->Paginator->counter(__('Pág {{page}} de {{pages}}')) ?></p>
                        </div>
                    </div>
                </div>
                <?= $this->element('testimonials') ?>
            </div>
            <?= $this->element('sidebar') ?>
        </div>
    </div>
</div>
