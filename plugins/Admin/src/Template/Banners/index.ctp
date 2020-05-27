<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Admin.Banner[]|\Cake\Collection\CollectionInterface $banners
  */
?>
<div class="page-title">
    <h2>Banners</h2>
</div>
<div class="content">
    <div class="container-fluid">
        <p><a class="btn btn-primary btn-sm"
              href="<?= $this->Url->build(['controller' => 'banners', 'action' => 'add']) ?>">Adicionar
                posição</a></p>
    </div>
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>ID</th>
                <th>Posição</th>
                <th>Qtde. Banners</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($banners): ?>
                <?php foreach ($banners as $banner): ?>
                    <tr>
                        <td><?= $banner->id ?></td>
                        <td><?= $banner->name ?></td>
                        <td><?= count($banner->banners_images) ?></td>
                        <td>
                            <a class="btn btn-default btn-sm"
                               href="<?= $this->Url->build(['controller' => 'banners', 'action' => 'view', $banner->id]) ?>" title="Imagens"><i class="fa fa-image" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm"
                               href="<?= $this->Url->build(['controller' => 'banners', 'action' => 'edit', $banner->id]) ?>" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'banners', 'action' => 'delete', $banner->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('pagination') ?>