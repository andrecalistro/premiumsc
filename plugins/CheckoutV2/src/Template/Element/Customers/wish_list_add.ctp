<div class="modal fade" id="modal-wish-list-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered garrula-customer" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lista de desejos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('', ['id' => 'form-save-wish-lis', 'url' => ['controller' => 'wish-lists', 'action' => 'save', 'plugin' => 'CheckoutV2']]) ?>
                <?= $this->Form->hidden('id', ['value' => isset($list->id) ? $list->id : '']) ?>
                <div class="mt-2">
                    <?= $this->Form->control('name', ['label' => 'Nome', 'placeholder' => 'Nome:', 'class' => 'form-control', 'value' => isset($list->name) ? $list->name : '']) ?>
                </div>
                <div class="mt-2">
                    <?= $this->Form->control('description', ['label' => 'Descrição', 'placeholder' => 'Descrição', 'class' => 'form-control', 'type' => 'textarea', 'value' => isset($list->description) ? $list->description : '']) ?>
                </div>
                <?= $this->Form->end() ?>
                <div class="modal-footer">
                    <button type="submit" form="form-save-wish-lis" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>