# Quality Assurance

This file contains the documentation for the `GET`, `POST`, `PUT`, and `DELETE` operations and the filters supported on resources as a part of the `Health-API`.


## GET /foods
`https://localhost/health-api/foods`
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

`NOTE:` `minimum_calories` and `maximum_calories`: Can be used to create a range for calories or for minimum and maximum delimiters
`NOTE:` `minimum_content` and `maximum_content`: Can be used to create a range for content or for minimum and maximum delimiters

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

Sample request: Sdorting by calories in descending order
`https://localhost/health-api/foods?sort_by=fruit&order=asc`
Sample response:
```json
```

### Sample request
The following are sample requests using all three optional GET parameters:

## GET /facts
`https://localhost/health-api/facts`
### Pagination
Sample request: To get 5 items per page on page 2 the URI would be the following: 
`https://localhost/health-api/facts?page_size=5&current_page=2`
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
1. `minimum_protein`: Filter by minimum number of protein
2. `maximum_protein`: Filter by maximum number of protein
3. `minimum_carbs`: Filter by minimum number of carbs
4. `maximum_carbs`; Filter by maximum number of carbs

`NOTE:` `minimum_calories` and `maximum_calories`: Can be used to create a range for calories or for minimum and maximum delimiters
`NOTE:` `minimum_content` and `maximum_content`: Can be used to create a range for content or for minimum and maximum delimiters

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

Sample request: Sdorting by calories in descending order
`https://localhost/health-api/foods?sort_by=fruit&order=asc`
Sample response:
```json
```

### Sample request
The following are sample requests using all three optional GET parameters:

## POST /foods
```json
[
    {
        
    }
]

```
