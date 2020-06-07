<?php
/**
 * @var $this \yii\web\View
 * @var $items \app\models\Gallery[]
 */
?>
<?php foreach ($items as $item): ?>
    <div class="item" style="margin: 10px;">
        <img width="100" src="<?= $item->thumbnail ?>" alt="">
        <div class="update-block hidden" style="display: inline;">
            <input type="text" class="form-control" style="display: inline; width: 30%;" value="<?= $item->title ?>">
            <span data-id="<?= $item->id ?>" class="action-item js-confirm-edit-item fa fa-check" style="font-size: 20px;"></span>
        </div>
        <span class="information-block">
                <span><?= $item->title ?></span>
                <span data-id="<?= $item->id ?>" class="action-item js-edit-item fa fa-pencil"></span>
                <span data-id="<?= $item->id ?>" class="action-item js-delete-item fa fa-trash"></span>
            </span>
    </div>
<?php endforeach; ?>