# QA Documentation

## GET /exercise
- Fetch all the records from the exercise db.
- use these query parameters`page_size` & `current_page` for pagination
- You can filter by doing like so:
```
Single example : ?difficulty_level=1
Multiple filters example: ?exercise_type=cardio&difficulty_level=3
```
>[!NOTE]
You can only filter with by using these query parameters : `exercise_type`, `difficulty_level`, `muscles_targeted`, `calories_burned_per_min`, `equipment_needed`
- To sort the data, you can use `sort_by`and`order=asc`
```
Example : ?sort_by=exercise_id&order=asc
```
>[!NOTE]
For sorting, you can only use `exercise_id`,`name`, and `exercise_type`
For the order, use `desc` for descending and `asc` for ascending

Example of a GET request combining all the query parameters: `/exercises?exercise_type=car&difficulty_level=3&sort_by=exercise_id&order=desc`
## POST /exercise
The body needs to follow a JSON format
```
Snippet Example
[
  {
    "name": "Aye",
    "exercise_type": "Cardio",
    "calories_burned_per_min": 10,
    "equipment_needed": "None",
    "difficulty_level": 3,
    "muscles_targeted": "Legs, Cardio"
  }
 ]
```
>[!CAUTION]
Make sure to follow the following requirements for each field

- `name`: At least 1 alphanumeric character
- `exercise_type`: At least 4 alphanumeric character
- `calories_burned_per_min` : At least 1 alphanumeric character
- `equipment_needed`: At least 1 alphanumeric character
- `difficulty_level`: At least 1 alphanumeric character with a maximum of 4 
- `muscles_targeted`: At least 1 alphanumeric character


## PUT /exercise
!- Everything is mandatory
The body needs to follow a JSON format
```
[
    {
        "exercise_id": 1,
        "name": "Aye",
        "exercise_type": "Cardio",
        "calories_burned_per_min": 10,
        "equipment_needed": "None",
        "difficulty_level": 3,
        "muscles_targeted": "Legs, Cardio"
    }

]
```
>[!CAUTION]
Make sure to follow the following requirements for each field

- `name`: At least 1 alphanumeric character
- `exercise_type`: At least 4 alphanumeric character
- `calories_burned_per_min` : At least 1 alphanumeric character
- `equipment_needed`: At least 1 alphanumeric character
- `difficulty_level`: At least 1 alphanumeric character with a maximum of 4 
- `muscles_targeted`: At least 1 alphanumeric character
## DELETE /exercise
The body needs to be in a JSON format.
You can only delete with the ID.
```
[
    {
        "exercise_id": 1,
    }
]
```
## GET /recommendations
- Fetch all the records from the recommendations db.
- use these query parameters`page_size` & `current_page` for pagination
- You can filter by doing like so:
```
Single example : ?diet_id=1
Multiple filters example: ?diet_id=1&duration_minutes=30
```
>[!NOTE]
You can only filter with by using these query parameters : `diet_id`, `exercise_id`, `duration_minutes`, `reps`, `sets`, `distance`, `additional_notes`
- To sort the data, you can use `sort_by`and`order=asc`
```
Example : ?sort_by=diet_id&order=asc
```
>[!NOTE]
For sorting, you can only use `recommendation_id`,`duration_minutes`, and `sets`
For the order, use `desc` for descending and `asc` for ascending

Example of a GET request combining all the query parameters: `recommendations?duration_minutes=20&reps=15&sort_by=diet_id&order=asc`

## GET /diets
- Fetch all the records from the recommendations db.
- use these query parameters`page_size` & `current_page` for pagination
- You can filter by doing like so:
```
Single example : ?is_gluten_free=1
Multiple filters example: ?diet_name=Keto&calorie_goal=2000
```
>[!NOTE]
You can only filter with by using these query parameters : `is_gluten_free`, `is_vegetarian`, `protein_goal`, `carbohydrate_goal`, `calorie_goal`, `diet_name`
- To sort the data, you can use `sort_by`and`order=asc`
```
Example : ?sort_by=diet_id&order=asc
```
>[!NOTE]
For sorting, you can only use `diet_id`,`diet_name`, and `protein_goal`
For the order, use `desc` for descending and `asc` for ascending

Example of a GET request combining all the query parameters: `diets?diet_name=Keto&calorie_goal=2000&sort_by=diet_id&order=asc`

