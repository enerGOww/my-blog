<?php

namespace app\service;

use yii\data\Pagination;
use yii\db\ActiveRecord;

class PaginationService
{
    public function getPagination(string $className, int $pageSize): array
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
