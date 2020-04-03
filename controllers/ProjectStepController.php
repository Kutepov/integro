<?php

namespace app\controllers;

use app\models\Projects;
use app\models\ProjectsCustomFields;
use app\models\ProjectsSearch;
use app\models\ProjectSteps;
use app\models\ProjectStepsStatuses;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProjectStepController extends Controller
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

    public function actionGetShortInfo($id)
    {
        $model = ProjectSteps::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Этап не найден');
        }

        $docTypes = \app\models\ProjectStepsDocumentsTypes::find()->orderBy(['id' => SORT_ASC])->all();
        return $this->renderAjax('short-info', compact('model', 'docTypes'));
    }
}
