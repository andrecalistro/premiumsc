<div class="modal fade" id="modal-wish-list-share" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered garrula-customer" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Compartilhe sua lista</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Copie a url abaixo e compartilhe com sua familia e amigos!</p>
                <div class="mt-2">
                    <?= $this->Form->control('link', ['label' => false, 'class' => 'form-control', 'id' => 'input-wish-list-share', 'readonly' => true]) ?>
                </div>
                <?= $this->Form->end() ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>