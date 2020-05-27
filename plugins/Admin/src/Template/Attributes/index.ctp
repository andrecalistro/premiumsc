<?php
/**
 * @var \App\View\AppView $this
 */
?>
    <div class="page-title">
        <h2>Atributos</h2>
    </div>
    <div class="content">
        <div class="container-fluid">
            <p><a class="btn btn-primary btn-sm"
                  href="<?= $this->Url->build(['controller' => 'attributes', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar</a>
            </p>
        </div>
        <div class="table-responsive">
            <table class="mar-bottom-20">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Cadastrado em</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if ($attributes): ?>
                    <?php foreach ($attributes as $attribute): ?>
                        <tr>
                            <td><?= $attribute->id ?></td>
                            <td><?= $attribute->name ?></td>
                            <td><?= $attribute->type_format ?></td>
                            <td><?= $attribute->created->format('d/m/Y') ?></td>
                            <td>
                                <a class="btn btn-default btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'attributes', 'action' => 'view', $attribute->id, 'plugin' => 'admin']) ?>"
                                   title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a class="btn btn-primary btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'attributes', 'action' => 'edit', $attribute->id, 'plugin' => 'admin']) ?>"
                                   title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'attributes', 'action' => 'delete', $attribute->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<?= $this->element('pagination') ?>