<div class="modal fade" id="modal-force-update-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered garrula-customer" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Atualize seu perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Para prosseguir, confirme as informações abaixo:</p>
                <?= $this->Form->create($customer, ['id' => 'form-customer-force-update-data']) ?>
                <div class="mt-2">
                    <?= $this->Form->control('name', ['label' => 'Nome', 'placeholder' => 'Nome:', 'class' => 'form-control']) ?>
                </div>
                <div class="mt-2">
                    <?= $this->Form->control('document', ['label' => 'CPF', 'placeholder' => 'CPF', 'class' => 'form-control mask-cpf']) ?>
                </div>
                <div class="mt-2">
                    <?= $this->Form->control('email', ['label' => 'E-mail', 'placeholder' => 'E-mail:', 'class' => 'form-control']) ?>
                </div>
                <div class="mt-2">
                    <?= $this->Form->control('birth_date', ['class' => 'form-control mask-date', 'label' => 'Data de nascimento', 'type' => 'text', 'value' => $customer->birth_date ? $customer->birth_date->format('d/m/Y') : '']) ?>
                </div>
                <div class="mt-2">
                    <?= $this->Form->control('telephone', ['label' => 'Celular', 'placeholder' => 'Telefone', 'class' => 'form-control mask-telephone']) ?>
                    <div class="mt-2">
                        <?= $this->Form->control('gender', ['type' => 'radio', 'label' => false, 'placeholder' => 'Sexo', 'options' => $genders, 'class' => 'radio-wrap',
                            'hiddenField' => false]) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="form-customer-force-update-data" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>