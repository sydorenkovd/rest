Feature: Programmer
  In order to battle projects
  As an API client
  I need to be able to create programmers and power them up

  Background:
    # Given the user "CowboyCfoder" exists


  Scenario: PUT to update a programmer
    Given the following programmers exist:
      | nickname    | avatarNumber | tagLine |
      | CowboyCoder | 5            | foo     |
    And I have the payload:
    """
    {
      "nickname": "CowboyCoder",
      "avatarNumber" : 2,
      "tagLine": "foo"
    }
    """
    When I request "PUT /api/programmers/CowboyCoder"
    And print last response
    Then the response status code should be 200
    And the "avatarNumber" property should equal "2"
