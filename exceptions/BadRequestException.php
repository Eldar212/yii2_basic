<?php


namespace app\exceptions;


class BadRequestException extends ApiException
{
    public function __construct(array $firstErrors = [], string $message = 'Ошибка', int $code = 0)
    {
        parent::__construct(400, $firstErrors, $message, $code);
    }
}