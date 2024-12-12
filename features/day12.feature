Feature:
    In order to verify the logic behind my algorithms for day 12 of AdventOfCode
    As me
    I want to check the values expected in the example against the one found by my code

    Scenario: Check part1
        When I request "/day12/1/day12test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be "1930"

    Scenario: Check part2
        When I request "/day12/2/day12test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be ""
