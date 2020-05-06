<?php

namespace app\controllers;

use app\entity\Article;
use app\repository\ArticleRepository;
use app\repository\CategoryRepository;
use app\repository\TagRepository;
use app\service\PaginationService;
use yii\web\Controller;
use yii\filters\VerbFilter;

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
            'verbs' => [
                'class' => VerbFilter::class,
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
     * @throws
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

    /**
     * @param int $id
     * @return string
     */
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
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
