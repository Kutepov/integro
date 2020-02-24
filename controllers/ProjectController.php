<?php

namespace app\controllers;

use app\models\Projects;
use app\models\ProjectsSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\forms\LoginForm;

class ProjectController extends Controller
{
    public $layout = 'project';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main';
        $searchModel = new ProjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', compact('dataProvider'));
    }

    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new Projects();
        return $this->render('create2', compact('model'));
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Projects::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Проект не найден');
        }

        return $this->render('view', compact('model'));
    }
}
