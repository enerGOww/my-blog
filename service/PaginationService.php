<?php

namespace app\service;

use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class PaginationService
{
    /**
     * @param string $className
     * @param int $pageSize
     * @param array $whereCondition ['columnName' => condition]
     * @return ActiveRecord[]
     */
    public function getPagination(string $className, array $whereCondition = [], int $pageSize = 5): array
    {
        /** @var ActiveRecord $className */
        $query = $className::find()->orderBy('id DESC');

        return $this->getPaginationForActiveQuery($query, $whereCondition, $pageSize);
    }

    /**
     * @param ActiveQuery $link
     * @param int $pageSize
     * @param array $whereCondition ['columnName' => condition]
     * @return ActiveRecord[]
     */
    public function getPaginationForM2m(ActiveQuery $link, array $whereCondition = [], int $pageSize = 5): array
    {
        /** @var ActiveRecord $className */
        $query = $link->orderBy('id DESC');

        return $this->getPaginationForActiveQuery($query, $whereCondition, $pageSize);
    }

    /**
     * @param ActiveQuery $query
     * @param array $whereCondition
     * @param int $pageSize
     * @return array
     */
    private function getPaginationForActiveQuery(ActiveQuery $query, array $whereCondition = [], int $pageSize = 5)
    {
        foreach ($whereCondition as $column => $condition) {
            $query->where(["$column" => $condition]);
        }

        $count = $query->count();

        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);

        $records = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return array($pagination, $records);
    }
}
