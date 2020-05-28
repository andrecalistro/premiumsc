<?php if ($installments): ?>
    <label class="mar-bottom-10">Ver Parcelas:</label>
    <select class="mar-bottom-10">
        <?php foreach($installments as $installment): ?>
        <option><?= $installment['installment'] ?>x de <?= $installment['price'] ?> <?= $installment['text'] ?></option>
        <?php endforeach; ?>
    </select>
<?php endif ?>