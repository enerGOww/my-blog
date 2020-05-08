<?php

namespace app\entity;

interface EntityImageInterface
{
    /**
     * @param string $fileName
     * @return bool
     */
    public function saveImage(string $fileName): bool;

    public function deleteImage(): void;

    /**
     * @return string
     */
    public function getImage(): string;
}
