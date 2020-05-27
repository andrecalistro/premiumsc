<?php
/**
 * @var \App\View\AppView $this
 */
?>
<section class="main">

    <div class="checkout-block-full">
        <div class="container text-center">
            <div class="shopping-cart">
                <h2 class="page-title">Ops! Seu carrinho está vazio</h2>
                <p>Para inserir produtos no seu carrinho, navegue pelo shopping ou utilize a busca do site. <br>
                    Ao encontrar os produtos desejados, clique no botão "Comprar"</p>
                <?= $this->Html->link(__("Continuar Comprando"), $this->Url->build("/", true),
                    ['class' => 'btn btn-primary btn-form spacing']) ?>

            </div>
        </div>
    </div>
</section>