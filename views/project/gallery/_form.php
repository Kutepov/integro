<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Gallery
 * @var $project \app\models\Projects
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$form = ActiveForm::begin(['action' => Url::to('/gallery/create'),'options' => ['data-pjax' => true,'enctype' => 'multipart/form-data'], 'id' => 'upload-file']);
?>
<div class="row">
    <div class="col-md-5">
        <?= $form->field($model, 'file')->fileInput(['class' => 'form-control']) ?>
    </div>
    <div class="col-md-5">
        <?= $form->field($model, 'title')->textInput() ?>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success gallery-upload-file-btn']); ?>
            <?= $form->field($model, 'project_id')->hiddenInput(['value' => $project->id])->label(false) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end();?>