Feature: Programmer
  In order to battle projects
  As an API client
  I need to be able to create programmers and power them up

  Background:
    # Given the user "CowboyCfoder" exists


  Scenario: DELETE a programmer
    When I request "DELETE /api/programmers/ObjectOrienter112"
    Then the response status code should be 204