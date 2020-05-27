<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['Admin.catalog/products-ratings.functions.js?v='.date('YmdHis')], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
    <div class="navbarBtns">
        <div class="page-title">
            <h2>Avaliações</h2>
        </div>

        <div class="navbarRightBtns">
            <a class="btn btn-primary btn-sm navbarBtn"
               href="<?= $this->Url->build(['controller' => 'products-ratings', 'action' => 'configure', 'plugin' => 'admin']) ?>">Configurações</a>
        </div>
    </div>

    <div class="content">
        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Produto</th>
                    <th>Nota</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                <tr>
                    <?= $this->Form->create('filter', ['autocomplete' => 'off', 'type' => 'get']) ?>
                    <th><?= $this->Form->control('id', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Pedido', 'value' => $filter['orders_id']]) ?></th>
                    <th><?= $this->Form->control('customer', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Cliente', 'value' => $filter['customer']]) ?></th>
                    <th><?= $this->Form->control('product', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Produto', 'value' => $filter['product']]) ?></th>
                    <th><?= $this->Form->control('rating', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Nota', 'value' => $filter['rating']]) ?></th>
                    <th><?= $this->Form->control('created', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Data', 'value' => $filter['created']]) ?></th>
                    <th><?= $this->Form->control('statuses', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Status', 'options' => $statuses, 'value' => $filter['statuses'], 'empty' => true]) ?></th>
                    <th>
                        <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>', ['escape' => false, 'class' => 'btn btn-primary btn-sm', 'title' => 'Buscar']) ?>
                        <?= $this->Html->link('<i class="fa fa-archive" aria-hidden="true"></i>', ['controller' => 'products-ratings', 'action' => 'index'], ['class' => 'btn btn-default btn-sm', 'escape' => false, 'title' => 'Todas as avaliações']) ?>
                    </th>
                    <?= $this->Form->end() ?>
                </tr>
                </thead>
                <tbody>
                <?php if ($productsRatings): ?>
                    <?php foreach ($productsRatings as $products_rating): ?>
                        <tr id="tr-rating-<?= $products_rating->id ?>">
                            <td><?= $this->Html->link($products_rating->orders_id, [
                                    'controller' => 'orders',
                                    'action' => 'view',
                                    $products_rating->orders_id,
                                    'plugin' => 'admin'
                                ], ['target' => '_blank']) ?></td>
                            <td>
                            <span><?= $this->Html->link($products_rating->customer->name, [
                                    'controller' => 'customers',
                                    'action' => 'view',
                                    $products_rating->customers_id,
                                    'plugin' => 'admin'
                                ], ['target' => '_blank']) ?></span>
                            </td>
                            <td><?= $this->Html->link($products_rating->product->name, [
                                    'controller' => 'products',
                                    'action' => 'view',
                                    $products_rating->products_id,
                                    'plugin' => 'admin'
                                ], ['target' => '_blank']) ?></td>
                            <td><?= $products_rating->rating ?></td>
                            <td><?= $products_rating->created->format('d/m/Y H:i') ?></td>
                            <td><?= $products_rating->products_ratings_status->name ?></td>
                            <td>
                                <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>', 'javascript:void(0)', ['escape' => false, 'class' => 'btn btn-sm btn-primary btn-view-product-rating', 'title' => 'Visualizar', 'data-id' => $products_rating->id]) ?>
                                <?= $this->Html->link('<i class="fa fa-check" aria-hidden="true"></i>', 'javascript:void(0)', ['escape' => false, 'class' => 'btn btn-sm btn-success btn-approve-product-rating', 'title' => 'Aprovar', 'data-id' => $products_rating->id]) ?>
                                <?= $this->Html->link('<i class="fa fa-close" aria-hidden="true"></i>', 'javascript:void(0)', ['escape' => false, 'class' => 'btn btn-sm btn-danger btn-disapprove-product-rating', 'title' => 'Reprovar', 'data-id' => $products_rating->id]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>

<div class="modal fade" id="modal-product-rating" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Avaliação</h4>
            </div>
            <div class="modal-body">
                <p><b>Data:</b> <span id="text-date"></span></p>
                <p><b>Status:</b> <span id="text-status"></span></p>
                <p><b>Pedido:</b> <span id="text-order"></span></p>
                <p><b>Cliente:</b> <span id="text-customer"></span></p>
                <p><b>Produto:</b> <span id="text-product"></span></p>
                <p><b>Avaliação:</b> <span id="text-rating"></span></p>
                <p><b>Comentário:</b> <span id="text-answer"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger btn-disapprove-product-rating" data-dismiss="modal">Reprovar</button>
                <button type="button" class="btn btn-sm btn-success btn-approve-product-rating" data-dismiss="modal">Aprovar</button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fechar</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
