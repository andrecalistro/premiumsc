<div id="form-block-company">
    <?= $this->Form->control('document', ['type' => 'hidden', 'id' => 'form-block-company-customer-document']) ?>
    <h4>Dados da empresa</h4>
    <div class="row">
        <div class="col-md-6 form-group">
            <?= $this->Form->control('company_name', [
                'class' => 'form-control',
                'placeholder' => 'Razão social',
                'label' => false,
                'disabled' => true
            ]) ?>
        </div>

        <div class="col-md-6 form-group">
            <?= $this->Form->control('trading_name', [
                'class' => 'form-control',
                'placeholder' => 'Nome Fantasia',
                'label' => false,
                'disabled' => true
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <?= $this->Form->control('company_document', [
                'class' => 'form-control mask-cnpj',
                'placeholder' => 'CNPJ',
                'label' => false,
                'disabled' => true
            ]) ?>
        </div>
        <div class="col-md-6 form-group">
            <?= $this->Form->control('company_state', [
                'class' => 'form-control',
                'placeholder' => 'Inscrição Estadual',
                'label' => false,
                'disabled' => true
            ]) ?>
        </div>
    </div>
    <h4>Dados pessoais</h4>
    <div class="row">
        <div class="col-md-6 form-group">
            <?= $this->Form->control('name', ['label' => false, 'placeholder' => 'Nome Completo', 'class' => 'form-control',
                'disabled' => true, 'id' => 'form-block-company-customcruzeer-name']) ?>
        </div>
        <div class=" col-md-6 form-group">
            <?= $this->Form->control('email', ['label' => false, 'placeholder' => 'E-mail', 'class' => 'form-control', 'type' => 'email',
                'disabled' => true, 'id' => 'form-block-company-customer-email']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?= $this->Form->control('telephone', ['label' => false, 'placeholder' => 'Telefone', 'class' => 'form-control mask-telephone',
                    'disabled' => true, 'id' => 'form-block-company-customer-telephone']) ?>
            </div>
        </div>
    </div>
</div>