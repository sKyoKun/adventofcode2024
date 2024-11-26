Feature:
    In order to verify the logic behind my algorithms for day 1 of AdventOfCode
    As me
    I want to check the values expected in the example against the one found by my code

    Scenario: Check part1
        When I request "/day1/1/day1test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be ""

    Scenario: Check part2
        When I request "/day1/2/day1test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be ""
