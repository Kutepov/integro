<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Projects
 */

use yii\helpers\Url;

$this->title = 'Описание проекта';

$this->registerCssFile('/css/project/description.css');
?>
<div class="project-description-wrapper">
    <div>
        <div id="TemplatesR">
            <div>
                <div>
                    <?= $this->render('_title', compact('model')) ?>
                </div>
                <div>
                    <div class="project-field-title"><p><?= $model->getAttributeLabel('name') ?></p></div>
                    <p class="project-field-value"><?= $model->name ?></p>
                </div>
                <div>
                    <div class="project-field-title"><p><?= $model->getAttributeLabel('begin_at') ?></p></div>
                    <p class="project-field-value"><?= $model->begin_at ?></p>
                </div>
                <div>
                    <div class="project-field-title"><p><?= $model->getAttributeLabel('end_at') ?></p></div>
                    <p class="project-field-value"><?= $model->end_at ?></p>
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

                <?php foreach ($model->customFields as $field):
                    /** @var $field \app\models\ProjectsCustomFields */ ?>
                    <div>
                        <div class="project-field-title"><p><?= $field->name ?></p></div>
                        <p class="project-field-value"><?= $field->value ?></p>
                    </div>
                <?php endforeach; ?>

                <div>
                    <div class="project-field-title"><p><?= $model->getAttributeLabel('description') ?></p></div>
                    <p class="project-field-value"><?= $model->description ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->beginBlock('control_buttons_page'); ?>
    <div class="footer-control-button fbc-first">
        <a href="<?= Url::toRoute(['project/update', 'id' => $model->id]) ?>">
            <p><span>Редактировать</span></p>
        </a>
    </div>

<?php
//Изображения для футера с кнопкой
$this->registerJs('$(".footerHalf").addClass("footerHalf2")');

$this->endBlock();
?>