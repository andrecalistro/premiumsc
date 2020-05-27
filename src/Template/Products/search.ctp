<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div id="content" class="pad-top-25 pad-bottom-95">
    <div class="container">
        <div class="tp-breadcrumbs mar-bottom-30">
            <?= $this->Html->link('Home', "/") ?>
            <span class="sep"><i class="fa fa-angle-right"></i></span>
            Busca
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-3">

                <?= $this->element('sidebar/categories') ?>

                <div class="widget-sidebar">
                    <div class="title-sidebar">COR</div>
                    <div class="sidebar-content">
                        <form class="filter">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="filter-item">
                                        <input type="radio" id="cores1" name="cores"/>
                                        <label for="cores1">Amarelo</label>
                                    </div>
                                    <div class="filter-item">
                                        <input type="radio" id="cores2" name="cores"/>
                                        <label for="cores2">Azul</label>
                                    </div>
                                    <div class="filter-item">
                                        <input type="radio" id="cores3" name="cores"/>
                                        <label for="cores3">Branco</label>
                                    </div>
                                    <div class="filter-item">
                                        <input type="radio" id="cores4" name="cores"/>
                                        <label for="cores4">Cinza</label>
                                    </div>
                                    <div class="filter-item">
                                        <input type="radio" id="cores5" name="cores"/>
                                        <label for="cores5">Preto</label>
                                    </div>
                                    <div class="filter-item">
                                        <input type="radio" id="cores6" name="cores"/>
                                        <label for="cores6">Rosa</label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="filter-item">
                                        <input type="radio" id="cores7" name="cores"/>
                                        <label for="cores7">Amarelo</label>
                                    </div>
                                    <div class="filter-item">
                                        <input type="radio" id="cores8" name="cores"/>
                                        <label for="cores8">Azul</label>
                                    </div>
                                    <div class="filter-item">
                                        <input type="radio" id="cores9" name="cores"/>
                                        <label for="cores9">Branco</label>
                                    </div>
                                    <div class="filter-item">
                                        <input type="radio" id="cores10" name="cores"/>
                                        <label for="cores10">Cinza</label>
                                    </div>
                                    <div class="filter-item">
                                        <input type="radio" id="cores11" name="cores"/>
                                        <label for="cores11">Preto</label>
                                    </div>
                                    <div class="filter-item">
                                        <input type="radio" id="cores12" name="cores"/>
                                        <label for="cores12">Rosa</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="widget-sidebar">
                    <div class="title-sidebar">preço</div>
                    <div class="sidebar-content">
                        <div id="amount"></div>
                        <div id="slider-range"></div>
                        <div class="row prefix mar-bottom-45">
                            <div class="col-md-6 col-sm-6 col-xs-6">R$ 20</div>
                            <div class="col-md-6 col-sm-6 col-xs-6 text-right">R$ 4530</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-9">
                <div class="categories-title"><?= $title ?><span
                            class="categories-total"><span>Resultado:</span> <?= $this->Paginator->total() ?> <?= $this->Paginator->total() > 1 ? 'itens' : 'item' ?> </span>
                </div>
                <div class="categories-filter">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="show-number hidden-xs">
                                Mostrar: <input type="number" value="6"/>
                            </div>
                            <ul class="gridlist-toggle hidden-xs">
                                <li><a class="active" data-filter="grid" href="#"><i class="fa fa-th-large"></i></a>
                                </li>
                                <li><a data-filter="list" href="#"><i class="fa fa-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-right">
                            <div class="tp-pagination">
                                <?= $this->Paginator->prev("<i class=\"fa fa-arrow-circle-o-left\"></i>", ['escape' => false]) ?>
                                <?= $this->Paginator->counter(["format" => "<span>Página <span>{{page}}</span> de {{pages}}</span>"]) ?>
                                <?= $this->Paginator->next("<i class=\"fa fa-arrow-circle-o-right\"></i>", ['escape' => false]) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row space-60 category-content grid">
                    <?php if ($this->Paginator->total() > 0): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-md-4 col-sm-6">
                                <?= $this->element('product_home', ['product' => $product]) ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Não há resultados para a sua pesquisa</p>
                    <?php endif; ?>
                </div>

                <div class="categories-filter filter-bottom">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="show-number hidden-xs">
                                Mostrar: <input type="number" value="6"/>
                            </div>
                            <ul class="gridlist-toggle hidden-xs">
                                <li><a class="active" data-filter="grid" href="#"><i class="fa fa-th-large"></i></a>
                                </li>
                                <li><a data-filter="list" href="#"><i class="fa fa-bars"></i></a></li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-right">
                            <div class="tp-pagination">
                                <?= $this->Paginator->prev("<i class=\"fa fa-arrow-circle-o-left\"></i>", ['escape' => false]) ?>
                                <?= $this->Paginator->counter(["format" => "<span>Página <span>{{page}}</span> de {{pages}}</span>"]) ?>
                                <?= $this->Paginator->next("<i class=\"fa fa-arrow-circle-o-right\"></i>", ['escape' => false]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>