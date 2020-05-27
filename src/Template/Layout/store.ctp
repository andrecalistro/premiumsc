<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" />

    <link rel="icon" href="<?= $_store->favicon_link ?>" />

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('font-awesome.min') ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800" rel="stylesheet" />
    <?= $this->Html->css('owl.carousel') ?>
    <?= $this->Html->css('jquery-ui.min') ?>
    <?= $this->Html->css('style') ?>
    <?= $this->Html->css('responsive') ?>

    <title><?= $_pageTitle ?> - <?= $_store->name ?></title>
</head>

    <?= $this->element('header') ?>

    <?= $this->fetch('content') ?>

    <?= $this->element('footer') ?>

<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <?= $this->Html->image('carregando.gif', ['fullBase' => true, 'class' => 'icon']) ?>
                    <h4>Processando...</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->scriptBlock('var base_url = "'.$_base_url.'"') ?>
<?= $this->Html->script('http://code.jquery.com/jquery-1.11.2.min.js') ?>
<?= $this->Html->script(['bootstrap.min', 'owl.carousel.min', 'jquery.matchHeight-min', 'owl.carousel.min', 'jquery-ui.min', 'main', 'cart.functions', 'shipment.functions']) ?>

</body>

</html>