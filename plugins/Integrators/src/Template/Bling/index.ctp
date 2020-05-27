<?php
/**
 * @var \App\View\AppView $this
 * @var \Admin\Model\Entity\Customer $customer
 */
?>
<div class="page-title">
    <h2>Bling</h2>
</div>
<div class="content">
    <div class="container-fluid pad-bottom-30">
        <div class="row">
            <div class="col-md-12 navigation">
            <?php foreach($links as $link): ?>
                <a href="<?= $link['link'] ?>" class="btn btn-default">
                    <i class="fa <?= $link['icon'] ?>" aria-hidden="true"></i><br>
                    <?= $link['name'] ?>
                </a>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>