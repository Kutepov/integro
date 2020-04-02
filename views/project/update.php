<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Projects
 */

$this->title = 'Редактирование проекта';
?>

<div id="project-update-form-wrapper">
    <div>
        <div class="project-country-type">
            <div class="project-country-flag" style="background: url('/img/countries/<?= $model->country->code ?>.png');"></div>
            <p class="project-country-name"><?= $model->country->name ?></p>
            <p class="project-type-name"><?= $model->type->name ?></p>
        </div>
        <?= $this->render('_form', compact('model')) ?>
    </div>
</div>