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

    public function getRecommendationsId(string $recommendation_id): mixed
    {

        $query = "SELECT * FROM recommendations WHERE recommendation_id = :recommendation_id";
        $recommendation_info = $this->fetchSingle(
            $query,
            ["recommendation_id" => $recommendation_id]
        );
        return $recommendation_info;
    }

    
}
