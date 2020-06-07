<?php
/**
 * @var $this \yii\web\View
 * @var $project \app\models\Projects
 * @var $gallery \app\models\Gallery;
 * @var $edit bool
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Галерея';
$this->registerJsFile('/js/gallery/main.js');
?>

<?= $this->render('/project/_title', ['model' => $project]) ?>

<?php if ($edit): ?>
    <div class="alert alert-success">
        Редактирование
        <a href="gallery" class="gallery-finish-edit-link text-success">Завершить <span class="fa fa-check"></span></a>
    </div>

    <?php
    Pjax::begin(['id' => 'form-pjax', 'timeout' => 60000]);
    echo $this->render('_form', ['model' => $gallery, 'project' => $project]);
    Pjax::end();
    ?>

<?php endif; ?>

<?php Pjax::begin(['id' => 'gallery']); ?>
<?php if (!$project->gallery): ?>
    <h1>Галерея пуста</h1>
<?php else: ?>
    <div id="lightgallery">
        <?= $this->render($edit ? '_edit_items' : '_view_items', ['items' => $project->gallery]) ?>
    </div>
<?php endif; ?>
<?php Pjax::end(); ?>

<?php if (!$edit): ?>
    <?php $this->beginBlock('control_buttons_page'); ?>
        <div class="footer-control-button fbc-first">
            <a href="<?= Url::toRoute(['/project/gallery', 'id' => $project->id, 'edit' => 'true']) ?>">
                <p><span>Редактировать</span></p>
            </a>
        </div>
    <?php
    //Изображения для футера с кнопкой
    $this->registerJs('$(".footerHalf").addClass("footerHalf2")');
    $this->endBlock();
endif;
?>