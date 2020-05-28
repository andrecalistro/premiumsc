<div class="sidebar-box">
    <div class="sidebar-title">CATEGORIA</div>
    <ul>
        <?php if($_categories): ?>
            <?php foreach($_categories as $category): ?>
                <li><?= $this->Html->link($category->title, $category->full_link) ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>