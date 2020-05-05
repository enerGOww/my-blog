<?php

namespace app\model;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUploader extends Model
{
    /** @var UploadedFile */
    public $image;

    public function rules()
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg,png']
        ];
    }

    /**
     * @param UploadedFile $image
     * @param string|null $currentImageName
     * @return string
     */
    public function uploadFile(UploadedFile $image, ?string $currentImageName): ?string
    {
        $this->image = $image;

        if ($this->validate()) {
            $this->deleteCurrentImage($currentImageName);

            return $this->saveImage();
        }
        return null;
    }

    /**
     * @param string|null $currentImageName
     */
    public function deleteCurrentImage(?string $currentImageName): void
    {
        if ($currentImageName !== null && file_exists($this->getFolder() . $currentImageName)) {
            unlink($this->getFolder() . $currentImageName);
        }
    }

    private function getFolder(): string
    {
        return Yii::getAlias('@web') . 'uploads/';
    }

    private function generateFileName(): string
    {
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    private function saveImage(): string
    {
        $fileName = $this->generateFileName();
        $this->image->saveAs($this->getFolder() . $fileName);
        return $fileName;
    }
}
