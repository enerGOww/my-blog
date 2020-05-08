<?php

namespace app\module\admin\controllers;

use app\service\SaveImageService;
use app\model\ImageUploader;
use app\repository\ArticleRepository;
use app\repository\CategoryRepository;
use app\repository\TagRepository;
use Yii;
use app\entity\Article;
use app\module\admin\search\ArticleSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /** @var SaveImageService */
    private $saveImageService;

    /** @var ArticleRepository */
    private $articleRepository;

    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var TagRepository */
    private $tagRepository;

    public function __construct(
        $id,
        $module,
        SaveImageService $saveImageService,
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->saveImageService = $saveImageService;
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->articleRepository->findModelById($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $this->articleRepository->save($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->articleRepository->findModelById($id);

        if ($model->load(Yii::$app->request->post()) && $this->articleRepository->save($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return Response
     * @throws
     */
    public function actionDelete(int $id)
    {
        $this->articleRepository->deleteById($id);

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return string
     * @throws
     */
    public function actionSetImage(int $id)
    {
        $imageModel = new ImageUploader();
        if (Yii::$app->request->isPost) {
            $article = $this->articleRepository->findModelById($id);
            if ($this->saveImageService->save($imageModel, $article)) {
                return $this->redirect(['view', 'id' => $id]);
            }
        }
        return $this->render('image', compact('imageModel'));
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionSetCategory(int $id)
    {
        $article = $this->articleRepository->findModelById($id);

        if (Yii::$app->request->isPost) {
            $categoryId = Yii::$app->request->post('category');
            $article->category_id = $categoryId;
            if ($this->articleRepository->save($article)) {
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }

        $selectedCategory = $article->category_id;
        $categories = ArrayHelper::map($this->categoryRepository->findAll(), 'id', 'title');
        return $this->render('category', compact('article', 'selectedCategory', 'categories'));
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSetTags(int $id)
    {
        $article = $this->articleRepository->findModelById($id);

        if (Yii::$app->request->post()) {
            $tagIds = Yii::$app->request->post('tags');
            $tags = $this->tagRepository->findAllTagsByIds($tagIds);
            $article->saveTags($tags);
            $this->redirect(['view', 'id' => $article->id]);
        }

        $selectedTags = $this->tagRepository->findAllIdsByArticleId($id);
        $tags = ArrayHelper::map($this->tagRepository->findAll(), 'id', 'title');
        return $this->render('tags', compact('article', 'selectedTags', 'tags'));
    }
}
