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
    <?= $this->Html->css(['Admin.bootstrap.min.css', 'Admin.bootstrap-datepicker.min.css', 'Admin.font-awesome.min.css', 'Admin.select2.min.css', 'Admin.select2.bootstrap.min.css', 'Admin.styles.css', 'Admin.main.css', 'Admin.main-queries.css'], ['fullBase' => true]) ?>

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
<body>
<?= $this->element('Admin.navigation/top-menu') ?>

<aside class="affix sidebar-nav">
    <?= $this->element('Admin.navigation/menu') ?>
</aside>
<div class="content-wrapper" id="content-right">
    <div id="content-inner-right" class="<?= $_class_path ?>">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
</div>

<div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <?= $this->Html->image('Admin.carregando.gif', ['fullBase' => true, 'class' => 'icon']) ?>
                    <h4>Processando...</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->scriptBlock('var base_url = "' . $_base_url . '"') ?>
<?= $this->Html->script('Admin.jquery.min.js') ?>
<?= $this->Html->script('Admin.bootstrap.min.js') ?>
<?= $this->Html->script('Admin.bootstrap-datepicker.min.js') ?>
<?= $this->Html->script('Admin.jquery.mask.js') ?>
<?= $this->Html->script('Admin.select2.min.js') ?>
<?= $this->Html->script('Admin.tinymce/tinymce.min.js') ?>
<?= $this->Html->script('Admin.jquery-ui.js') ?>
<?= $this->Html->script('Admin.scripts.js') ?>
<?= $this->fetch('scriptBottom') ?>


</body>
</html>