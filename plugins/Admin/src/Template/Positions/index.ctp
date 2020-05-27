<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Vitrine</h2>
</div>

<div class="content mar-bottom-20">
	<h2 class="section-title">Produtos</h2>

    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th><?= $this->Paginator->sort('name', 'Nome') ?></th>
                <th><?= $this->Paginator->sort('slug', 'Apelido') ?></th>
                <th><?= $this->Paginator->sort('PositionsPages.name', 'Página') ?></th>
                <th></th>
            </tr>

            </thead>
            <tbody>
            <?php if ($positions): ?>
                <?php foreach ($positions as $position): ?>
                    <tr>
                        <td><?= $position->id ?></td>
                        <td><?= $position->name ?></td>
                        <td><?= $position->slug ?></td>
                        <td><?= isset($position->positions_page->name) ? $position->positions_page->name : '' ?></td>
                        <td>
                            <a class="btn btn-default btn-sm"
                               href="<?= $this->Url->build(['controller' => 'positions', 'action' => 'view', $position->id, 'plugin' => 'admin']) ?>"
                               title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="content">
	<h2 class="section-title">Banners</h2>

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
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>