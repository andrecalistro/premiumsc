<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Premium Shirts Club - Login</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Exo:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

    <?= $this->Html->css(['bootstrap.min.css', 'font-awesome.min.css', 'select2.min.css', 'select2.bootstrap.min.css', 'styles.css', 'main.css', 'login.css', 'main-queries.css'], ['fullBase' => true, 'plugin' => 'admin']) ?>
</head>
<body>
<?= $this->element('navigation/top-menu-login') ?>

<div class="container-fluid content-main" id="content-right">
    <div id="content-inner-right" class="<?= $_class_path ?>">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
</div>

<?= $this->Html->scriptBlock('var base_url = "' . $_base_url . '"') ?>
<?= $this->Html->script('jquery.min.js') ?>
<?= $this->Html->script('bootstrap.min.js') ?>
</body>
</html>