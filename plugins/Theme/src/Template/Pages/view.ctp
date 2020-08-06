<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="breadcrumb-area pt-35 pb-35 bg-gray-3">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <ul>
                <li>
                    <a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a>
                </li>
                <li class="active"><?= $page->name ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="welcome-area pt-100 pb-95">
    <div class="container">
        <?= $page->content ?>
    </div>
</div>