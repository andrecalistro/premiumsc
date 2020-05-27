<?php
/**
 * @var \App\View\AppView $this
 * @var \Subscriptions\Model\Entity\Subscription $subscription
 */
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
?>
<div class="garrula-customer garrula-customer-dashboard">

    <div class="container py-3">
        <nav class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'dashboard'], ['fullBase' => true]) ?>">Minha conta</a></li>
                <li class="breadcrumb-item"><?= $_pageTitle ?></li>
            </ol>
        </nav>
    </div>

    <section class="container">
        <div class="text-center mb-4">
            <h3><?= $_pageTitle ?></h3>
        </div>

        <div class="row">
            <div class="col-md-3">
                <?= $this->cell('Checkout.Customer::menu') ?>
            </div>

            <div class="col-md-9">
                <div class="mt-4 mb-5">
                    <?php if ($subscriptions): ?>
                        <?php foreach ($subscriptions as $subscription): ?>
                            <div class="bg-cor-3 mt-2 py-2">
                                <div class="row p-2">
									<div class="col">
										<strong>Plano</strong>
                                        <p><?= $subscription->plan->name ?></p>
									</div>
                                    <div class="col">
                                        <strong>Data</strong>
                                        <p><?= $subscription->created->format('d/m/Y') ?></p>
                                    </div>
                                    <div class="col">
                                        <strong>Total</strong>
                                        <p><?= $subscription->price_total_format ?></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <strong>Status</strong>
                                        <p><?= $subscription->status === 1 ? 'Ativo' : 'Inativo' ?></p>
                                    </div>
                                    <div class="col d-flex justify-content-end align-items-center">
                                        <?= $this->Html->link('Ver detalhes', [$subscription->id, '_name' => 'customerSubscriptionView'], ['class' => 'btn btn-primary']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="m-auto">Você ainda não assinou nenhum plano.</p>
                    <?php endif; ?>
                </div>

                <?= $this->element('Customers/pagination') ?>
            </div>
        </div>
    </section>
</div>