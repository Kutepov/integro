<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Projects
 */

$this->title = 'Описание проекта';

$this->registerCssFile('/css/project/description.css');
?>
<div class="project-description-wrapper">
    <div>
        <div id="TemplatesR">
            <div>
                <div>
                    <div class="project-country-type">
                        <div class="project-country-flag" style="background: url('/img/countries/<?= $model->country->code ?>.png');"></div>
                        <p class="project-country-name"><?= $model->country->name ?></p>
                        <p class="project-type-name"><?= $model->type->name ?></p>
                    </div>
                    <p class="project-full-name"><?= $model->full_name ?></p>
                </div>
                <div>
                    <div class="project-field-title"><p><?= $model->getAttributeLabel('name') ?></p></div>
                    <p class="project-field-value"><?= $model->name ?></p>
                </div>
                <div>
                    <div class="project-field-title"><p><?= $model->getAttributeLabel('begin_at') ?></p></div>
                    <p class="project-field-value"><?= date('d.m.Y', $model->begin_at) ?></p>
                </div>
                <div>
                    <div class="project-field-title"><p><?= $model->getAttributeLabel('end_at') ?></p></div>
                    <p class="project-field-value"><?= date('d.m.Y', $model->end_at) ?></p>
                </div>
                <div>
                    <div class="project-field-title"><p><?= $model->getAttributeLabel('ceo_id') ?></p></div>
                    <p class="project-field-value"><?= $model->ceo->full_name ?></p>
                </div>
                <div>
                    <div class="project-field-title"><p><?= $model->getAttributeLabel('manager_id') ?></p></div>
                    <p class="project-field-value"><?= $model->manager->full_name ?></p>
                </div>
                <div>
                    <div class="project-field-title"><p><?= $model->getAttributeLabel('agreement_id') ?></p></div>
                    <p class="project-field-value"><?= $model->agreement->name ?></p>
                </div>
                <div>
                    <div class="project-field-title"><p><?= $model->getAttributeLabel('description') ?></p></div>
                    <p class="project-field-value"><?= $model->description ?></p>
                </div>

                <?php foreach ($model->customFields as $field):
                    /** @var $field \app\models\ProjectsCustomFields */ ?>
                    <div>
                        <div class="project-field-title"><p><?= $field->name ?></p></div>
                        <p class="project-field-value"><?= $field->value ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>