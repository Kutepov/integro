<?php
/**
 * @var $this \yii\web\View
 * @var $project \app\models\Projects
 * @var $model \app\models\ProjectSteps
 */

use yii\helpers\Url;

$this->title = 'Дорожная карта - ';
$this->title .= $model->isNewRecord ? 'новый этап' : 'редактирование';
?>

<div class="create-step-form-wrapper">
    <div class="create-step-form-wrapper-2">
        <div>
            <?= $this->render('/project/_title', ['model' => $project]) ?>
        </div>
        <div>
            <p class="create-step-form-title"><?= $this->title ?></p>
            <a class="create-step-form-close" href="<?= Url::toRoute(['/project/road-map', 'id' => $project->id, 'edit' => 'true']) ?>">
                <p>x Закрыть без сохранения</p>
            </a>
        </div>

        <?= $this->render('_form', compact('model')) ?>
    </div>
</div>