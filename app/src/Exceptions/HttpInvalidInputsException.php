<?php

namespace App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpInvalidInputsException extends HttpSpecializedException
{
    //@var int
    protected $code = 404;

    //@var String
    protected $message = "BAD request";

    protected String $title = '404';

    protected String $description = "The requested resource could not be found, try again";
}
