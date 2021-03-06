<?php

namespace app\handlers;

use app\exceptions\ApiException;
use Error;
use Exception;
use yii\web\HttpException;
use yii\web\Response;

class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * @param Error|Exception $exception
     * @throws Exception
     */
    protected function renderException($exception)
    {
        $response = new Response([
            'format' => Response::FORMAT_JSON,
            'data' => $this->convertExceptionToArray($exception),
        ]);

        if($exception instanceof ApiException || $exception instanceof HttpException) {
            $response->setStatusCode($exception->statusCode);
        }

        $response->send();
    }

    /**
     * @param Exception $exception
     * @return array|string
     * @throws Exception
     */
    protected function convertExceptionToArray($exception)
    {
        $error = [
            'type' => $this->getClassName($exception),
            'message' => $exception->getMessage(),
            'errors' => [],
        ];

        if($exception instanceof ApiException) {
            foreach($exception->firstErrors as $name => $message) {
                $error['errors'][] = [
                    'name' => $name,
                    'message' => $message,
                ];
            }
        }

        if(YII_DEBUG === true) {
            $error['file'] = $exception->getFile();
            $error['line'] = $exception->getLine();
        }

        return $error;
    }

    /**
     * @param $class
     * @return bool|string
     */
    private function getClassName($class)
    {
        $class = get_class($class);
        if($pos = strrpos($class, '\\')) {
            return substr($class, $pos + 1);
        }

        return $class;
    }
}
