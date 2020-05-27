<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['shipments/correios.functions.js'], ['fullBase' => true, 'block' => 'scriptBottom']);
?>
<div class="page-title">
    <h2>Configurar Retirada na Loja</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <?= $this->Form->create($removal, ['id' => 'form-interval']) ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->Form->control('status', ['label' => false, 'empty' => 0, 'options' => $statuses, 'type' => 'radio', 'value' => $removal->status]) ?>
                </div>
            </div>
        </div>
        <hr>

        <h3>Faixas de CEPS que o Motoboy entrega</h3>
        <p>
            <?= $this->Form->button('Adicionar', ['class' => 'btn btn-sm btn-primary', 'type' => 'button', 'id' => 'add-row-interval', 'data-quantity-row-fields' => 3]) ?>

            <?= $this->Html->link('Pesquisa Faixa de CEP', 'http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaFaixaCEP.cfm', ['class' => 'btn btn-sm btn-default', 'target' => '_blank']) ?>
        </p>
        <div class="row table-responsive" id="list-interval">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>CEP Inicial</th>
                        <th>CEP Final</th>
                        <th>Prazo</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($removal->interval): ?>
                        <?php
                        $count = 0;
                        foreach ($removal->interval as $key => $interval): ?>
                            <tr>
                                <td><?= $this->Form->control("interval.{$count}[]", ['class' => 'form-control', 'label' => false, 'value' => $interval[0], 'required' => true]) ?></td>
                                <td><?= $this->Form->control("interval.{$count}[]", ['class' => 'form-control', 'label' => false, 'value' => $interval[1], 'required' => true]) ?></td>
                                <td><?= $this->Form->control("interval.{$count}[]", ['class' => 'form-control', 'label' => false, 'value' => $interval[2], 'required' => true]) ?></td>
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
<?php /*
<div class="modal fade" id="modal-add-cep-interval" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <? //= $this->Form->create('', ['url' => $this->Url->build(['action' => 'get-cep-interval', '_ext' => 'json'], ['fullBase' => true])]) ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Adicionar Faixa de CEP</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <? //= $this->Form->control('UF', ['class' => 'form-control', 'label' => 'Estado', 'required' => true, 'empty' => '-- Selecione -- ', 'type' => 'select', 'options' => $states]) ?>
                </div>
                <div class="form-group">
                    <? //= $this->Form->control('Localidade', ['class' => 'form-control', 'label' => 'Cidade', 'required' => true]) ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary btn-sm">Pesquisar</button>
            </div>
        </div>
        <? //= $this->Form->end() ?>
    </div>
</div>
 */ ?>