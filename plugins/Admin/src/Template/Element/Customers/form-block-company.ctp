<div id="form-block-company">
    <?= $this->Form->control('document', ['type' => 'hidden', 'id' => 'form-block-company-customer-document']) ?>
    <h4>Dados da empresa</h4>
    <div class="row">
        <div class="col-md-6 form-group">
            <?= $this->Form->control('company_name', [
                'class' => 'form-control',
                'label' => 'Razão social',
                'disabled' => true
            ]) ?>
        </div>

        <div class="col-md-6 form-group">
            <?= $this->Form->control('trading_name', [
                'class' => 'form-control',
                'label' => 'Nome Fantasia',
                'disabled' => true
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <?= $this->Form->control('company_document', [
                'class' => 'form-control input-cnpj',
                'label' => 'CNPJ',
                'disabled' => true
            ]) ?>
        </div>
        <div class="col-md-6 form-group">
            <?= $this->Form->control('company_state', [
                'class' => 'form-control',
                'label' => 'Inscrição Estadual',
                'disabled' => true
            ]) ?>
        </div>
    </div>
    <h4>Dados pessoais</h4>
    <div class="row">
        <div class="col-md-4 form-group">
            <?= $this->Form->control('name', ['label' => 'Nome Completo', 'class' => 'form-control',
                'disabled' => true, 'id' => 'form-block-company-customer-name']) ?>
        </div>
        <div class="col-md-4 form-group">
            <?= $this->Form->control('email', ['label' => 'E-mail', 'class' => 'form-control', 'type' => 'email',
                'disabled' => true, 'id' => 'form-block-company-customer-email']) ?>
        </div>
        <div class="col-md-4 form-group">
            <?= $this->Form->control('telephone', ['label' => 'Telefone', 'class' => 'form-control input-phone',
                'disabled' => true, 'id' => 'form-block-company-customer-telephone']) ?>
        </div>
    </div>
</div>