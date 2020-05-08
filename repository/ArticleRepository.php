<?php

namespace app\repository;

use app\entity\Article;
use yii\web\NotFoundHttpException;

class ArticleRepository extends BaseModelRepository
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

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        $model = Article::findOne($id);
        if ($model !== null) {
            return $this->delete($model);
        }

        return true;
    }

    /**
     * @return Article[]
     */
    public function findThreePublishedOrderByViewedDesc(): array
    {
        return Article::find()
            ->where(['status' => Article::PUBLISHED])
            ->orderBy('viewed desc')
            ->limit(3)
            ->all();
    }

    /**
     * @return Article[]
     */
    public function findFourPublishedOrderByDateDesc(): array
    {
        return Article::find()
            ->where(['status' => Article::PUBLISHED])
            ->orderBy('date desc')
            ->limit(4)
            ->all();
    }
}
