<?php

namespace app\controllers;

use app\entity\Article;
use app\form\CommentForm;
use app\repository\ArticleRepository;
use app\repository\CategoryRepository;
use app\repository\CommentRepository;
use app\repository\TagRepository;
use app\service\PaginationService;
use app\service\SaveCommentService;
use Yii;
use yii\base\InvalidConfigException;
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

    /** @var SaveCommentService */
    private $saveCommentService;

    /** @var CommentRepository */
    private $commentRepository;

    public function __construct(
        $id,
        $module,
        PaginationService $paginationService,
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        SaveCommentService $saveCommentService,
        CommentRepository $commentRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->paginationService = $paginationService;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->saveCommentService = $saveCommentService;
        $this->commentRepository = $commentRepository;
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
        $comments = $this->commentRepository->findAllByArticleId($id);
        $commentForm = new CommentForm();

        $article->viewed++;
        $this->articleRepository->save($article);

        return $this->render('article', compact(
            'article',
            'populars',
            'recents',
            'categories',
            'commentForm',
            'comments'
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
     * @throws InvalidConfigException
     */
    public function actionTag(int $id)
    {
        $tag = $this->tagRepository->findModelById($id);
        list($pagination, $articles) = $this->paginationService->getPaginationForM2m($tag->getArticles());

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
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionComment(int $articleId)
    {
        $form = new CommentForm();
        if (
            Yii::$app->request->isPost
            && $form->load(Yii::$app->request->post())
            && $this->saveCommentService->saveCommentByFormAndArticleId($form, $articleId)
        ) {
            Yii::$app->getSession()->setFlash('success', 'Comment added successfully');
            return $this->redirect(['article', 'id' => $articleId]);
        }

        Yii::$app->getSession()->setFlash('error', 'Your comment not safe. Something went wrong');
        return $this->redirect(['article', 'id' => $articleId]);
    }
}
