<?php

namespace app\repository;

use app\entity\Category;

class CategoryRepository
{
    public function findAll()
    {
        return Category::find()->all();
    }
}
