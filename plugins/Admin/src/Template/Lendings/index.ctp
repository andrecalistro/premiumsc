<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="navbarBtns">
    <div class="page-title">
        <h2>Comodatos</h2>
    </div>

    <div class="navbarRightBtns">
        <a class="btn btn-primary btn-sm navbarBtn"
           href="<?= $this->Url->build(['controller' => 'lendings', 'action' => 'add', 'plugin' => 'admin']) ?>">Adicionar
            Comodato</a>
    </div>
</div>

<div class="content">
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Cliente</th>
                <th>Email do Cliente</th>
                <th>Status de venda</th>
                <th>Produtos enviados para o cliente?</th>
                <th>Usuário</th>
                <th>Data de Criação</th>
                <th width="260">Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($lendings): ?>
                <?php foreach ($lendings as $lending): ?>
                    <tr>
                        <td><?= $lending->id ?></td>
                        <td><?= $lending->customer_name ?></td>
                        <td><?= $lending->customer_email ?></td>
                        <td><?= $lending->status_text ?></td>
                        <td><?= ($lending->send_status) ? '<span class="label label-success">Enviado em ' . $lending->send_date->format("d/m/Y") . '</span>' : '<span class="label label-danger">Não enviado</span>' ?></td>
                        <td><?= $lending->user->name ?></td>
                        <td><?= $lending->created->format("d/m/Y") ?></td>
                        <td>
                            <a class="btn btn-default btn-sm"
                               href="<?= $this->Url->build(['controller' => 'lendings', 'action' => 'view', $lending->id]) ?>"
                               title="Visualizar">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                            <?php if ($lending->status != 1) : ?>
								<a class="btn btn-success btn-sm"
								   href="<?= $this->Url->build(['controller' => 'orders', 'action' => 'add', $lending->id]) ?>" title="Faturar">
									<i class="fa fa-check" aria-hidden="true"></i>
								</a>
								<!--
                                <a class="btn btn-success btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'lendings', 'action' => 'finalize', $lending->id]) ?>"
                                   title="Finalizar">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </a>
                                -->
                                <a class="btn btn-primary btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'lendings', 'action' => 'edit', $lending->id]) ?>"
                                   title="Editar">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                            <?php endif; ?>
                            <?= $this->Form->postLink('<i class="fa fa-envelope" aria-hidden="true"></i>',
                                ['controller' => 'lendings', 'action' => 'send-email', $lending->id],
                                ['method' => 'post', 'class' => 'btn btn-warning btn-sm', 'confirm' => 'Tem certeza que deseja enviar por email?', 'escape' => false, 'title' => 'Enviar produtos para o e-mail do cliente']) ?>
                            <?php if (!$lending->send_status): ?>
                                <?= $this->Form->postLink('<i class="fa fa-truck" aria-hidden="true"></i>',
                                    ['controller' => 'lendings', 'action' => 'send-products', $lending->id],
                                    ['method' => 'post', 'class' => 'btn btn-success btn-sm', 'confirm' => 'Os produtos foram enviados para o cliente?', 'escape' => false, 'title' => 'Marcar produtos enviados para o cliente']) ?>
                            <?php endif; ?>
                            <?= $this->Html->link('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>', ['controller' => 'lendings', 'action' => 'export-pdf', $lending->id, '_ext' => 'pdf'], ['class' => 'btn btn-sm btn-default', 'escape' => false, 'title' => 'Exportar PDF']) ?>
                            <?php if($lending->status == 0): ?>
								<?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>',
									['controller' => 'lendings', 'action' => 'cancel', $lending->id],
									['method' => 'post', 'class' => 'btn btn-danger btn-sm', 'confirm' => 'Tem certeza que deseja cancelar esse item?', 'escape' => false]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->element('pagination') ?>
