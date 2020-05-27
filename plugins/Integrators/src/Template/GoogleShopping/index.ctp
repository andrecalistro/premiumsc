<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="navbarBtns">
    <div class="page-title">
        <h2>Google Shopping</h2>
    </div>

    <div class="navbarRightBtns">
        <a class="btn btn-primary btn-sm navbarBtn"
           href="<?= $this->Url->build(['controller' => 'google-shopping', 'action' => 'add', 'plugin' => 'integrators']) ?>">Adicionar
            novo feed</a>
    </div>
</div>
<div class="content">
    <div class="container-fluid pad-bottom-30">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Categorias</th>
                        <th>Url</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Todas</td>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control" readonly value="<?= $url_xml ?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"
                                            onclick="window.open('<?= $url_xml ?>', '_blank')"><i
                                                class="fa fa-external-link" aria-hidden="true"></i></button>
                                </span>
                            </div>
                        </td>
                        <td>
                        </td>
                    </tr>
                    <?php if ($feeds): ?>
                        <?php foreach ($feeds as $key => $feed): ?>
                            <tr>
                                <td><?= implode(', ', (array) $feed['value']->categories) ?></td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" class="form-control" readonly value="<?= $feed['value']->url ?>">
                                        <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"
                                            onclick="window.open('<?= $feed['value']->url ?>', '_blank')"><i
                                                class="fa fa-external-link" aria-hidden="true"></i></button>
                                </span>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?= $this->Url->build(['controller' => 'google-shopping', 'action' => 'delete', $key]) ?>" class="btn btn-danger btn-sm" title="Excluir feed"><i
                                                class="fa fa-trash-o"
                                                aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>