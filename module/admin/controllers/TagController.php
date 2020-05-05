<?php

namespace app\module\admin\controllers;

use app\repository\TagRepository;
use Yii;
use app\entity\Tag;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
{
    /** @var TagRepository */
    private $tagRepository;

    public function __construct(
        $id,
        $module,
        TagRepository $tagRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
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
     * Lists all Tag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tag::find(),
        ]);

        return $this->render('index', [
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
            'model' => $this->tagRepository->findModelById($id),
        ]);
    }

    /**
     * Creates a new Tag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $tag = new Tag();

        if ($tag->load(Yii::$app->request->post()) && $tag->save()) {
            return $this->redirect(['view', 'id' => $tag->id]);
        }

        return $this->render('create', [
            'model' => $tag,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     */
    public function actionUpdate($id)
    {
        $tag = $this->tagRepository->findModelById($id);

        if ($tag->load(Yii::$app->request->post()) && $tag->save()) {
            return $this->redirect(['view', 'id' => $tag->id]);
        }

        return $this->render('update', [
            'model' => $tag,
        ]);
    }

    /**
     * @param $id
     * @return Response
     * @throws
     */
    public function actionDelete($id)
    {
        $this->tagRepository->findModelById($id)->delete();

        return $this->redirect(['index']);
    }
}
