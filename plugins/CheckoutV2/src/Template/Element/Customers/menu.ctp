<div class="col-md-4 col-lg-3 align-self-start">
    <div class="profile-navigation">
        <ul>
            <li>
                <?= $this->Html->link(__('Meus pedidos'), ['controller' => 'customers', 'action' => 'orders']) ?>
                <?= $this->Html->link(__('Alterar senha'), ['controller' => 'customers', 'action' => 'change-password']) ?>
                <?= $this->Html->link(__('Meus dados'), ['controller' => 'customers', 'action' => 'account']) ?>
                <?= $this->Html->link(__('Meus endereços'), ['controller' => 'customers-addresses', 'action' => 'index']) ?>
                <?= $this->Html->link('Sair', ['controller' => 'customers', 'action' => 'logout']) ?>
            </li>
        </ul>
    </div>
</div>