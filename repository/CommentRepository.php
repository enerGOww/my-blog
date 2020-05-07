<?php

namespace app\repository;

use app\entity\Comment;
use yii\web\NotFoundHttpException;

class CommentRepository extends BaseModelRepository
{
    /**
     * @param int $id
     * @return Comment
     * @throws NotFoundHttpException
     */
    public function findModelById(int $id): Comment
    {
        /** @var Comment $model */
        $model = $this->getModel(Comment::class, $id);
        return $model;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        $model = Comment::findOne($id);
        if ($model !== null) {
            return $this->delete($model);
        }

        return true;
    }

    public function findAllByArticleId(int $articleId): array
    {
        return Comment::find()
            ->where(['article_id' => $articleId])
            ->orderBy('id ASC')
            ->all();
    }
}
