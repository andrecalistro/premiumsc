<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Atualizar produtos</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <div class="form-group">
            <h3>Instruções</h3>
            <ul>
                <li>Os valores do CSV devem ser separados por vírgula</li>
                <li>O conteúdo das colunas deve ser limitado por ""</li>
                <li>A primeira linha do CSV deve ser o cabeçalho da planilha</li>
                <li>O arquivo CSV não deve conter imagens</li>
                <li>Os valores de peso devem estar em kg, por exemplo 400g deve estar como 0,400</li>
                <li>As dimensões do produto devem ser em cm, por exemplo 1,2m deve estar como 102</li>
                <li>Os valores de preço e preço especial devem ser no formato 1.000,99, podem ou não conter simbolo R$</li>
                <li>Os produtos serão identificados pela coluna Código, mapeada na segunda etapa, caso não seja encontrado um produto com aquele código, será cadastrado um novo, se for encontrado um produto com aquele código, ele será atualizado com as informações do arquivo.</li>
                <li>O nome das colunas não deve conter quebra de linha, assim como a descrição se tiver, no campo de descrição utilize marcação HTML para editar o texto para importar/atualizar</li>
            </ul>
        </div>

        <?= $this->Form->create('', ['type' => 'file']) ?>

        <div class="form-group">
            <?= $this->Form->control('file', ['type' => 'file', 'class' => 'form-control', 'label' => 'Arquivo CSV', 'required']) ?>
        </div>

        <?= $this->Form->submit('Enviar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['controller' => 'payments-methods'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>