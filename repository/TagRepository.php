<?php

namespace app\repository;

use app\entity\Tag;
use yii\db\Query;

class TagRepository extends AbstractModelRepository
{
    /**
     * @return Tag[]
     */
    public function findAll(): array
    {
        return Tag::find()->all();
    }

    /**
     * @param int $id
     * @return Tag
     * @throws
     */
    public function findModelById(int $id): Tag
    {
        /** @var Tag $model */
        $model = $this->getModel(Tag::class, $id);
        return $model;
    }

    /**
     * @param int $articleId
     * @return array
     */
    public function findAllIdsByArticleId(int $articleId): array
    {
        return (new Query())
            ->select('tag_id')
            ->from('article_tag')
            ->where(['article_id' => $articleId])
            ->column();
    }

    /**
     * @param array $ids
     * @return Tag[]
     */
    public function findAllTagsByIds(array $ids): array
    {
        return Tag::find()->where(['id' => $ids])->all();
    }
}
