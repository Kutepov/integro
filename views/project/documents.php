<?php
/**
 * @var $this \yii\web\View
 * @var $project \app\models\Projects
 */

use yii\widgets\Pjax;
use yii\bootstrap\Modal;

$this->title = 'Документы';

$this->registerJsFile('/js/documents/main.js');

echo Modal::widget(['id' => 'js-documents-modal-preview', 'header' => 'Предпросмотр']);
?>

<div class="create-step-form-wrapper js-documents-page-wrapper">
    <div class="create-step-form-wrapper-2">
        <div>
            <?= $this->render('/project/_title', ['model' => $project]) ?>
        </div>
        <div>
            <p class="create-step-form-title"><?= $this->title ?></p>
        </div>

        <?php Pjax::begin(['id' => 'documents']) ?>
            <div id="documents-by-project" data-project-id="<?= $project->id ?>">
                <label class="js-documents-folder" data-id-folder="0"><i class="fas fa-folder-open" aria-hidden="true"></i>Документы</label>
                <a class="js-documents-add-folder js-documents-controls" data-id-folder="0"><i class="fas fa-folder-plus" aria-hidden="true"></i></a>
                <span class="js-documents-create-folder" data-id-folder="0" style="display: none;">
                    <input class="form-control documents-input-text js-documents-name-new-folder" type="text" data-id-folder="0">
                <button class="btn btn-primary js-documents-btn-create-folder" data-id-folder="0">ОК</button>
                </span>

                <div class="documents-wrapper-folder" data-id-folder="0">
                    <?= $this->render('_tree', ['folders' => $project->rootFolders]) ?>
                </div>
            </div>
        <?php Pjax::end(); ?>

    </div>
</div>