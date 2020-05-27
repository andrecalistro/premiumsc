<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div id="table-scroll-menu"> 
<ul class="nav nav-stacked" id="main-menu-nav">
    <?php foreach ($_menus as $key => $menu): ?>
        <?php if (isset($menu->children) && !empty($menu->children)): ?>
            <li class="nav-header menu-drop-down">
                <a href="#" class="menu-dropdown" title="<?= $menu->name ?>">
                    <div class="row name-menu-dropdown">
                        <div class="col-md-2 col-xs-2"><i class="fa <?= $menu->icon ?>" aria-hidden="true"></i></div>
                        <div class="col-md-8 col-xs-8 text-menu"><?= $menu->name ?></div>
                        <div class="col-md-2 col-xs-2">
                            <i class="fa fa-angle-down pull-right" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="row name-menu-min-dropdown">
                        <div class="col-md-12">
                            <i class="fa <?= $menu->icon ?>" aria-hidden="true"></i>
                            <i class="fa fa-angle-down pull-right" aria-hidden="true"></i>
                        </div>
                    </div>
                </a>
                <ul class="nav nav-stacked child-submenu" style="display: none;">
                    <?php foreach ($menu->children as $children): ?>
                        <li><?= $this->Html->link($children->name, ['controller' => $children->controller, 'action' => $children->action, 'plugin' => $children->plugin]) ?></li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php else: ?>
            <li>
                <a href="<?= $this->Url->build(['controller' => $menu->controller, 'action' => $menu->action, 'plugin' => $menu->plugin], true) ?>"
                   title="<?= $menu->name ?>">
                    <div class="row">
                        <div class="col-md-2 col-xs-2"><i class="fa <?= $menu->icon ?>" aria-hidden="true"></i></div>
                        <div class="col-md-10 col-xs-10 text-menu"><?= $menu->name ?></div>
                    </div>
                </a>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
</div>