<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->css('Admin.order/tag-shipping', ['block' => 'cssTop', 'fullBase' => true]);
$this->Html->script(['Admin.order/barcodes', 'Admin.order/orders.functions'], ['block' => 'scriptBottom', 'fullBase' => true]);
$this->Html->scriptBlock('
$(document).ready(function(){
    updateBarcode();
})
', ['block' => 'scriptBottom']);
?>
<div id="print">
    <table width="391" class="tabela1" cellpadding="14" cellspacing="0">
        <tr>
            <td width="51%" valign="top" style="padding: 15px;">
                <table width="100%" border="0">
                    <tbody>
                    <tr>
                        <td align="botton"><?= $this->Html->image('tag-shipping/destinatario_peq.gif', ['border' => 0, 'fullBase' => true]) ?></td>
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
                                    , <?= $order->number ?><?= !empty($order->complement) ? ' - ' . $order->complement : '' ?><br>
                                <?= $order->zipcode ?> - <?= $order->neighborhood ?> - <?= $order->city ?> - <?= $order->state ?></p>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div align="center" class="style4">
                    <input style="display: none;" id="barcodeValue" type="text" name="value" value="<?= $order->zipcode ?>" />
                    <img id="barcodeImage" />
                </div>
                <hr align="center" width="100%" color="silver" size="1" />
                <div class="style2">
                    <b>Remetente:</b><br />
                    <span class="transforme">
                        <?php if($store->sender_address): ?>
                            <p><?= nl2br($store->sender_address) ?></p>
                        <?php else: ?>
                            <p><?= $store->address ?>
                                , <?= $store->number ?><?= !empty($store->complement) ? ' - ' . $store->complement : '' ?><br>
                                    <?= $store->zipcode ?> - <?= $store->neighborhood ?> - <?= $store->city ?> - <?= $store->state ?></p>
                        <?php endif; ?>
                    </span>
                </div>
            </td>
        </tr>
    </table>
</div>