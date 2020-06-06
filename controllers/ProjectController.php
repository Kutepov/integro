<?php

namespace app\controllers;

use app\models\DocumentsFolders;
use app\models\Projects;
use app\models\ProjectsCustomFields;
use app\models\ProjectsSearch;
use app\models\ProjectStepsStatuses;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Cookie;

class ProjectController extends BaseController
{
    public $layout = 'project';

    public function beforeAction($action)
    {
        if (Yii::$app->request->get('id')) {
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'projectId',
                'value' => Yii::$app->request->get('id')
            ]));
        }
        return parent::beforeAction($action);
    }

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
                if (Yii::$app->request->post('Projects')['customFields']) {
                    foreach (Yii::$app->request->post('Projects')['customFields'] as $field) {
                        $modelField = new ProjectsCustomFields();
                        $modelField->name = $field['name'];
                        $modelField->value = $field['value'];
                        $modelField->project_id = $model->id;
                        $modelField->save();
                    }
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
                if (Yii::$app->request->post('Projects')['customFields']) {
                    foreach (Yii::$app->request->post('Projects')['customFields'] as $field) {
                        $modelField = new ProjectsCustomFields();
                        $modelField->name = $field['name'];
                        $modelField->value = $field['value'];
                        $modelField->project_id = $model->id;
                        $modelField->save();
                    }
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

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionRoadMap($id, $edit = false)
    {
        $project = Projects::findOne($id);
        $statuses = ProjectStepsStatuses::find()->orderBy(['id' => SORT_ASC])->all();

        if (!$project) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        $edit = (bool)$edit;
        return $this->render('road-map\index', compact('project', 'statuses', 'edit'));
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDocuments($id)
    {
        $project = Projects::findOne($id);

        if (!$project) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $this->render('documents\index', compact('project'));
    }
}
