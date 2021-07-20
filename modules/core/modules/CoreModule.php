<?php

namespace app\modules\core\modules;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Module;

/**
 * Class CoreModule
 * @package app\core\modules
 */
abstract class CoreModule extends Module implements BootstrapInterface
{
    public function init()
    {
        parent::init();

        $this->setChildModules();
    }

    /**
     * @return void
     */
    public function setChildModules(): void
    {
        $childModules = $this->getChildModules();

        $this->setModules($childModules);

        foreach ($childModules as $name => $class) {
            $this->getModule($name, $class)->bootstrap(Yii::$app);
        }
    }

    /**
     * @return array
     */
    public function getChildModules(): array
    {
        return [];
    }
}