<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\ORM\ResultSet $products
 */
$this->Html->script(['Admin.catalog/product.functions.js', 'Admin.product/moda.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
?>
    <div class="navbarBtns">
        <div class="page-title">
            <h2>Bling Produtos</h2>
        </div>
    </div>
<?= $this->element('pagination') ?>
    <div class="content">
        <div class="container-fluid mar-bottom-20">
            <?= $this->Html->link('<i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar', ['controller' => 'bling', 'action' => 'index'], ['class' => 'btn btn-sm btn-default', 'escape' => false]) ?>
        </div>

        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name', 'Produto') ?></th>
                    <th><?= $this->Paginator->sort('code', 'Código') ?></th>
                    <th class="hidden-xs"><?= $this->Paginator->sort('stock', 'Estoque') ?></th>
                    <th><?= $this->Paginator->sort('price', 'Preço Desapegar') ?></th>
                    <th>Status Bling</th>
                    <th></th>
                </tr>

                <tr>
                    <?= $this->Form->create('', ['type' => 'get', 'autocomplete' => 'off']) ?>
                    <th><?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Produto', 'value' => $filter['name'],]) ?></th>
                    <th><?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Código', 'value' => $filter['code'],]) ?></th>
                    <th class="hidden-xs"><?= $this->Form->control('stock', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Estoque', 'value' => $filter['stock']]) ?></th>
                    <th><?= $this->Form->control('price', ['label' => false, 'class' => 'form-control input-price', 'placeholder' => 'Preço Desapegar', 'value' => $filter['price']]) ?></th>
                    <th></th>
                    <th>
                        <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>', ['escape' => false, 'class' => 'btn btn-primary', 'title' => 'Buscar']) ?>
                        <?= $this->Html->link('<i class="fa fa-archive" aria-hidden="true"></i>', ['controller' => 'bling', 'action' => 'products'], ['class' => 'btn btn-default', 'escape' => false, 'title' => 'Todos os produtos']) ?>
                    </th>
                    <?= $this->Form->end() ?>
                </tr>

                </thead>
                <tbody>
                <?php if ($products->count() > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= isset($product->products_images[0]->thumb_image_link) ? $this->Html->image($product->products_images[0]->thumb_image_link, ['align' => 'left', 'width' => '55', 'class' => 'hidden-xs']) : '' ?> <?= $product->name ?>
                            </td>
                            <td class="hidden-xs"><?= $product->code ?></td>
                            <td class="hidden-xs"><?= $product->stock ?></td>
                            <td><?= $product->price_format ?></td>
                            <td>
                                <?= $product->bling_status ?>
                            </td>
                            <td>
                                <a class="btn btn-default btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'bling', 'action' => 'view-product', $product->id, 'plugin' => 'admin']) ?>"
                                   title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a class="btn btn-success btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'bling', 'action' => 'synchronize-product', $product->id]) ?>"
                                   title="Sincronizar"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" align="center">Nenhum produto encontrado</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>