<?php if($installment): ?>
    <div class="product-total">ou em até <?= $installment['installment'] ?>x de <?= $installment['price'] ?>
        <?= $installment['text'] ?>
    </div>
<?php endif;
