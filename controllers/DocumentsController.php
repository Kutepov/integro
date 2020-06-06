<?php

namespace app\controllers;

use app\models\Documents;
use app\models\DocumentsFolders;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DocumentsController extends BaseController
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
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
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionCreateFolder()
    {
        $model = new DocumentsFolders();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->returnData('Success');
        }

        Yii::$app->response->statusCode = 400;
        return [
            'status' => Yii::$app->response->statusCode,
            'name' => 'Bad data',
            'message' => $model->getErrors()
        ];
    }

    /**
     * @return array
     * @throws \yii\base\Exception
     */
    public function actionDocumentUpload()
    {
        $model = new Documents();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save() && $model->upload()) {
                return $this->returnData();
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
    public function actionEdit($object)
    {
        $model = $this->loadModel($object);
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
    public function actionDelete($object)
    {
        $model = $this->loadModel($object);
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
     * @return Documents|DocumentsFolders
     * @throws NotFoundHttpException
     */
    private function loadModel($object)
    {
        $id = Yii::$app->request->post($object)['id'];
        $object = 'app\models\\'.$object;
        $model = $object::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Object not found');
        }
        return $model;
    }
}
