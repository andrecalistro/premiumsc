<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="shop-top-bar mb-35">
    <div class="select-shoing-wrap">
        <div class="shop-select">
            <select class="sort">
                <option value="">Ordenar por</option>
                <?php foreach ($sort_links as $sort_link): ?>
                    <option value="<?= $sort_link['key'] ?>" data-sort="<?= $sort_link['key'] ?>"
                            data-direction="<?= $sort_link['direction'] ?>"><?= $sort_link['title'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <p><?= $this->Paginator->counter('Exibindo {{start}}-{{end}} de {{count}} produtos') ?></p>
    </div>
    <div class="filter-active">
        <a href="#"><i class="fa fa-plus"></i> Filtrar (<?= \count($filters_query) ?>)</a>
    </div>
</div>
<div class="product-filter-wrapper">
    <div class="row lista-filtros">
        <?php if ($filters): ?>
            <?php foreach ($filters as $key => $itens): ?>
                <div class="col-md-3 col-sm-6 col-xs-12 mb-30">
                    <div class="product-filter">
                        <h5><?= $key ?></h5>
                        <ul class="color-filter">
                            <?php foreach ($itens as $item): ?>
                                <?php $checked = in_array($item['id'], $filters_query) ? 'checked' : '' ?>
                                <li><input <?= $checked ?> type="checkbox"
                                                           id="filter-<?= $item['id'] ?>"
                                                           data-type="<?= $item['slug_group'] ?>"
                                                           value="<?= $item['id'] ?>">
                                    <label for="filter-<?= $item['id'] ?>"><?= $item['name'] ?></label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <!-- Product Filter -->
        <!--                        <div class="col-md-3 col-sm-6 col-xs-12 mb-30">-->
        <!--                            <div class="product-filter">-->
        <!--                                <h5>Preço</h5>-->
        <!--                                <div class="price-filter mt-25">-->
        <!--                                    <div class="price-slider-amount">-->
        <!--                                        <input type="text" id="amount" name="price" placeholder="Insira o valor"-->
        <!--                                               readonly="readonly"/>-->
        <!--                                    </div>-->
        <!--                                    <div id="slider-range"></div>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                        </div>-->
    </div>
    <div class="row">
        <a href="<?= $category->full_link ?>">Limpar</a>
    </div>
</div>
