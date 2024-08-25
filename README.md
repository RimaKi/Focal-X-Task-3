## Focal-X-Task-3

 RESTful API application for managing a movie library using Laravel.
 The application performs user-specific operations.The API supports basic CRUD operations (create, read, update, delete)
   


## project details

1. **APIS**
    - Most of the links are built using apiResource, shortening the code and not having to write all the links for(index - store - show - update- distroy) operations.
    - CRUD operations for both movies & ratings
    - APIs for user operations likes (register  - login - logout).
    - Sanctum middleware is used to ensure the login process and validate tokens.


2. **Validations**
    - The validation process was done through Form Request to distribute the codes and facilitate the review and verification process.
    - Use simple and important expressions and rules in the validation process like: required , exists , unique , numeric ,.......

3. **Services**

    - The requirements were adhered to and services were provided and implemented in the same manner as they were presented in the theoretical session.
    - Within the movieService file there are 3 methods to perform the process of adding, modifying and deleting.

4. **Response**
    -The response is a json with an attempt to model the response, distinguish true and false cases, and capture error cases and display them in a modeled way.

## Additional Notes
- Sorting, pagination, filtering cases are implemented within the movie display api.
- Display average ratings for each movie by building a function in moudel that calculates avarege and takes advantage of the append feature to ensure it is displayed with  each movie
- For each method there is a comment & document to explain the method operations and define params & returns.
- postman collection attached in  laravel project