<?php
/**
 * @var \Admin\View\AppView $this
 */
?>
<?php if ($_ambient === 'test'): ?>
    <div class="alert-ambient">
        <marquee><strong>Ambiente de testes</strong> Não utilize dados reais. Os pedidos criados não serão cobrados.</marquee>
    </div>
<?php endif; ?>
