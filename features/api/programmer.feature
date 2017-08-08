Feature: Programmer
  In order to battle projects
  As an API client
  I need to be able to create programmers and power them up

  Background:
    # Given the user "weaverryan" exists


  Scenario: GET a collection of programmers
    When I request "GET /api/programmers"
    Then the response status code should be 200
    And the "programmers" property should be an array
    And the "programmers" property should contain 30 items
