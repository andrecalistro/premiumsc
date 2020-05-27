<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['chart/dist/Chart.bundle.js', 'chart/utils.js'], ['block' => 'scriptBottom']);
$this->Html->scriptBlock('
    var MONTHS = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    var config = {
        type: \'line\',
        data: {
            labels: [\''.implode("', '",$orders['orders_days_text']).'\'],
            datasets: [{
                label: "Vendas de '.$orders['start'].' a '.$orders['end'].'",
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: ['.implode(",",$orders['orders']).'],
                fill: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title:{
                display: false,
                text:\'Vendas de '.$orders['start'].' a '.$orders['end'].'\'
            },
            tooltips: {
                mode: \'index\',
                intersect: false,
            },
            hover: {
                mode: \'nearest\',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: false,
                        labelString: \'Dias\'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: \'Quantidade\'
                    }
                }]
            }
        }
    };
    
    window.onload = function() {
        var ctx = document.getElementById("buyers").getContext("2d");
        window.myLine = new Chart(ctx, config);
    };
', ['block' => 'scriptBottom']);
?>
<div class="graph-bg" style="max-height: 40%;">
    <h2>Vendas da última semana<br><br></h2>
    <canvas id="buyers" height="280" class="graph"></canvas>
</div>
<div class="content mar-bottom-30">
    <div class="container-fluid pad-bottom-30">
        <div class="row text-center" id="widget-resume">
            <div class="col-md-3 col-xs-12">
                <p><i class="fa fa-user" aria-hidden="true"></i></p>
                <?= $customers ?><br>
                <strong>NOVOS CLIENTES</strong>
            </div>

            <div class="col-md-3 col-xs-12">
                <p><i class="fa fa-bullseye" aria-hidden="true"></i></p>
                <?= $orders['count_total'] ?><br>
                <strong>NOVOS PEDIDOS</strong>
            </div>

            <div class="col-md-3 col-xs-12">
                <p><i class="fa fa-arrow-circle-o-up"></i></p>
                <?= $orders['total'] ?><br>
                <strong>RECEITA</strong>
            </div>

            <div class="col-md-3 col-xs-12">
                <p><i class="fa fa-truck"></i></p>
                <?= $orders['orders_sends'] ?><br>
                <strong>ENVIOS</strong>
            </div>
        </div>
    </div>
</div>

<div class="row mar-bottom-30">
    <div class="col-lg-6 hidden-sm hidden-md">
        <div class="content widget">
            <div class="container-fluid pad-bottom-30" id="widget-tops">
				<div class="row mar-bottom-25">
					<div class="col-md-12">
						<i class="fa fa-cart-plus pull-left" aria-hidden="true"></i>
						<div class="pull-left">
							<strong>Produtos mais vendidos:</strong><br>
                            <?php 
                                echo "<ul>";
                                foreach ($bestSellers as $bestSeller) {
                                    echo "<li>".$bestSeller['name']." (".$bestSeller['total'].")</li>";
                                }
                                echo "</ul>";
                            ?>
                        </div>
					</div>
				</div>

                <div class="row mar-bottom-25">
                    <div class="col-md-12">
                        <i class="fa fa-keyboard-o pull-left" aria-hidden="true"></i>
                        <div class="pull-left">
                            <strong>Palavras-chaves mais procuradas:</strong><br>
                            <?= implode(", ", $searches) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <i class="fa fa-list-ol pull-left" aria-hidden="true"></i>
                        <div class="pull-left">
                            <strong>Categorias mais populares:</strong><br>
                            <?= implode(", ", $categories) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="content widget">
            <div class="container-fluid pad-bottom-30">
                <div class="row text-center" id="widget-conversion">
                    <div class="col-md-4 col-xs-12">
                        <div class="circle">
                            <span class="title"><?= $conversionTaxes['today'] ?>%</span>
                        </div>
                        Taxa de conversão<br>
                        <strong>do dia</strong>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="circle">
                            <span class="title"><?= $conversionTaxes['week'] ?>%</span>
                        </div>
                        Taxa de conversão<br>
                        <strong>na última semana</strong>
                    </div>
                    <div class="col-md-4 col-xs-12">
                        <div class="circle">
                            <span class="title"><?= $conversionTaxes['month'] ?>%</span>
                        </div>
						Taxa de conversão<br>
						<strong>no último mês</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--
<div class="row">
    <div class="col-lg-6 col-md-12 col-md-12 col-xs-12">
        <div class="content widget">
            <div class="container-fluid pad-bottom-30">
                <div class="row text-center" id="widget-traffic">
                    <div class="col-md-3 col-xs-12 pad-top-30">
                        <h3>Origem do tráfego</h3>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <div class="circle facebook">
                            <span>66%</span>
                        </div>
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <div class="circle">
                            <span>21%</span>
                        </div>
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <div class="circle organic">
                            <span>75%</span>
                        </div>
                        <strong>orgânico</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="content widget">
            <div class="container-fluid pad-bottom-30">
                <div class="row text-center" id="widget-online">
                    <div class="col-md-6 col-xs-12">
                        <strong>VISITANTES</strong>
                        <p>ONLINE AGORA</p>
                        <h2>1.330</h2>
                    </div>

                    <div class="col-md-6 col-xs-12">
                        <strong>VISITANTES</strong>
                        <p>ONLINE HOJE</p>
                        <h2>730</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->

<div class="row hidden-lg hidden-xs mar-top-30">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="content widget">
            <div class="container-fluid pad-bottom-30" id="widget-tops">
				<div class="row mar-bottom-25">
					<div class="col-md-12">
						<i class="fa fa-cart-plus pull-left" aria-hidden="true"></i>
						<div class="pull-left">
							<strong>Produtos mais vendidos:</strong><br>
							<?php
							foreach ($bestSellers as $bestSeller) :
								echo $bestSeller->name . ' (' . $bestSeller->products_sales[0]->count . ' vendidos), ';
							endforeach;
							?>
						</div>
					</div>
				</div>

                <div class="row mar-bottom-25">
                    <div class="col-md-12">
                        <i class="fa fa-keyboard-o pull-left" aria-hidden="true"></i>
                        <div class="pull-left">
                            <strong>Palavras-chaves mais procuradas</strong><br>
							<?= implode(", ", $searches) ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <i class="fa fa-list-ol pull-left" aria-hidden="true"></i>
                        <div class="pull-left">
                            <strong>Categorias mais populares</strong><br>
							<?= implode(", ", $categories) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
