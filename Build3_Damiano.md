# Build #3 Notes

1 - Remember that all the data must be in JSON (including errors) *Never use echo*

2 - Use valitron or custom error handling exceptions.
 Error handling: require to handle runtime errors on the server side and custom HTTP exception (for authentication as an ex) *Need to be discussed as a team: how do we handle errors ?*

4- Root resource is not important, just add the new end-points 

*For Tuesday, November 5, 2024 :*
- Find a third-party REST-based API to fetch data from using ThunderClient

## General Information
- The PHP documentation should be stored in the 'Docs' folder.
- All information sent between the client and server is communicated through JSON.
- Do not use echo on the server side.
- `If during the demonstration something goes wrong, each team member will be penalzied.`

## Error Handling
- Required to handle runtime errors.
- Discuss with team members what type of examples to implement.
- "Were working as a team" so everything has to be uniform across all files: Errors should be handled the same way.
- Handle Errors on server, require to implement custom http exceptions, especially for when you create an account, to validate and generate token. To raise errors related to insufficient priviledges or unauthorized access
- invalid inputs exception for example, figure out what inputs we have and how we validate them
- Figure out what kind of exceptions lead to what scenarios (eg. Login, token validation)

## Composite Resources
- Each team member is responsible for creating on composite resource
- Using ThunderClient, try and pull data from a third-party REST-based API to aggregate the returned data in a meaningful/relevant way.
- Refer to `lab 5` for fetching data from an API :
  1. In the `Helpers` folder, create a new `Invoker` class and following method,`invokeUri`, to return an array/object containing data fetched from the specified URI/
- Composite resource: At least one third-party REST-based API that is public and free. **for next week** the code for implementing it we already have it : from the lab with ajax (`Lab 5` #3 the helpers thingy) 

1)  implement composite resource (PK/FK tables), sourced from 2 different tables.
2) Implement a source of remote processing using thunder client (one third party rest api free of charge, pull data from api)
3) Next week: find 1 api, test it, figure out if u need to create an account to get the token. use dummy email if needed
4) code needed to write for composite resource is available in php lab for fetching. kms. (guzzlette), code that creates client, return data extracted from response (no parsing needed, forget dates, flags or whatnot)
5) reusable part = helpers folder
- 
- Each member must implement at least one value-returning computation functionality (Ex : BMI calculator) the data sent must be as a POST method encoded in JSON. You need to validate each input. You are not suppose to read data from an API. It should be the result of a computation.You need to return the result of that computation. Omni calculator


## Computing Functionality/Remote Processing
- Each team member must implement at least one value-returning function.
- In our Health-API, we may use :
  1. BMI calculator (`Exercises`) : https://www.calculator.net/bmi-calculator.html
  2. Calorie calculator (`Foods`) : https://www.calculator.net/bmi-calculator.html
  3. Ideal weight calculator (`Exercises`) : https://www.calculator.net/ideal-weight-calculator.html

- The data sent in the remote processing request has to be encoded in JSON. This function is purely a response containing a computational result from our own function. We cannot pull this calculated result from an API.
1) find a formula to implement on server side, give back on the client (BMI calculator), checkckkc link
2) calories burned per hour!!!!!!
3) describe or find formula, include links
4) dont code EEEYAHHHHHHHHHHHHHHHHHHHHHHHHHHHHH


## Monolog
- We will be using `StreamHandler` 
- Log LeveL:
  1. `Info`: 100 
  2. `Errors`: 400
- We have to maintain 2 loggers:
  1. `StreamHandler`
  2. `FirePHPHandler`

## AA
### JWT (Json Web Token)
`The user/client must be identified before generating their token (JWT)`
Structure of JWT:
1. Header
2. Payload
3. Signature
- We have to use the RFC standardized terms like IAT, NBF, EXP ... etc
(error 401 we have already and now we need to add, 403 not acceptable (incorrect format to be added))
  - [RFC7519](https://datatracker.ietf.org/doc/html/rfc7519#section-4.1.1)

Creating a token: [Php-jwt](https://github.com/firebase/php-jwt)

6 - 
# Configuring a logger
- Create the logger with the channel name
- Add the handlers
- Use the handler
- *Test the code in the callback, use it wherever you want afterwards* 

# Configuring a logger
- ALL COLLECTIONS have callback already, in ur callback. 
- first step that we did in first build: pull from the database (actual collection),using a read operation from the resource GET
- pull from the api (remote uri) and append 
- after u get response from the model component, it gave you back a data set
- to combine the 2:_array merge. lets say u have data[api key (eg. api exercises)] the one we decoded from the API
