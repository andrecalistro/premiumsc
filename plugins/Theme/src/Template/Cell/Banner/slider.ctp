<?php
/**
 * @var \Cake\View\View $this
 * @var \Theme\Model\Entity\BannersImage[] $images
 */
?>
<?php if ($images): ?>
    <div class="slider-area">
        <div class="container">
            <div class="slider-active-3 owl-carousel slider-hm8 owl-dot-style">
                <?php foreach ($images as $image): ?>
                    <div class="slider-height-6 d-flex align-items-center justify-content-center bg-img"
                         style="background-image:url(<?= $image->image_link ?>);"
                        <?php if ($image->url): ?>
                            onclick="window.location.href='<?= $image->url ?>'"
                        <?php endif; ?>
                    >
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>