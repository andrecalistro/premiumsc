<?php
/**
* @var \App\View\AppView $this
 */
?>
<div class="pro-pagination-style text-center mt-30">
    <ul>
        <?= $this->Paginator->prev('<i class="fa fa-angle-double-left"></i>', ['escape' => false]) ?>
        <?= $this->Paginator->numbers([
            'first' => 1,
            'last' => 1,
            'templates' => [
                'current' => '<li><a class="active" href="">{{text}}</a></li>'
            ]
        ]) ?>
        <?= $this->Paginator->next('<i class="fa fa-angle-double-right"></i>', ['escape' => false]) ?>
    </ul>
</div>