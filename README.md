
Car park booking test


I created a parking space table as I found it easy to query on whether there's a space or not but it wouldn't be actually required to display this parking space unless we want people to park in a specific space.
We just use it for checking availability.

Not entirely sure what to do for the pricing but I basically assumed summer and weekend were more expensive so had a base price and a multiplier for those. 
Could have a table for them so they can be editted easier instead of in the env file.

Made a service for checking availability. Afterwards I thought it could probably just go in the model but I like having services for bigger projects

If you setup and run the database stuff you can test the endpoints in postman, or run the unit tests.
