<?php

    namespace app\components;

    use Yii;
    use yii\base\Exception;

    class securityHelper
    {
        /**
         * @param string $password
         * @return string
         * @throws \yii\base\Exception
         */

        public static function generatePasswordHash (string $password): string
        {
            return \Yii::$app->security->generatePasswordHash(password);
        }
    }