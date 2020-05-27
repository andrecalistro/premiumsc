<div id="form-block-person">
    <div class="col">
        <div class="form-group">
            <label for="name">Nome Completo</label>
            <?= $this->Form->control('name', [
                'label' => false,
                'placeholder' => 'Nome Completo',
                'class' => 'block'])
            ?>
        </div>
    </div>

    <div class="col col-xs-6">
        <div class="form-group">
            <label for="document">CPF</label>
            <?= $this->Form->control('document', [
                'label' => false,
                'placeholder' => 'CPF',
                'class' => 'block mask-cpf'
            ]) ?>
        </div>
    </div>

    <div class="col col-xs-6">
        <div class="form-group">
            <label for="telephone">Telefone</label>
            <?= $this->Form->control('telephone', [
                'label' => false,
                'placeholder' => 'Telefone',
                'class' => 'block mask-telephone'
            ]) ?>
        </div>
    </div>
</div>