<?php
/**
 * @var App\View\AppView $this
 * @var \Subscriptions\Model\Entity\Subscription $subscription
 */
$this->Html->css(['Theme.loja.min.css'], ['fullBase' => true, 'block' => 'cssTop']);
echo $this->element('CheckoutV2.Checkout/ga-ecommerce-tracking');
?>

<div class="garrula-checkout garrula-checkout-success-ticket">
    <div class="container py-3">
        <nav class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li class="breadcrumb-item"><a
                            href="<?= $this->Url->build(['controller' => 'carts', 'action' => 'index'], ['fullBase' => true]) ?>">Assinatura</a>
                </li>
                <li class="breadcrumb-item"><?= $_pageTitle ?></li>
            </ol>
        </nav>
    </div>

    <?= $this->cell('Subscriptions.Cart::steps', ['steps' => [1, 2, 3]]); ?>

    <div class="container my-5">
        <div class="text-center">
            <h4><?= $_pageTitle ?></h4>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p class="text-center font-19">Aguardando pagamento</p>
                <p class="text-center font-16 mar-bottom-40">
                    Seu pagamento está sendo processado, assim que ele for confirmado nós avisaremos por e-mail.
                </p>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="box-border">
                            <div class="title">Resumo da assinatura</div>
                            <div class="border-bottom pb-2 mb-2">
                                <div class="row">
                                    <div class="col-md-3">
                                        <?= $this->Html->image($subscription->plan->thumb_main_image, ['class' => 'img-responsive', 'width' => 50]) ?>
                                    </div>
                                    <div class="col-md-9 text-right">
                                        <b><?= $subscription->plan->name ?></b><br>
                                        <br>
                                        <small><?= $subscription->plan->price_format ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-bottom pb-2 mb-2">
                                <div class="col-8">
                                    <b>Frequência de cobrança</b>
                                </div>
                                <div class="col-4 text-right">
                                    <?= $subscription->frequency_billing_name ?>
                                </div>
                            </div>
                            <div class="row border-bottom pb-2 mb-2">
                                <div class="col-8">
                                    <b>Frequência de envio</b>
                                </div>
                                <div class="col-4 text-right">
                                    <?= $subscription->frequency_delivery_name ?>
                                </div>
                            </div>
                            <?php if ($subscription->price_shipping): ?>
                                <div class="row border-bottom pb-2 mb-2">
                                    <div class="col-8">
                                        <b>Frete</b>
                                    </div>
                                    <div class="col-4 text-right">
                                        <?= $subscription->price_shipping_format ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row total">
                                <div class="col-8">
                                    <strong>Total:</strong>
                                </div>
                                <div class="col-4 text-right">
                                    <?= $subscription->price_total_format ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php if ($subscription->plan->shipping_required): ?>
                            <div class="box-border">
                                <div class="title">Endereço de entrega</div>
                                <p>
                                    <?= $subscription->customers_address->address ?>, <?= $subscription->customers_address->number ?>, <?= $subscription->customers_address->complement ?><br/>
                                    <?= $subscription->customers_address->neighborhood ?> - <?= $subscription->customers_address->city ?> - <?= $subscription->customers_address->state ?><br/>
                                    CEP: <?= $subscription->customers_address->zipcode ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row text-center mt-3">
                    <div class="col-md-12">
                        <a href="<?= $this->Url->build(['_name' => 'customerSubscriptions', 'plugin' => 'checkout'], ['fullBase' => true]) ?>"
                           class="btn btn-primary">Acompanhe sua assinatura</a>
                    </div>
                    <div class="col-md-12 mt-3">
                        <a href="<?= $this->Url->build('/', true) ?>" class="btn btn-secondary">Voltar ao início</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>