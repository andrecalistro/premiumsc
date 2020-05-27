<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->scriptBlock('
alertDialog("' . $message . '", "info");
', ['block' => 'scriptBottom']);