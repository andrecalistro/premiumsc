<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script('shipments/free_shipping.functions.js', ['fullBase' => true, 'block' => 'scriptBottom']);
?>
<div class="page-title">
    <h2>Configurar Frete Grátis</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($freeShipping, ['id' => 'form-interval']) ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => 'Status', 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $freeShipping->status, 'label' => false]) ?>
                </div>
            </div>
        </div>
        <hr>

        <h3>Faixas de CEPS com Frete Grátis</h3>
        <p>
            <?= $this->Form->button('Adicionar', ['class' => 'btn btn-sm btn-primary', 'type' => 'button', 'id' => 'add-row-interval', 'data-quantity-row-fields' => 4]) ?>

            <?= $this->Html->link('Pesquisa Faixa de CEP', 'http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaFaixaCEP.cfm', ['class' => 'btn btn-sm btn-default', 'target' => '_blank']) ?>
        </p>
        <div class="row table-responsive" id="list-interval">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>CEP Inicial</th>
                        <th>CEP Final</th>
                        <th>Prazo de entrega em dias</th>
                        <th>
                            Valor mínimo do pedido
                            <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip"
                                  data-placement="bottom"
                                  title="Deixe o valor do minimo do pedido vazio ou zerado para aceitar pedidos de qualquer valor"></span>
                        </th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($freeShipping->interval): ?>
                        <?php
                        $count = 0;
                        foreach ($freeShipping->interval as $key => $interval): ?>
                            <tr>
                                <td><?= $this->Form->control("interval.{$count}[]", ['class' => 'form-control', 'label' => false, 'value' => isset($interval[0]) ? $interval[0] : '', 'required' => true]) ?></td>
                                <td><?= $this->Form->control("interval.{$count}[]", ['class' => 'form-control', 'label' => false, 'value' => isset($interval[1]) ? $interval[1] : '', 'required' => true]) ?></td>
                                <td><?= $this->Form->control("interval.{$count}[]", ['class' => 'form-control', 'label' => false, 'value' => isset($interval[2]) ? $interval[2] : '', 'required' => true, 'type' => 'number']) ?></td>
                                <td><?= $this->Form->control("interval.{$count}[]", ['class' => 'form-control', 'label' => false, 'value' => isset($interval[3]) ? $interval[3] : '', 'required' => true]) ?></td>
                                <td><?= $this->Html->link('<i class="fa fa-trash" aria-hidden="true"></i>', [], ['class' => 'btn btn-sm btn-danger remove-interval', 'escape' => false]) ?></td>
                            </tr>
                            <?php
                            $count++;
                        endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>