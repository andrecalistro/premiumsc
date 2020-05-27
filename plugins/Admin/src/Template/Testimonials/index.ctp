<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Depoimentos</h2>
</div>
<div class="content">
    <div class="container-fluid">
        <p><a class="btn btn-primary btn-sm"
              href="<?= $this->Url->build(['controller' => 'testimonials', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar</a></p>
    </div>
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>ID</th>
                <th class="hidden-xs">Imagem</th>
                <th>Nome</th>
                <th>Cadastrado em</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($testimonials): ?>
                <?php foreach ($testimonials as $testimonial): ?>
                    <tr>
                        <td><?= $testimonial->id ?></td>
                        <td class="hidden-xs"><?= $this->Html->image($testimonial->thumb_avatar_link, ['width' => 50]) ?></td>
                        <td><?= $testimonial->name ?></td>
                        <td><?= $testimonial->created->format('d/m/Y') ?></td>
                        <td>
                            <a class="btn btn-default btn-sm"
                               href="<?= $this->Url->build(['controller' => 'testimonials', 'action' => 'view', $testimonial->id, 'plugin' => 'admin']) ?>" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm"
                               href="<?= $this->Url->build(['controller' => 'testimonials', 'action' => 'edit', $testimonial->id, 'plugin' => 'admin']) ?>" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'testimonials', 'action' => 'delete', $testimonial->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('pagination') ?>