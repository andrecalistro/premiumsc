<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\Customer $customer
 */
?>
<div class="page-title">
    <h2>Integradores</h2>
</div>
<div class="content">
    <div class="table-responsive">
        <table class="mar-bottom-20">
            <thead>
            <tr>
                <th>Modulo</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($integrators): ?>
                <?php foreach ($integrators as $integrator): ?>
                    <tr>
                        <td><?= $integrator['name'] ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa fa-cogs" aria-hidden="true"></i>', ['controller' => $integrator['controller'], 'action' => $integrator['action']], ['class' => 'btn btn-primary btn-sm', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>