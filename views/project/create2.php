<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Projects
 */

$this->title = 'Создание проекта';

?>

<div id="cForm">
    <h1 class="project-create-title"><?= $this->title ?></h1>
    <div>
        <?= $this->render('_form', compact('model')) ?>
    </div>
</div>