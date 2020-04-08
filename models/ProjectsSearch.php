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
        return [
            [['country_name'], 'safe']
        ];
    }

    public function search($params)
    {
        $query = self::find()->joinWith('country')->joinWith('type')->orderBy(['countries.name' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
