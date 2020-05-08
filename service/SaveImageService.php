<?php

namespace app\service;

use app\entity\EntityImageInterface;
use app\model\ImageUploader;
use yii\web\UploadedFile;

class SaveImageService
{
    /**
     * @param ImageUploader $imageModel
     * @param EntityImageInterface $model
     * @return bool
     */
    public function save(ImageUploader $imageModel, EntityImageInterface $model): bool
    {
        $image = UploadedFile::getInstance($imageModel, 'image');
        $imageName = $imageModel->uploadFile($image, $model->image);
        return $model->saveImage($imageName);
    }
}
