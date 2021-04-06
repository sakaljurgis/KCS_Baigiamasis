<?php

namespace KCS\Controller;

use KCS\Render;
use KCS\Services\RequestHandlerService;
use KCS\Services\RequestValidator;

class BaseController
{
    public RequestHandlerService $requestHandler;
    public RequestValidator $requestValidator;

    public function __construct(RequestHandlerService $requestHandler, RequestValidator $requestValidator)
    {
        $this->requestHandler = $requestHandler;
        $this->requestValidator = $requestValidator;
    }
}
