<?php
/**
 * @var $this yii\web\View
 */

use yii\helpers\Url;

$this->title = 'Зарубежные проекты';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Тут будет карта</h1>
    </div>
</div>


<?php $this->beginBlock('control_buttons_page'); ?>
<div class="footer-control-button fbc-second"">
    <a href="<?= Url::toRoute('project/index') ?>">
        <p><span>Список проектов</span><i class="fa fa-pencil" aria-hidden="true"></i></p>
    </a>
</div>
<div class="footer-control-button fbc-first">
    <a href="<?= Url::toRoute('project/create') ?>">
        <p><span>Добавить проект</span><i class="fa fa-pencil" aria-hidden="true"></i></p>
    </a>
</div>

<?php
//Изображения для футера с кнопкой
$this->registerJs('$(".footerHalf").addClass("footerHalf2")');

$this->endBlock();
?>