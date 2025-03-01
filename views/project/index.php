<?php
/**
 * @var $this yii\web\View
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Зарубежные проекты';
Pjax::begin();
echo \yii\grid\GridView::widget([
    'id' => 'list-projects',
    'layout' => "{items}\n{pager}",
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'country_id',
            'value' => function ($model) {
                /** @var \app\models\Projects $model */
                return $model->country->name;
            },
            'enableSorting' => false
        ],
        [
            'attribute' => 'name',
            'header' => 'Проект'
        ],
        [
            'attribute' => 'type_id',
            'value' => function ($model) {
                /** @var \app\models\Projects $model */
                return $model->type->name;
            },
            'enableSorting' => false
        ],
        [
            'format' => 'raw',
            'value' => function ($model) {
                /** @var \app\models\Projects $model */
                return '<a href=" '.Url::toRoute(['view', 'id' => $model->id]).'">
						<input class="button-go-to-project" type="button" value="Подробнее">
					</a>';
            }
        ]
    ]
]);
Pjax::end();

$this->beginBlock('control_buttons_page'); ?>
<div class="footer-control-button fbc-first">
    <a href="<?= Url::toRoute('/') ?>">
        <p><span>Карта</span></p>
    </a>
</div>

<?php
//Изображения для футера с кнопкой
$this->registerJs('$(".footerHalf").addClass("footerHalf2")');

$this->endBlock();
?>