<?php

namespace App\Helpers;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * LogHelper class provides static methods for logging messages to specific log files.
 *
 * This helper class supports two main types of logs:
 * - Access logs: Written to `access.log` for recording access-related messages.
 * - Error logs: Written to `errors.log` for recording error-related messages.
 */
class LogHelper
{

    /**
     * Handles writing access logs to the `access.log` file.
     *
     * This method initializes a Monolog logger instance, sets up a StreamHandler
     * to direct log messages to the `access.log` file, and logs the provided message
     * with an informational log level.
     *
     * @param string $log_message The message to be logged in the access log.
     * @return void
     */
    public static function handleAccess($log_message)
    {
        //1) Instantiate the logger
        $logger = new Logger("ACCESS");
        //2)Push the handlers
        $logger->pushHandler(new StreamHandler(APP_LOGS_PATH . '/access.log'));
        //use the log level
        $logger->info($log_message);
    }
    /**
     * Handles writing error logs to the `errors.log` file.
     *
     * This method initializes a Monolog logger instance, sets up a StreamHandler
     * to direct log messages to the `errors.log` file, and logs the provided message
     * with an error log level.
     *
     * @param string $log_message The message to be logged in the error log.
     * @return void
     */
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
