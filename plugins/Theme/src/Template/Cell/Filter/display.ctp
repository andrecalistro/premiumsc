<?php foreach($filtersGroups as $filtersGroup): ?>
<div class="sidebar-box">
    <div class="sidebar-title"><?= $filtersGroup->name ?></div>
    <ul>
        <?php foreach($filtersGroup->filters as $filter): ?>
            <li><a href="<?= $filter->link ?>"><?= $filter->name ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endforeach; ?>