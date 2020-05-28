<?php
/**
 * @var App\View\AppView $this
 */
?>
<p>Olá <?= $name ?>, obrigado por se cadastrar em nossa loja.</p>

<p>Por favor clique no link baixo para confirmar sua conta.</p>

<p><?= $this->Html->link('Confirmar Conta', $token) ?></p>