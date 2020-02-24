<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the search model class for table "projects".
 */
class ProjectsSearch extends Projects
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    public function search($params)
    {
        $query = self::find()->with('country')->with('type');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => [
                'pageSize' => 200
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
