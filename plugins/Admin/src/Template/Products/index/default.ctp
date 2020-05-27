<?php
/**
 * @var \App\View\AppView $this
 */
$url = $this->request->getRequestTarget();
$this->Html->script('Admin.catalog/product.functions.js', ['block' => 'scriptBottom', 'fullBase' => true]);
?>
    <div class="navbarBtns">
        <div class="page-title">
            <h2>Produtos</h2>
            <span class="subtitle"><?= $messageTotalProducts ?></span>
        </div>

        <div class="navbarRightBtns">
            <a class="btn btn-primary btn-sm navbarBtn"
               href="<?= $this->Url->build(['controller' => 'products', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar
                Produto</a>
        </div>
    </div>
<?= $this->element('pagination') ?>
    <div class="content">
        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('Products.code', 'Cód') ?></th>
                    <th><?= $this->Paginator->sort('Products.name', 'Produto') ?></th>
					<th>Categorias</th>
                    <th class="hidden-xs"><?= $this->Paginator->sort('stock', 'Estoque') ?></th>
                    <th><?= $this->Paginator->sort('Products.price', 'Preço Original') ?></th>
                    <th><?= $this->Paginator->sort('Products.price_special', 'Preço Promo') ?></th>
                    <th></th>
                </tr>

                <tr>
                    <?= $this->Form->create('', ['type' => 'get']) ?>
                    <th width="120"><?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Cód', 'value' => $filter['code'], 'autocomplete' => 'off']) ?></th>
                    <th width="500"><?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Produto', 'value' => $filter['name'], 'autocomplete' => 'off']) ?></th>
					<th><?= $this->Form->control('category', ['label' => false, 'class' => 'form-control', 'empty' => '-- Selecione --', 'options' => $categories, 'value' => $filter['category']]) ?></th>
                    <th class="hidden-xs"><?= $this->Form->control('stock', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Estoque', 'value' => $filter['stock'], 'autocomplete' => 'off']) ?></th>
                    <th><?= $this->Form->control('price', ['label' => false, 'class' => 'form-control input-price', 'placeholder' => 'Preço Original', 'value' => $filter['price'], 'autocomplete' => 'off']) ?></th>
                    <th><?= $this->Form->control('price_special', ['label' => false, 'class' => 'form-control input-price', 'placeholder' => 'Preço Promocional', 'value' => $filter['price_special'], 'autocomplete' => 'off']) ?></th>
                    <th>
                        <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>', ['escape' => false, 'class' => 'btn btn-primary btn-sm', 'title' => 'Buscar']) ?>
                        <?= $this->Html->link('<i class="fa fa-archive" aria-hidden="true"></i>', ['controller' => 'products', 'action' => 'index'], ['class' => 'btn btn-default btn-sm', 'escape' => false, 'title' => 'Todos os produtos']) ?>
                    </th>
                    <?= $this->Form->end() ?>
                </tr>

                </thead>
                <tbody>
                <?php if ($products): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product->code ?></td>
                            <td>
								<?= isset($product->products_images[0]->thumb_image_link) ? $this->Html->image($product->products_images[0]->thumb_image_link, ['align' => 'left', 'width' => '55', 'class' => 'hidden-xs']) : '' ?> <?= $product->name ?>
                                <a href="<?= $product->view_link ?>" target="_blank">
                                     &nbsp;<i class="fa fa-external-link" aria-hidden="true"></i>
                                </a>
                            </td>
							<td><?= isset($product->categories[0]->title) ? $product->categories[0]->title : '' ?></td>
                            <td class="hidden-xs"><?= $product->stock ?></td>
                            <td><?= $product->price_format ?></td>
                            <td><?= $product->price_special_format ?></td>
                            <td>
                                <a class="btn btn-default btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'products', 'action' => 'view', $product->id, 'plugin' => 'admin']) ?>"
                                   title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a class="btn btn-primary btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'products', 'action' => 'edit', $product->id, 'plugin' => 'admin']) ?>"
                                   title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'products', 'action' => 'delete', $product->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'escape' => false, 'title' => 'Excluir']) ?>
                                <a class="btn btn-<?= $product->status === 1 ? 'success' : 'default' ?> btn-sm status-product"
                                   title="<?= $product->status === 1 ? 'Desabilitar' : 'Habilitar' ?> Produto"
                                   href="javascript:void(0)" data-product-id="<?= $product->id ?>"><i
                                            class="fa fa-power-off"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->element('pagination') ?>