<?php
/**
 * @var App\View\AppView $this
 */
?>
<div id="content" class="pad-top-60 pad-bottom-95">
    <div class="container">
        <div class="page-title mar-bottom-85">Minha Conta</div>

        <?= $this->element('Customers/menu') ?>

        <div class="col-md-8">
            <p class="title-conta">MEUS PEDIDOS</p>

            <div class="box-pedido">
                <div class="data">Data do pedido: <br><span>09/11/16</span></div>
                <div class="status">Status: <br><span><i class="fa fa-truck" aria-hidden="true"></i>Pedido em transporte</span></div>
                <div class="btn btn-black"><a href="#">VER DETALHES</a></div>
            </div>

            <div class="box-pedido">
                <div class="data">Data do pedido: <br><span>09/11/16</span></div>
                <div class="status">Status: <br><span><i class="fa fa-times" aria-hidden="true"></i>Pedido cancelado</span></div>
                <div class="btn btn-black"><a href="#">VER DETALHES</a></div>
            </div>

            <div class="box-pedido">
                <div class="data">Data do pedido: <br><span>09/11/16</span></div>
                <div class="status">Status: <br><span><i class="fa fa-check" aria-hidden="true"></i>Pedido entregue</span></div>
                <div class="btn btn-black"><a href="#">VER DETALHES</a></div>
            </div>
        </div>

    </div>
</div>

