<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\ProjectSteps
 */

use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use \app\models\ProjectStepsStatuses;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use \yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\Url;

$this->registerCssFile('/css/road-map/form.css');
$this->registerJsFile('/js/road-map/form.js');

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
?>

    <div class="project-step-create-item-wrapper" style=" ">
        <p class="project-step-create-label-wrapper"><?= $model->getAttributeLabel('name') ?></p>
        <div class="input-container sse form-group field-stepform-name addProjectStepInputName">
            <i class="fa fa-search icon project-step-create-icon-search" aria-hidden="true"></i>
            <?php if (!$model->isNewRecord): ?>
                <?= $form->field($model, 'name')->textInput(['class' => 'ui-autocomplete-input'])->label(false); ?>
            <?php else: ?>
                <?= $form->field($model, 'name')->widget(AutoComplete::class, [
                        'clientOptions' => [
                            'source' => '/project-step/search-templates',
                            'class' => 'ui-autocomplete-input',
                            'select' => new JsExpression('function( event, ui ) {
                                applyTemplate(ui);
                            }'
                        )
                    ]
                ])->label(false) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="ssse">
        <p class="project-step-create-label-start-end-wrapper"> <?= $model->getAttributeLabel('begin_at') ?> - <br><?= $model->getAttributeLabel('end_at') ?></p>
        <div class="project-step-create-begin-at field-stepform-begin">
            <?= $form->field($model, 'begin_at', ['inputOptions' => ['autocomplete' => 'off']])
                ->widget(DatePicker::class,
                    [
                        'language' => 'ru',
                        'addon' => false,
                        'options' => ['class' => 'asdsdads hasDatepicker', 'tag' => false],
                        'template' => '{input}',
                        'clientOptions' => ['changeMonth' => true, 'changeYear' => true, 'format' => 'dd.mm.yyyy']
                    ]
                )->label(false); ?>
        </div>
        <div class="project-step-create-end-at field-stepform-begin">
            <?= $form->field($model, 'end_at', ['inputOptions' => ['autocomplete' => 'off']])
                ->widget(DatePicker::class,
                    [
                        'language' => 'ru',
                        'addon' => false,
                        'options' => ['class' => 'asdsdads hasDatepicker', 'tag' => false],
                        'template' => '{input}',
                        'clientOptions' => ['changeMonth' => true, 'changeYear' => true, 'format' => 'dd.mm.yyyy']
                    ]
                )->label(false); ?>
        </div>
    </div>
    <div id="statusStep">
        <p class="project-step-create-label-status-wrapper"><?= $model->getAttributeLabel('status_id') ?></p>

        <div class="col-sm-6 col-sm-offset-3">
        <?= $form->field($model, 'status_id')
            ->radioList(
                    ArrayHelper::map(ProjectStepsStatuses::find()->select(['id', 'name'])->all(), 'id', 'name'),
                    ['item' => function($index, $label, $name, $checked, $value){
                        $model = ProjectStepsStatuses::findOne($value);
                        return Html::radio($name,
                            $checked,
                            [
                                'label' => $label,
                                'value' => $value,
                                'labelOptions' => ['class' => 'radio-inline', 'style' => 'color: '.$model->color]
                            ]);

                    }]
            )
            ->label(false) ?>
        </div>
    </div>

    <div>
        <p class="project-step-create-label-docs-1-wrapper">Нормативные документы</p>
        <div id="docsDiv1New"></div>
        <div id="docsTemplateDiv1New"></div>
        <?php if (!$model->isNewRecord): ?>
            <?php foreach ($model->projectStepsDocuments1 as $document): ?>
                <span id="isset-doc-<?= $document->id ?>" class="create-step-form-file"><?= $document->name.'.'.$document->extension ?><i class="fas fa-trash-alt" aria-hidden="true" onclick="deleteIssetFile(<?= $document->id ?>)"></i></span><br>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="example-3">
            <label for="projectsteps-docs1" class="filupp">
                <span class="project-step-create-docs-1 filupp-file-name js-value"> + Добавить документ</span>
                <?= $form->field($model, 'docs1[]')->fileInput(['multiple' => true, 'style' => ['display' => 'none']])->label(false) ?>
                <?= $form->field($model, 'exclude_files1')->hiddenInput(['id' => 'deldocs1'])->label(false) ?>
            </label>
        </div>
    </div>
    <div>
        <p class="project-step-create-label-docs-1-wrapper">Документы по этапу</p>
        <div id="docsDiv2New"></div>
        <div id="docsTemplateDiv2New"></div>
        <?php if (!$model->isNewRecord): ?>
            <?php foreach ($model->projectStepsDocuments2 as $document): ?>
                <span id="isset-doc-<?= $document->id ?>" class="create-step-form-file"><?= $document->name.'.'.$document->extension ?> <i class="fas fa-trash-alt" aria-hidden="true" onclick="deleteIssetFile(<?= $document->id ?>)"></i></span><br>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="example-3">
            <label for="projectsteps-docs2" class="filupp">
                <span class="project-step-create-docs-1 filupp-file-name js-value"> + Добавить документ</span>
                <?= $form->field($model, 'docs2[]')->fileInput(['multiple' => true, 'style' => ['display' => 'none']])->label(false) ?>
                <?= $form->field($model, 'exclude_files2')->hiddenInput(['id' => 'deldocs2'])->label(false) ?>
            </label>
        </div>
    </div>
    <div class="custom-fa bounds" style="height: 17.5em;">
        <p class="create-step-form-related-steps-title">Связанные этапы</p>
        <p class="create-step-form-related-steps-descr">
            Здесь можно построить логическую связь (условия), например: «Если создаваемый этап
            <span style="color: #db7235;">Невыполненный</span>, то этап <span style="color: #2f475b;">Подготовка <br>
            документации</span> приобретает статус <span style="color: #f6cb00;">В работе</span>. Т.к. нарушены сроки.<br>
            Второе условие: «Если создаваемый этап <span style="color: #8bb85c;">Выполненый</span>,
            то этап <span style="color: #2f475b;">Подготовка документации</span> приобретает статус
            <span style="color: #f6cb00;">В работе</span>.
        </p>
        <div class="create-step-form-win-step-wrapper">
            <p class="create-step-form-win-step-title">1. Если создаваемый этап</p>
            <p class="create-step-form-win-step-checkbox-wrapper">
                <label for="ifwin">
                    <input name="ifwin" id="ifwin" type="checkbox" <?= $model->win_id ? 'checked' : '' ?>>
                    <span>Выполненный</span>
                </label>
            </p>
            <p class="create-step-form-that-start">То запускаем этап</p>
            <div class="create-step-form-that-start-wrapper input-container">
                <i class="fa fa-search icon" aria-hidden="true"></i>

                <?= $form->field($model, 'win_id')
                    ->dropDownList(
                            $model->arrForDropdown,
                            ['class' => 'addProjectFormFieldTR', 'disabled' => !(bool)$model->win_id, 'prompt' => 'Выберите этап'])
                    ->label(false);
                ?>
            </div>
        </div>
        <div class="create-step-form-lose-step-wrapper">
            <p class="create-step-form-win-step-title">2. Если создаваемый этап</p>
            <p class="create-step-form-lose-step-checkbox-wrapper">
                <label for="iflose">
                    <input name="iflose" id="iflose" type="checkbox" <?= $model->lose_id ? 'checked' : '' ?>>
                    <span>Не выполненный</span>
                </label>
            </p>
            <p class="create-step-form-that-start">То запускаем этап</p>
            <div class="create-step-form-that-start-wrapper input-container">
                <i class="fa fa-search icon" aria-hidden="true"></i>
                <?= $form->field($model, 'lose_id')
                    ->dropDownList(
                        $model->arrForDropdown,
                        ['class' => 'addProjectFormFieldTR', 'disabled' => !(bool)$model->lose_id, 'prompt' => 'Выберите этап'])
                    ->label(false);
                ?>
            </div>
        </div>
    </div>

    <?php if (
        ($model->isNewRecord && Yii::$app->request->get('type') && Yii::$app->request->get('type') != 'left' && Yii::$app->request->get('type') != 'right') ||
        (!$model->isNewRecord && $model->is_substep)
    ): ?>
        <div class="project-step-create-textarea-wrapper">
            <p><?= $model->getAttributeLabel('reason') ?> (максимум 2000 символов)</p><div class="form-group field-addprojectform-description">
                <?= $form->field($model, 'reason')->textarea(['rows' => 6])->label(false) ?>
                <p class="help-block help-block-error"></p>
            </div>
        </div>

        <div class="project-step-create-textarea-wrapper">
            <p><?= $model->getAttributeLabel('actions') ?> (максимум 2000 символов)</p><div class="form-group field-addprojectform-description">
                <?= $form->field($model, 'actions')->textarea(['rows' => 6])->label(false) ?>
                <p class="help-block help-block-error"></p>
            </div>
        </div>
    <?php endif; ?>

    <div class="create-step-form-check-wrap">
        <button type="submit" class="redbtn"><?= $model->isNewRecord ? 'Создать' : 'Сохранить'?></button>
        <div class="create-step-form-template-checkbox-wrapper">
            <?= $form->field($model, 'is_template')->checkbox() ?>
            <p class="step-create-template-description">В шаблоне сохранятся Название и <br>Нормативные документы копия</p>
        </div>
        <?php if (!$model->isNewRecord): ?>
            <a class="create-step-form-btn-delete-step" href="<?= Url::toRoute(['/project-step/delete', 'id' => $model->id]) ?>" onclick="return confirm('Вы уверены, что хотите удалить этап?')">Удалить этап</a>
        <?php endif; ?>
    </div>

<?php ActiveForm::end(); ?>