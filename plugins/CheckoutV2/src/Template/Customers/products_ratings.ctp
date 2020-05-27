<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
$this->Html->script('Checkout.product-rating.functions.js', [
    'block' => 'scriptBottom',
    'fullBase' => true
]);
?>
<div class="garrula-customer garrula-customer-product-rating">

    <div class="container py-3">
        <nav class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li class="breadcrumb-item"><a
                            href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'dashboard'], ['fullBase' => true]) ?>">Minha
                        conta</a></li>
                <li class="breadcrumb-item"><?= $_pageTitle ?></li>
            </ol>
        </nav>
    </div>

    <section class="container">
        <div class="text-center mb-4">
            <h3><?= $_pageTitle ?></h3>
        </div>

        <div class="row">
            <div class="col-md-3">
                <?= $this->element('Customers/menu') ?>
            </div>

            <div class="col-md-9">
                <div class="mt-4 mb-5">
                    <?= $this->Form->create() ?>
                    <?php foreach ($order->orders_products as $order_product): ?>
                        <div class="product-rating d-block w-100">
                            <div class="d-flex flex-row mb-2">
                                <img src="<?= $order_product->product->thumb_main_image ?>"
                                     alt="<?= $order_product->product->name ?>" class="mr-3">
                                <div>
                                    <h4><?= $order_product->product->name ?></h4>

                                    <div class="rating">
                                        <p class="clasificacion">
                                            <?php for ($i = 5; $i > 0; $i--): ?>
                                                <input id="rating-product-<?= $order_product->products_id ?>-<?= $i ?>"
                                                       type="radio" name="rating[<?= $order_product->products_id ?>][rating]" value="<?= $i ?>">
                                                <label for="rating-product-<?= $order_product->products_id ?>-<?= $i ?>">&#9733;</label>
                                            <?php endfor; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="rating[<?= $order_product->products_id ?>][answer]" class="form-control"
                                          placeholder="Comente sobre o produto, dê detalhes e por que deu a nota acima"></textarea>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <button type="submit" class="btn btn-primary">Enviar Avaliação</button>

                    <?= $this->Form->end() ?>

                </div>

            </div>
        </div>
    </section>
</div>