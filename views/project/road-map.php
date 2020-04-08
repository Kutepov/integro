<?php
/**
 * @var $this \yii\web\View
 * @var $project \app\models\Projects
 * @var $statuses \app\models\ProjectStepsStatuses[]
 * @var $edit boolean
 */

use yii\helpers\Url;

$this->title = 'Дорожная карта';

$this->registerCssFile('/css/road-map/roadmap.css');
$this->registerJsFile('/js/road-map/roadmap.js');
if (!$edit) {
    $this->registerJsFile('/js/road-map/short-info.js');
}
else {
    $this->registerJsFile('/js/road-map/edit.js');
}
?>

<div class="road-map-wrapper">
    <?= $this->render('_title', ['model' => $project]) ?>
    <?php if ($edit): ?>
        <div class="alert alert-success">Редактирование <b><a style="float: right;" class="text-success" href="<?= Url::toRoute(['/project/road-map', 'id' => $project->id]) ?>">Завершить <span class="fa fa-check"></span> </a></b></div>
    <?php endif; ?>
    <hr>
    <div class="list-statuses">
        <div class="list-statuses-title-wrapper"><p class="list-statuses-title">Дорожная карта</p></div>

        <div class="list-statuses-content">
            <?php foreach ($statuses as $status): ?>
                <div class="list-status-item-wrapper">
                    <div class="list-status-item outer-circle circle-s">
                        <div class="inner-circle <?= $status->class ?>">
                        </div>
                    </div>
                    <span class="list-status-item-name"> <?= $status->name ?> </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if ($project->lateSteps): ?>
        <div class="steps-overdue-wrapper">
            <p class="steps-overdue-title">Просроченные этапы:</p>
            <?php foreach ($project->lateSteps as $step): ?>
                <p class="steps-overdue-item">
                    <?php foreach ($step->getChain('parent', true) as $item): ?>
                        <?= $item->name.' -> ' ?>
                    <?php endforeach; ?>
                    <?= $step->name ?>:
                    <span class="overude"><b><?= $step->end_at ?></b></span>
                </p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="elMot" id="elMot" style="width: 100%; white-space: nowrap; position: relative;">
        <?php if (!$mainSteps = $project->mainSteps): ?>
            <p class="road-map-is-not-exists">Дорожная карта отсутствует</p>
        <?php else: ?>
            <?php foreach ($mainSteps as $index => $mainStep): ?>
                <div class="main-step-wrapper">
                    <div class="main-step-title-wrapper">
                        <p><?= $mainStep->name ?></p>
                    </div>
                    <div class="main-step-dates-wrapper">
                        <p><b><?= $mainStep->begin_at ?> - <br><?= $mainStep->end_at ?></b></p>
                    </div>
                    <div class="js-step-hover main-step-circle-wrapper">

                        <?php
                        //Плюс слева
                        if ($edit):
                        ?>
                            <div class="js-step-create step-create-main-left">
                                <a href="<?= Url::toRoute(['/project-step/create', 'type' => 'left', 'related_step_id' => $mainStep->id]) ?>">
                                    <span class="dstp dstp_130"><i class="fas fa-plus"></i></span>
                                </a>
                            </div>
                        <?php endif; ?>

                        <<?= $edit ? 'a' : 'div' ?>
                            data-step-id="<?= $mainStep->id ?>"
                            data-win-id="<?= $mainStep->win_id ?>"
                            data-lose-id="<?= $mainStep->lose_id ?>"
                            class="outer-circle-main outer-circle circle-m"
                            <?= $edit ? 'href="'.Url::toRoute(['/project-step/edit', 'id' => $mainStep->id]).'"' : 'div' ?>
                        >
                            <div class="inner-circle <?= $mainStep->status->class ?>"></div>
                        </<?= $edit ? 'a' : 'div' ?>>
                        <?php if (count($mainSteps) > $index + 1): ?><div class="steps-vertical-hr"></div><?php endif; ?>


                        <?php
                        //Плюс справа
                        if ($edit):
                        ?>
                        <div class="js-step-create step-create-main-right">
                            <a href="<?= Url::toRoute(['/project-step/create', 'type' => 'right', 'related_step_id' => $mainStep->id]) ?>" >
                                <span class="dstp dstp_130"><i class="fas fa-plus"></i></span>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php
                        //Плюс внизу
                        if ($edit && !$mainStep->getChain('child')):
                        ?>
                            <div class="steps-small-horizontal-hr"></div>
                            <a class="js-step-create step-create-first-child" href="<?= Url::toRoute(['/project-step/create', 'type' => 'child', 'related_step_id' => $mainStep->id]) ?>">
                                <span class="dstp dstp_130"><i class="fas fa-plus"></i></span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if ($children = $mainStep->getChain('child')): ?>
                        <div class="substeps-wrapper">
                            <?php foreach ($children as $subStep): ?>
                                <div>
                                    <div class="js-step-hover substep-wrapper-2">

                                        <div class="substep-horizontal-hr"></div>

                                        <?php
                                        //Плюс снизу
                                        if ($edit):
                                            ?>
                                            <div class="js-step-create step-create-sub-bottom">
                                                <a href="<?= Url::toRoute(['/project-step/create', 'type' => 'bottom', 'related_step_id' => $subStep->id]) ?>">
                                                    <span class="dstp dstp_114"><i class="fas fa-plus"></i></span>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <div class="substep-circle-wrapper">
                                            <<?= $edit ? 'a' : 'div' ?>
                                                data-step-id="<?= $subStep->id ?>"
                                                data-win-id="<?= $subStep->win_id ?>"
                                                data-lose-id="<?= $subStep->lose_id ?>"
                                                class="outer-circle-sub outer-circle circle-s"
                                                <?= $edit ? 'href="'.Url::toRoute(['/project-step/edit', 'id' => $subStep->id]).'"' : 'div' ?>
                                            >
                                                <div class="inner-circle <?= $subStep->status->class ?>"></div>
                                            </<?= $edit ? 'a' : 'div' ?>>
                                            <p><?= $subStep->name ?></p>
                                        </div>

                                        <?php
                                        //Плюс сверху
                                        if ($edit):
                                        ?>
                                            <div class="js-step-create step-create-sub-top">
                                                <a href="<?= Url::toRoute(['/project-step/create', 'type' => 'top', 'related_step_id' => $subStep->id]) ?>">
                                                    <span class="dstp dstp_114"><i class="fas fa-plus"></i></span>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>


<div style="display: none;">
    <div class="box-modal" id="modalHint">
        <div id="modalHintBox"></div>
    </div>
</div>


<?php if (!$edit): ?>
<?php $this->beginBlock('control_buttons_page'); ?>
    <div class="footer-control-button fbc-first">
        <a href="<?= $mainSteps ? Url::toRoute(['/project/road-map', 'id' => $project->id, 'edit' => 'true']) : Url::toRoute(['/project-step/create']) ?>">
            <p><span><?= $mainSteps ? 'Редактировать' : 'Создать' ?></span></p>
        </a>
    </div>
<?php
//Изображения для футера с кнопкой
$this->registerJs('$(".footerHalf").addClass("footerHalf2")');

$this->endBlock();
endif;
?>