<?php
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\helpers\Html;
?>

<div class="wrap">
    <div class="headerInner">
        <a href="<?= Yii::$app->homeUrl ?>" title="Главная">
            <img src="<?= Url::to('@web/img/') ?>rrr_logo.png" id="header_logo" height="45" alt="" width="100" border="0" />
        </a>
        <div id="header_text">
            <span>Зарубежные проекты</span>
        </div>
        <?php if (!Yii::$app->user->isGuest): ?>
            <form action="/search" method="get" class="search-form example-5">
                <input type="text" id="qwert" name="r" value="" size="15" maxlength="50" class="form-control" />
                <label for="s" class="filupp">
                    <span class="filupp-file-name js-value"> Поиск</span>
                    <input id="s" type="submit" value="Поиск">
                </label>
            </form>
        <?php endif; ?>

        <?=  Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/site/login']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Выйти (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);

        ?>
    </div>
</div>