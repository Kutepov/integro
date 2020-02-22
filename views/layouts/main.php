<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
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
                    <input id="s" type="button" onclick="getSearch();" value="Поиск">
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
<div class="container main-wrapper">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<footer >
    <div id="footerHalf-left" >
        <div class="footerHalf">
            <div style="">
                <p>Интерактивная карта зарубежных проектов «РЖД»</p>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
