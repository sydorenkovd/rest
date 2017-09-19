Feature: Programmer
  In order to battle projects
  As an API client
  I need to be able to create programmers and power them up

  Background:
    # Given the user "CowboyCfoder" exists

  Scenario: Proper 404 exception on no programmer
    When I request "GET /api/programmers/fake"
    Then the response status code should be 404
    And the "Content-Type" header should be "application/problem+json"
    And the "type" property should equal "about:blank"
    And the "title" property should equal "Not Found"
    And the "detail" property should equal "The programmer fake does not exist!"