<div id="form-block-person">
    <h4>Dados pessoais</h4>
    <div class="row">
        <div class="col-md-6 form-group">
            <p><strong>Nome</strong></p>
            <?= $customer->name ?>
        </div>
        <div class=" col-md-6 form-group">
            <p><strong>E-mail</strong></p>
            <?= $customer->email ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6 form-group">
            <p><strong>CPF</strong></p>
            <?= $customer->document ?>
        </div>
        <div class="col-md-6 form-group">
            <p><strong>Telefone</strong></p>
            <?= $customer->telephone ?>
        </div>
    </div>
</div>