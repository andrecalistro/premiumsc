<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\Customer $customer
 */
?>
<div class="page-title">
    <h2>Modulos do Sistema</h2>
</div>
<div class="content">
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
            <?php if ($modules): ?>
                <?php foreach ($modules as $module): ?>
                    <tr>
                        <td><?= $module['name'] ?></td>
                        <td><?= $module['status'] ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa fa-cogs" aria-hidden="true"></i>', ['action' => $module['action']], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>