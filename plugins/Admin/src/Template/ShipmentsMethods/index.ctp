<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Metodos de Entrega</h2>
</div>
<div class="content">
    <div class="container-fluid">
        <p><a class="btn btn-primary btn-sm"
              href="<?= $this->Url->build(['controller' => 'shipments-methods', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar
                Metodo de Entrega</a></p>
    </div>
    <div class="table-responsive">
        <table class="mar-bottom-30">
            <thead>
            <tr>
                <th>ID</th>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Apelido</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($shipmentsMethods): ?>
                <?php foreach ($shipmentsMethods as $shipmentsMethod): ?>
                    <tr>
                        <td><?= $shipmentsMethod->id ?></td>
                        <td><?= $this->Html->image($shipmentsMethod->thumb_image_link, ['width' => 50]) ?></td>
                        <td><?= $shipmentsMethod->name ?></td>
                        <td><?= $shipmentsMethod->slug ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm"
                               href="<?= $this->Url->build(['controller' => 'shipments-methods', 'action' => 'edit', $shipmentsMethod->id, 'plugin' => 'admin']) ?>" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'shipments-methods', 'action' => 'delete', $shipmentsMethod->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('pagination') ?>