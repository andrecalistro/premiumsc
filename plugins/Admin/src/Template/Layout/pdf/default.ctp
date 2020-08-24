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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Premium Shirts Club</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Exo:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

    <!-- Bootstrap -->
    <?= $this->fetch('cssTop') ?>
    <?= $this->Html->css(['bootstrap.min.css', 'font-awesome.min.css'], ['fullBase' => true]) ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        var base_url = '<?= $this->Url->build('/', ['fullBase' => true]) ?>';
    </script>
</head>
<body><?= $this->fetch('content') ?>
<?= $this->Html->scriptBlock('var base_url = "' . $_base_url . '"') ?>
<?= $this->Html->script('jquery.min.js') ?>
<?= $this->Html->script('bootstrap.min.js') ?>
<?= $this->fetch('scriptBottom') ?>
</body>
</html>