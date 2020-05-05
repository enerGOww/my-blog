<?php

namespace app\repository;

use app\entity\Category;

class CategoryRepository extends AbstractModelRepository
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
}
