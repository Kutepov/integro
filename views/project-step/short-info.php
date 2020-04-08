<?php
/**
 * @var $model \app\models\ProjectSteps
 * @var $docTypes \app\models\ProjectStepsDocumentsTypes[]
 */
?>

<p class="short-info-dates"><?= $model->begin_at ?> - <?= $model->end_at ?></p>
<div class="short-info-close-button box-modal_close arcticmodal-close" ><i class="fas fa-times"></i></div>
<p class="short-info-status" style="color: <?= $model->status->color?>"><i><?= $model->status->name ?></i></p>
<?php foreach($docTypes as $docType):  ?>
    <p class="short-info-title"><?= $docType->name ?>:</p>
    <?php foreach ($model->getDocuments($docType->id) as $document): ?>
        <div>
            <a class="short-info-link-to-file" href="<?= $document->path ?>" download="<?= $document->name ?>.<?= $document->extension ?>">
                <span class="short-info-name-file"><?= $document->name ?> </span> <span class="short-info-format-file">.<?= $document->extension ?></span>
            </a>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>

<?php if ($model->reason): ?>
    <div class="short-info-reasons-wrapper tooltip-1"><p>Причины:</p>
        <span class="short-info-reasons-text tooltiptext-1"><?= $model->reason ?></span>
</div>
<?php endif; ?>
<?php if ($model->actions): ?>
    <br>
    <div class="short-info-reasons-wrapper tooltip-2"><p>Действия:</p>
        <span class="short-info-reasons-text tooltiptext-2"><?= $model->actions ?></span>
    </div>
<?php endif; ?>
