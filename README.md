Quick start:

- set the usual database vars in .env
- set the wonde token env variable (see .env.example: WONDE_TOKEN)
- set the school wonde id variable (see .env.example: SCHOOL_ID)
- run the migrations
- run the artisan command to retrieve the data from the wonde API: php artisan download:wonde
- go to the root url of the site. the first page only displays the employees who have classes
- clicking on an employee's wonde ID will show a list of dates when that employee has lessons
- clicking a date will show the lessons taking place that day, with details (time, location etc.), plus a list of students for each lesson