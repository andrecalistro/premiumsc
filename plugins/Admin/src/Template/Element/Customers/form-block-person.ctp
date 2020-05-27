<div id="form-block-person">
    <h4>Dados pessoais</h4>
    <div class="row">
        <div class="col-md-6 form-group">
            <?= $this->Form->control('name', ['label' => 'Nome Completo', 'class' => 'form-control']) ?>
        </div>
        <div class=" col-md-6 form-group">
            <?= $this->Form->control('email', ['label' => 'E-mail', 'class' => 'form-control', 'type' => 'email']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?= $this->Form->control('document', ['label' => 'CPF', 'class' => 'form-control input-cpf']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?= $this->Form->control('telephone', ['label' => 'Telefone', 'class' => 'form-control input-phone']) ?>
            </div>
        </div>
    </div>
</div>