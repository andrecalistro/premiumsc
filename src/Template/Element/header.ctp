<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Controller\Component\AuthComponent $_auth
 */
?>
<header id="header">

    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <div class="barra-mobile visible-xs">
                    <ul>
                        <li><a href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'register']) ?>"><i
                                        class="fa fa-user" aria-hidden="true"></i></a></li>
                        <li><a href="<?= $this->Url->build(['controller' => 'carts', 'action' => 'index']) ?>"><i
                                        class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                        </li>
                        <li class="search"><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
                            <?= $this->Form->create('', ['url' => ['controller' => 'products', 'action' => 'search'], 'type' => 'get']) ?>
                            <?= $this->Form->control('p', ['class' => 'input-search', 'placeholder' => 'Olá, o que você procura?', 'required' => true, 'label' => false, 'div' => false]) ?>
                            <?= $this->Form->end() ?>
                        </li>

                    </ul>
                </div>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-brand">
                    <a href="<?= $this->Url->build('/', ['fullBase' => true]) ?> ">
                        <?= $this->Html->image($_store->logo_link, ['class' => 'img-responsive']) ?>
                    </a>
                </div>
            </div>

            <div id="navbar" class="navbar-collapse collapse">

                <?= $this->Form->create('', ['url' => ['controller' => 'products', 'action' => 'search'], 'type' => 'get', 'class' => 'navbar-form navbar-left hidden-xs']) ?>
                    <?= $this->Form->control('p', ['class' => 'search-input', 'placeholder' => 'Olá, o que você procura?', 'required' => true, 'label' => false, 'div' => false]) ?>
                    <?= $this->Form->submit('', ['class' => 'submit']) ?>
                <?= $this->Form->end() ?>

                <ul class="nav navbar-nav navbar-right navbar-top hidden-xs">
                    <li class="login">
                        <?php if ($_auth->user('id')): ?>
                            <span>Olá <?= $this->Html->link($_auth->user('name'), ['controller' => 'customers', 'action' => 'orders']) ?></span>
                        <?php else: ?>
                            <a href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'register']) ?>"><span>Entre</span>
                                ou <span class="accent">Cadastre-se</span></a>
                        <?php endif; ?>
                    </li>
                    <li class="cart dropdown">
                        <a href="<?= $this->Url->build(['controller' => 'carts', 'action' => 'index']) ?>"
                           class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="true">meu
                            carrinho<span><?= count($_cart_products) > 1 ? count($_cart_products) . ' itens' : count($_cart_products) . ' item' ?></span></a>
                        <ul class="dropdown-menu hidden-xs">
                            <li class="produto">
                                <?php if ($_cart_products): ?>
                                    <?php foreach ($_cart_products as $product): ?>
                                        <div class="box">
                                            <?= $this->Html->image($product->thumb_main_image, ['fullBase' => true]) ?>
                                            <div class="txt">
                                                <p class="nome"><?= $product->name ?></p>
                                                <p class="valor">Valor: <span><?= $product->total_price_format ?></span>
                                                </p>
                                                <p class="quant">Quantidade: <?= $product->quantity ?></p>
                                            </div>
                                            <div class="opcoes">
                                                <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'carts', 'action' => 'delete', $product->carts_id], ['class' => 'remove', 'escape' => false]) ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="total text-right">Total:
                                        <span><?= $_cart_subtotal->subtotal_format ?></span></div>
                                    <div class="botoes">
                                        <a href="<?= $this->Url->build(['controller' => 'carts']) ?>"
                                           class="btn btn-accent">VER CARRINHO</a>
                                        <a href="#" class="btn btn-accent">FINALIZAR COMPRA</a>
                                    </div>
                                <?php else: ?>
                                    <p class="text-center">Seu carrinho está vazio :(</p>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right menu-top hidden-xs">
                    <li><a href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'account']) ?>">Minha
                            conta</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'orders']) ?>">Meus
                            pedidos</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'stores', 'action' => 'contact']) ?>">Atendimento</a>
                    </li>
                </ul>
                <ul class="nav nav-justified main-menu hidden-xs">
                    <?php if ($_categories): ?>
                        <?php foreach ($_categories as $category): ?>
                            <li><?= $this->Html->link($category->title, $category->full_link) ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <div class="menu-mobile nav nav-justified hidden-lg hidden-sm hidden-md">
                    <li><a href="categorias.html">Novidades</a></li>
                    <li><a href="categorias.html">Categorias</a>
                    <li><a href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'account']) ?>">Minha
                            conta</a></li>
                    <li><a href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'orders']) ?>">Meus
                            pedidos</a></li>
                    <li><a href=<?= $this->Url->build('contact') ?>>Atendimento</a></li>
                    </li>
                </div>

            </div>
        </div>
    </nav>
</header>