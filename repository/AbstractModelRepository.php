<?php

namespace app\repository;

use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

abstract class AbstractModelRepository
{
    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $modelName
     * @return ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function getModel(string $modelName, int $id): ActiveRecord
    {
        if (($model = $modelName::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
