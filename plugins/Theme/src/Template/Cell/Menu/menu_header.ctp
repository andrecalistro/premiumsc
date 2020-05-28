<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\StoresMenusItem[] $menus
 */
?>
<div class="col-xl-12 col-lg-12 d-none d-lg-block">
    <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <?php foreach($menus as $menu): ?>
                    <?php if(!$menu->children): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $menu->url ?>" target="<?= $menu->target ?>"><?= $menu->name ?></a>
                        </li>
                    <?php continue; endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= $menu->name ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php foreach($menu->children as $child): ?>
                                <?php if(!$child->children): ?>
                                    <li class="dropdown-submenu">
                                        <a class="dropdown-item" href="<?= $child->url ?>" target="<?= $child->target ?>"><?= $child->name ?></a>
                                    </li>
                                <?php continue; endif; ?>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#"><?= $child->name ?></a>
                                    <ul class="dropdown-menu">
                                        <?php foreach($child->children as $subChild): ?>
                                            <li><a class="dropdown-item" href="<?= $subChild->url ?>" target="<?= $subChild->target ?>"><?= $subChild->name ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
</div>