<?php

namespace App\Core;

use Psr\Http\Message\ResponseInterface;
use Slim\Handlers\ErrorHandler;

class CustomErrorHandler extends ErrorHandler
{
    protected function logErrorDetails(): void
    {
        //log the exception to the error.log file
        $exception = $this->exception;
        $request = $this->request;
    }

    protected function respond(): ResponseInterface
    {
        //error response
        $status = 400;
    }
}
