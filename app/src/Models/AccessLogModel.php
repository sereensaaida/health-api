<?php

namespace App\Models;

use App\Core\PDOService;

class AccessLogModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    //method to insert data into the ws_users db
    /*
    . The log records must include information about the account used to access the resource, IP address,
    resource URI, HTTP method used, date and time, etc.
    */
    public function insertLogDb(array $new_log): mixed
    {
        //insert statement
        $user = $this->insert("ws_log", $new_log);

        return $user;
    }
}
