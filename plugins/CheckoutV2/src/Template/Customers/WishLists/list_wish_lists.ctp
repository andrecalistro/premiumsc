<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->css(['Theme.loja.min.css'], ['block' => 'cssTop', 'fullBase' => true]);
?>
<div class="garrula-customer garrula-customer-dashboard">

    <div class="container py-3">
        <nav class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->build('/', ['fullBase' => true]) ?>">Home</a></li>
                <li class="breadcrumb-item"><a
                            href="<?= $this->Url->build(['controller' => 'customers', 'action' => 'dashboard'], ['fullBase' => true]) ?>">Minha
                        conta</a></li>
                <li class="breadcrumb-item"><?= $_pageTitle ?></li>
            </ol>
        </nav>
    </div>

    <section class="container">
        <div class="text-center mb-4">
            <h3><?= $_pageTitle ?></h3>
        </div>

        <div class="row">
            <div class="col-md-3">
                <?= $this->cell('Checkout.Customer::menu') ?>
            </div>

            <div class="col-md-9">
                <div class="row"><a href="javascript:void(0)"
                      class="btn-small btn-primary"
                      data-toggle="modal" data-target="#modal-wish-list-form">Criar Lista</a></div>
                <div class="mt-4 mb-5">
                    <?php if ($wishLists): ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Criada em</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($wishLists as $wishList): ?>
                                <tr>
                                    <td><?= $wishList->name ?></td>
                                    <td><?= $wishList->created->format('d/m/Y') ?></td>
                                    <td><?= $wishList->wish_list_status->name ?></td>
                                    <td>
                                        <a href="https://www.facebook.com/sharer.php?u=<?= $wishList->full_link ?>"
                                           target="_blank">
                                            <i class="fab fa-facebook-square"></i>
                                        </a>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-wish-list-share"
                                            onclick="$('#input-wish-list-share').val('<?= $wishList->full_link ?>')">
                                            <i class="fas fa-share-alt-square"></i>
                                        </a>
                                        <a href="<?= $this->Url->build(['controller' => 'wish-lists', 'action' => 'edit', $wishList->id, 'plugin' => 'CheckoutV2']) ?>">
                                            <i class="fas fa-pen-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="m-auto">Você ainda não tem nenhuma lista.</p>
                    <?php endif; ?>
                </div>

                <?= $this->element('Customers/pagination') ?>
            </div>
        </div>
    </section>
</div>

<?= $this->element('Checkout.Customers/wish_list_add', ['list' => []]) ?>
<?= $this->element('Checkout.Customers/wish_list_share') ?>