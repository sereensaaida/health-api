# Quality Assurance

This file contains the documentation for the `GET`, `POST`, `PUT`, and `DELETE` operations and the filters supported on resources as a part of the `Health-API`.


## GET /foods
`https://localhost/health-api/foods`

Fetches all the records from the `foods` table.
### Pagination
Pagination refers to manipulating the returned set of data. 
Through pagination, you can manipulate the number of contents per page and the retrieved page number through the metadata.

The `meta` field typically includes:
- `page_size`: The number of items per page
- `current_page`: The page number retrieved
- `total`: The total number of items available
- `total_pages`: The total number of pages available

You can manipulate the number of items per page and current_page through the URI query parameters using the following format: 
`https://localhost/health-api/foods?page_size=X&current_page=X`
The response will appear as follows:
```json
{
    "meta": {
        "total": 1,
        "total_pages": 1,
        "current_page": 1,
        "page_size": 1
    },
    "data":[
        // Array of items
    ]
}
```

Sample request: To get 5 items per page on page 2 the URI would be the following: 
`https://localhost/health-api/foods?page_size=5&current_page=2`
Sample response:
```json
{
    "meta": {
        "total": X,
        "total_pages": X,
        "current_page": X,
        "page_size": X
    },
    "data":[
        // Array of items
    ]
}
```

### Filtering
Filtering allows clients to manage the returned response based on specific filtering parameters.
The Foods resource allows the following filters:
1. `category`: Filter by category (.i.e fruit, vegetable)
2. `serving_size`: Filter by serving size (.i.e. 100)
3. `minimum_calories`: Filter by minimum number of calories
4. `maximum_calories`; Filter by maximum number of calories
5. `minimum_content`: Filter by minimum number of content
6. `maximum_content`: Filter by maximum number of content

>[!NOTE]
`minimum_calories` and `maximum_calories`: Can be used to create a range for calories and
`minimum_content` and `maximum_content`: Can be used to create a range for content

Sample request: Filtering by minimum and maximum calories
`https://localhost/health-api/foods?minimum_calories=5&maximum_calories=50`
Sample response:
```json
```

### Sorting
Sorting allows clients to sort the returned set of data in certain orders.
With sorting, you can manipulate the the returned set of data in ascending or descending order

The `order` field includes:
- `asc`: Sort by ascending order
- `desc`: Sort by descending order
  
The Foods resource allows the following sorting filters through the `sort_by` field:
1. `food_id`: Sort by food_id 
2. `name`: Sort by food name (alphabetically)
3. `category`: Sort by category (alphabetically)
4. `avg_price`: Sort by average price of food
5. `calories`: Sort by number of calories

Sample request: Sorting by calories in ascending order
`https://localhost/health-api/foods?sort_by=fruit&order=asc`
Sample response:
```json
```

### Sample /foods requests and responses
The following are sample requests using all three optional GET parameters:

## GET /facts
`https://localhost/health-api/facts`

Fetches all the records from the `facts` table.

### Filtering
The Facts resource allows the following filters:
1. `minimum_protein`: Filter by minimum number of protein
2. `maximum_protein`: Filter by maximum number of protein
3. `minimum_carbs`: Filter by minimum number of carbs
4. `maximum_carbs`: Filter by maximum number of carbs

>[!NOTE]
`minimum_protein` and `maximum_protein`: Can be used to create a range for protein and
`minimum_carbs` and `maximum_carbs`: Can be used to create a range for carbs

Sample request: Filtering by minimum and maximum calories
`https://localhost/health-api/facts?minimum_protein=5&maximum_protein=50`
Sample response:
```json
```

### Sorting
The `order` field includes:
- `asc`: Sort by ascending order
- `desc`: Sort by descending order

The Facts resource allows the following sorting filters through the `sort_by` field:
1. `nutrition_id`: Sort by nutrition_id 
2. `carbohydrates`: Sort by carbohydrates (alphabetically)
3. `protein`: Sort by number of protein
4. `sugar`: Sort by amount of sugar
5. `sodium`: Sort by amount of sodium
6. `cholesterol`: Sort by amount of cholesterol 

Sample request: Sorting by carbohydrates in descending order
`https://localhost/health-api/facts?sort_by=carbohydrates&order=desc`
Sample response:
```json
```

### Sample /facts requests and responses
The following are sample requests using all three optional GET parameters:



## GET /exercise
`https://localhost/health-api/exercises`

Fetches all the records from the `exercise` table.

### Filtering
The Exercises resource allows the following filters:
1. `exercise_type`: Filter by exercise type
2. `difficulty_level`: Filter by difficulty level
3. `muscles_targeted`: Filter by muscles targetted
4. `calories_burned_per_min`: Filter by number of calories burned by minute
5. `equipment_needed`: Filter by equipment needed

Sample request filter parameters:
```json
Single example : ?difficulty_level=1
Multiple filters example: ?exercise_type=cardio&difficulty_level=3
```

### Sorting
The `order` field includes:
- `asc`: Sort by ascending order
- `desc`: Sort by descending order

The Exercise resource allows the following sorting filters through the `sort_by` field:
1. `exercise_id`: Sort by exercise_id 
2. `name`: Sort by name (alphabetically)
3. `exercise_type`: Sort by exercise type

Sample request: Sorting by name in descending order
`https://localhost/health-api/exercises?sort_by=name&order=desc`
Sample response:
```json

```

### Sample /facts requests and responses
The following are sample requests using all three optional GET parameters:
`/exercises?exercise_type=car&difficulty_level=3&sort_by=exercise_id&order=desc`
```json

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

## GET /countries
`https://localhost/health-api/countries`

Fetches all the records from the `countries` table.

### Filtering
The countries resource allows the following filters:
1.`name`: Filter by name
2.`population`: Filter by population
3.`vegetarian_percentage`: Filter by vegetarian percentage
4.`daily_calorie_intake`: Filter by daily calorie intake
5.`consumed_dishes`: Filter by consumed dishes
6.`food_culture`: Filter by food culture
7.`nutritional_deficiency`: Filter by nutritional deficiency

Sample request filter parameters:
```json
Single example : ?difficulty_level=1
Multiple filters example: ?name=brazil&vegetarian_percentage=21
```

### Sorting
The `order` field includes:
- `asc`: Sort by ascending order
- `desc`: Sort by descending order

The countries resource allows the following sorting filters through the `sort_by` field:
1.`name`: Sort by name (alphabetically)
2.`population`: Sort by population
3.`vegetarian_percentage`: Sort by vegetarian_percentage
4.`daily_calorie_intake`: Sort by daily_calorie_intake
5.`consumed_dishes`: Sort by consumed_dishes
6.`food_culture`: Sort by food_culture
7.`nutritional_deficiency`: Sort by nutritional_deficiency

Sample request: Sorting by name in descending order
`https://localhost/health-api/countries?sort_by=name&order=desc`
Sample response:
```json

```
## GET /guidelines
`https://localhost/health-api/guidelines`

Fetches all the records from the `guidelines` table.

### Filtering
The guidelines resource allows the following filters:
1.`country_id`: Filter by country_id
2.`calorie_intake`: Filter by calorie_intake
3.`protein_intake`: Filter by protein_intake
4.`fats`: Filter by fats
5.`carbohydrates`: Filter by carbohydrates
6.`servings_per_day`: Filter by servings_per_day
7.`guideline_notes`: Filter by guideline_notes

Sample request filter parameters:
```json
Single example : ?difficulty_level=1
Multiple filters example: ?country_id=1&fats=20
```

### Sorting
The `order` field includes:
- `asc`: Sort by ascending order
- `desc`: Sort by descending order

The guidelines resource allows the following sorting filters through the `sort_by` field:
1.`country_id`: Sort by country_id
2.`calorie_intake`: Sort by calorie_intake
3.`protein_intake`: Sort by protein_intake
4.`fats`: Sort by fats
5.`carbohydrates`: Sort by carbohydrates
6.`servings_per_day`: Sort by servings_per_day
7.`guideline_notes`: Sort by guideline_notes

Sample request: Sorting by carbohydrates in descending order
`https://localhost/health-api/guidelines?sort_by=carbohydrates&order=desc`
Sample response:
```json

```

## POST /foods
Given you are an admin with an authorized token, you can create a new item of foods.
The Foods table requires the following fields:
1. `name`: Food name
2. `category`: Food category (.i.e. fruit)
3. `calories`: Number of calories
4. `serving_size`: Number of serving size
5. `content`: Number of content 
6. `avg_price`: Average price
7. `is_vegan`: Vegan boolean

Sample POST request body:
```json
[
  {
  "name": "Starfruit",
  "category": "Fruit",
  "calories": 22,
  "serving_size": 75,
  "content": 35,
  "avg_price": 1,
  "is_vegan": 1
  }
]
```
>[!NOTE]
The `food_id` field is auto-incremented since it is the primary key.

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


## POST /countries
Given you are an admin with an authorized token, you can create a new country.
The countries table requires the following fields:
1. `name`: country name
2. `population`: population amount
3. `vegetarian_percentage`: % of vegetarians
4. `daily_calorie_intake`: amount of daily calorie intake
5. `consumed_dishes`: list of consumed dishes
6. `food_culture`:  list of food prices
7. `nutritional_deficiency`:  list of nutritional deficiency

Sample POST request body:
```json
[
  {
    "name": "Canada",
    "population": 38000000,
    "vegetarian_percentage": 10,
    "daily_calorie_intake": 2500,
    "consumed_dishes": "Poutine, Maple Syrup",
    "food_culture": "North American",
    "nutritional_deficiency": "Vitamin D"
  }
]
```
>[!NOTE]
The `country_id` field is auto-incremented since it is the primary key.

### PUT /foods
Given you are an admin with an authorized token, you can update an existing item of foods.
The /PUT operation must have the `food_id` to identify the food being updated, and the additional field you want to update.

Sample PUT request body:
```json
[
  {
  "food_id": 15,
  "name": "Starfruit",
  "category": "Fruit",
  "calories": 22,
  "serving_size": 55,
  "content": 20,
  "avg_price": 3,
  "is_vegan": 1
  }
]
```

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

## PUT /countries
!- Everything is mandatory
The body needs to follow a JSON format
```
[
    {
        "country_id": 1,
        "name": "Canada",
        "population": 38000000,
        "vegetarian_percentage": 10,
        "daily_calorie_intake": 2500,
        "consumed_dishes": "Poutine, Maple Syrup",
        "food_culture": "North American",
        "nutritional_deficiency": "Vitamin D"
    }

]
```
>[!CAUTION]
Make sure to follow the following requirements for each field

- `name`: At least 1 alphanumeric character
- `population`: At least 1 sized of integer
- `vegetarian_percentage` : percentage of not more than 100
- `daily_calorie_intake`: at least 1 sized of integer
- `consumed_dishes`: At least 1 alphanumeric character 
- `food_culture`: At least 1 alphanumeric character
- `nutritional_deficiency`: At least 1 alphanumeric character

  

### DELETE /foods
Given you are an admin with an authorized token, you can delete an existing item of foods.
The DELETE operation requires the following field(s):
1. `food_id`: The ID of the food

Sample DELETE request body:
```json
[
  {
  "food_id": 15
  }
]
```

### DELETE /exercise
The body needs to be in a JSON format.
You can only delete with the ID.
```
[
    {
        "exercise_id": 1,
    }
]
```

### DELETE /countries
Given you are an admin with an authorized token, you can delete an existing country record.
The DELETE operation requires the following field(s):

country_id: The ID of the country
Sample DELETE request body:
```
[
    {
    "country_id" : 1,
    }
    
]
```
