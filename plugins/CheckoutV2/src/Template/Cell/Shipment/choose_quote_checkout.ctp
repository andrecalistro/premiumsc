<?php
/**
 * @var \App\View\AppView $this
 */
?>
<li class="selectable-option">
    <div>
        <div class="form-group">
            <input name="shipping" value='<?= json_encode($quote['data']) ?>' id="<?= $quote['code'] ?>"
                   data-value="<?= $quote['cost'] ?>"
                   data-title="<?= $quote['title'] ?>"
                   data-text="<?= $quote['text'] ?>"
                   type="radio">
            <label for="<?= $quote['code'] ?>" class="dark"></label>
        </div>
    </div>
    <div><?= $quote['title'] ?></div>
    <div><?= $quote['text'] ?></div>
</li>