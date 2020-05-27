<ul class="menu">
    <li><?= $this->Html->link(__('Minha conta'), ['controller' => 'customers', 'action' => 'dashboard']) ?></li>
    <li><?= $this->Html->link(__('Alterar senha'), ['controller' => 'customers', 'action' => 'change-password']) ?></li>
    <li><?= $this->Html->link(__('Meus pedidos'), ['controller' => 'customers', 'action' => 'orders']) ?></li>
    <li><?= $this->Html->link(__('Meus dados'), ['controller' => 'customers', 'action' => 'account']) ?></li>
    <li><?= $this->Html->link(__('Meus endereços'), ['controller' => 'customers-addresses', 'action' => 'index']) ?></li>

    <?php if($subscriptiosStatus): ?>
        <li><?= $this->Html->link(__('Minhas Assinaturas'), ['_name' => 'customerSubscriptions']) ?></li>
    <?php endif; ?>

    <?php if($wishListStatus): ?>
        <li><?= $this->Html->link(__('Minhas listas de desejos'), ['controller' => 'wish-lists', 'action' => 'list-wish-lists']) ?></li>
    <?php endif; ?>

    <li><?= $this->Html->link('Sair', ['controller' => 'customers', 'action' => 'logout']) ?></li>
</ul>