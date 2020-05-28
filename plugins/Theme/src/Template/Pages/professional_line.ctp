<?php
/**
 * @var \App\View\AppView $this
 * @var \Theme\Model\Entity\Page $page
 */
$this->Html->scriptBlock(
    "$(document).ready(function () {
    var LinhaProfissionalSlider = new Swiper ('#linha-profissional-slider',{
                scrollbar: {
                    el: '.swiper-scrollbar',
                    hide: false,
                },
                slidesPerView: 1,
                direction: 'vertical',
                mousewheel: true
            });});", ['block' => 'scriptBottom']
);
echo $page->content;