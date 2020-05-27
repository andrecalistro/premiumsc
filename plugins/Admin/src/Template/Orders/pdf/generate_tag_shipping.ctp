<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->css('tag-shipping', ['block' => 'cssTop', 'fullBase' => true]);
?>
<div id="print">
    <table width="391" class="tabela1" cellpadding="14" cellspacing="0">
        <tr>
            <td width="51%" valign="top">
                <table width="100%" border="0">
                    <tbody>
                    <tr>
                        <td align="botton"><?= $this->Html->image('destinatario_peq.gif', ['border' => 0, 'fullBase' => true]) ?><img src="../image/etiqueta/destinatario_peq.gif" border="0"></td>
                        <td align="right">
                            <?= $this->Html->image('tag-shipping/correios.gif', ['border' => 0, 'fullBase' => true]) ?>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table border="0" cellpadding="0" cellspacing="0" height="150">
                    <tbody>
                    <tr>
                        <td valign="top">
                            <span class="style1">
                                <p>Destinatário: <?= $order->customer->name ?></p>
    <p><?= $order->address ?>
        , <?= $order->number ?><?= !empty($order->complement) ? ' - ' . $order->complement : '' ?></p>
    <p><?= $order->zipcode ?> - <?= $order->neighborhood ?> - <?= $order->city ?> - <?= $order->state ?></p>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div align="center" class="style4">
                    <input style="display: none;" id="barcodeValue" type="text" name="value" value="<?php echo $order['cep']; ?>" />
                    <img id="barcodeImage" />
                </div>
                <hr align="center" width="100%" color="silver" size="1" />
                <div class="style2">
                    <b>Remetente:</b><br />
                    <span class="transforme">

                            </span>
                </div>
            </td>
        </tr>
    </table>
</div>