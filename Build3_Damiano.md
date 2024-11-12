# Build #3 Notes

*For Tuesday, November 5, 2024 :*
- Find a third-party REST-based API to fetch data from using ThunderClient

# General Information
- The PHP documentation should be stored in the 'Docs' folder.
- All information sent between the client and server is communicated through JSON.
- Do not use echo on the server side.
- `If during the demonstration something goes wrong, each team member will be penalzied.`

# Error Handling
- Required to handle runtime errors.
- Discuss with team members what type of examples to implement.
- "Were working as a team" so everything has to be uniform across all files: Errors should be handled the same way.

# Composite Resources
- Each team member is responsible for creating on composite resource
- Using ThunderClient, try and pull data from a third-party REST-based API to aggregate the returned data in a meaningful/relevant way.
- Refer to `lab 5` for fetching data from an API :
  1. In the `Helpers` folder, create a new `Invoker` class and following method,`invokeUri`, to return an array/object containing data fetched from the specified URI/

# Computing Functionality/Remote Processing
- Each team member must implement at least one value-returning function.
- In our Health-API, we may use :
  1. BMI calculator (`Exercises`) : https://www.calculator.net/bmi-calculator.html
  2. Calorie calculator (`Foods`) : https://www.calculator.net/bmi-calculator.html
  3. Ideal weight calculator (`Exercises`) : https://www.calculator.net/ideal-weight-calculator.html

- The data sent in the remote processing request has to be encoded in JSON. This function is purely a response containing a computational result from our own function. We cannot pull this calculated result from an API.
