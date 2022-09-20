<?php

declare(strict_types=1);

namespace frontend\helpers;

use Yii;
use yii\helpers\FileHelper;

class BannerHelper
{
    public array $bannersNames = [];
    public array $carouselData = [];

    /**
     * @return array|null
     */
    public static function getBannerNames(): array|null
    {
        $banners = FileHelper::findFiles(Yii::getAlias('@frontend') . '/web/img/banners', ['only' => ['*.png', '*.jpg', '*.jpeg']]);
        foreach ($banners as $key => $banner) {
            $bannersNames[$key] = (basename($banner));
        }
        if (isset($bannersNames[0]))
        {
            sort($bannersNames);

            return $bannersNames;
        }

        return null;
    }

    /**
     * @return array|null
     */
    public static function getCarouselData(): array|null
    {
        $bannerNames = self::getBannerNames();
        if ($bannerNames !== null) {
        foreach ($bannerNames as $key => $name) {
            $carouselData[$key]['content'] = '<img class=banner src=' . Yii::getAlias('@frontendUrl') .'/img/banners/' . $name . ' />';
        }
            return $carouselData;
        }

        return null;
    }
}
