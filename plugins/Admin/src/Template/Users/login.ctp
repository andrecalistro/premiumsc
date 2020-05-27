<div class="page-title text-center">
    <h2>Administração</h2>
</div>
<div class="content loginBox">
    <?= $this->Form->create('') ?>
    <div class="form-group">
        <label>E-mail</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
            <?= $this->Form->control('email', ['class' => 'form-control', 'required' => true, 'label' => false]) ?>
        </div>
    </div>
    <div class="form-group">
        <label>Senha</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
            <?= $this->Form->control('password', ['type' => 'password', 'class' => 'form-control', 'required' => true, 'label' => false]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= $this->Form->submit('Acessar', ['class' => 'btn btn-block btn-primary']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>