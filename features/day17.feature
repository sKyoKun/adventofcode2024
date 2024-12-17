Feature:
    In order to verify the logic behind my algorithms for day 17 of AdventOfCode
    As me
    I want to check the values expected in the example against the one found by my code

    Scenario: Check part1
        When I request "/day17/1/day17test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be "4,2,5,6,7,7,7,7,3,1,0"

    Scenario: Check part2
        When I request "/day17/2/day17test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be ""
