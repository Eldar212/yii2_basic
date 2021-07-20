<?php

namespace app\exceptions;

use yii\web\HttpException;

class ApiException extends HttpException
{
    public $firstErrors;

    public function __construct(int $status, array $firstErrors = [], string $message = 'Ошибка', int $code = 0)
    {
        $this->firstErrors = $firstErrors;
        parent::__construct($status, $message, $code, null);
    }

}