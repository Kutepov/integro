<?php

namespace app\models\scopes;

/**
 * This is the ActiveQuery class for [[\app\models\ProjectSteps]].
 *
 * @see \app\models\ProjectSteps
 */
class ProjectStepControllerQuery extends \yii\db\ActiveQuery
{
    public function templates($term = false)
    {
        if ($term) {
            $this->andWhere(['like', 'name', $term]);
        }
        return $this->andWhere(['is_template' => true]);
    }
}
