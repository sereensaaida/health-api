<?php

namespace App\Helpers;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

//where public static methods for writing log messages to a specific file (access.log, error.log) should be implemented
class LogHelper
{

    //handle the access.log
    public static function handleAccess($log_message)
    {
        //1) Instantiate the logger
        $logger = new Logger("ACCESS");
        //2)Push the handlers
        $logger->pushHandler(new StreamHandler(APP_LOGS_PATH . '/access.log'));
        //use the log level
        $logger->info($log_message);
    }
    //handle the error.log
    public static function handleError($log_message)
    {
        //1)Instantiate the logger
        $logger = new Logger("ERROR");
        //Push the handlers
        $logger->pushHandler(new StreamHandler(APP_ERRORS_PATH . '/errors.log'));

        //use the error log level
        $logger->error($log_message);
    }
}
