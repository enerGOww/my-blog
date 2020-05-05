<?php

namespace app\traits;

use app\model\ImageUploader;

/**
 * Used to model which work with images for deleting image after deleting model
 * you need call $this->deleteImage(); in beforeDelete
 */
trait ImageTrait
{
    public function saveImage(string $fileName): bool
    {
        $this->image = $fileName;
        return $this->save(false);
    }

    public function deleteImage(): void
    {
        $imageUploader = new ImageUploader();
        $imageUploader->deleteCurrentImage($this->image);
    }

    public function getImage(): string
    {
        return $this->image ? '/uploads/' . $this->image : '/uploads/' . '/no-image.png';
    }
}
