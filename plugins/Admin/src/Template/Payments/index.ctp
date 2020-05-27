<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\Customer $customer
 */
?>
<div class="page-title">
    <h2>Modulos de Pagamento</h2>
</div>
<div class="content">
    <div class="container-fluid">
        <p><a class="btn btn-primary btn-sm"
              href="<?= $this->Url->build(['controller' => 'payments', 'action' => 'configuration']) ?>">Configurar
                parcelamento e descontos</a></p>
    </div>
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>Modulo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($payments): ?>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?= $payment['name'] ?></td>
                        <td><?= $payment['status'] ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa fa-cogs" aria-hidden="true"></i>', ['action' => $payment['action']], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>