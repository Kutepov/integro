<?php
/**
 * @var $model \app\models\Projects
 * @var $this \yii\web\View
 */

use yii\helpers\ArrayHelper;
use app\models\ProjectsTypes;
use app\models\Countries;
use yii\jui\DatePicker;

$form = \yii\widgets\ActiveForm::begin();

$this->registerJsFile('/js/project-create-form.js', ['position' => \yii\web\View::POS_END]);
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

<div class="project-create-item-wrapper">
    <div class="project-create-label-wrapper"><p><?= $model->getAttributeLabel('country_id') ?></p></div>
    <div class="addProjectInputName project-create-short-field">
        <?= $form->field($model, 'country_id')
            ->dropDownList(
                ArrayHelper::map(Countries::find()->all(), 'id', 'name'),
                [
                    'class' => 'addProjectFormField',
                    'prompt' => 'Выберите страну'
                ])
            ->label(false) ?>
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
                    'dateFormat' => 'dd.MM.yyyy',
                    'options' => ['class' => 'addProjectFormField'],
                    'clientOptions' => ['changeMonth' => true, 'changeYear' => true,]
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
                    'dateFormat' => 'dd.MM.yyyy',
                    'options' => ['class' => 'addProjectFormField'],
                    'clientOptions' => ['changeMonth' => true, 'changeYear' => true,]
                ]
            )->label(false); ?>
    </div>
</div>

<div class="project-create-item-wrapper">
    <div class="project-create-label-wrapper"><p><?= $model->getAttributeLabel('ceo_id') ?></p></div>
    <div class="addProjectInput"> <?php
        echo $form->field($model, 'ceo_id')->hiddenInput()->label(false); ?>
        <div class="ui-widget">
            <select id="selCEO" class="combobox" onchange="setCEO();">
                <?php foreach (\app\models\Users::findAll(['role_id' => 4]) as $user):
                    $selected = $model->ceo_id == $user->id ? 'selected' : '';
                ?>
                    <option value=""></option>
                    <?= '<option "'.$selected.'" value="'.$user->id.'">'.$user->full_name.'</option>' ?>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<div class="project-create-item-wrapper">
    <div class="project-create-label-wrapper"><p><?= $model->getAttributeLabel('manager_id') ?></p></div>
    <div class="addProjectInput"> <?php
        echo $form->field($model, 'manager_id')->hiddenInput()->label(false); ?>
        <div class="ui-widget">
            <select id="selManager" class="combobox" onchange="setManager();">
                <?php foreach (\app\models\Users::findAll(['role_id' => 2]) as $user):
                    $selected = $model->manager_id == $user->id ? 'selected' : '';
                    ?>
                    <option value=""></option>
                    <?= '<option "'.$selected.'" value="'.$user->id.'">'.$user->full_name.'</option>' ?>
                <?php endforeach; ?>
            </select>
        </div>
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


<div class="project-create-textarea-wrapper">
    <p><?= $model->getAttributeLabel('description') ?> (максимум 2000 символов)</p><div class="form-group field-addprojectform-description">
        <?= $form->field($model, 'description')->textarea(['rows' => 6])->label(false) ?>
        <p class="help-block help-block-error"></p>
    </div>
</div>

<?php \yii\widgets\ActiveForm::end(); ?>