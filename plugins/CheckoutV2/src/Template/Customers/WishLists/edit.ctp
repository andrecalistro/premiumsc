<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['Checkout.alert.functions.js', 'Checkout.wish-list/functions.js?v' . date('YmdHis')], ['block' => 'scriptBottom', 'fullBase' => true]);
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
?>
<div class="garrula-customer garrula-customer-dashboard">

    <div class="container py-3">
        <nav class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li class="breadcrumb-item"><a
                            href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'dashboard'], ['fullBase' => true]) ?>">Minha
                        conta</a></li>
                <li class="breadcrumb-item"><a
                            href="<?= $this->Url->build(['controller' => 'wish-lists', 'action' => 'list-wish-lists', 'plugin' => 'CheckoutV2'], ['fullBase' => true]) ?>">Minhas
                        listas de desejos</a></li>
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
                <?= $this->cell('Checkout.Customer::menu') ?>
            </div>

            <div class="col-md-9">
                <div class="row mb-3"><a href="javascript:void(0)"
                      class="btn-small btn-primary"
                      data-toggle="modal" data-target="#modal-wish-list-form">Editar dados da lista</a></div>

                <div class="row">
                    <?php if ($products->count() > 0): ?>
                        <?php foreach ($products as $wishListProduct): ?>
                            <div class="col-md-3 mb-5 d-flex flex-column align-content-between justify-content-between p-2 box-product">
                                <a href="<?= $wishListProduct->product->full_link ?>" target="_blank">
                                    <div class="col-md-12 d-flex justify-content-start flex-column align-items-center flex-1 mb-3">
                                        <?= $this->Html->image($wishListProduct->product->main_image, ['class' => 'img-fluid d-inline-block']) ?>
                                        <strong class="d-block"><?= $wishListProduct->product->name ?></strong>
                                    </div>
                                </a>
                                <div class="info-produto text-center">
                                    <p class="preco mt-2 mb-2">
                                        <span><?= $wishListProduct->product->price_format['formatted'] ?></span>
                                    </p>

                                    <p><?= $wishListProduct->label ?></p>

                                    <div class="d-flex mt-3">
                                        <a href="<?= $wishListProduct->product->full_link ?>"
                                           target="_blank"
                                           title="Visualizar"
                                           class="flex-1 btn-small btn-success">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($wishListProduct->wish_list_product_statuses_id === 1): ?>
                                            <a href="<?= $this->Url->build([
                                                'controller' => 'wish-lists',
                                                'action' => 'delete', $wishListProduct->id,
                                                'plugin' => 'CheckoutV2'
                                            ]) ?>"
                                               class="flex-1 btn-small btn-danger"
                                               title="Excluir">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center mb-4">Nenhum produto nessa lista</div>
                    <?php endif; ?>
                </div>
                <div class="d-flex justify-content-center">
                    <?= $this->element('Customers/pagination') ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->element('Checkout.Customers/wish_list_add', ['list' => $wishList]) ?>