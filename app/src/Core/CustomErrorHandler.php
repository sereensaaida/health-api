<?php

namespace App\Core;

use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpException;
use Slim\Handlers\ErrorHandler;
use Throwable;
use App\Helpers\LogHelper;

class CustomErrorHandler extends ErrorHandler
{
    protected function logErrorDetails(): void
    {
        //log the exception to the error.log file
        $exception = $this->exception;
        $request = $this->request;

        LogHelper::handleError($exception->getMessage());
    }

    protected function respond(): ResponseInterface
    {
        //error response
        $status = 400;
        $exception = $this->exception;

        $statusCode = $exception;

        $statusCode = $exception instanceof HttpException ? $exception->getCode() : 500;

        if ($exception instanceof HttpException) {
            $this->logErrorDetails();
        }

        $data = [
            'status' => 'error',
            'code' => $statusCode,
            'type' => $this->getClassName($exception),
            'message' => $exception->getMessage()
        ];

        return $this->getErrorResponse($data, $statusCode);
    }


    private function getClassName($object)
    {
        $path = explode('\\', get_class($object));

        return array_pop($path);
    }

    private function getErrorResponse($data, $statusCode = 400)
    {
        $response = $this->responseFactory->createResponse($statusCode)->withHeader("Content-type", "application/json");

        $payload = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR);

        // Prepare a JSON response with an error message
        $response->getBody()->write($payload);
        return $response->withStatus($statusCode)->withHeader('Content-Type', 'application/json');
    }
}
