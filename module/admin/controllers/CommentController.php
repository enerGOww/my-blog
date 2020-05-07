<?php

namespace app\module\admin\controllers;

use app\repository\CommentRepository;
use Yii;
use app\module\admin\search\CommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends Controller
{
    /** @var CommentRepository */
    private $commentRepository;

    public function __construct(
        $id,
        $module,
        CommentRepository $commentRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Comment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Comment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->commentRepository->findModelById($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionDelete(int $id)
    {
        $this->commentRepository->deleteById($id);

        return $this->redirect(['index']);
    }
}
