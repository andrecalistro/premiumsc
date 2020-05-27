<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $productsRating
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $productsRating->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $productsRating->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Products Ratings'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Products Ratings Statuses'), ['controller' => 'ProductsRatingsStatuses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Products Ratings Status'), ['controller' => 'ProductsRatingsStatuses', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="productsRatings form large-9 medium-8 columns content">
    <?= $this->Form->create($productsRating) ?>
    <fieldset>
        <legend><?= __('Edit Products Rating') ?></legend>
        <?php
            echo $this->Form->control('customers_id', ['options' => $customers]);
            echo $this->Form->control('orders_id', ['options' => $orders, 'empty' => true]);
            echo $this->Form->control('products_id', ['options' => $products, 'empty' => true]);
            echo $this->Form->control('rating');
            echo $this->Form->control('answer');
            echo $this->Form->control('products_ratings_statuses_id', ['options' => $productsRatingsStatuses]);
            echo $this->Form->control('products_name');
            echo $this->Form->control('products_image');
            echo $this->Form->control('deleted', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
