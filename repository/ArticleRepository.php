<?php

namespace app\repository;

use app\entity\Article;
use yii\web\NotFoundHttpException;

class ArticleRepository extends AbstractModelRepository
{
    /**
     * @param int $id
     * @return Article
     * @throws NotFoundHttpException
     */
    public function findModelById(int $id): Article
    {
        /** @var Article $model */
        $model = $this->getModel(Article::class, $id);
        return $model;
    }
}
