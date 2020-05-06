<?php

namespace app\controllers;

use app\entity\Article;
use app\repository\ArticleRepository;
use app\repository\CategoryRepository;
use app\repository\TagRepository;
use app\service\PaginationService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\form\LoginForm;

class SiteController extends Controller
{
    /** @var PaginationService */
    private $paginationService;

    /** @var ArticleRepository */
    private $articleRepository;

    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var TagRepository */
    private $tagRepository;

    public function __construct(
        $id,
        $module,
        PaginationService $paginationService,
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->paginationService = $paginationService;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        list($pagination, $articles) = $this->paginationService->getPagination(Article::class);

        $populars = $this->articleRepository->findThreeOrderByViewedDesc();
        $recents = $this->articleRepository->findFourOrderByDateDesc();
        $categories = $this->categoryRepository->findAll();

        return $this->render('index', compact(
            'articles',
            'pagination',
            'populars',
            'recents',
            'categories'
        ));
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionArticle(int $id)
    {
        $article = $this->articleRepository->findModelById($id);

        $populars = $this->articleRepository->findThreeOrderByViewedDesc();
        $recents = $this->articleRepository->findFourOrderByDateDesc();
        $categories = $this->categoryRepository->findAll();

        return $this->render('article', compact(
            'article',
            'populars',
            'recents',
            'categories'
        ));
    }

    public function actionCategory(int $id)
    {
        list($pagination, $articles) = $this->paginationService
            ->getPagination(Article::class, ['category_id' => $id]);

        $populars = $this->articleRepository->findThreeOrderByViewedDesc();
        $recents = $this->articleRepository->findFourOrderByDateDesc();
        $categories = $this->categoryRepository->findAll();

        return $this->render('category', compact(
            'articles',
            'pagination',
            'populars',
            'recents',
            'categories'
        ));
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionTag(int $id)
    {
        $tag = $this->tagRepository->findModelById($id);

        return $this->render('tag', compact('tag'));
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
