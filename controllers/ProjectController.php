<?php

namespace app\controllers;

use app\models\Projects;
use app\models\ProjectsCustomFields;
use app\models\ProjectsSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $this->layout = 'main';
        $model = new Projects();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->save()) {
                foreach (Yii::$app->request->post('Projects')['customFields'] as $field) {
                    $modelField = new ProjectsCustomFields();
                    $modelField->name = $field['name'];
                    $modelField->value = $field['value'];
                    $modelField->project_id = $model->id;
                    $modelField->save();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', compact('model'));
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = Projects::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Проект не найден');
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->save()) {
                ProjectsCustomFields::clearByProject($model->id);
                foreach (Yii::$app->request->post('Projects')['customFields'] as $field) {
                    $modelField = new ProjectsCustomFields();
                    $modelField->name = $field['name'];
                    $modelField->value = $field['value'];
                    $modelField->project_id = $model->id;
                    $modelField->save();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', compact('model'));
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
