<?php

namespace app\modules\swagger\actions;

use yii\base\Action;
use yii\web\Response;

/**
 * Class SwaggerUIRenderer renders the UI (HTML/JS/CSS).
 *
 * @package yii2mod\swagger
 */
class SwaggerUIRenderer extends Action
{
    /**
     * @var string
     */
    public $restUrl;

    /**
     * @var string
     */
    public $view = '@module_swagger/views/default/index';

    /**
     * @var null|string|false
     */
    public $layout = false;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->controller->response->format = Response::FORMAT_HTML;
        $this->controller->layout = $this->layout;

        return $this->controller->render($this->view, [
            'restUrl' => $this->restUrl,
        ]);
    }
}
