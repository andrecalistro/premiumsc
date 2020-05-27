<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Admin.Banner $banner
 */
?>
<div class="page-title">
    <h2>Banner</h2>
</div>

<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <div class="row">
            <div class="col-md-7 col-xs-12">
                <p><strong>Nome</strong></p>
                <?= $banner->name ?>
            </div>
            <div class="col-md-3 col-xs-12">
                <p><strong>Descrição</strong></p>
                <?= $banner->description ?>
            </div>
        </div>
        <p><?= $this->Html->link('<i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar', ['controller' => 'positions', 'action' => 'index'], ['class' => 'btn btn-sm btn-default', 'escape' => false]) ?></p>
        <hr>
        <h3>Banners</h3>
        <p><?= $this->Html->link('Cadastrar', ['controller' => 'banners-images', 'action' => 'add', $banner->id], ['class' => 'btn btn-sm btn-default']) ?></p>
    </div>
    <div class="table-responsive">
        <table class="mar-bottom-20 normal-line-height">
            <thead>
            <th>Imagem</th>
            <th>URL</th>
            <th>Janela</th>
            <th>Status</th>
            <th></th>
            </thead>
            <tbody>
            <?php if (isset($banner->banners_images[0])): ?>
                <?php foreach ($banner->banners_images as $banners_image): ?>
                    <tr>
                        <td><?= ($banners_image->thumb_image_link) ? $this->Html->image($banners_image->thumb_image_link, ['class' => 'img-thumbnail']) : '' ?></td>
                        <td><?= $banners_image->url ?></td>
                        <td><?= $banners_image->name_target ?></td>
                        <td><?= $banners_image->name_status ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>', ['controller' => 'banners_images', 'action' => 'edit', $banners_image->id], ['class' => 'btn btn-sm btn-primary', 'title' => 'Editar', 'escape' => false]) ?>
                            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'banners_images', 'action' => 'delete', $banners_image->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" align="center">Nenhuma imagem cadastrada.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>