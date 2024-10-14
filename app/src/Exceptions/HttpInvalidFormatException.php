<?php

namespace App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpInvalidFormatException extends HttpSpecializedException
{
    //@var int
    protected $code = 403;

    //@var String
    protected $message = "Invalid Format";

    protected String $title = '403';

    protected String $description = "The requested resource could not be found, try again";
}
