<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\StoresMenusItem[] $menus
 */
?>
<div class="footer-widget mb-30 ml-30">
    <div class="footer-title">
        <h3><?= $title ?></h3>
    </div>
    <div class="footer-list">
        <ul>
            <?php foreach($menus as $menu): ?>
                <li><a href="<?= $menu->url ?>" target="<?= $menu->target ?>"><?= $menu->name ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>