Feature:
    In order to verify the logic behind my algorithms for day 10 of AdventOfCode
    As me
    I want to check the values expected in the example against the one found by my code

    Scenario: Check part1
        When I request "/day10/1/day10test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be "36"

    Scenario: Check part2
        When I request "/day10/2/day10test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be "81"
