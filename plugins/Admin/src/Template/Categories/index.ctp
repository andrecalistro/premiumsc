<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="navbarBtns">
    <div class="page-title">
        <h2>Categorias</h2>
        <span class="subtitle"><?= $messageTotal ?></span>
    </div>

    <div class="navbarRightBtns">
        <a class="btn btn-primary btn-sm navbarBtn"
           href="<?= $this->Url->build(['controller' => 'categories', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar
            Categoria</a>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <?= $this->Html->link('Atualizar contagem dos produtos', ['controller' => 'categories', 'action' => 'refresh-count'], ['class' => 'btn btn-default']) ?>
    </div>

    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>ID</th>
                <th class="hidden-xs">Imagem</th>
                <th class="hidden-xs">Categoria Pai</th>
                <th>Nome</th>
                <th>Total de produtos</th>
                <th>Ordem de exibição</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($categories): ?>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $category->id ?></td>
                        <td class="hidden-xs"><?= !empty($category->thumb_image_link) ? $this->Html->image($category->thumb_image_link, ['width' => 50]) : '' ?></td>
                        <td class="hidden-xs"><?= isset($category->parent_category->title) ? $category->parent_category->title : '' ?></td>
                        <td><?= $category->title ?></td>
                        <td><?= $category->products_total ?></td>
                        <td><?= $category->order_show ?></td>
                        <td>
                            <a class="btn btn-default btn-sm"
                               href="<?= $this->Url->build(['controller' => 'categories', 'action' => 'view', $category->id, 'plugin' => 'admin']) ?>" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm"
                               href="<?= $this->Url->build(['controller' => 'categories', 'action' => 'edit', $category->id, 'plugin' => 'admin']) ?>" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'categories', 'action' => 'delete', $category->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->element('pagination') ?>