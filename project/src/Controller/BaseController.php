<?php

namespace KCS\Controller;

use KCS\Render;
use KCS\Services\RequestHandlerService;
use KCS\Services\RequestValidator;

class BaseController
{
    /**
     * @var Render
     */
    public Render $render;
    public RequestHandlerService $requestHandler;
    public RequestValidator $requestValidator;

    public function __construct(Render $render, RequestHandlerService $requestHandler, RequestValidator $requestValidator)
    {
        $this->render = $render;
        $this->requestHandler = $requestHandler;
        $this->requestValidator = $requestValidator;
    }
}
