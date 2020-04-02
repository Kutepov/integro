<?php
/**
 * @var $model \app\models\Projects
 * @var $this \yii\web\View
 */

use yii\helpers\ArrayHelper;
use app\models\ProjectsTypes;
use app\models\Countries;
use \dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Users;
use unclead\multipleinput\MultipleInput;

$this->registerCss('.select2-container--krajee .select2-dropdown {margin-top: 11px;}');

$form = \yii\widgets\ActiveForm::begin();
?>

<div class="project-create-item-wrapper">
    <div class="project-create-label-wrapper"><p><?= $model->getAttributeLabel('full_name') ?></p></div>
    <div class="addProjectInputName">
        <?= $form->field($model, 'full_name')->textInput(['class' => 'addProjectFormFieldTop'])->label(false); ?>
    </div>
</div>

<div class="project-create-item-wrapper">
    <div class="project-create-label-wrapper"><p><?= $model->getAttributeLabel('type_id') ?></p></div>
    <div class="addProjectInputName project-create-short-field">
        <?= $form->field($model, 'type_id')
            ->dropDownList(
                    ArrayHelper::map(ProjectsTypes::find()->all(), 'id', 'name'),
                    [
                        'class' => 'addProjectFormField',
                        'prompt' => 'Выберите '.mb_strtolower($model->getAttributeLabel('type_id'))
                    ])
            ->label(false) ?>
    </div>
</div>

    <div class="project-create-item-wrapper project-create-item-wrapper__select2">
        <div class="project-create-label-wrapper"><p><?= $model->getAttributeLabel('country_id') ?></p></div>
        <div class="addProjectInputName project-create-short-field">
            <?= $form->field($model, 'country_id')->widget(\kartik\select2\Select2::class, [
                'data' => ArrayHelper::map(Countries::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите страну', 'class' => 'custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left ui-autocomplete-input'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ])->label(false); ?>
        </div>
    </div>

<div class="project-create-item-wrapper">
    <div class="project-create-label-wrapper"><p><?= $model->getAttributeLabel('name') ?></p></div>
    <div class="addProjectInputName project-create-short-field">
        <?= $form->field($model, 'name')->textInput(['class' => 'addProjectFormFieldTop'])->label(false); ?>
    </div>
</div>

<div class="project-create-item-wrapper">
    <div class="project-create-label-wrapper"><p><?= $model->getAttributeLabel('begin_at') ?></p></div>
    <div class="addProjectInputName project-create-short-field">
        <?= $form->field($model, 'begin_at', ['inputOptions' => ['autocomplete' => 'off']])
            ->widget(DatePicker::class,
                [
                    'language' => 'ru',
                    'addon' => false,
                    'options' => ['class' => 'addProjectFormField', 'style' => 'box-shadow: none;'],
                    'template' => '{input}',
                    'clientOptions' => ['changeMonth' => true, 'changeYear' => true, 'format' => 'dd.mm.yyyy']
                ]
            )->label(false); ?>
    </div>
</div>

<div class="project-create-item-wrapper">
    <div class="project-create-label-wrapper"><p><?= $model->getAttributeLabel('end_at') ?></p></div>
    <div class="addProjectInputName project-create-short-field">
        <?= $form->field($model, 'end_at', ['inputOptions' => ['autocomplete' => 'off']])
            ->widget(DatePicker::class,
                [
                    'language' => 'ru',
                    'addon' => false,
                    'options' => ['class' => 'addProjectFormField', 'style' => 'box-shadow: none;'],
                    'template' => '{input}',
                    'clientOptions' => ['changeMonth' => true, 'changeYear' => true, 'format' => 'dd.mm.yyyy']
                ]
            )->label(false); ?>
    </div>
</div>

<div class="project-create-item-wrapper project-create-item-wrapper__select2">
    <div class="project-create-label-wrapper"><p><?= $model->getAttributeLabel('ceo_id') ?></p></div>
    <div class="addProjectInputName project-create-short-field">
        <?= $form->field($model, 'ceo_id')->widget(\kartik\select2\Select2::class, [
            'data' => ArrayHelper::map(Users::findAll(['role_id' => 4]), 'id', 'full_name'),
            'options' => ['placeholder' => 'Выберите руководителя', 'class' => 'custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left ui-autocomplete-input'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false); ?>
    </div>
</div>

<div class="project-create-item-wrapper project-create-item-wrapper__select2">
    <div class="project-create-label-wrapper"><p><?= $model->getAttributeLabel('manager_id') ?></p></div>
    <div class="addProjectInputName project-create-short-field">
        <?= $form->field($model, 'manager_id')->widget(\kartik\select2\Select2::class, [
            'data' => ArrayHelper::map(Users::findAll(['role_id' => 2]), 'id', 'full_name'),
            'options' => ['placeholder' => 'Выберите менеджера', 'class' => 'custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left ui-autocomplete-input'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false); ?>
    </div>
</div>

<div class="project-create-item-wrapper">
    <div class="project-create-label-wrapper"><p><?= $model->getAttributeLabel('agreement_id') ?></p></div>
    <div class="addProjectInputName project-create-short-field">
        <?= $form->field($model, 'agreement_id')
            ->dropDownList(
                ArrayHelper::map(\app\models\ProjectsAgreements::find()->all(), 'id', 'name'),
                [
                    'class' => 'addProjectFormField',
                    'prompt' => 'Выберите '.mb_strtolower($model->getAttributeLabel('agreement_id'))
                ])
            ->label(false) ?>
    </div>
</div>


<?= $form->field($model, 'customFields')->widget(MultipleInput::className(), [
    'addButtonPosition' => MultipleInput::POS_FOOTER,
    'allowEmptyList'    => true,
    'addButtonOptions' => [
        'class' => 'btn redbtn project-create-custom-btn',
        'label' => 'Добавить поле'
    ],
    'removeButtonOptions' => [
        'class' => 'btn redbtn project-create-custom-btn',
        'label' => 'Удалить поле'
    ],
    'columns' => [
        [
            'name' => 'name',
            'title' => '',
            'options' => [
                'required' => 'required',
                'placeholder' => 'Название поля',
                'class' => 'project-create-custom-field-name'
            ],
            'columnOptions' => [
                    'class' => 'project-create-custom-field-name-wrapper'
            ],
        ],
        [
            'name' => 'value',
            'title' => '',
            'options' => [
                'required' => 'required',
                'class' => 'project-create-custom-field-value'
            ]
        ]
    ]
])
    ->label(false);
?>

<div class="project-create-textarea-wrapper">
    <p><?= $model->getAttributeLabel('description') ?> (максимум 2000 символов)</p><div class="form-group field-addprojectform-description">
        <?= $form->field($model, 'description')->textarea(['rows' => 6])->label(false) ?>
        <p class="help-block help-block-error"></p>
    </div>
</div>


<?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'redbtn']) ?>
<?= Html::a(Html::button('Назад', ['class' => 'project-form-back']), Url::to('/')) ?>

<?php \yii\widgets\ActiveForm::end(); ?>