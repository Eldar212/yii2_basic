<?php

namespace app\modules\swagger\actions;

use OpenApi\Annotations\OpenApi;
use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\base\Response;
use yii\caching\Cache;
use yii\di\Instance;
use function OpenApi\scan;

/**
 * Class OpenAPIRenderer is responsible for generating the JSON spec.
 */
class SwaggerSchemaRender extends Action
{
    /** @var string|array */
    public $scanDir;

    /** @var array */
    public $scanOptions = [];

    /** @var Cache|array|string */
    public $cache = 'cache';

    /** @var int */
    public $cacheDuration = 86400;

    /** @var string */
    public $cacheKey = 'api-swagger-cache';

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();

        if($this->cache !== null) {
            $this->cache = Instance::ensure($this->cache, Cache::class);
        }
    }

    /**
     * @inheritdoc
     */
    public function run(): Response
    {
        $this->enableCORS();

        return $this->controller->asJson($this->getSwaggerDocumentation());
    }

    /**
     * @return OpenApi
     */
    protected function getSwaggerDocumentation(): OpenApi
    {
        if(!$this->cache instanceof Cache) {
            return scan($this->scanDir, $this->scanOptions);
        }

        return $this->cache->getOrSet(
            $this->cacheKey,
            function() {
                return scan($this->scanDir, $this->scanOptions);
            },
            $this->cacheDuration
        );
    }

    /**
     * Enable CORS
     */
    protected function enableCORS(): void
    {
        $headers = Yii::$app->getResponse()->getHeaders();

        $headers->set('Access-Control-Allow-Headers', 'Content-Type, api_key, Authorization');
        $headers->set('Access-Control-Allow-Methods', 'GET, POST, DELETE, PUT');
        $headers->set('Access-Control-Allow-Origin', '*');
    }
}
