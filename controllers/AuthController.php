<?php

namespace app\controllers;

use app\form\LoginForm;
use app\form\SignupForm;
use app\service\LoginUserVkService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    /** @var LoginUserVkService */
    private $loginVkService;

    public function __construct(
        $id,
        $module,
        LoginUserVkService $loginUserVkService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->loginVkService = $loginUserVkService;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLoginVk(int $uid, string $first_name, string $photo)
    {
        if ($this->loginVkService->loginUserAndSaveIfNew($uid, $first_name, $photo)) {
            return $this->redirect(['site/index']);
        }

        return $this->redirect(['auth/login']);
    }
}
