<?php

namespace app\modules\swagger\assets;

use yii\web\AssetBundle;
use yii\web\View;

class SwaggerAsset extends AssetBundle
{
    public $sourcePath = '@module_swagger/views/assets';

    public $js = [
        'swagger-ui-bundle.js',
        'swagger-ui-standalone-preset.js',
    ];

    public $jsOptions = [
        'position' => View::POS_END,
    ];

    public $css = [
        'swagger-ui.css',
    ];
}
