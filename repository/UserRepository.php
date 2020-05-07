<?php

namespace app\repository;

use app\entity\User;

class UserRepository extends BaseModelRepository
{
    public function findOneById(int $id): ?User
    {
        return User::findOne($id);
    }
}
