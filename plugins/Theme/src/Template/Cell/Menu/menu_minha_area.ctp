<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\StoresMenusItem[] $menus
 */
?>
<ul>
    <?php foreach($menus as $menu): ?>
        <?php if(!$menu->children): ?>
            <li><a href="<?= $menu->url ?>" target="<?= $menu->target ?>"><?= $menu->name ?></a></li>
        <?php continue; endif; ?>
        <li class="submenu"><a href="<?= $menu->url ?>" target="<?= $menu->target ?>"><?= $menu->name ?></a>
            <ul>
                <?php foreach ($menu->children as $child): ?>
                    <li><a href="<?= $child->url ?>" target="<?= $child->target ?>"><?= $child->name ?></a></li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>