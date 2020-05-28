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
</div>
