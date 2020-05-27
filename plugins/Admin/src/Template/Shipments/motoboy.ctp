<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['shipments/motoboy.functions.js'], ['fullBase' => true, 'block' => 'scriptBottom']);
?>
<div class="page-title">
    <h2>Configurar Motoboy</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($motoboy, ['id' => 'form-interval']) ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $motoboy->status]) ?>
                </div>
            </div>
        </div>
        <hr>

        <h3>Faixas de CEPS que o Motoboy entrega</h3>
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
                        <th>Prazo em dias</th>
                        <th>
                            Valor do frete
                            <span class="glyphicon glyphicon-question-sign" aria-hidden="true" data-toggle="tooltip"
                                  data-placement="bottom"
                                  title="Deixe o valor do frete vazio ou zerado para conceder o frete grátis"></span>
                        </th>
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
                    <?php if ($motoboy->interval): ?>
                        <?php
                        $count = 0;
                        foreach ($motoboy->interval as $key => $interval): ?>
                            <tr>
                                <td><?= $this->Form->control("interval.{$count}[]", ['class' => 'form-control input-zipcode', 'label' => false, 'value' => isset($interval[0]) ? $interval[0] : '', 'required' => true]) ?></td>
                                <td><?= $this->Form->control("interval.{$count}[]", ['class' => 'form-control input-zipcode', 'label' => false, 'value' => isset($interval[1]) ? $interval[1] : '', 'required' => true]) ?></td>
                                <td><?= $this->Form->control("interval.{$count}[]", ['class' => 'form-control', 'label' => false, 'value' => isset($interval[2]) ? $interval[2] : '', 'required' => true, 'type' => 'number']) ?></td>
                                <td><?= $this->Form->control("interval.{$count}[]", ['class' => 'form-control input-price', 'label' => false, 'value' => isset($interval[3]) ? $interval[3] : '', 'required' => true]) ?></td>
                                <td><?= $this->Form->control("interval.{$count}[]", ['class' => 'form-control input-price', 'label' => false, 'value' => isset($interval[4]) ? $interval[4] : '', 'required' => true]) ?></td>
                                <td><?= $this->Html->link('<i class="fa fa-trash" aria-hidden="true"></i>', [], ['class' => 'btn btn-sm btn-danger remove-interval', 'escape' => false]) ?></td>
                            </tr>
                            <?php
                            $count++;
                        endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
                <p>
                    <small></small>
                </p>
            </div>
        </div>
        <?= $this->Form->submit('Salvar', ['class' => 'btn btn-success btn-sm']) ?>
        <?= $this->Html->link("Voltar", ['action' => 'index'], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>