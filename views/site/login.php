<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Авторизация';
?>
<div class="site-login">
    <div>
        <div>
            <div id="sdf">
                <div>
                    <p class="login-title">Авторизация</p>
                    <div class="login-empty-div"></div>
                    <p class="login-tip">Чтобы воспользоваться сервисом, введите <br/>логин и пароль</p>
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'layout' => 'horizontal',
                        'fieldConfig' => [
                            'template' => "{input}\n<div class='login-error'>{error}</div>",
                            'labelOptions' => ['class' => 'col-lg-1 control-label'],
                        ],
                    ]);  ?>
                    <div class="input-container login-wrapper-username">
                        <i class="fa fa-user icon" aria-hidden="true"></i>
                        <?= $form->field($model, 'username', [
                                'enableLabel' => false,
                                'inputOptions' =>
                                    ['autocomplete' => 'nope']
                                ])->textInput([
                                        'autocomplete' => 'off',
                                        'autofocus' => true,
                                        'placeholder' => 'Логин',
                                        'class'=>'inputLogin']); ?>
                    </div>
                    <div class="input-container login-wrapper-password">
                        <i class="fas fa-key" aria-hidden="true"></i>
                        <?= $form->field($model, 'password',[
                                'enableLabel' => false,
                                'inputOptions' => [
                                        'autocomplete' => 'nope']
                                ])->passwordInput([
                                        'autocomplete' => 'nope',
                                        'placeholder' => 'Пароль',
                                        'class'=>'inputLogin']); ?>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11 login-submit-button">
                            <?= Html::submitButton('Войти', [
                                    'class' => 'btn btn-primary redSubmitButton',
                                    'name' => 'login-button']) ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
