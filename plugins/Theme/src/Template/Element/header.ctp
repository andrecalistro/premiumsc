<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Controller\Component\AuthComponent $_auth
 */
?>
<header class="header-area clearfix header-hm8">
    <div class="header-top-area header-padding-2">
        <div class="container-fluid">
            <div class="header-top-wap">
                <div class="language-currency-wrap">
                    <div class="same-language-currency">
                        <p>
                            <a href="#" title="Whatsapp">
                                <i class="fa fa-whatsapp" aria-hidden="true"></i> <?= $_store->cellphone ?>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="header-right-wrap">
                    <div class="same-style header-search">
                        <a class="search-active" href="#"><i class="pe-7s-search"></i></a>
                        <div class="search-content">
                            <?= $this->Form->create('', ['url' => $this->Url->build('/busca', ['fullBase' => true]), 'type' => 'post', 'style' => 'width: 100%;', 'id' => 'form-search']) ?>
                                <input type="text" name="q" placeholder="O que você procura?" />
                                <button class="button-search" type="submit"><i class="pe-7s-search"></i></button>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                    <div class="same-style account-satting">
                        <a class="account-satting-active" href="#"><i class="pe-7s-user-female"></i></a>
                        <div class="account-dropdown">
                            <ul>
                                <?php if ($_auth): ?>
                                    <li><a href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'dashboard', 'plugin' => 'CheckoutV2'], ['fullBase' => true]) ?>">Olá, <?= $_auth['name'] ?></a></li>
                                <?php else: ?>
                                    <li><a href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'register', 'plugin' => 'CheckoutV2'], ['fullBase' => true]) ?>">Login</a></li>
                                    <li><a href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'register', 'plugin' => 'CheckoutV2'], ['fullBase' => true]) ?>">Cadastrar</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="same-style cart-wrap">
                        <button class="icon-cart" title="Meu carrinho" onclick='window.location.href="<?= $this->Url->build('/carrinho', ['fullBase' => true]) ?>"'>
                            <i class="pe-7s-shopbag"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom sticky-bar header-res-padding header-padding-2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-6 col-4">
                    <div class="logo text-center">
                        <a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">
                            <?= $this->Html->image($_store->logo_link) ?>
                        </a>
                    </div>
                </div>
                <?= $this->cell('Theme.Menu::menuHeader') ?>
            </div>
            <div class="mobile-menu-area">
                <div class="mobile-menu">
                    <nav id="mobile-menu-active">
                        <?= $this->cell('Theme.Menu::menuHeaderMobile') ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>