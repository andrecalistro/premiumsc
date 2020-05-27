<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Admin.Banner $banner
 */
$this->Html->script('positions.functions.js', ['block' => 'scriptBottom', 'fullBase' => true]);
?>
<div class="page-title">
    <h2>Posição</h2>
</div>

<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <div class="row mar-bottom-20">
            <div class="col-md-7 col-xs-12">
                <p><strong>Nome</strong></p>
                <?= $position->name ?>
            </div>
            <div class="col-md-3 col-xs-12">
                <p><strong>Página</strong></p>
                <?= isset($position->positions_page->name) ? $position->positions_page->name : '' ?>
            </div>
        </div>
        <p><?= $this->Html->link('<i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar', ['controller' => 'positions', 'action' => 'index'], ['class' => 'btn btn-sm btn-default', 'escape' => false]) ?></p>
        <hr>
        <h3>Produtos cadastrados nessa posição</h3>
        <p><?= $this->Html->link('Cadastrar', ['controller' => 'positions', 'action' => 'add-product', $position->id], ['class' => 'btn btn-sm btn-default']) ?></p>
    </div>
    <div class="table-responsive">
        <table class="mar-bottom-20 normal-line-height">
            <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Posição</th>
            <th></th>
            </thead>
            <tbody>
            <?php if (isset($position->products[0])): ?>
                <?php foreach ($position->products as $product): ?>
                    <tr>
                        <td><?= $product->id ?></td>
                        <td><?= isset($product->products_images[0]->thumb_image_link) ? $this->Html->image($product->products_images[0]->thumb_image_link, ['align' => 'left', 'width' => '55', 'class' => 'img-thumbnail hidden-xs']) : '' ?> <?= $product->name ?></td>
                        <td><?= $product->price_format ?></td>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control" value="<?= $product->_joinData->order_show ?>"
                                       data-product-position-id="<?= $product->_joinData->id ?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-change-position" type="button">Ok</button>
                                </span>
                            </div>
                        </td>
                        <td>
                            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'positions', 'action' => 'delete-product', $product->_joinData->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" align="center">Nenhuma produto encontrado.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>