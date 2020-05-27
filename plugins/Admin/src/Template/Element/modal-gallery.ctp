<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script(['lightbox.min.js'], ['block' => 'scriptBottom', 'fullBase' => true]);
$this->Html->css('lightbox.css', ['block' => 'cssTop', 'fullBase' => true]);
$this->Html->scriptBlock('
$(document).on(\'click\', \'[data-toggle="lightbox"]\', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});
', ['block' => 'scriptBottom']);