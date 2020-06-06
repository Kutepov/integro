<?php

namespace app\controllers;

use app\models\ProjectSteps;
use app\models\ProjectStepsDocuments;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use \app\models\ProjectStepsDocumentsTypes;

class ProjectStepController extends BaseController
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
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionGetShortInfo($id)
    {
        $model = ProjectSteps::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Этап не найден');
        }

        $docTypes = ProjectStepsDocumentsTypes::find()->orderBy(['id' => SORT_ASC])->all();
        return $this->renderAjax('short-info', compact('model', 'docTypes'));
    }

    /**
     * @param string $type
     * @param null $related_step_id
     * @return string|Response
     */
    public function actionCreate($type = 'default', $related_step_id = null)
    {
        $model = new ProjectSteps();
        $project = $this->project;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->project_id = $project->id;

            if ($model->save() && $model->upload()) {
                $model->saveTemplateDocs();
                if ($type && $related_step_id) {
                    $model->updateRelations($type, (int)$related_step_id);
                }
                return $this->redirect(['/project/road-map', 'id' => $this->project->id, 'edit' => 'true']);
            }
        }

        return $this->render('create', compact('model', 'project'));
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionEdit($id)
    {
        $model = ProjectSteps::findOne($id);
        $project = $this->project;

        if (!$model) {
            throw new NotFoundHttpException('Этап не найден');
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save() && $model->upload()) {
                return $this->redirect(['/project/road-map', 'id' => $this->project->id, 'edit' => 'true']);
            }
        }

        return $this->render('create', compact('model', 'project'));
    }

    /**
     * @param $id
     * @return bool
     * @throws BadRequestHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteDoc($id)
    {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('Only ajax method');
        }

        $model = ProjectStepsDocuments::findOne($id);
        if (!$model) {
            return false;
        }

        if (FileHelper::unlink(Yii::getAlias('@webroot').$model->path)) {
            $model->delete();
        }

        return true;
    }

    /**
     * @param $term
     * @return array|\yii\db\ActiveRecord[]
     * @throws BadRequestHttpException
     */
    public function actionSearchTemplates($term)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('Only ajax request');
        }

        return ProjectSteps::find()->select(['value' => 'name', 'id'])->templates($term)->asArray()->all();
    }


    /**
     * @param $id
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionGetTemplateDocs($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('Only ajax method');
        }

        $model = ProjectSteps::findOne($id);

        if (!$model) {
            return [];
        }

        return [
            'docs1' => $model->getProjectStepsDocuments1()->select(['id', 'name', 'extension'])->asArray()->all(),
            'docs2' => $model->getProjectStepsDocuments2()->select(['id', 'name', 'extension'])->   asArray()->all()
        ];
    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = ProjectSteps::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Этап не найден');
        }

        if ($model->delete()) {
            return $this->redirect(['/project/road-map', 'id' => $this->project->id, 'edit' => 'true']);
        }

        return $this->redirect(['/project-step/edit', 'id' => $model->id]);
    }
}
