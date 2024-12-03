# Quality Assurance

This file contains the documentation for the `GET`, `POST`, `PUT`, and `DELETE` operations and the filters supported on resources as a part of the `Health-API`.


## GET /guidelines
`https://localhost/health-api/guidelines`
### Pagination
Sample request: To get 5 items per page on page 2 the URI would be the following: 
`https://localhost/health-api/guidelines?page_size=5&current_page=2`
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
The Facts resource allows the following filters:
1. `country_id`: Filter by country id from country table
2. `calorie_intake`: Filter by calorie intake
3. `protein_intake`: Filter by protein intake
4. `fats`; Filter by amount of fats
5. `carbohydrates`: Filter by amount of carbohydrates
6. `servings_per_day`: Filter by servings per day
7. `guideline_notes`: Filter by Guideline notes



Sample request: Filtering by minimum and maximum calories
`https://localhost/health-api/guidelines?calorie_intake=10&protein_intake=50`
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
1. `country_id`: Sort by Country id
2. `calorie_intake`: Sort by calorie intake
3. `protein_intake`: Sort by protein intake
4. `fats`; Sort by amount of fats
5. `carbohydrates`: Sort by amount of carbohydrates
6. `servings_per_day`: Sort by servings per day
7. `guideline_notes`: Sort by Guideline notes

Sample request: Sorting by fats in descending order
`https://localhost/health-api/foods?sort_by=fats&order=desc`
Sample response:
```json
```

## GET /countries
`https://localhost/health-api/countries`
### Pagination
Pagination refers to manipulating the returned set of data. 
Through pagination, you can manipulate the number of contents per page and the retrieved page number through the metadata.

The `meta` field typically includes:
- `page_size`: The number of items per page
- `current_page`: The page number retrieved
- `total`: The total number of items available
- `total_pages`: The total number of pages available

You can manipulate the number of items per page and current_page through the URI query parameters using the following format: 
`https://localhost/health-api/countries?page_size=X&current_page=X`
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
`https://localhost/health-api/countries?page_size=5&current_page=2`
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
1. `name`: Filter by name (i.e brazil, canada)
2. `population`: Filter by population (.i.e 200000)
3. `vegetaian_percentage`: Filter by % of vegetarians (45)
4. `daily_calorie_intake`; Filter by daily calorie intake (.i.e 2000)
5. `consumed_dishes`: Filter by minimum number of content (i.e soup)
6. `food_culture`: Filter by maximum number of content (i.e)
7. `nutritional_deficiency`: Filter by maximum number of content (i.e)



Sample request: Filtering by name
`https://localhost/health-api/countries?name="brazil"`
Sample response:
```json
```

### Sorting
Sorting allows clients to sort the returned set of data in certain orders.
With sorting, you can manipulate the the returned set of data in ascending or descending order

The `order` field includes:
- `asc`: Sort by ascending order
- `desc`: Sort by descending order
  
The Countries resource allows the following sorting filters through the `sort_by` field:
1. `country_id`: Sort by country 
2. `name`: Sort by food name (alphabetically)
3. `population`: Sort by population (alphabetically)
4. `vegetarian_percentage`: Sort by percentage of vegetarians
5. `daily_calorie_intake`: Sort by calorie intake per day
6. `consumed_dishes`: Sort by consumed disched (alphabetically)
7. `food_culture`: Sort by food culture (alphabetically)
8. `nutritional_deficiency`: Sort by nutritional deficiency (alphabetically)

Sample request: Sorting by calories in descending order
`https://localhost/health-api/countries?sort_by=fruit&order=asc` ??
Sample response:
```json
```

### Sample request
The following are sample requests using all three optional GET parameters:

## POST /countries
```json
[
    {
        
    }
]

```
