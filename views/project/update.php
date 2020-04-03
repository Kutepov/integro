<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Projects
 */

$this->title = 'Редактирование проекта';
?>

<div id="project-update-form-wrapper">
    <div>
        <?= $this->render('_title', compact('model')) ?>
        <?= $this->render('_form', compact('model')) ?>
    </div>
</div>