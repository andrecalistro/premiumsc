<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\StoresMenusItem[] $menus
 */
?>
<ul class="menu-overflow">
    <?php foreach($menus as $menu): ?>
        <?php if(!$menu->children): ?>
            <li><a href="<?= $menu->url ?>" target="<?= $menu->target ?>"><?= $menu->name ?></a></li>
            <?php continue; ?>
        <?php endif; ?>
        <li><a href="#"><?= $menu->name ?></a>
            <ul>
                <?php foreach($menu->children as $child): ?>
                    <?php if(!$child->children): ?>
                        <li><a href="<?= $child->url ?>" target="<?= $child->target ?>"><?= $child->name ?></a></li>
                        <?php continue; ?>
                    <?php endif; ?>
                    <li><a href="#"><?= $child->name ?></a>
                        <ul>
                            <?php foreach($child->children as $subChild): ?>
                                <li><a href="<?= $subChild->url ?>" target="<?= $subChild->target ?>"><?= $subChild->name ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>