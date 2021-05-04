Library For Fetch Weather For Different Countries 

NB: This is the Crud  implementation in PHP.

Requirements
PHP 7.0 or higher with PDO drivers enabled for database systems:
MySQL 5.6 or higher in MySQL

**Installation**

For local development you may create virtual host in local system

Test the script by opening the following URL:

http://your-virtual-host-name/api/weather.php
Don't forget to modify the configuration at the bottom of the file.

Alternatively you can user POSTMAN Rest Api tool to test the PHP API


**Configuration:**

Edit the database connection details which mentioned inside config folder "database.php":

These are all the configuration options

"host":"localhost"
"username":"database_username"
"password":"database_password"

The CRUD + List operations below act on this table.

Table : weather

If you want to create a record the request can be written in URL format as:

POST http://your-virtual-hostname/api/weather.php

You have to send a body containing city name ( its optinal ):

{
    "city": "London"
}


And it will return the success message of created record:
Response 

{
    "message": "Created."
}


**Read
**Table Name : weather

To read last record from this table the request can be written in URL format as:

GET http://your-virtual-hostname/api/getValue.php

On read operations you may apply average.
you can also check average of last 7 records 

You can also check any number of records for that you need to send a body containing last_days as key

{
   "last_days" : "7"
}

It will return the 7 days records average

{
    "results": {
        "average": "295.1242857142857"
    },
    "message": "success"
}

**For Crone Set Up
**We can setup crone file for inserting data in every 3 min**

http://yourvirtualhostname/api/weather.php

**Database Configuration For Task Scheduler**

Run
http://yourvirtualhostname/api/task.php
It will automatically create task table in database and insert some data into table

**For Run Script**
POST http://yourvirtualhostname/api/task.php

You need to pass two parameters for creating task

{
   "job" : "job_type",
   "status" : "job_status"
}


**Database Configuration For Task Scheduler**

Once table has been created we can easily retrive pending task from task table

http://yourvirtualhostname/api/getTask.php

Response

{
    "results": [
        {
            "id": "1",
            "job": "job_type"
        },
        {
            "id": "2",
            "job": "job_type"
        },
        {
            "id": "3",
            "job": "job_type"
        }
    ],
    "message": "success"
}


