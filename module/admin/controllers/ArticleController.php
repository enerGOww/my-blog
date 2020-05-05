<?php

namespace app\module\admin\controllers;

use app\command\SaveImageCommand;
use app\model\ImageUploader;
use app\repository\ArticleRepository;
use Yii;
use app\entity\Article;
use app\search\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /** @var SaveImageCommand */
    private $saveImageCommand;

    /** @var ArticleRepository */
    private $articleRepository;

    public function __construct(
        $id,
        $module,
        SaveImageCommand $saveImageCommand,
        ArticleRepository $articleRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->saveImageCommand = $saveImageCommand;
        $this->articleRepository = $articleRepository;
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
        $this->articleRepository->findModelById($id)->delete();

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
            if ($this->saveImageCommand->execute($imageModel, $id)) {
                return $this->redirect(['view', 'id' => $id]);
            }
        }
        return $this->render('image', compact('imageModel'));
    }
}
