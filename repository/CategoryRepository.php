<?php

namespace app\repository;

use app\entity\Category;

class CategoryRepository extends BaseModelRepository
{
    /**
     * @return array
     */
    public function findAll(): array
    {
        return Category::find()->all();
    }

    /**
     * @param int $id
     * @return Category
     * @throws
     */
    public function findModelById(int $id): Category
    {
        /** @var Category $model */
        $model = $this->getModel(Category::class, $id);
        return $model;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        $model = Category::findOne($id);
        if ($model !== null) {
            return $this->delete($model);
        }

        return true;
    }
}
