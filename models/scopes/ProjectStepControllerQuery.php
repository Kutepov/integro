<?php

namespace app\models\scopes;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\ProjectSteps]].
 *
 * @see \app\models\ProjectSteps
 */
class ProjectStepControllerQuery extends ActiveQuery
{
    /**
     * @param false $term
     * @return ProjectStepControllerQuery
     */
    public function templates($term = false)
    {
        if ($term) {
            $this->andWhere(['like', 'name', $term]);
        }
        return $this->andWhere(['is_template' => true]);
    }
}
