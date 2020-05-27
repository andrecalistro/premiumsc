<div class="author">
    <?= $this->Html->image('avatar.png', ['fullBase' => true, 'class' => 'img-responsive']) ?>
    <div class="name"><?= $_auth['name'] ?></div>
    <?= $this->Html->link('Sair', ['controller' => 'customers', 'action' => 'logout']) ?>
</div>