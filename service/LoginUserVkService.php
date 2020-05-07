<?php

namespace app\service;

use app\entity\User;
use app\repository\UserRepository;
use Yii;

class LoginUserVkService
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loginUserAndSaveIfNew(int $id, string $name, string $image): bool
    {
        $user = $this->userRepository->findOneById($id);
        if ($user) {
            return Yii::$app->user->login($user);
        }

        $user = new User();
        $user->name = $name;
        $user->id = $id;
        $user->image = $image;
        $user->setPassword($id);
        $user->generateAuthKey();
        $this->userRepository->save($user);

        return Yii::$app->user->login($user);
    }
}
