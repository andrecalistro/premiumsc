<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Admin.EmailTemplate[]|\Cake\Collection\CollectionInterface $emailTemplates
 */
?>
<div class="page-title">
    <h2>Templates de E-mail</h2>
</div>
<div class="content">
    <div class="container-fluid">
        <p><a class="btn btn-sm btn-primary" href="<?= $this->Url->build(['action' => 'add', 'plugin' => 'admin']) ?>">Adicionar
                Template</a></p>
    </div>
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Quem recebe</th>
                <th width="150"></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($emailTemplates): ?>
                <?php foreach ($emailTemplates as $emailTemplate): ?>
                    <tr>
                        <td><?= $emailTemplate->name ?></td>
                        <td><?= $emailTemplate->who_receives_name ?></td>
                        <td>
                            <a class="btn btn-default btn-sm"
                               href="<?= $this->Url->build(['action' => 'view', $emailTemplate->id, 'plugin' => 'admin']) ?>"
                               title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>
                            <a class="btn btn-primary btn-sm"
                               href="<?= $this->Url->build(['action' => 'edit', $emailTemplate->id, 'plugin' => 'admin']) ?>"
                               title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['action' => 'delete', $emailTemplate->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'title' => 'Excluir', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->element('pagination') ?>

