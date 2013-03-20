SU Coding Challenge
===================

Description
-----------

This is a standard requirement for all engineering positions.  We ask that you return it within one week.  We leave this very open-ended so run with it and have fun.  Our goal is to see your code, coding style, problem solving and creative/critical thinking skills.  Please complete the project using PHP.  Spend as much or as little time on the challenge as you see fit.  Geoff Smith (our CTO) has put a tarball at: http://d2ajbu9l4gdfg1.cloudfront.net/interviews/urls.tgz containing 5 data files, for 5 different websites, in csv format.  The format is as follows:

rating,timestamp,age,gender, city,state,country[,tag:count]+

Each line number is a unique person, and the lines are sorted by date the site was seen. The people in each separate file may or may not be the same. Here's an explanation of each parameter:

* rating - 0 = seen, but no rating.   1 = thumbup, -1 = thumbdown
* timestamp = unix timestamp of when they saw the site
* age = age
* gender - 1 = male, 2 = female
* city,state,country
* tag:count - this is a list of tags and how often they've been used by that person, ordered by most used first.  basically you can take this is a count of the types of sites they've thumbed up

Setup
-----
1. Change config information in index.php

    // Web Root

    define('WEBBASEDIR', 'su.local');

    // database setting

    define('DB_HOST', 'localhost');

    define('DB_NAME', 'su');

    define('DB_USERNAME', 'root');

    define('DB_PASSWORD', 'root');

2. Make sure csv files are stored in "data" folder and names are correct in index.php

        define ('DATASOURCES',
            serialize (
                array('free411.com', 'gigaom.com', 'hubspot.com', 'leadertoleader.org', 'simplyexplained.com')
            )
        );

3. Create tables in "su" database

    You can use create.sql file in "data" folder

4. Run the updater

    URL: http://[WEBROOT]/person/update/all

    e.g. http://su.local/person/update/all

    This reads csv files from data folder and populates the database

5. View the report dashboard

    URL: http://[WEBROOT]/dashboard.html

    e.g. http://su.local/dashboard.html

6. You can also view individual reports

    Top 10 Tags: http://su.local/person/display/top_ten_tags

    User by State: http://su.local/person/display/user_by_state

    User by Age: http://su.local/person/display/user_by_age

Technology summary
------------------
PHP

MySQL

d3.js

jquery.js

