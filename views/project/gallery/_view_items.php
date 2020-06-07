<?php
/**
 * @var $this \yii\web\View
 * @var $items \app\models\Gallery[]
 */
?>
<?php foreach ($items as $item): ?>
    <div class="gasllery-item-wrapper item">
        <a class="gallery-item-a lightbox" href="<?= $item->path ?>">
            <img width="100" src="<?= $item->thumbnail ?>" alt="">
        </a>
        <span><?= $item->title ?></span>
    </div>
<?php endforeach; ?>