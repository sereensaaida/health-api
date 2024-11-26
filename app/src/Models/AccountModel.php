<?php

namespace App\Models;

use App\Core\PDOService;


class AccountModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }

    public function insertUser(array $user_info): mixed
    {
        $user = $this->insert('ws_users', $user_info);

        return $user;
    }
}
