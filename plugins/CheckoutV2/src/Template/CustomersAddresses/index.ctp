<?php
/**
 * @var App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
?>
<section class="main">

    <div class="breadcrumb">
        <div class="container">
            <ul>
                <li><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Início</a></li>
                <li><?= $_pageTitle ?></li>
            </ul>
        </div>
    </div>

    <div class="user-profile">
        <div class="container">
            <div class="grid">
                <?= $this->element('Customers/menu') ?>
                <div class="col-md-8 col-lg-8 align-self-start">
                    <h2 class="profile-section-title float-left"><?= $_pageTitle ?></h2>
                    <?= $this->Html->link('Adicionar endereço', ['controller' => 'customers-addresses', 'action' => 'add'], ['class' => 'btn btn-success float-right']) ?>
                    <ul class="enderecos">
                        <?php if ($customersAddresses): ?>
                            <?php foreach ($customersAddresses as $address): ?>
                                <li>
                                    <p><?= $address->complete_address ?></p>
                                    <p><?= $this->Html->link('Editar', ['controller' => 'customers-addresses', 'action' => 'edit', $address->id]) ?></p>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="m-auto">Nenhum endereço cadastrado.</p>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</section>