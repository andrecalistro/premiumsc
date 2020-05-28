<?php
/**
 * @var App\View\AppView $this
 */
?>
<p>Olá, um cliente entrou em contato via formulário da Loja Virtual, os dados preenchidos foram:</p>

<p>
    <b>Nome:</b> <?= $data['name'] ?><br>
    <b>E-mail:</b> <?= $data['email'] ?><br>
    <b>Telefone:</b> <?= $data['telephone'] ?><br>
    <b>Estado:</b> <?= $data['state'] ?><br>
    <b>Cidade:</b> <?= $data['city'] ?><br>
    <b>Departamento:</b> <?= $data['department'] ?><br>
    <b>Mensagem:</b> <?= $data['message'] ?><br>
</p>