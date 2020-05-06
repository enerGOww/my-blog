<?php

namespace app\repository;

use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class BaseModelRepository
{
    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $modelName
     * @return ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function getModel(string $modelName, int $id): ActiveRecord
    {
        /** @var $modelName ActiveRecord */
        if (($model = $modelName::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param ActiveRecord $model
     * @return bool
     */
    public function save(ActiveRecord $model): bool
    {
        return $model->save();
    }

    /**
     * @param ActiveRecord $model
     * @return bool
     * @throws
     */
    public function delete(ActiveRecord $model): bool
    {
        return (bool) $model->delete();
    }
}
