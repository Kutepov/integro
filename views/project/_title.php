<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Projects
 */
?>

<div class="project-country-type">
    <div class="project-country-flag" style="background: url('/img/countries/<?= $model->country->code ?>.png');"></div>
    <p class="project-country-name"><?= $model->country->name ?></p>
    <p class="project-type-name"><?= $model->type->name ?></p>
</div>
<p class="project-full-name"><?= $model->full_name ?></p>