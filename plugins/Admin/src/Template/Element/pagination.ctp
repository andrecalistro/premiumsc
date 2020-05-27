<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="container-fluid pagination-button">
    <div class="pull-left">
        <?= $this->Paginator->counter('Exibindo {{current}} itens de um total de {{count}}'); ?>
    </div>
    <div class="pull-right">
        <nav>
            <ul>
                <li><?= $this->Paginator->prev('<i class="fa fa-chevron-left" aria-hidden="true"></i>', ['escape' => false]) ?></li>

                <li style="margin-right: 10px;"><?= $this->Custom->selectPages(['style' => 'padding: 3px; height: 25px;, margin-top: -2px;']) ?></li>

                <li><?= $this->Paginator->counter(' DE {{pages}}') ?></li>

                <li><?= $this->Paginator->next('<i class="fa fa-chevron-right" aria-hidden="true"></i>', ['escape' => false]) ?></li>
            </ul>
        </nav>

    </div>
</div>