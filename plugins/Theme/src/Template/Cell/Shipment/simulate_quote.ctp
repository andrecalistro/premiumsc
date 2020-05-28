<tr>
    <?php if($quote['image']): ?>
        <td><?= $this->Html->image($quote['image']) ?></td>
        <td><?= $quote['title'] ?></td>
    <?php else: ?>
        <td colspan="2"><?= $quote['title'] ?></td>
    <?php endif; ?>
    <td class="price"><?= $quote['text'] ?></td>
    <td class="td-btn" valign="top" align="right">
        <a href="javascript:void(0)" class="btn btn-default btn-accent btn-add-cart-with-shipping" title="Comprar agora" data-toggle="tooltip" data-placement="top" data-shipping-quote="<?= $quote['code'] ?>" data-shipping-quote-price="<?= $quote['cost'] ?>" data-shipping-title="<?= $quote['title'] ?>">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        </a>
    </td>
</tr>