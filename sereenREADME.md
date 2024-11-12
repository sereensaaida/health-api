

# Project Notessssssssssssssssssssssssssss

## Build 33333333333333333333
1) Requirement #9 should be inside docs folder
2) Data between client and server are always to be in JSON  (do not use echo on server side to check)
3) dont ask him to debug :(
4) Use valitron or Validation logic to validate inputs being passed to service

## Error Handlingggggggggggggggggggggg
1) Handle Errors on server, require to implement custom http exceptions, especially for when you create an account, to validate and generate token. To raise errors related to insufficient priviledges or unauthorized access
2) invalid inputs exception for example, figure out what inputs we have and how we validate them
3) Figure out what kind of exceptions lead to what scenarios (eg. Login, token validation)

## composite resourceeeeeeeeeeeeeeeeeee
1) implement composite resource (PK/FK tables), sourced from 2 different tables.
2) Implement a source of remote processing using thunder client (one third party rest api free of charge, pull data from api)
3) Next week: find 1 api, test it, figure out if u need to create an account to get the token. use dummy email if needed
4) code needed to write for composite resource is available in php lab for fetching. kms. (guzzlette), code that creates client, return data extracted from response (no parsing needed, forget dates, flags or whatnot)
5) reusable part = helpers folder

## commmmmpuuuutation functionality remote processin
1) find a formula to implement on server side, give back on the client (BMI calculator), checkckkc link
2) calories burned per hour!!!!!!
3) describe or find formula, include links
4) dont code EEEYAHHHHHHHHHHHHHHHHHHHHHHHHHHHHH
