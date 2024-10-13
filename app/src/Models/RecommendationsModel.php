<?php

namespace App\Models;

use App\Core\PDOService;

class RecommendationsModel extends BaseModel
{
    public function __construct(PDOService $pdo)
    {
        parent::__construct($pdo);
    }
    public function getRecommendations(array $filter_params = []): mixed
    {
        $named_params = [];
        $sql = "SELECT * FROM recommendations WHERE 1";

        if (isset($filter_params['diet_id'])) {
            $sql .= " AND diet_id LIKE  CONCAT(:diet_id,'%')";
            $named_params['diet_id'] = $filter_params['diet_id'];
        }

        if (isset($filter_params['exercise_id'])) {
            $sql .= " AND exercise_id LIKE  CONCAT(:exercise_id,'%')";
            $named_params['exercise_id'] = $filter_params['exercise_id'];
        }

        if (isset($filter_params['duration_minutes'])) {
            $sql .= " AND duration_minutes LIKE  CONCAT(:duration_minutes,'%')";
            $named_params['duration_minutes'] = $filter_params['duration_minutes'];
        }

        if (isset($filter_params['reps'])) {
            $sql .= " AND reps LIKE  CONCAT(:reps,'%')";
            $named_params['reps'] = $filter_params['reps'];
        }

        if (isset($filter_params['sets'])) {
            $sql .= " AND sets LIKE  CONCAT(:sets,'%')";
            $named_params['sets'] = $filter_params['sets'];
        }

        if (isset($filter_params['distance'])) {
            $sql .= " AND distance LIKE  CONCAT(:distance,'%')";
            $named_params['distance'] = $filter_params['distance'];
        }

        if (isset($filter_params['additional_notes'])) {
            $sql .= " AND additional_notes LIKE  CONCAT(:additional_notes,'%')";
            $named_params['additional_notes'] = $filter_params['additional_notes'];
        }


        $recommendations = $this->paginate($sql, $named_params);

        return $recommendations;
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
