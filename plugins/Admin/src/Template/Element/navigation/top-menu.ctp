<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row header hidden-xs">
	<div class="logo">
		<button class="btn btn-default dropdown-toggle" style="cursor: default">
            Premium Shirts Club
		</button>
	</div>

	<div class="col-sm-5 col-xs-12 navigation-top">
        <?= $this->element('Admin.alert-ambient') ?>
    </div>

	<div class="col-sm-5 col-xs-12 perfil">
		<button class="btn btn-default dropdown-toggle pull-right" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
			<?= $this->Html->image('Admin.perfil.png', ['fullBase' => true, 'width' => 35, 'class' => 'pull-left']) ?>
			<!--
			<?= $this->request->getSession()->read('Auth.User.name') ?><br>
            <?= $this->request->getSession()->read('Auth.User.email') ?>
			-->
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
			<!--<li><h4>COMPANIES</h4></li>-->
			<li><?= $this->Html->link(__("Meu dados"), ['plugin' => 'admin', 'controller' => 'users', 'action' => 'edit', $this->request->getSession()->read('Auth.User.id')]) ?></li>
			<li><?= $this->Html->link(__("Alterar senha"), ['plugin' => 'admin', 'controller' => 'users', 'action' => 'password-change']) ?></li>
			<li><?= $this->Html->link(__("Visualizar Loja"), '/', ['target' => '_blank']) ?></li>
			<li><?= $this->Html->link(__("Sair"), ['plugin' => 'admin', 'controller' => 'users', 'action' => 'logout']) ?></li>
		</ul>
	</div>
</div>

<div class="row header hidden-lg hidden-md hidden-sm">
	<div class="col-xs-12">
		<div class="logo">
			<button class="btn btn-default dropdown-toggle" style="cursor: default">
                Premium Shirts Club
			</button>
		</div>
	</div>
	<div class="col-xs-12 navigation-top-mobile">
		<div class="menu-icon">
			<a href="#" class="link toggle-main-menu"><i class="fa fa-bars" aria-hidden="true"></i></a>
		</div>

		<div class="profile-icon">
			<a href="javascript:void(0)" class="link dropdown-toggle" id="dropDownMenuTopMobile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<?= $this->Html->image('Admin.perfil.png', ['fullBase' => true, 'width' => 35]) ?>
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu pull-right" aria-labelledby="dropDownMenuTopMobile">
				<li><?= $this->Html->link(__("Meu dados"), ['plugin' => 'admin', 'controller' => 'users', 'action' => 'edit', $this->request->getSession()->read('Auth.User.id')]) ?></li>
				<li><?= $this->Html->link(__("Alterar senha"), ['plugin' => 'admin', 'controller' => 'users', 'action' => 'password-change']) ?></li>
				<li><?= $this->Html->link(__("Visualizar Loja"), '/', ['target' => '_blank']) ?></li>
				<li><?= $this->Html->link(__("Sair"), ['plugin' => 'admin', 'controller' => 'users', 'action' => 'logout']) ?></li>
			</ul>
		</div>
	</div>
</div>