<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\ORM\ResultSet $products
 */
$this->Html->script(['Admin.catalog/product.functions.js', 'Admin.product/moda.functions.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
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
	<div class="pagination-top">
		<?= $this->element('pagination') ?>
	</div>
    <div class="content">
        <div class="table-responsive">
            <table class="mar-bottom-20 <?= $table_class ?>">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('Products.code', 'Cód.') ?></th>
                    <th><?= $this->Paginator->sort('Products.name', 'Produto') ?></th>
					<th>Categorias</th>
                    <th class="hidden-xs"><?= $this->Paginator->sort('Products.stock', 'Estoque') ?></th>
                    <th><?= $this->Paginator->sort('Providers.name', 'Fornecedor') ?></th>
                    <th><?= $this->Paginator->sort('Products.price', 'Preço Desapegar') ?></th>
                    <th><?= $this->Paginator->sort('Products.price_special', 'Preço Promo') ?></th>
                    <th><?= $this->Paginator->sort('Products.status', 'Status') ?></th>
                    <th></th>
                </tr>

                <tr>
                    <?= $this->Form->create('', ['type' => 'get', 'autocomplete' => 'off']) ?>
                    <th><?= $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Cód', 'value' => $filter['code'],]) ?></th>
                    <th><?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Produto', 'value' => $filter['name'],]) ?></th>
					<th><?= $this->Form->control('category', ['label' => false, 'class' => 'form-control', 'empty' => '-- Selecione --', 'options' => $categories, 'value' => $filter['category']]) ?></th>
                    <th class="hidden-xs"><?= $this->Form->control('stock', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Estoque', 'value' => $filter['stock']]) ?></th>
                    <th><?= $this->Form->control('providers_name', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Fornecedor', 'value' => $filter['providers_name'],]) ?></th>
                    <th><?= $this->Form->control('price', ['label' => false, 'class' => 'form-control input-price', 'placeholder' => 'Preço Desapegar', 'value' => $filter['price']]) ?></th>
                    <th><?= $this->Form->control('price_special', ['label' => false, 'class' => 'form-control input-price', 'placeholder' => 'Preço Promocional', 'value' => $filter['price_special']]) ?></th>
                    <th><?= $this->Form->control('status', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Status', 'options' => $productsStatuses, 'empty' => ' ', 'value' => $filter['status']]) ?></th>
                    <th>
                        <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i>', ['escape' => false, 'class' => 'btn btn-primary btn-sm', 'title' => 'Buscar']) ?>
                        <?= $this->Html->link('<i class="fa fa-archive" aria-hidden="true"></i>', ['controller' => 'products', 'action' => 'index'], ['class' => 'btn btn-default btn-sm', 'escape' => false, 'title' => 'Todos os produtos']) ?>
                    </th>
                    <?= $this->Form->end() ?>
                </tr>

                </thead>
                <tbody>
                <?php if ($products->count() > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product->code ?></td>
                            <td class="td-center">
                                <?php if(isset($product->thumb_main_image)): ?>
                                    <a href="<?= $product->main_image ?>" data-toggle="lightbox"><?= $this->Html->image($product->thumb_main_image, ['align' => 'left', 'width' => '55']) ?></a>
                                <?php endif; ?>
                                <?= $product->name ?>
                            </td>
							<td>
								<?php
								$categoriesArray = [];
								if (isset($product->categories)):
									foreach ($product->categories as $category):
										$categoriesArray[] = $category->title;
									endforeach;
								endif;
								echo implode(', ', $categoriesArray);
								?>
							</td>
                            <td class="hidden-xs"><?= $product->stock ?></td>
                            <td><?= $product->provider_name ?></td>
                            <td><?= $product->price_format ?></td>
                            <td><?= $product->price_special_format ?></td>
                            <td>
                                <?= $this->Form->create('') ?>
                                    <?= $this->Form->control('status', ['label' => false, 'class' => 'form-control select-product-status', 'data-products-id' => $product->id, 'placeholder' => 'Status', 'options' => $productsStatuses, 'value' => $product->status]) ?>
                                <?= $this->Form->end() ?>
                            </td>
                            <td>
                                <a class="btn btn-default btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'products', 'action' => 'view', $product->id, 'plugin' => 'admin']) ?>"
                                   title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a class="btn btn-primary btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'products', 'action' => 'edit', $product->id, 'plugin' => 'admin']) ?>"
                                   title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'products', 'action' => 'delete', $product->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'escape' => false, 'title' => 'Excluir']) ?>
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
<?= $this->element('modal-gallery') ?>
