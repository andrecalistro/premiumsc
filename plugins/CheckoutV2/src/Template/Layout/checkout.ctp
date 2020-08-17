<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?= empty($_pageTitle) ? '' : $_pageTitle . ' - ' ?><?= $_store->name ?></title>
    <meta name="description" content="<?= $_description ?>"/>
    <meta name="author" content="Nerdweb">
    <meta name="language" content="pt-br"/>

    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!-- Facebook -->
    <meta property="og:site_name" content="<?= $_store->name ?>">
    <meta property="og:type" content="website">
    <meta property="og:description" content="<?= $_description ?>">
    <meta property="og:image" content="<?= $_og_image ?>">
    <meta property="og:image:type" content="<?= $_og_type ?>">
    <meta property="og:image:width" content="<?= $_og_width ?>">
    <meta property="og:image:height" content="<?= $_og_height ?>">

    <!--Favicon-->
    <link rel="icon" href="<?= $_store->favicon_link ?>"/>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <?= $this->Html->css('CheckoutV2.checkout.min', ['fullBase' => true]) ?>
    <?= $this->fetch('cssTop') ?>
    <?= $_store->google_analytics ?>
</head>
<body class="checkout">
<?= $this->Flash->render() ?>
<?= $this->element('CheckoutV2.Checkout/header') ?>

<?= $this->fetch('content') ?>

<?= $this->element('CheckoutV2.Checkout/footer') ?>

<?= $this->Html->scriptBlock('var base_url = "' . $_base_url . '"') ?>
<?= $this->Html->script(
    [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js',
        'CheckoutV2.sweetalert2.all.min.js',
        'CheckoutV2.main.js',
    ], ['fullBase' => true]
) ?>

<?= $this->fetch('scriptBottom') ?>

</body>
</html>