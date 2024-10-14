<?php

namespace App\Exceptions;

use Slim\Exception\HttpSpecializedException;


class HttpNotAcceptableException extends HttpSpecializedException
{
    //TODO Add a hint member and retrieve it in a customer error handler.
    /**
     * @var int
     */
    protected $code = 406;

    /**
     * @var string
     */
    protected $message = 'Not Acceptable';

    protected string $title = '406 Not Acceptable';
    protected string $description = 'The request could not be processed due to invalid resource representation provided in the request. Please try again.';
}
