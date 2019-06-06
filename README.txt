To set up for local use:

-Ensure MySQL PDO drivers are enabled in php.ini
-Create a database and run /db/createSchema.sql to generate the structure and employee data.  Update /api/config/database.php with connection info.
-Navigate to the base directory and open a command prompt - type 'php -S localhost:8000' to make sure the API is listening
-Navigate to the index.html page in the checkout from a web browser (preferably Google Chrome).

When creating a shift, please use a human-readable format (e.g. "Jun 18 2019 08:00:00").

Shifts up to 16 hours are supported.

Employees are supported by the database and recorded against the schedule.  There's a hook in place to hide the Create Shift functionality if not logged in as a manager, however authentication isn't implemented.

There is a collection of Postman scripts for testing the three currently supported API calls (read all shifts, read all employees, create a shift) in the root directory.  
Despite the headers I've got set up I was running into CORS access issues when testing locally, and firewall and versioning issues when hosting elsewhere, which made
testing basically impossible.  That means that sadly the overlap check is broken - something about the date conversions and arithmetic has gone wrong and I haven't had quite enough time to devote to
fixing it.
The UI is set up with bootstrap.js.