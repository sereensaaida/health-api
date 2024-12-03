<?php

namespace App\Models;

use App\Core\PDOService;
use GuzzleHttp\Psr7\Response;

/**
 * Class FoodsModel
 *
 * This model class handles operations related to the Food table
 */

// Api key
// /J+4XMLi0cWNeQ3F70t39Q==oNVAN6eElkdV58Fl
class FoodsModel extends BaseModel
{
    /**
     * FoodsModel constructor.
     *
     * @param PDOService $dbo The database service object.
     */
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    /**
     * Retrieves a list of foods based on the filter parameters.
     *
     * @param array $filter_params An array of filtering options such as category, calories, etc.
     * @return array The filtered list of foods.
     */
    public function getFoods(array $filter_params = []): array
    {
        $named_params_values = [];

        //* Sorting:
        $sortBy = isset($filter_params['sort_by']) ? $filter_params['sort_by'] : 'food_id';
        $order = isset($filter_params['order']) ? $filter_params['order'] : 'asc';

        // Validating the sorting params
        $validSortingParameters = ['food_id', 'name', 'category', 'avg_price', 'calories'];
        $sortBy = in_array($sortBy, $validSortingParameters) ? $sortBy : 'food_id';
        $order = ($order === 'desc') ? 'desc' : 'asc';

        // Base query
        $sql = "SELECT * FROM foods WHERE 1=1";

        //* FILTERING:

        // General filtering (e.g., category, serving_size)
        $allowed_fields = ['category', 'serving_size'];
        $filter_result = $this->buildFilterConditions($filter_params, $allowed_fields);
        $sql .= $filter_result['sql_conditions'];
        $named_params_values = array_merge($named_params_values, $filter_result['named_params']);

        // CALORIES (validate min/max range)
        if (
            isset($filter_params['minimum_calories']) &&
            isset($filter_params['maximum_calories']) &&
            $filter_params['minimum_calories'] > $filter_params['maximum_calories']
        )

            if (isset($filter_params['minimum_calories'])) {
                $sql .= " AND calories >= :minimum_calories";
                $named_params_values['minimum_calories'] = (int) $filter_params['minimum_calories'];
            }

        if (isset($filter_params['maximum_calories'])) {
            $sql .= " AND calories <= :maximum_calories";
            $named_params_values['maximum_calories'] = (int) $filter_params['maximum_calories'];
        }

        // CONTENT SIZE (validate min/max range)
        if (
            isset($filter_params['minimum_content']) &&
            isset($filter_params['maximum_content']) &&
            $filter_params['minimum_content'] > $filter_params['maximum_content']
        )

            if (isset($filter_params['minimum_content'])) {
                $sql .= " AND content >= :minimum_content";
                $named_params_values['minimum_content'] = (int) $filter_params['minimum_content'];
            }

        if (isset($filter_params['maximum_content'])) {
            $sql .= " AND content <= :maximum_content";
            $named_params_values['maximum_content'] = (int) $filter_params['maximum_content'];
        }

        // Sorting
        $sql .= " ORDER BY $sortBy $order";

        // Execute paginated query
        $foods = (array) $this->paginate($sql, $named_params_values);

        return $foods;
    }


    /**
     * Retrieves a singleton resource of Food by its ID
     *
     * @param string $food_id The ID of the food
     * @return mixed The food data
     */
    public function getFoodId(string $food_id): mixed
    {
        $sql = "SELECT * FROM foods WHERE food_id = :food_id";

        $food_info = $this->fetchSingle(
            $sql,
            ["food_id" => $food_id]
        );
        return $food_info;
    }

    //* Sub collection resource
    // We retrieve a single/specific food's nutrition facts. This is because Facts is dependent on foods.
    /**
     * Retrieves nutrition facts for a specific food.
     *
     * @param string $food_id The ID of the food to get nutrition facts for.
     * @return mixed The food's nutrition facts.
     */
    public function getFoodFacts(String $food_id): mixed
    {
        $food = $this->getFoodId($food_id);

        $sql = "SELECT * FROM facts WHERE food_id = :food_id";

        $facts = $this->fetchAll(
            $sql,
            ["food_id" => $food_id]
        );

        $result = [
            'food' => $food,
            'facts' => $facts,
        ];

        return $result;
    }


    /**
     * Inserts a new Food item into the database.
     *
     * @param array $new_food_info An array containing the information for the new food item.
     * @return mixed The ID of the inserted food item.
     */
    public function insertFood(array $new_food_info): mixed
    {
        // We dont have to write the SQl statement:
        //$sql = "INSERT INTO foods (food_id, name, category, calories, serving_size, content, avg_price, is_vegan) VALUES (:food_id, name, category, calories, ////serving_size, content, avg_price, is_vegan)";

        // Instead do this:
        $last_id = $this->insert('foods', $new_food_info);

        return $last_id;
    }

    /**
     * Model method for updating a food
     *
     * @param array $food_info The food information inputted by the user
     * @return void Updates the food.
     */
    public function updateFood(array $food_info): void
    {
        // Storing the food id because we cant keep it in the array when we are updating the food since it will interfere
        $food_id = $food_info["food_id"];

        unset($food_info["food_id"]);

        $this->update("foods", $food_info, ["food_id" => $food_id]);
    }

    /**
     * Model method for deleting a food
     *
     * @param array $food_info The food information inputted by the user
     * @return mixed Deletes the food.
     */
    public function deleteFood(array $food_info): void
    {
        $this->delete("foods", $food_info, 1);
    }
}
