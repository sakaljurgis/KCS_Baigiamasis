<?php

namespace KCS\Exceptions;

class ValidationException extends \Exception
{
    public function __construct(string $message, $code = null, Throwable $exception = null)
    {
        parent::__construct($message ?: 'Field validation error', $code, $exception);
    }
}
