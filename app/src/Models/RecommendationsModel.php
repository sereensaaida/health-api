<?php

namespace App\Models;

use App\Core\PDOService;

class RecommendationsModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }
    public function getRecommendations(): mixed
    {
        $sql = "SELECT * FROM recommendations";
        return   (array)$this->fetchAll($sql);
    }
}
