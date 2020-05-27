<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Admin.Lending $lending
 */
?>
<div class="page-title">
    <h2>Comodato #<?= $lending->id ?></h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid mar-bottom-20">
        <p><b>Nome do Cliente:</b> <?= $lending->customer_name ?></p>
        <p><b>Email do Cliente:</b> <?= $lending->customer_email ?></p>
        <p>
            <b>Status:</b> <?= ($lending->status) ? '<span class="label label-success">Finalizado</span>' : '<span class="label label-warning">Pendente</span>' ?>
        </p>
        <p><b>Status de
                Envio:</b> <?= ($lending->send_status) ? '<span class="label label-success">Enviado em ' . $lending->send_date->format("d/m/Y") . '</span>' : '<span class="label label-danger">Não enviado</span>' ?>
        </p>
        <p><b>Usuário Responsável:</b> <?= $lending->user->name ?></p>
        <p><b>Data do Cadastro:</b> <?= $lending->created->format("d/m/Y") ?></p>

        <hr>

        <h4>Produtos</h4>
        <?php if (!empty($lending->products)): ?>
            <div class="table-responsive">
                <table class="mar-bottom-20">
                    <thead>
                    <tr>
                        <th width="80">ID</th>
                        <th width="120">Código</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th width="80">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($lending->products as $product): ?>
                        <tr>
                            <td><?= $product->id ?></td>
                            <td><?= $product->code ?></td>
                            <td><?= isset($product->products_images[0]->thumb_image_link) ? $this->Html->image($product->products_images[0]->thumb_image_link, ['align' => 'left', 'width' => '55', 'class' => 'hidden-xs']) : '' ?> <?= $product->name ?></td>
                            <td><?= $product->price_final['formatted'] ?></td>
                            <td><?= ($product->_joinData->status) ? '<span class="label label-success">Adquirido</span>' : '<span class="label label-danger">Não adquirido</span>' ?></td>
                            <td>
                                <a class="btn btn-default btn-sm"
                                   href="<?= $this->Url->build(['controller' => 'products', 'action' => 'view', $product->id]) ?>"
                                   title="Visualizar">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center">Nenhum produto.</p>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <?= $this->Html->link('<i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                <?= $this->Form->postLink('<i class="fa fa-envelope" aria-hidden="true"></i>',
                    ['controller' => 'lendings', 'action' => 'send-email', $lending->id],
                    ['method' => 'post', 'class' => 'btn btn-warning btn-sm', 'confirm' => 'Tem certeza que deseja enviar por email?', 'escape' => false, 'title' => 'Enviar produtos para o e-mail do cliente']) ?>
                <?php if (!$lending->send_status): ?>
                    <?= $this->Form->postLink('<i class="fa fa-truck" aria-hidden="true"></i>',
                        ['controller' => 'lendings', 'action' => 'send-products', $lending->id],
                        ['method' => 'post', 'class' => 'btn btn-success btn-sm', 'confirm' => 'Os produtos foram enviados para o cliente?', 'escape' => false, 'title' => 'Marcar produtos enviados para o cliente']) ?>
                <?php endif; ?>
                <?= $this->Html->link('<i class="fa fa-file-pdf-o" aria-hidden="true"></i>', ['controller' => 'lendings', 'action' => 'export-pdf', $lending->id, '_ext' => 'pdf'], ['class' => 'btn btn-sm btn-default', 'escape' => false, 'title' => 'Exportar PDF']) ?>
            </div>
        </div>
    </div>
</div>
