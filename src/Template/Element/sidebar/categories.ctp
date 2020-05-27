<div class="widget-sidebar">
    <div class="title-sidebar">Categorias</div>
    <div class="sidebar-content">
        <ul>
            <?php if($_categories): ?>
                <?php foreach($_categories as $category): ?>
                    <li><?= $this->Html->link($category->title, $category->full_link) ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>