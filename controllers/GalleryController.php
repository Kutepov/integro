<?php

namespace app\controllers;

use app\models\Gallery;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class GalleryController extends BaseController
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax && Yii::$app->controller->action->id != 'create') {
            throw new BadRequestHttpException('Only ajax request');
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
     * @return array|Response
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new Gallery();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save() && $model->upload()) {
                return $this->redirect(Url::to(['/project/gallery', 'id' => $model->project_id, 'edit' => 'true']));
            }
        }

        Yii::$app->response->statusCode = 400;
        return $this->returnData('Bad data', $model->getErrors());
    }

    /**
     * @param $object
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionEdit()
    {
        $model = $this->loadModel();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->returnData('Success');
        }

        Yii::$app->response->statusCode = 400;
        return $this->returnData('Bad data', $model->getErrors());
    }

    /**
     * @param $object
     * @return array
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete()
    {
        $model = $this->loadModel();
        if ($model->delete()) {
            return $this->returnData('Success');
        }
        return $this->returnData('Error', 'Delete error');
    }

    /**
     * @param $name
     * @param $message
     * @return array
     */
    private function returnData($name = null, $message = null)
    {
        $result['status'] = Yii::$app->response->statusCode;
        if ($name) $result['name'] = $name;
        if ($message) $result['message'] = $message;
        return $result;
    }

    /**
     * @param $object
     * @return Gallery
     * @throws NotFoundHttpException
     */
    private function loadModel()
    {

        $id = Yii::$app->request->post('Gallery')['id'];
        $model = Gallery::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Object not found');
        }
        return $model;
    }
}
