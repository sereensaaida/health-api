<?php

declare(strict_types=1);

use App\Middleware\LogMiddleware;
use App\Middleware\AuthMiddleware;
use Slim\App;
use App\Middleware\ContentNegotiationMiddleware;

return function (App $app) {
    //! Content negotiation middlewear class
    $app->addMiddleware(new ContentNegotiationMiddleware());
    // Authentication middleware
    //$app->addMiddleware(new AuthMiddleware());
    // Add your middleware here.
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    //add the access log middleware
    $app->addMiddleware(new LogMiddleware());

    //!NOTE: the error handling middleware MUST be added last.
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $errorMiddleware->getDefaultErrorHandler()->forceContentType(APP_MEDIA_TYPE_JSON);
};
