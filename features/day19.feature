Feature:
    In order to verify the logic behind my algorithms for day 19 of AdventOfCode
    As me
    I want to check the values expected in the example against the one found by my code

    Scenario: Check part1
        When I request "/day19/1/day19test" using HTTP method "GET"
        Then the status code must be 200
        And the response should be "6"

    Scenario: Check part2
        When I request "/day19/2/day19" using HTTP method "GET"
        Then the status code must be 200
        And the response should be "16"
