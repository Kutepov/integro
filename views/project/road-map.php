<?php
/**
 * @var $this \yii\web\View
 * @var $project \app\models\Projects
 * @var $statuses \app\models\ProjectStepsStatuses[]
 */

$this->title = 'Дорожная карта';

$this->registerCssFile('/css/roadmap.css');
$this->registerJsFile('/js/roadmap.js');
?>
<div style="display: none;">
    <div class="box-modal" id="modalHint" style="background: #fff; position: relative; width: 13.75em; box-shadow: 0 0 10px rgba(0,0,0,0.5); border-radius: 1.25em;">
        <div id="modalHintBox" style="padding: 1.25em; position: relative;">
            123434
        </div>
    </div>
</div>


<div class="road-map-wrapper">
    <?= $this->render('_title', ['model' => $project]) ?>
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
                    <span class="overude"><b><?= date('d.m.Y', $step->end_at) ?></b></span>
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
                        <p><b><?= date('d.m.Y', $mainStep->start_at) ?> - <br><?= date('d.m.Y', $mainStep->end_at) ?></b></p>
                    </div>
                    <div class="main-step-circle-wrapper">
                        <div
                            data-step-id="<?= $mainStep->id ?>"
                            data-win-id="<?= $mainStep->win_id ?>"
                            data-lose-id="<?= $mainStep->lose_id ?>"
                            class="outer-circle-main outer-circle circle-m"
                        >
                            <div class="inner-circle <?= $mainStep->status->class ?>"></div>
                        </div>
                        <?php if (count($mainSteps) > $index + 1): ?><div class="steps-vertical-hr"></div><?php endif; ?>
                    </div>

                    <?php if ($children = $mainStep->getChain('child')): ?>
                        <div class="substeps-wrapper">
                            <?php foreach ($children as $subStep): ?>
                                <div>
                                    <div class="substep-wrapper-2">
                                        <div class="substep-horizontal-hr"></div>
                                        <div class="substep-circle-wrapper">
                                            <div
                                                data-step-id="<?= $subStep->id ?>"
                                                data-win-id="<?= $subStep->win_id ?>"
                                                data-lose-id="<?= $subStep->lose_id ?>"
                                                class="outer-circle-sub outer-circle circle-s"
                                            >
                                                <div class="inner-circle <?= $subStep->status->class ?>"></div>
                                            </div>
                                            <p><?= $subStep->name ?></p>
                                        </div>
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