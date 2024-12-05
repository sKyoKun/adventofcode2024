# Adventofcode2024

This repository contains all the code written for https://adventofcode.com/2024. These are Christmas themed exercices that you can answer in any language. Mine is made in PHP/Symfony7

I try to be as clean as possible but sometimes time is leaving me no choice than "quick and dirty" (sorry !) 

Install the project : ```composer install```

Run the symfony server : ```symfony serve -d```

Initialize a new day : ```php bin/console generate:day X``` where X is the day number

Run php-cs-fixer : ```vendor/bin/php-cs-fixer fix```

Run the tests : 
```vendor/bin/phpunit``` (unit)
```vendor/bin/behat``` (functional)

For the leaderboard, route is /leaderboards/{year} :

Configure the API calls :
- Create a cookie.txt file at the root of the project and paste the session cookie into it. To do so, go to an AOC input and use the network tab of the developper tool to retrieve the session cookie.
- Paste it in the cookie.txt file (/!\ remove the blank line if it exists)
- Update the default year on the controller if needed
- Change the leaderboard list in _LeaderboardService_
