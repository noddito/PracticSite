<?php

declare(strict_types=1);

namespace backend\helpers;

use Yii;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * EditPhoto have functions for edit photo.
 */
class EditPhoto
{
    /**
     * @param UploadedFile|null $image
     * @param string $photoPath
     * @param string $miniaturePath
     * @return bool|string
     */
    public static function savePhoto(UploadedFile|null $image, string $photoPath, string $miniaturePath): bool|string
    {
        $alias = Yii::getAlias('@frontend');
        $imageName = $image->baseName . uniqid('', false) . '.' . $image->extension;
        $image->saveAs($alias . $photoPath . $imageName);
        $image = $alias . $photoPath . $imageName;
        Image::resize($image, 100, 100, false)
            ->save(($alias . $miniaturePath . $imageName), ['quality' => 80]);

        return $imageName;
    }

    /**
     * @param string $imageName
     * @param string $photoPath
     * @param string $miniaturePath
     * @return void
     */
    public static function deletePhoto(string $imageName, string $photoPath, string $miniaturePath): void
    {
        if ($imageName !== '') {
            unlink(Yii::getAlias('@frontend') . $photoPath . $imageName);
            unlink(Yii::getAlias('@frontend') . $miniaturePath . $imageName);
        }
    }
}
