<div id="content" class="pad-top-25 pad-bottom-95">
    <div class="container">
        <div class="tp-breadcrumbs">
            <?= $this->Html->link('Home', "/") ?>
            <span class="sep"><i class="fa fa-angle-right"></i></span>
            Carrinho de Compras
        </div>
        <div class="page-title mar-bottom-20">Carrinho de Compras</div>
        <p class="text-center mar-bottom-85 font-16 font-semibold">Ops! Seu carrinho está vazio.
            Para inserir produtos no seu carrinho, navegue pelo shopping ou utilize a busca do site. Ao encontrar os
            produtos desejados, clique no botão "Comprar".</p>
        <div class="text-center mar-bottom-30">
            <a href="<?= $this->Url->build("/", true) ?>" class="btn btn-grey">Continuar Comprando</a>
        </div>
    </div>
</div>