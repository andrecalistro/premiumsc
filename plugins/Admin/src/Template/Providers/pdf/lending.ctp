<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="page-title">
    <h2>Produtos em Comodato - Fornecedor <?= $provider->name ?></h2>
    <h3><?= $date ?></h3>
</div>

<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <h3>Produtos</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Produto</th>
                    <th>Link</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products_send as $product): ?>
                    <tr>
                        <td><img src="<?= $product->thumb_main_image ?>" border="0"></td>
                        <td><?= $product->name ?></td>
                        <td><a href="<?= $product->full_link ?>">Visualizar Produto</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>