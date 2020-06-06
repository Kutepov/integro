<?php

namespace app\controllers;

use app\models\Projects;
use yii\web\Controller;
use Yii;

class BaseController extends Controller
{
    protected $project;

    public function __construct($id, $module, $config = [])
    {
        $this->project = Yii::$app->request->cookies['projectId'] ? Projects::findOne(Yii::$app->request->cookies['projectId']) : false;
        parent::__construct($id, $module, $config);
    }
}
