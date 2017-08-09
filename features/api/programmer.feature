Feature: Programmer
  In order to battle projects
  As an API client
  I need to be able to create programmers and power them up

  Background:
    # Given the user "CowboyCfoder" exists


  Scenario: PATCH to update a programmer
    And I have the payload:
    """
    {
      "tagLine": "giddyup"
    }
    """
    When I request "PATCH /api/programmers/ObjectOrienter"
    Then the response status code should be 200
    And the "avatarNumber" property should equal "2"
    And the "tagLine" property should equal "giddyup"