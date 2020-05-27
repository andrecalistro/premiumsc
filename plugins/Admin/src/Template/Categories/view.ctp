<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script('https://code.jquery.com/ui/1.12.1/jquery-ui.js', ['block' => 'scriptBottom']);
$this->Html->scriptBlock('
$( function() {
    $( "#sortable" ).sortable({
      stop: function( event, ui ) {
        var items = [];
        $("input[name=\'products_id[]\']").each(function(a, b){
            items.push($(b).val());
        });
        $.ajax({
            url: base_url + \'categories/save-order.json\',
            type: \'post\',
            data: {products:items.join()},        
            beforeSend: function () {
                openModalLoading();
            },
            success: function (data) {
                console.log(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            },
            complete: function () {
                closeModalLoading();
            }
        })
      }
    });
    $( "#sortable" ).disableSelection();
  } );
', ['block' => 'scriptBottom']);
?>
<div class="page-title">
    <h2>Categoria</h2>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#details" aria-controls="home" role="tab" data-toggle="tab">Detalhes</a>
            </li>
            <li role="presentation"><a href="#products" aria-controls="profile" role="tab"
                                       data-toggle="tab">Produtos</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="details">
                <?= !empty($category->thumb_image_link) ? "<p>" . $this->Html->image($category->thumb_image_link, ['class' => 'thumbnail']) . "</p>" : '' ?>
                <p><b>Nome:</b> <?= $category->title ?></p>
                <p><b>Categoria
                        Pai</b> <?= isset($category->parent_category->title) ? $category->parent_category->title : '' ?>
                </p>
                <p><b>Data do Cadastro:</b> <?= $category->created->format("d/m/Y") ?></p>
                <p><b>Ordem de exibição:</b> <?= $category->order_show ?></p>
                <p><b>Data de Lançamento:</b> <?= $category->formatted_deadlines['release_date'] ?></p>
                <p><b>Data de Expiração:</b> <?= $category->formatted_deadlines['expiration_date'] ?></p>
            </div>

            <div role="tabpanel" class="tab-pane table-responsive" id="products">
                <?php if ($category->products): ?>
                    <table>
                        <thead>
                        <tr>
                            <th></th>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Cadastrado em</th>
                            <th>Estoque</th>
                        </tr>
                        </thead>
                        <tbody id="sortable">
                        <?php foreach ($category->products as $product): ?>
                            <tr>
                                <td>
                                    <i class="fa fa-sort" aria-hidden="true"></i>
                                    <input type="hidden" name="products_id[]" value="<?= $product->_joinData->id ?>">
                                </td>
                                <td><?= $product->name ?></td>
                                <td><?= $product->price_format ?></td>
                                <td><?= $product->created->format('d/m/Y H:i') ?></td>
                                <td><?= $product->quantity ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-12">
                <p><?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-primary btn-sm']) ?></p>
            </div>
        </div>
    </div>
</div>