<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Email Marketing</h2>
    <span class="subtitle"><?= $messageTotalEmails ?></span>
</div>
<div class="content">
    <div class="container-fluid">
        <p>
			<a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'emails-marketings', 'action' => 'import', 'plugin' => 'admin']) ?>">Importar</a>
			<a class="btn btn-primary btn-sm" href="<?= $this->Url->build(['controller' => 'emails-marketings', 'action' => 'export', 'plugin' => 'admin']) ?>">Exportar</a>
		</p>
    </div>

    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Data do cadastro</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php if ($emailsMarketings): ?>
                <?php foreach ($emailsMarketings as $emailsMarketing): ?>
                    <tr>
                        <td><?= $emailsMarketing->name ?></td>
                        <td><?= $emailsMarketing->email ?></td>
                        <td><?= $emailsMarketing->created->format("d/m/Y") ?></td>
                        <td>
                            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>', ['controller' => 'emails-marketings', 'action' => 'delete', $emailsMarketing->id], ['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja excluir esse item?', 'escape' => false, 'title' => 'Excluir']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('pagination') ?>