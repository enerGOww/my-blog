<?php

namespace app\command;

use app\model\ImageUploader;
use app\repository\ArticleRepository;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class SaveImageCommand
{
    /** @var ArticleRepository */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param ImageUploader $imageModel
     * @param int $id
     * @return bool
     * @throws NotFoundHttpException
     */
    public function execute(ImageUploader $imageModel, int $id): bool
    {
        $article = $this->articleRepository->findModelById($id);
        $image = UploadedFile::getInstance($imageModel, 'image');
        $imageName = $imageModel->uploadFile($image, $article->image);
        return $article->saveImage($imageName);
    }
}
