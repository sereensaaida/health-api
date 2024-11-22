<?php

declare(strict_types=1);

namespace App\Core;

use App\Middleware\LogMiddleware;
use App\Middleware\AuthMiddleware;
use Slim\App;
use App\Middleware\ContentNegotiationMiddleware;


return function (App $app) {
    //! Content negotiation middlewear class
    $app->addMiddleware(new ContentNegotiationMiddleware());
    // Authentication middleware
    // $app->addMiddleware(new AuthMiddleware());
    // Add your middleware here.
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    //add the access log middleware
    $app->addMiddleware(new LogMiddleware());

    //!NOTE: the error handling middleware MUST be added last.
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);

    //custom error handler to be used for handling runtime errors.
    $callableResolver = $app->getCallableResolver();
    $responseFactory = $app->getResponseFactory();
    $errorHandler = new CustomErrorHandler($callableResolver, $responseFactory);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);
    $errorMiddleware->getDefaultErrorHandler()->forceContentType(APP_MEDIA_TYPE_JSON);
};
