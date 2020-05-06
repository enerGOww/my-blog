<?php

namespace app\service;

use yii\data\Pagination;
use yii\db\ActiveRecord;

class PaginationService
{
    /**
     * @param string $className
     * @param int $pageSize
     * @return ActiveRecord[]
     */
    public function getPagination(string $className, int $pageSize = 5): array
    {
        /** @var ActiveRecord $className */
        $query = $className::find();
        $count = $query->count();

        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);

        $records = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return array($pagination, $records);
    }
}
