<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
<?= $this->renderPhpFile(__DIR__.DIRECTORY_SEPARATOR.'_header.php'); ?>
<div class="container main-wrapper">
    <div style="width: 63%; margin: auto;">
        <div style="width: 100%; margin: auto;">
            <?= Alert::widget() ?>
            <?= $this->renderPhpFile(__DIR__.DIRECTORY_SEPARATOR.'_project_menu.php'); ?>
            <div style="width: 77%; color: #2f475b; display: inline-block; vertical-align: top; min-height: 73vh;">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
<?= $this->renderPhpFile(__DIR__.DIRECTORY_SEPARATOR.'_footer.php'); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
