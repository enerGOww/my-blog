<?php

namespace app\module\admin\controllers;

use app\repository\CategoryRepository;
use Yii;
use app\entity\Category;
use app\search\CategorySearch;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /** @var CategoryRepository */
    private $categoryRepository;

    public function __construct(
        $id,
        $module,
        CategoryRepository $categoryRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->categoryRepository = $categoryRepository;
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->categoryRepository->findModelById($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $category = new Category();

        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            return $this->redirect(['view', 'id' => $category->id]);
        }

        return $this->render('create', [
            'model' => $category,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     */
    public function actionUpdate($id)
    {
        $category = $this->categoryRepository->findModelById($id);

        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            return $this->redirect(['view', 'id' => $category->id]);
        }

        return $this->render('update', [
            'model' => $category,
        ]);
    }

    /**
     * @param $id
     * @return Response
     * @throws
     */
    public function actionDelete($id)
    {
        $this->categoryRepository->findModelById($id)->delete();

        return $this->redirect(['index']);
    }
}
