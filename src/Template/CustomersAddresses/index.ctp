<?php
/**
 * @var App\View\AppView $this
 */
?>
<div id="content" class="pad-top-60 pad-bottom-95">
    <div class="container">

        <?= $this->Flash->render() ?>

        <div class="page-title mar-bottom-85">Minha Conta</div>

        <?= $this->element('Customers/menu') ?>

        <div class="col-md-8">
            <p class="title-conta">MEUS ENDEREÇOS</p>

            <p><?= $this->Html->link('Adicionar Endereço', ['action' => 'add'], ['class' => 'btn btn-primary']) ?></p>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Endereço</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($customersAddresses): ?>
                        <?php foreach ($customersAddresses as $address): ?>
                            <tr>
                                <td><?= $address->complete_address ?></td>
                                <td><?= $address->description ?></td>
                                <td>
                                    <?= $this->Html->link('Editar', ['action' => 'edit', $address->id], ['class' => 'btn btb-primary']) ?>
                                    <?= $this->Form->postLink('Excluir', ['action' => 'delete', $address->id], ['class' => 'btn btb-primary', 'confirm' => 'Tem certeza que deseja excluir esse endereço?']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" align="center">Nenhum endereço cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

