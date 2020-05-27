<div id="form-block-company">
    <h4>Dados da empresa</h4>
    <div class="row">
        <div class="col-md-6 form-group">
            <p><strong>Razão Social</strong></p>
            <?= $customer->company_name ?>
        </div>

        <div class="col-md-6 form-group">
            <p><strong>Nome Fantasia</strong></p>
            <?= $customer->trading_name ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 form-group">
            <p><strong>CNPJ</strong></p>
            <?= $customer->company_document ?>
        </div>
        <div class="col-md-6 form-group">
            <p><strong>Inscrição Estadual</strong></p>
            <?= $customer->company_state ?>
        </div>
    </div>
    <hr>
    <h4>Dados pessoais</h4>
    <div class="row">
        <div class="col-md-4 form-group">
            <p><strong>Nome</strong></p>
            <?= $customer->name ?>
        </div>
        <div class="col-md-4 form-group">
            <p><strong>E-mail</strong></p>
            <?= $customer->email ?>
        </div>
        <div class="col-md-4 form-group">
            <p><strong>Telefone</strong></p>
            <?= $customer->telephone ?>
        </div>
    </div>
</div>