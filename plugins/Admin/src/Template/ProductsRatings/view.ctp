<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $productsRating
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Products Rating'), ['action' => 'edit', $productsRating->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Products Rating'), ['action' => 'delete', $productsRating->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productsRating->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Products Ratings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Products Rating'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products Ratings Statuses'), ['controller' => 'ProductsRatingsStatuses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Products Ratings Status'), ['controller' => 'ProductsRatingsStatuses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="productsRatings view large-9 medium-8 columns content">
    <h3><?= h($productsRating->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $productsRating->has('customer') ? $this->Html->link($productsRating->customer->name, ['controller' => 'Customers', 'action' => 'view', $productsRating->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order') ?></th>
            <td><?= $productsRating->has('order') ? $this->Html->link($productsRating->order->id, ['controller' => 'Orders', 'action' => 'view', $productsRating->order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product') ?></th>
            <td><?= $productsRating->has('product') ? $this->Html->link($productsRating->product->name, ['controller' => 'Products', 'action' => 'view', $productsRating->product->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Products Ratings Status') ?></th>
            <td><?= $productsRating->has('products_ratings_status') ? $this->Html->link($productsRating->products_ratings_status->name, ['controller' => 'ProductsRatingsStatuses', 'action' => 'view', $productsRating->products_ratings_status->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Products Name') ?></th>
            <td><?= h($productsRating->products_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Products Image') ?></th>
            <td><?= h($productsRating->products_image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($productsRating->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rating') ?></th>
            <td><?= $this->Number->format($productsRating->rating) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($productsRating->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($productsRating->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($productsRating->deleted) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Answer') ?></h4>
        <?= $this->Text->autoParagraph(h($productsRating->answer)); ?>
    </div>
</div>
