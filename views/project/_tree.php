<?php
/**
 * @var $this View
 * @var $folders DocumentsFolders[]
 */

use app\models\DocumentsFolders;
use yii\web\View;

?>
<?php foreach ($folders as $folder): ?>
    <div class="documents-indent">
        <label class="js-documents-folder" data-id-folder="<?= $folder->id ?>">
            <i class="fas fa-folder-open" aria-hidden="true"></i><?= $folder->name ?>
        </label>
        <a class="js-documents-controls js-documents-add-file" data-id-folder="<?= $folder->id ?>"><i class="fas fa-plus" aria-hidden="true"></i></a>
        <span class="js-documents-form-file-wrapper" data-id-folder="<?= $folder->id ?>" style="display: none;">
                <form enctype="multipart/form-data" class="js-documents-form-file" data-id-folder="<?= $folder->id ?>"  style="display: inline-block;">
                    <div class="help-block documents-help-block-add-file"></div>
                    <input type="hidden" name="folder_id" value="<?= $folder->id ?>">
                    <input class="form-control documents-input-file js-documents-input-add-file" data-id-folder="<?= $folder->id ?>" type="file" name="file">
                    <input class="btn btn-primary documents-input-add-file" type="submit" data-id-folder="<?= $folder->id ?>" value="Загрузить">
                </form>
            </span>
        <a class="js-documents-add-folder js-documents-controls" data-id-folder="<?= $folder->id ?>">
            <i class="fas fa-folder-plus" aria-hidden="true"></i>
        </a>
        <div class="js-documents-create-folder" data-id-folder="<?= $folder->id ?>" style="display: none;">
            <input class="form-control documents-input-text js-documents-name-new-folder" type="text" data-id-folder="<?= $folder->id ?>">
            <button class="btn btn-primary js-documents-btn-create-folder" data-id-folder="<?= $folder->id ?>">ОК</button>
        </div>
        <a class="js-documents-update-folder js-documents-controls" data-id-folder="<?= $folder->id ?>"><i class="fas fa-pencil-alt" aria-hidden="true"></i></a>
        <div class="js-documents-edit-folder" data-id-folder="<?= $folder->id ?>" style="display: none;">
                <input class="form-control documents-input-text js-documents-name-folder" data-id-folder="<?= $folder->id ?>" type="text" value="<?= $folder->name ?>">
                <button class="btn btn-primary js-documents-btn-edit-folder" data-id-folder="<?= $folder->id ?>">ОК</button>
            </div>
        <a class="js-documents-delete-folder js-documents-controls" data-id-folder="<?= $folder->id ?>"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>

        <div class="documents-wrapper-folder" data-id-folder="<?= $folder->id ?>" style="display: none">
            <?= $this->render('_tree', ['folders' => $folder->childFolders]) ?>
            <div class="documents-indent">
                <?php foreach ($folder->documents as $document): ?>
                    <p>
                        <a
                            class="documents-file <?= $document->is_preview ? 'js-documents-preview' : ''?>"
                            <?= $document->is_preview ? 'data-' : 'data-pjax="0" download="'.$document->name.'" ' ?>href="<?= $document->path ?>"
                        >
                            <?= $document->name ?>
                            <span class="documents-file-extension">.<?= $document->extension ?></span>
                        </a>
                        <a data-pjax="0" class="js-documents-controls" href="<?= $document->path ?>" download="<?= $document->name ?>.<?= $document->extension ?>">
                            <i class="fas fa-download" aria-hidden="true"></i>
                        </a>
                        <span
                            class="js-documents-controls"
                            data-toggle="tooltip"
                            data-placement="top"
                            data-html="true"
                            title="Добавил: <?= $document->creator->full_name ?><br>Дата: <?= date('d.m.Y H:i:s', $document->created_at) ?>">
                            <i class="fas fa-file-invoice"></i>
                        </span>

                        <a class="js-documents-controls js-documents-edit-file" data-id-file="<?= $document->id ?>">
                            <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                        </a>
                        <span class="js-documents-edit-file-input" data-id-file="<?= $document->id?>"  style="display: none;">
                            <input class="form-control documents-input-text js-documents-name-file" data-id-file="<?= $document->id?>" type="text" value="<?= $document->name ?>">
                            <button class="btn btn-primary js-documents-btn-edit-file" data-id-file="<?= $document->id?>">ОК</button>
                        </span>
                    <a class="js-documents-delete-file js-documents-controls" data-id-file="<?= $document->id?>"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                    </p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
